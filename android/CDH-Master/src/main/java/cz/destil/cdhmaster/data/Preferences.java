package cz.destil.cdhmaster.data;

import java.util.ArrayList;
import java.util.Date;
import java.util.List;

import android.content.SharedPreferences;
import android.preference.PreferenceManager;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import cz.destil.cdhmaster.App;
import cz.destil.cdhmaster.api.Achievements;
import cz.destil.cdhmaster.api.Attendees;

/**
 * Created by Destil on 24.10.13.
 */
public class Preferences {
    public static void savePassword(String password) {
        get().edit().putString("PASSWORD", password).commit();
    }

    public static boolean isLoggedIn() {
        return get().contains("PASSWORD");
    }

    public static String getPassword() {
        return get().getString("PASSWORD", null);
    }

    public static void saveAchievement(Achievements.Achievement achievement) {
        String json = new Gson().toJson(achievement);
        get().edit().putString("ACHIEVEMENT", json).commit();
    }

    public static Achievements.Achievement getAchievement() {
        String json = get().getString("ACHIEVEMENT", null);
        return new Gson().fromJson(json, Achievements.Achievement.class);
    }

    public static boolean isAchievementSelected() {
        return get().contains("ACHIEVEMENT");
    }

    public static void clearSelectedAchievement() {
        get().edit().remove("ACHIEVEMENT").commit();
    }

    private static SharedPreferences get() {
        return PreferenceManager.getDefaultSharedPreferences(App.get());
    }

    public static void saveAchievementList(List<Achievements.Achievement> achievements) {
        String json = new Gson().toJson(achievements);
        get().edit().putString("ACHIEVEMENTS", json).commit();
    }

    public static List<Achievements.Achievement> getAchievements() {
        String json = get().getString("ACHIEVEMENTS", null);
        return new Gson().fromJson(json, new TypeToken<List<Achievements.Achievement>>() {
        }.getType());
    }

    public static boolean areAchievementsOffline() {
        return get().contains("ACHIEVEMENTS");
    }

    public static void addHistory(String firstLine, String secondLine) {
        List<String> history = getHistory();
        history.add(firstLine + "\n" + secondLine + "\n" + new Date());
        String json = new Gson().toJson(history);
        get().edit().putString("HISTORY", json).commit();
    }

    public static List<String> getHistory() {
        String json = get().getString("HISTORY", null);
        if (json == null) {
            return new ArrayList<String>();
        }
        return new Gson().fromJson(json, new TypeToken<List<String>>() {
        }.getType());
    }

    public static String getAchievementNameById(int achievementId) {
        for (Achievements.Achievement achievement : getAchievements()) {
            if (achievement.id == achievementId) {
                return achievement.name;
            }
        }
        return null;
    }

	public static void saveAttendees(List<Attendees.Attendee> items) {
		String json = new Gson().toJson(items);
		get().edit().putString("ATTENDEES", json).commit();
	}

	public static List<Attendees.Attendee> getAttendees() {
		String json = get().getString("ATTENDEES", null);
		return new Gson().fromJson(json, new TypeToken<List<Attendees.Attendee>>() {
		}.getType());
	}
}
