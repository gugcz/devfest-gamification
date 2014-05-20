/**
 * Copyright (c) 2014, Inmite s.r.o. (www.inmite.eu). All rights reserved. 
 *
 * This source code can be used only for purposes specified by the given license contract 
 * signed by the rightful deputy of Inmite s.r.o. This source code can be used only 
 * by the owner of the license. 
 *
 * Any disputes arising in respect of this agreement (license) shall be brought 
 * before the Municipal Court of Prague. 
 */
package cz.destil.cdhmaster.adapter;

import java.util.List;

import android.content.Context;
import android.widget.ArrayAdapter;

import cz.destil.cdhmaster.api.Attendees;

/**
 * @author David Vávra (david@inmite.eu)
 */
public class AttendeeAdapter extends ArrayAdapter<Attendees.Attendee> {

	List<Attendees.Attendee> mAttendees;

	public AttendeeAdapter(Context context, int resource, List<Attendees.Attendee> objects) {
		super(context, resource, objects);
		mAttendees = objects;
	}

	@Override
	public long getItemId(int position) {
		return mAttendees.get(position).id;
	}
}
