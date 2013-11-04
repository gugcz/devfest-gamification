package cz.destil.cdhmaster.api;

import java.math.BigInteger;

import retrofit.Callback;
import retrofit.http.Body;
import retrofit.http.POST;

/**
 * Created by Destil on 4.11.13.
 */
public interface Unlock {

    @POST("/achievements/unlock")
    void unlock(@Body Request request, Callback<Response> cb);

    static class Request {
        BigInteger gplus_id;
        int achievement_id;
        String password;
        String org_email;

        public Request(BigInteger gplus_id, int achievement_id, String password, String org_email) {
            this.gplus_id = gplus_id;
            this.achievement_id = achievement_id;
            this.password = password;
            this.org_email = org_email;
        }
    }

    static class Response {
        public String user_name;
        public String user_image;
        public int achievements_unlocked;
        public int leaderboard_position;
    }
}
