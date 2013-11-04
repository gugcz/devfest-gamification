package cz.destil.cdhmaster.service;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;

import cz.destil.cdhmaster.util.Util;

/**
 * Created by Destil on 4.11.13.
 */
public class ConnectivityReceiver extends BroadcastReceiver {
    @Override
    public void onReceive(Context context, Intent intent) {
        if (Util.isNetworkAvailable()) {
            UnlockService unlockService = UnlockService.get();
            if (unlockService!=null && !unlockService.isStackEmpty()) {
                unlockService.unlockNext();
            }
        }
    }
}
