package cz.destil.cdhmaster.fragment;

import android.content.Intent;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import butterknife.InjectView;
import butterknife.OnClick;
import com.squareup.picasso.Picasso;
import cz.destil.cdhmaster.App;
import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.api.Achievements;
import cz.destil.cdhmaster.data.Preferences;
import cz.destil.cdhmaster.service.UnlockService;
import cz.destil.cdhmaster.util.Util;

/**
 * Created by Destil on 30.10.13.
 */
public class UnlockedFragment extends AppFragment {

    @InjectView(R.id.nice_image)
    ImageView vNiceImage;
    @InjectView(R.id.profile_picture)
    ImageView vProfilePicture;
    @InjectView(R.id.name)
    TextView vName;
    @InjectView(R.id.congratz_text)
    TextView vCongratzText;
    @InjectView(R.id.status)
    TextView vStatus;

    @Override
    int getLayoutId() {
        return R.layout.fragment_unlocked;
    }

    @Override
    public void setupViews(View parentView) {
        Achievements.Achievement achievement = Preferences.getAchievement();
        Picasso.with(App.get()).load(achievement.nice_image).into(vNiceImage);
        vName.setText(achievement.name);
        vCongratzText.setText(achievement.congrats_text);
    }

    @Override
    public void setupViewsFirstRotation(View parentView) {
	    long attendeeId = (Long) getData();
        unlockAchievement(attendeeId);
    }

    private void unlockAchievement(long attendeeId) {
        Intent intent = new Intent(getActivity(), UnlockService.class);
        intent.putExtra(UnlockService.EXTRA_ATTENDEE_ID, attendeeId);
        getActivity().startService(intent);
    }

    @OnClick(R.id.unlock_next)
    void unlockNext() {
	    Util.showKeyboard();
	    getActivity().onBackPressed();
    }

    @Override
    public int getMenuResource() {
        return R.menu.login;
    }
}
