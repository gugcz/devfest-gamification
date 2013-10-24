package cz.destil.cdhmaster.util;

import android.widget.Toast;

import cz.destil.cdhmaster.App;

/**
 * Created by Destil on 24.10.13.
 */
public class Util {
    public static void toast(String message) {
        Toast.makeText(App.get(), message, Toast.LENGTH_LONG).show();
    }
}
