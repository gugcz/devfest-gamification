package cz.destil.cdhmaster;

import android.app.Application;

/**
 * Created by Destil on 24.10.13.
 */
public class App extends Application {

    static App sInstance;

    public static Application get() {
        return sInstance;
    }

    @Override
    public void onCreate() {
        super.onCreate();
        sInstance = this;
    }
}
