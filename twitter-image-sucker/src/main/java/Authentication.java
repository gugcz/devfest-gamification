import retrofit.http.Body;
import retrofit.http.Header;
import retrofit.http.Headers;
import retrofit.http.POST;
import retrofit.mime.TypedString;

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
public interface Authentication {

	@Headers({
		"Content-Type: application/x-www-form-urlencoded;charset=UTF-8",
		"User-Agent: mDevGame Sucker"
	})
	@POST("/oauth2/token")
	Access authenticate(@Header("Authorization") String encodedKeys, @Body TypedString body);

	static class Access {
		public String access_token;
	}
}
