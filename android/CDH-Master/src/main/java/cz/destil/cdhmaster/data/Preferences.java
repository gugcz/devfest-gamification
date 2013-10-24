package cz.destil.cdhmaster.data;

import android.app.Application;
import android.preference.PreferenceManager;

import cz.destil.cdhmaster.App;

/**
 * Created by Destil on 24.10.13.
 */
public class Preferences {
    public static void savePassword(String password) {
        PreferenceManager.getDefaultSharedPreferences(App.get()).edit().putString("PASSWORD", password).commit();
    }

    public static boolean isLoggedIn() {
        return PreferenceManager.getDefaultSharedPreferences(App.get()).contains("PASSWORD");
    }

    public static String getPassword() {
        return PreferenceManager.getDefaultSharedPreferences(App.get()).getString("PASSWORD", null);
    }
}
