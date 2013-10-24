package cz.destil.cdhmaster.fragment;

import android.app.Fragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import butterknife.Views;
import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.activity.MainActivity;

/**
 * Created by Destil on 24.10.13.
 */
public abstract class AppFragment extends Fragment {

    public void replaceFragment(Class<? extends AppFragment> clazz) {
        ((MainActivity)getActivity()).replaceFragment(clazz);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        return inflater.inflate(getLayoutId(), container, false);
    }

    @Override
    public void onViewCreated(View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        Views.inject(this, view);
        setupViews(view);
    }

    abstract int getLayoutId();

    public void setupViews(View parentView) {
        // override in child
    }

}
