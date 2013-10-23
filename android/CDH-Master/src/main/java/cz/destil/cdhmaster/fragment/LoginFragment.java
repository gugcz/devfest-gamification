package cz.destil.cdhmaster.fragment;

import android.app.Fragment;
import android.os.Bundle;
import android.os.Debug;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.Toast;

import butterknife.InjectView;
import butterknife.OnClick;
import butterknife.Views;
import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.api.Achievements;
import cz.destil.cdhmaster.api.Api;
import cz.destil.cdhmaster.api.Login;
import cz.destil.cdhmaster.util.DebugLog;
import retrofit.Callback;
import retrofit.RetrofitError;
import retrofit.client.Response;

/**
 * Created by Destil on 23.10.13.
 */
public class LoginFragment extends Fragment {

    @InjectView(R.id.password)
    EditText vPassword;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_login, container, false);
    }

    @Override
    public void onViewCreated(View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        Views.inject(this, view);
    }

    @OnClick(R.id.verify)
    void verify() {
        String password = vPassword.getText().toString();
        Api.get().create(Login.class).verify(new Login.Request(password), new Callback<Login.Response>() {
            @Override
            public void success(Login.Response loginResponse, Response response) {
                DebugLog.d("login success");
                getAchievements();
            }

            @Override
            public void failure(RetrofitError retrofitError) {
                vPassword.setError(Api.getErrorString(retrofitError));
            }
        });
    }

    private void getAchievements() {
        Api.get().create(Achievements.class).get(new Callback<Achievements.Response>() {
            @Override
            public void success(Achievements.Response response, Response response2) {
                DebugLog.d(response.items.toString());
            }

            @Override
            public void failure(RetrofitError error) {

            }
        });
    }
}
