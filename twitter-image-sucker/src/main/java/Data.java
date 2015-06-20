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
public class Data {
	public static final Attendee[] ATTENDEES = {
		new Attendee(1,"test","test@test.cz"),
		new Attendee(2,"test2","test2@test.cz")
	};

	public static class Attendee {
		public int id;
		public String twitter;
		public String email;

		Attendee(int id, String twitter, String email) {
			this.id = id;
			this.twitter = twitter.replace("@", "");
			this.email = email;
		}
	}


}
