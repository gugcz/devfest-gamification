package cz.destil.cdhmaster.api;

import retrofit.Callback;
import retrofit.http.Body;
import retrofit.http.POST;

/**
 * Created by Destil on 23.10.13.
 */
public interface Login {
    @POST("/login")
    void verify(@Body Request request, Callback<Response> callback);

    public static class Request {
        String password;

        public Request(String password) {
            this.password = password;
        }
    }

    public static class Response {

    }
}
