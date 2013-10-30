package cz.destil.cdhmaster.activity;

import android.app.Activity;
import android.os.Bundle;

import java.io.Serializable;

import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.data.Preferences;
import cz.destil.cdhmaster.fragment.AchievementsFragment;
import cz.destil.cdhmaster.fragment.AppFragment;
import cz.destil.cdhmaster.fragment.LoginFragment;
import cz.destil.cdhmaster.fragment.UnlockFragment;

public class MainActivity extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
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
        replaceFragment(clazz, null);
    }

    public void replaceFragment(Class<? extends AppFragment> clazz, Serializable serializable) {
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
        getFragmentManager().beginTransaction().replace(R.id.container, fragment).commit();
    }
}
