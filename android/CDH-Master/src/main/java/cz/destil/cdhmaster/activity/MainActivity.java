package cz.destil.cdhmaster.activity;

import android.app.Activity;
import android.os.Bundle;

import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.api.Achievements;
import cz.destil.cdhmaster.data.Preferences;
import cz.destil.cdhmaster.fragment.AchievementsFragment;
import cz.destil.cdhmaster.fragment.AppFragment;
import cz.destil.cdhmaster.fragment.LoginFragment;

public class MainActivity extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        if (savedInstanceState == null) {
            if (Preferences.isLoggedIn()) {
                replaceFragment(AchievementsFragment.class);
            } else {
                replaceFragment(LoginFragment.class);
            }
        }
    }

    public void replaceFragment(Class<? extends AppFragment> clazz) {
        try {
            getFragmentManager().beginTransaction().replace(R.id.container, clazz.newInstance()).commit();
        } catch (InstantiationException e) {
            e.printStackTrace();
        } catch (IllegalAccessException e) {
            e.printStackTrace();
        }
    }
}
