package cz.destil.cdhmaster.fragment;

import android.app.Fragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;

import butterknife.InjectView;
import butterknife.OnClick;
import butterknife.Views;
import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.api.Achievements;
import cz.destil.cdhmaster.api.Api;
import cz.destil.cdhmaster.api.Login;
import cz.destil.cdhmaster.data.Preferences;
import cz.destil.cdhmaster.util.DebugLog;
import retrofit.Callback;
import retrofit.RetrofitError;
import retrofit.client.Response;

/**
 * Created by Destil on 23.10.13.
 */
public class LoginFragment extends AppFragment {

    @InjectView(R.id.password)
    EditText vPassword;

    @Override
    int getLayoutId() {
        return R.layout.fragment_login;
    }

    @OnClick(R.id.verify)
    void verify() {
        final String password = vPassword.getText().toString();
        showProgress();
        Api.get().create(Login.class).verify(new Login.Request(password), new Callback<Login.Response>() {
            @Override
            public void success(Login.Response loginResponse, Response response) {
                hideProgress();
                Preferences.savePassword(password);
                replaceFragment(AchievementsFragment.class);
            }

            @Override
            public void failure(RetrofitError retrofitError) {
                hideProgress();
                vPassword.setError(Api.getErrorString(retrofitError));
            }
        });
    }

    @Override
    public int getMenuResource() {
        return R.menu.login;
    }
}
