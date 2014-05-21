import retrofit.RestAdapter;

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
public class Api {

	public static final String URL = "https://api.twitter.com";

	public static RestAdapter get() {
		return new RestAdapter.Builder().setEndpoint(URL).setLogLevel(RestAdapter.LogLevel.BASIC).setLog(new RestAdapter.Log() {
			@Override
			public void log(String s) {
				System.out.println(s);
			}
		}).build();
	}
}
