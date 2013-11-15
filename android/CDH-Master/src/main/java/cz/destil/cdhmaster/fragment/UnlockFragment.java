package cz.destil.cdhmaster.fragment;

import android.app.Activity;
import android.app.PendingIntent;
import android.content.ActivityNotFoundException;
import android.content.Intent;
import android.content.IntentFilter;
import android.net.Uri;
import android.nfc.NfcAdapter;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import java.math.BigInteger;

import butterknife.InjectView;
import butterknife.OnClick;
import cz.destil.cdhmaster.App;
import cz.destil.cdhmaster.R;
import cz.destil.cdhmaster.activity.MainActivity;
import cz.destil.cdhmaster.api.Achievements;
import cz.destil.cdhmaster.data.Preferences;
import cz.destil.cdhmaster.util.DebugLog;
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
    @InjectView(R.id.nfc_status)
    TextView vNfcStatus;
    NfcAdapter mNfcAdapter;

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
    public void onResume() {
        super.onResume();
        mNfcAdapter = NfcAdapter.getDefaultAdapter(getActivity());
        if (mNfcAdapter == null) {
            vNfcStatus.setText("NFC not enabled, enable it or use QR code.");
        } else {
            vNfcStatus.setText("NFC ready! You can tap attendee badge to unlock achievement.");
            PendingIntent pendingIntent = PendingIntent.getActivity(
                    getActivity(), 0, new Intent(getActivity(), MainActivity.class).addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP), 0);
            mNfcAdapter.enableForegroundDispatch(getActivity(), pendingIntent, null, null);
        }
    }

    @Override
    public void onPause() {
        if (mNfcAdapter!=null) {
            mNfcAdapter.disableForegroundDispatch(getActivity());
            vNfcStatus.setText("NFC not enabled, enable it or use QR code.");
        }
        super.onPause();
    }

    @Override
    public int getMenuResource() {
        return R.menu.unlock;
    }

    @OnClick(R.id.scan_qr)
    void scanQr() {
        try {
            Intent intent = new Intent("com.google.zxing.client.android.SCAN");
            intent.putExtra("SCAN_MODE", "QR_CODE_MODE");
            startActivityForResult(intent, 0);
        } catch (ActivityNotFoundException e) {
            Util.openBrowser(getActivity(), "https://play.google.com/store/apps/details?id=eu.inmite.prj.vf.reader");
        }
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (requestCode == 0) {
            if (resultCode == Activity.RESULT_OK) {
                String contents = data.getStringExtra("SCAN_RESULT");
                processTag(contents);
            }
        }
    }

    public void processTag(String contents) {
        BigInteger gplusId = parseGplusId(contents);
        if (gplusId.equals(BigInteger.ZERO)) {
            Util.toastNegative("Invalid G+ ID");
        } else {
            replaceFragment(UnlockedFragment.class, gplusId);
        }
    }

    private BigInteger parseGplusId(String url) {
        String[] parts = url.split("/");
        for (int i = parts.length - 1; i >= 0; i--) {
            String part = parts[i];
            try {
                return new BigInteger(part);
            } catch (NumberFormatException e) {
                // continue
            }
        }
        return BigInteger.ZERO;
    }
}
