package cz.destil.cdhmaster.activity;

import java.io.Serializable;

import android.app.Activity;
import android.app.FragmentTransaction;
import android.os.Bundle;
import android.view.MenuItem;
import android.view.Window;

import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.data.Preferences;
import cz.destil.cdhmaster.fragment.*;

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
