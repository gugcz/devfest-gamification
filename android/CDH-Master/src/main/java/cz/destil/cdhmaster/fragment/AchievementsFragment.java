package cz.destil.cdhmaster.fragment;

import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

import cz.destil.cdhmaster.App;
import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.api.Achievements;
import cz.destil.cdhmaster.api.Api;
import cz.destil.cdhmaster.data.Preferences;
import cz.destil.cdhmaster.util.DebugLog;
import cz.destil.cdhmaster.util.Util;
import cz.destil.cdhmaster.view.AchievementView;
import cz.destil.cdhmaster.view.ViewAdapter;
import retrofit.Callback;
import retrofit.RetrofitError;
import retrofit.client.Response;

/**
 * Created by Destil on 24.10.13.
 */
public class AchievementsFragment extends AppFragment {

    private ListView vListView;

    @Override
    int getLayoutId() {
        return R.layout.fragment_achievements;
    }

    @Override
    public void setupViews(View parentView) {
        vListView = (ListView) parentView;

        Api.get().create(Achievements.class).get(new Callback<Achievements.Response>() {
            @Override
            public void success(Achievements.Response response, Response response2) {
                DebugLog.d(response.items.toString());
                final ViewAdapter<Achievements.Achievement> adapter = new ViewAdapter<Achievements.Achievement>(response.items, R.layout.view_achievement);
                vListView.setAdapter(adapter);
                vListView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                    @Override
                    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                        Preferences.saveAchievement(adapter.getItem(position));
                        replaceFragment(UnlockFragment.class);
                    }
                });
            }

            @Override
            public void failure(RetrofitError error) {
                Util.toast(Api.getErrorString(error));
            }
        });
    }
}
