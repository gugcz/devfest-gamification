package cz.destil.cdhmaster.view;

import android.content.Context;
import android.util.AttributeSet;
import android.widget.ImageView;
import android.widget.TextView;

import butterknife.InjectView;
import com.squareup.picasso.Picasso;
import cz.destil.cdhmaster.App;
import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.api.Achievements;

/**
 * Created by Destil on 24.10.13.
 */
public class AchievementView extends AdapterView<Achievements.Achievement> {

    @InjectView(R.id.picture)
    ImageView vPicture;
    @InjectView(R.id.name)
    TextView vName;
    @InjectView(R.id.location)
    TextView vLocation;

    public AchievementView(Context context) {
        super(context);
    }

    public AchievementView(Context context, AttributeSet attrs) {
        super(context, attrs);
    }

    public AchievementView(Context context, AttributeSet attrs, int defStyle) {
        super(context, attrs, defStyle);
    }

    @Override
    void setData(Achievements.Achievement achievement) {
        Picasso.with(App.get()).load(achievement.nice_image).into(vPicture);
        vName.setText(achievement.name);
        vLocation.setText(achievement.location);
    }
}
