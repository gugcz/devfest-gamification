package cz.destil.cdhmaster.service;

import java.util.Stack;
import java.util.regex.Pattern;

import android.accounts.Account;
import android.accounts.AccountManager;
import android.app.Notification;
import android.app.PendingIntent;
import android.app.Service;
import android.content.Intent;
import android.os.IBinder;
import android.support.v4.app.NotificationCompat;
import android.util.Pair;
import android.util.Patterns;

import cz.destil.cdhmaster.App;
import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.activity.MainActivity;
import cz.destil.cdhmaster.api.Api;
import cz.destil.cdhmaster.api.Unlock;
import cz.destil.cdhmaster.data.Preferences;
import cz.destil.cdhmaster.util.Util;
import retrofit.Callback;
import retrofit.RetrofitError;
import retrofit.client.Response;

/**
 * Created by Destil on 4.11.13.
 */
public class UnlockService extends Service {

    public static final String EXTRA_ATTENDEE_ID = "ATTENDEE_ID";
    private static UnlockService sInstance;
    private Stack<Pair<Long, Integer>> mToUnlock;
    private boolean mUnlockingInProgress = false;

    public static UnlockService get() {
        return sInstance;
    }

    @Override
    public void onCreate() {
        super.onCreate();
        mToUnlock = new Stack<Pair<Long, Integer>>();
        sInstance = this;
    }

    @Override
    public int onStartCommand(Intent intent, int flags, int startId) {
        long attendeeId =  intent.getLongExtra(EXTRA_ATTENDEE_ID, -1);
	    if (attendeeId != -1) {
		    Intent notificationIntent = new Intent(App.get(), MainActivity.class);
		    PendingIntent pendingIntent = PendingIntent.getActivity(this, 42, notificationIntent, 0);
		    Notification notification = new NotificationCompat.Builder(App.get()).setOngoing(true).setTicker("Unlocking achievement...").setSmallIcon(R.drawable.ic_launcher).setContentTitle("Waiting for connection").setContentText("Achievements will be unlocked when you get online").setContentIntent(pendingIntent).build();

		    startForeground(42, notification);
		    mToUnlock.push(new Pair<Long, Integer>(attendeeId, Preferences.getAchievement().id));
		    unlockNext();
	    }
        return START_STICKY;
    }

    void unlockNext() {
        if (isStackEmpty()) {
            stopForeground(true);
            stopSelf();
            return;
        }
        if (Util.isNetworkAvailable()) {
            final Pair<Long, Integer> toUnlock = mToUnlock.peek();
            final long attendeeId = toUnlock.first;
            int achievementId = toUnlock.second;
            final String achievementName = Preferences.getAchievementNameById(achievementId);
            String password = Preferences.getPassword();
            String orgEmail = getUserEmail();
            mUnlockingInProgress = true;
            Api.get().create(Unlock.class).unlock(new Unlock.Request(attendeeId, achievementId, password, orgEmail), new Callback<Unlock.Response>() {
                @Override
                public void success(Unlock.Response response, Response retrofitResponse) {
                    String text = "Achievement unlocked! (" + response.achievements_unlocked + " unlocked, #" + response.leaderboard_position + " in leaderboard)";
                    Preferences.addHistory(achievementName+" -> "+response.user_name, text);
                    Util.toastPositive(text);
                    mToUnlock.pop();
                    mUnlockingInProgress = false;
                    unlockNext();
                }

                @Override
                public void failure(RetrofitError error) {
                    String text = "Achievement unlock failed: " + Api.getErrorString(error);
                    Preferences.addHistory(achievementName+" -> "+attendeeId, text);
                    Util.toastNegative(text);
                    if (Util.isNetworkAvailable()) {
                        mToUnlock.pop();
                    }
                    mUnlockingInProgress = false;
                    unlockNext();
                }
            });
        }
    }

    private String getUserEmail() {
        Pattern emailPattern = Patterns.EMAIL_ADDRESS;
        Account[] accounts = AccountManager.get(App.get()).getAccounts();
        for (Account account : accounts) {
            if (emailPattern.matcher(account.name).matches()) {
                return account.name;
            }
        }
        return null;
    }

    @Override
    public IBinder onBind(Intent intent) {
        return null;
    }

    public boolean isStackEmpty() {
        return mToUnlock.empty();
    }

    public boolean isUnlockingInProgress() {
        return mUnlockingInProgress;
    }
}
