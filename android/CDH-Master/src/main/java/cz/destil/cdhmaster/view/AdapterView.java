package cz.destil.cdhmaster.view;

import android.content.Context;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;

import java.util.List;

import butterknife.Views;
import cz.destil.cdhmaster.App;

/**
 * Created by Destil on 24.10.13.
 */
abstract class AdapterView<T> extends LinearLayout {

    public AdapterView(Context context) {
        super(context);
    }

    public AdapterView(Context context, AttributeSet attrs) {
        super(context, attrs);
    }

    public AdapterView(Context context, AttributeSet attrs, int defStyle) {
        super(context, attrs, defStyle);
    }

    @Override
    protected void onFinishInflate() {
        super.onFinishInflate();
        Views.inject(this, this);
    }

    abstract void setData(T item);
}
