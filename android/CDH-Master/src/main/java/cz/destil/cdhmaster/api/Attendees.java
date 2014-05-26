package cz.destil.cdhmaster.api;

import java.util.List;

import retrofit.Callback;
import retrofit.http.GET;

/**
 * Created by Destil on 23.10.13.
 */
public interface Attendees {

	@GET("/attendees")
	void get(Callback<Response> callback);

	public static class Response {
		public List<Attendee> items;
	}

	static class Attendee {
		public long id;
		public String first_name;
		public String last_name;
		public String email;
		public boolean duplicate_name;

		@Override
		public String toString() {
			String text = first_name + " " + last_name;
			if (duplicate_name) {
				text += " (" + email + ")";
			}
			return text;
		}
	}
}
