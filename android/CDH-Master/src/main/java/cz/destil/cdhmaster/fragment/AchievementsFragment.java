package cz.destil.cdhmaster.fragment;

import java.util.List;

import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;

import butterknife.InjectView;
import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.api.Achievements;
import cz.destil.cdhmaster.api.Api;
import cz.destil.cdhmaster.api.Attendees;
import cz.destil.cdhmaster.data.Preferences;
import cz.destil.cdhmaster.util.Util;
import cz.destil.cdhmaster.view.ViewAdapter;
import retrofit.Callback;
import retrofit.RetrofitError;
import retrofit.client.Response;

/**
 * Created by Destil on 24.10.13.
 */
public class AchievementsFragment extends AppFragment {

    @InjectView(R.id.list)
    ListView vListView;

    @Override
    int getLayoutId() {
        return R.layout.fragment_list;
    }

    @Override
    public void setupViews(View parentView) {
        if (Preferences.areAchievementsOffline()) {
            showAchievements(Preferences.getAchievements());
        } else {
            downloadAchievements();
        }
    }

    private void showAchievements(List<Achievements.Achievement> achievements) {
        final ViewAdapter<Achievements.Achievement> adapter = new ViewAdapter<Achievements.Achievement>(achievements, R.layout.view_achievement);
        vListView.setAdapter(adapter);
        vListView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Preferences.saveAchievement(adapter.getItem(position));
                replaceFragment(UnlockFragment.class);
            }
        });
    }

    private void downloadAchievements() {
        showProgress();
        Api.get().create(Achievements.class).get(new Callback<Achievements.Response>() {
            @Override
            public void success(Achievements.Response response, Response response2) {
                hideProgress();
                showAchievements(response.items);
                Preferences.saveAchievementList(response.items);
            }

            @Override
            public void failure(RetrofitError error) {
                hideProgress();
                Util.toastNegative(Api.getErrorString(error));
            }
        });
	    Api.get().create(Attendees.class).get(new Callback<Attendees.Response>() {
		    @Override
		    public void success(Attendees.Response response, Response response2) {
			    Preferences.saveAttendees(response.items);
		    }

		    @Override
		    public void failure(RetrofitError error) {
			    Util.toastNegative(Api.getErrorString(error));
		    }
	    });
    }

    @Override
    public int getMenuResource() {
        return R.menu.achievements;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if (item.getItemId() == R.id.menu_refresh) {
            downloadAchievements();
        }
        return super.onOptionsItemSelected(item);
    }
}
