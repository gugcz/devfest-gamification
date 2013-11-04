package cz.destil.cdhmaster.util;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import cz.destil.cdhmaster.App;

/**
 * Created by Destil on 24.10.13.
 */
public class Util {
    public static void toastPositive(String message) {
        toast(message, android.R.color.holo_green_light, android.R.color.primary_text_light);
    }

    public static void toastNegative(String message) {
        toast(message, android.R.color.holo_red_light, android.R.color.primary_text_light);
    }

    private static void toast(String message, int backgroundColor, int textColor) {
        Toast toast = Toast.makeText(App.get(), message, Toast.LENGTH_LONG);
        View view = toast.getView();
        view.setBackgroundColor(App.get().getResources().getColor(backgroundColor));
        TextView text = (TextView) view.findViewById(android.R.id.message);
        text.setTextColor(App.get().getResources().getColor(textColor));
        toast.show();
    }

    public static boolean isNetworkAvailable() {
        ConnectivityManager connectivityManager
                = (ConnectivityManager) App.get().getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        return activeNetworkInfo != null && activeNetworkInfo.isConnected();
    }
}
