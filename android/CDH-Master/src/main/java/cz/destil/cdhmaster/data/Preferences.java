package cz.destil.cdhmaster.data;

import android.content.SharedPreferences;
import android.preference.PreferenceManager;

import com.google.gson.Gson;

import cz.destil.cdhmaster.App;
import cz.destil.cdhmaster.api.Achievements;

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
}
