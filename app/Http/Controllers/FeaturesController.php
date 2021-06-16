<?php

namespace App\Http\Controllers;

use App\feature_sub_products;
use App\features;
use App\User;
use App\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use Auth;
use App\Generalsetting;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeaturesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index()
    {
        $features = features::orderBy('id','desc')->get();

        return view('admin.features.index',compact('features'));
    }

    public function create()
    {
        return view('admin.features.create');
    }

    public function store(Request $request)
    {
        if($request->feature_id)
        {
            $removed = explode(',', $request->removed);
            feature_sub_products::whereIn('id',$removed)->delete();

            features::where('id',$request->feature_id)->update(['title' => $request->title]);

            $sub = feature_sub_products::where('feature_id',$request->feature_id)->get();

            if(count($sub) == 0)
            {
                foreach ($request->sub_codes as $i => $key)
                {
                    if($key && $request->sub_product_titles[$i])
                    {
                        $sub = new feature_sub_products;
                        $sub->feature_id = $request->feature_id;
                        $sub->unique_code = $key;
                        $sub->title = $request->sub_product_titles[$i];
                        $sub->size1_value = $request->size1_value[$i];
                        $sub->size2_value = $request->size2_value[$i];
                        $sub->save();
                    }
                }
            }
            else
            {
                if(count($request->sub_codes) > 0)
                {
                    foreach ($request->sub_codes as $s => $key)
                    {
                        $sub_check = feature_sub_products::where('feature_id',$request->feature_id)->skip($s)->first();

                        if($sub_check)
                        {
                            if($key && $request->sub_product_titles[$s])
                            {
                                $sub_check->unique_code = $key;
                                $sub_check->title = $request->sub_product_titles[$s];
                                $sub_check->size1_value = $request->size1_value[$s];
                                $sub_check->size2_value = $request->size2_value[$s];
                                $sub_check->save();
                            }
                        }
                        else
                        {
                            if($key && $request->sub_product_titles[$s])
                            {
                                $sub = new feature_sub_products;
                                $sub->feature_id = $request->feature_id;
                                $sub->unique_code = $key;
                                $sub->title = $request->sub_product_titles[$s];
                                $sub->size1_value = $request->size1_value[$s];
                                $sub->size2_value = $request->size2_value[$s];
                                $sub->save();
                            }
                        }
                    }
                }
                else
                {
                    feature_sub_products::where('feature_id',$request->feature_id)->delete();
                }
            }

            Session::flash('success', 'Feature updated successfully.');
            return redirect()->route('admin-feature-index');
        }
        else
        {
            $features = new features;

            $features->title = $request->title;
            $features->save();

            foreach ($request->sub_codes as $i => $key)
            {
                if($key && $request->sub_product_titles[$i])
                {
                    $sub = new feature_sub_products;
                    $sub->feature_id = $features->id;
                    $sub->unique_code = $key;
                    $sub->title = $request->sub_product_titles[$i];
                    $sub->size1_value = $request->size1_value[$i];
                    $sub->size2_value = $request->size2_value[$i];
                    $sub->save();
                }
            }

            Session::flash('success', 'New Feature added successfully.');
        }

        return redirect()->route('admin-feature-index');
    }

    public function edit($id)
    {
        $feature = features::findOrFail($id);

        $sub_data = feature_sub_products::where('feature_id',$id)->get();

        return view('admin.features.create',compact('feature','sub_data'));
    }

    public function destroy($id)
    {
        $feature = features::findOrFail($id);
        $feature->delete();

        feature_sub_products::where('feature_id',$id)->delete();
        Session::flash('success', 'Feature deleted successfully.');
        return redirect()->route('admin-feature-index');

    }
}
