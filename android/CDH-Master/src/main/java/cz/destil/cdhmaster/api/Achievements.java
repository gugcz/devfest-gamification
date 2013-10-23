package cz.destil.cdhmaster.api;

import java.util.List;

import retrofit.Callback;
import retrofit.http.Body;
import retrofit.http.GET;

/**
 * Created by Destil on 23.10.13.
 */
public interface Achievements {

    @GET("/achievements.php")
    void get(Callback<Response> callback);

    public static class Response {
        public List<Achievement> items;
    }

    static class Achievement {
        public int id;
        public String name;
        public String location;
        public String nice_image;
        public String basic_image;
        public String congrats_text;
        public int unlockedCount;

        @Override
        public String toString() {
            return "Achievement{" +
                    "id=" + id +
                    ", name='" + name + '\'' +
                    ", location='" + location + '\'' +
                    ", niceImage='" + nice_image + '\'' +
                    ", basicImage='" + basic_image + '\'' +
                    ", congratsText='" + congrats_text + '\'' +
                    ", unlockedCount=" + unlockedCount +
                    '}';
        }
    }
}
