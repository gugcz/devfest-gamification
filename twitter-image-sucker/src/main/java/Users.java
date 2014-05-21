import retrofit.http.GET;
import retrofit.http.Header;
import retrofit.http.Query;

/**
 * Copyright (c) ${year}, Inmite s.r.o. (www.inmite.eu). All rights reserved.
 * <p/>
 * This source code can be used only for purposes specified by the given license contract
 * signed by the rightful deputy of Inmite s.r.o. This source code can be used only
 * by the owner of the license.
 * <p/>
 * Any disputes arising in respect of this agreement (license) shall be brought
 * before the Municipal Court of Prague.
 */
public interface Users {
	@GET("/1.1/users/show.json")
	User show(@Header("Authorization") String token, @Query("screen_name") String screenName);

	static class User {
		public String profile_image_url;
	}
}
