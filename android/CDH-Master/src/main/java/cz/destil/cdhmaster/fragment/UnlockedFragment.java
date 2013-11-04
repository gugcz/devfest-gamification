package cz.destil.cdhmaster.fragment;

import android.content.Intent;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import java.math.BigInteger;

import butterknife.InjectView;
import butterknife.OnClick;
import cz.destil.cdhmaster.App;
import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.api.Achievements;
import cz.destil.cdhmaster.data.Preferences;
import cz.destil.cdhmaster.service.UnlockService;

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
        BigInteger gplusId = (BigInteger) getData();
        Picasso.with(App.get()).load(achievement.nice_image).into(vNiceImage);
        Picasso.with(App.get()).load("https://plus.google.com/s2/photos/profile/" + gplusId + "?sz=300").into(vProfilePicture);
        vName.setText(achievement.name);
        vCongratzText.setText(achievement.congrats_text);
        unlockAchievement(gplusId);
    }

    private void unlockAchievement(BigInteger gplusId) {
        Intent intent = new Intent(getActivity(), UnlockService.class);
        intent.putExtra(UnlockService.EXTRA_GPLUS_ID, gplusId);
        getActivity().startService(intent);
    }

    @OnClick(R.id.unlock_next)
    void unlockNext() {
        replaceFragment(UnlockFragment.class);
    }

}
