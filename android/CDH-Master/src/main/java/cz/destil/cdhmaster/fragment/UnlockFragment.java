package cz.destil.cdhmaster.fragment;

import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import butterknife.InjectView;
import cz.destil.cdhmaster.App;
import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.api.Achievements;
import cz.destil.cdhmaster.data.Preferences;

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
    @InjectView(R.id.nfc_status)
    TextView vNfcStatus;
    @InjectView(R.id.scan_qr)
    Button vScanQr;

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
    }

    @Override
    public int getMenuResource() {
        return R.menu.unlock;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if (item.getItemId() == R.id.menu_change_achievement) {
            Preferences.clearSelectedAchievement();
            replaceFragment(AchievementsFragment.class);
            return true;
        }
        return super.onOptionsItemSelected(item);
    }
}
