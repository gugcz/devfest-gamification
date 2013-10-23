package cz.destil.cdhmaster.api;

import cz.destil.cdhmaster.util.DebugLog;
import retrofit.RestAdapter;
import retrofit.RetrofitError;

/**
 * Created by Destil on 23.10.13.
 */
public class Api {

    public static final String URL = "http://game.korejtko.cz/api";

    public static RestAdapter get() {
        return new RestAdapter.Builder().setServer(URL).setLogLevel(RestAdapter.LogLevel.BASIC).setLog(new RestAdapter.Log() {
            @Override
            public void log(String s) {
                DebugLog.d(s);
            }
        }).build();
    }

    public static String getErrorString(RetrofitError retrofitError) {
        if (retrofitError == null) {
            return null;
        }
        if (retrofitError.isNetworkError()) {
            return "Connect to the Internet";
        }
        if (retrofitError.getResponse().getStatus() == 400) {
            ErrorResponse errorResponse = (ErrorResponse) retrofitError.getBodyAs(ErrorResponse.class);
            return errorResponse.error;
        } else {
            return "Unknown error";
        }
    }

    public class ErrorResponse {
        public String error;
    }
}
