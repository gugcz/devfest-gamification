package cz.destil.cdhmaster.view;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;

import java.util.List;

import cz.destil.cdhmaster.App;

/**
 * Created by Destil on 24.10.13.
 */
public class ViewAdapter<T> extends ArrayAdapter<T> {

    private List<T> mList;
    private int mLayoutId;

    public ViewAdapter(List<T> list, int layoutId) {
        super(App.get(), layoutId, list);
        mList = list;
        mLayoutId = layoutId;
    }

    @Override
    public int getCount() {
        return mList.size();
    }

    public T getItem(int position) {
        return mList.get(position);
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if (convertView == null) {
            convertView = LayoutInflater.from(getContext()).inflate(mLayoutId, parent, false);
        }
        ((AdapterView<T>) convertView).setData(getItem(position));
        return convertView;
    }
}
