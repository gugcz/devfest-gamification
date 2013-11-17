package cz.destil.cdhmaster.fragment;

import android.app.Fragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;

import java.io.Serializable;

import butterknife.Views;
import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.activity.MainActivity;
import cz.destil.cdhmaster.data.Preferences;
import cz.destil.cdhmaster.util.Util;

/**
 * Created by Destil on 24.10.13.
 */
public abstract class AppFragment extends Fragment {

    public void replaceFragment(Class<? extends AppFragment> clazz) {
        ((MainActivity) getActivity()).replaceFragment(clazz);
    }

    public void replaceFragment(Class<? extends AppFragment> clazz, Serializable serializable) {
        ((MainActivity) getActivity()).replaceFragment(clazz, serializable);
    }

    public void replaceFragmentToBack(Class<HistoryFragment> clazz) {
        ((MainActivity) getActivity()).replaceFragmentToBack(clazz);
    }

    public void replaceFragment(Class<? extends AppFragment> clazz, Serializable serializable, boolean addToBackStack) {
        ((MainActivity) getActivity()).replaceFragment(clazz, serializable, addToBackStack);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        if (getMenuResource() != -1) {
            setHasOptionsMenu(true);
        }
        return inflater.inflate(getLayoutId(), container, false);
    }

    @Override
    public void onViewCreated(View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        Views.inject(this, view);
        setupViews(view);
        if (savedInstanceState==null) {
            setupViewsFirstRotation(view);
        }
    }

    @Override
    public void onCreateOptionsMenu(Menu menu, MenuInflater inflater) {
        if (getMenuResource() != -1) {
            inflater.inflate(getMenuResource(), menu);
        }
    }

    abstract int getLayoutId();

    public void setupViews(View parentView) {
        // override in child
    }

    public void setupViewsFirstRotation(View parentView) {
        // override in child
    }

    public int getMenuResource() {
        return -1;
        // override in child
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.menu_history:
                replaceFragmentToBack(HistoryFragment.class);
                return true;
            case R.id.menu_change_achievement:
                Preferences.clearSelectedAchievement();
                replaceFragment(AchievementsFragment.class);
                return true;
            case R.id.menu_update:
                Util.openBrowser(getActivity(), "https://drive.google.com/folderview?id=0B6rxb_ov7Sd5aFpFYmV3eWowQTQ");
                return true;
        }
        return super.onOptionsItemSelected(item);
    }

    public Serializable getData() {
        if (getArguments() == null) {
            return null;
        }
        return getArguments().getSerializable("DATA");
    }

    protected void showProgress() {
        getActivity().setProgressBarIndeterminateVisibility(true);
    }

    protected void hideProgress() {
        getActivity().setProgressBarIndeterminateVisibility(false);
    }

}
