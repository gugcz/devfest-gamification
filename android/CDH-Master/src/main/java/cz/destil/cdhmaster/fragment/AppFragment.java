package cz.destil.cdhmaster.fragment;

import android.app.Fragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.View;
import android.view.ViewGroup;

import java.io.Serializable;

import butterknife.Views;
import cz.destil.cdhmaster.activity.MainActivity;

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

    public int getMenuResource() {
        return -1;
        // override in child
    }

    public Serializable getData() {
        if (getArguments() == null) {
            return null;
        }
        return getArguments().getSerializable("DATA");
    }

}
