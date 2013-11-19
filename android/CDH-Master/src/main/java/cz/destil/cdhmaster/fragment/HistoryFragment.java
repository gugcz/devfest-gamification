package cz.destil.cdhmaster.fragment;

import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

import java.util.Collections;
import java.util.List;

import butterknife.InjectView;
import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.api.Achievements;
import cz.destil.cdhmaster.api.Api;
import cz.destil.cdhmaster.data.Preferences;
import cz.destil.cdhmaster.util.Util;
import cz.destil.cdhmaster.view.ViewAdapter;
import retrofit.Callback;
import retrofit.RetrofitError;
import retrofit.client.Response;

/**
 * Created by Destil on 24.10.13.
 */
public class HistoryFragment extends AppFragment {

    @InjectView(R.id.list)
    ListView vListView;
    @InjectView(R.id.empty)
    TextView vEmpty;

    @Override
    int getLayoutId() {
        return R.layout.fragment_list;
    }

    @Override
    public void setupViews(View parentView) {
        vListView.setEmptyView(vEmpty);
        List<String> history = Preferences.getHistory();
        Collections.reverse(history);
        vListView.setAdapter(new ArrayAdapter<String>(getActivity(), android.R.layout.simple_list_item_1, history));
    }
}
