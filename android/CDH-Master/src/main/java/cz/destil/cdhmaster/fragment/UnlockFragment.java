package cz.destil.cdhmaster.fragment;

import android.view.View;
import android.widget.AdapterView;
import android.widget.AutoCompleteTextView;
import android.widget.ImageView;
import android.widget.TextView;

import butterknife.InjectView;
import butterknife.OnClick;
import com.squareup.picasso.Picasso;
import cz.destil.cdhmaster.App;
import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.adapter.AttendeeAdapter;
import cz.destil.cdhmaster.api.Achievements;
import cz.destil.cdhmaster.data.Preferences;
import cz.destil.cdhmaster.util.Util;

/**
 * Created by Destil on 30.10.13.
 */
public class UnlockFragment extends AppFragment {

    @InjectView(R.id.basic_image)
    ImageView vBasicImage;
    @InjectView(R.id.name)
    TextView vName;
    @InjectView(R.id.location)
    TextView vLocation;
    @InjectView(R.id.attendee_name)
    AutoCompleteTextView vAttendeeName;
	private long mSelectedAttendeeId = -1;

    @Override
    int getLayoutId() {
        return R.layout.fragment_unlock;
    }

    @Override
    public void setupViews(View parentView) {
        Achievements.Achievement achievement = Preferences.getAchievement();
        Picasso.with(App.get()).load(achievement.basic_image).into(vBasicImage);
        vName.setText(achievement.name);
        vLocation.setText(achievement.location);
	    vAttendeeName.setAdapter(new AttendeeAdapter(getActivity(), R.layout.view_autocomplete, Preferences.getAttendees()));
	    vAttendeeName.setOnItemClickListener(new AdapterView.OnItemClickListener() {

		    @Override
		    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
			    mSelectedAttendeeId = id;
		    }
	    });
	    vAttendeeName.requestFocus();
    }

    @Override
    public int getMenuResource() {
        return R.menu.unlock;
    }

    @OnClick(R.id.unlock)
    void unlock() {
	    if (mSelectedAttendeeId == -1) {
		    Util.toastNegative("You didn't select attendee");
	    } else {
		    vAttendeeName.setText("");
		    Util.hideKeyboard(vAttendeeName);
		    replaceFragment(UnlockedFragment.class, mSelectedAttendeeId, true);
	    }
    }
}
