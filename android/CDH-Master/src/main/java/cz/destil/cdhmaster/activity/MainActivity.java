package cz.destil.cdhmaster.activity;

import android.app.Activity;
import android.app.Fragment;
import android.app.FragmentTransaction;
import android.content.Intent;
import android.nfc.NdefMessage;
import android.nfc.NfcAdapter;
import android.os.Bundle;
import android.os.Parcelable;
import android.view.MenuItem;
import android.view.Window;

import java.io.Serializable;

import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.data.Preferences;
import cz.destil.cdhmaster.fragment.AchievementsFragment;
import cz.destil.cdhmaster.fragment.AppFragment;
import cz.destil.cdhmaster.fragment.HistoryFragment;
import cz.destil.cdhmaster.fragment.LoginFragment;
import cz.destil.cdhmaster.fragment.UnlockFragment;

public class MainActivity extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        requestWindowFeature(Window.FEATURE_INDETERMINATE_PROGRESS);
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        if (savedInstanceState == null) {
            if (Preferences.isLoggedIn()) {
                if (Preferences.isAchievementSelected()) {
                    replaceFragment(UnlockFragment.class);
                } else {
                    replaceFragment(AchievementsFragment.class);
                }
            } else {
                replaceFragment(LoginFragment.class);
            }
        }
    }

    public void replaceFragment(Class<? extends AppFragment> clazz) {
        replaceFragment(clazz, null, false);
    }

    public void replaceFragmentToBack(Class<HistoryFragment> clazz) {
        replaceFragment(clazz, null, true);
    }

    public void replaceFragment(Class<? extends AppFragment> clazz, Serializable serializable) {
        replaceFragment(clazz, serializable, false);
    }

    public void replaceFragment(Class<? extends AppFragment> clazz, Serializable serializable, boolean addToBackStack) {
        AppFragment fragment = null;
        try {
            fragment = clazz.newInstance();
        } catch (InstantiationException e) {
            e.printStackTrace();
        } catch (IllegalAccessException e) {
            e.printStackTrace();
        }
        if (serializable != null) {
            Bundle bundle = new Bundle();
            bundle.putSerializable("DATA", serializable);
            fragment.setArguments(bundle);
        }
        FragmentTransaction transaction = getFragmentManager().beginTransaction();
        if (addToBackStack) {
            transaction.addToBackStack(null);
            getActionBar().setDisplayHomeAsUpEnabled(true);
        } else {
            getActionBar().setDisplayHomeAsUpEnabled(false);
        }
        transaction.replace(R.id.container, fragment).commit();
    }

    @Override
    protected void onNewIntent(Intent intent) {
        Parcelable[] rawMsgs = intent.getParcelableArrayExtra(
                NfcAdapter.EXTRA_NDEF_MESSAGES);
        if (rawMsgs != null && rawMsgs.length > 0) {
            NdefMessage msg = (NdefMessage) rawMsgs[0];
            Fragment currentFragment = getFragmentManager().findFragmentById(R.id.container);
            if (currentFragment instanceof UnlockFragment) {
                ((UnlockFragment) currentFragment).processTag(new String(msg.getRecords()[0].getPayload()));
            }
        }
    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        getActionBar().setDisplayHomeAsUpEnabled(false);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if (item.getItemId()==android.R.id.home) {
            onBackPressed();
            return true;
        }
        return super.onOptionsItemSelected(item);
    }
}
