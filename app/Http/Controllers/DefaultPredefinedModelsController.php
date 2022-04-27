<?php

namespace App\Http\Controllers;

use App\default_predefined_models;
use App\default_predefined_models_details;
use App\User;
use App\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use Auth;
use App\Generalsetting;
use App\Category;
use App\sub_categories;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Database\Eloquent\SoftDeletes;

class DefaultPredefinedModelsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $models = default_predefined_models::orderBy('id','desc')->get();

        $categories = Category::get();

        return view('admin.default_predefined_models.index',compact('models','categories'));
    }

    public function create()
    {
        $cats = Category::get();

        return view('admin.default_predefined_models.create',compact('cats'));
    }

    public function store(Request $request)
    {
        $category_ids = implode(",",$request->model_category);

        if($request->heading_id)
        {
            $model = default_predefined_models::where('id',$request->heading_id)->first();
            Session::flash('success', 'Model updated successfully.');
        }
        else
        {
            $model = new default_predefined_models;
            Session::flash('success', 'New Model added successfully.');
        }

        $model->model = $request->title;
        $model->category_ids = $category_ids;
        $model->save();

        $sizes = $request->sizes;
        $size_ids = $request->size_ids;
        $id_array = [];

        foreach($sizes as $x => $key)
        {
            $size_check = default_predefined_models_details::where('id',$size_ids[$x])->first();

            if($size_check)
            {
                if($key)
                {
                    $size_check->model_id = $model->id;
                    $size_check->model = $key;
                    $size_check->value = $request->size_values[$x] ? $request->size_values[$x] : 0;
                    $size_check->measure = $request->size_measure[$x];
                    $size_check->price_impact = $request->price_impact[$x] == 1 ? 1 : 0;
                    $size_check->impact_type = $request->impact_type[$x];
                    $size_check->m1_impact = $request->price_impact[$x] == 2 ? 1 : 0;
                    $size_check->m2_impact = $request->price_impact[$x] == 3 ? 1 : 0;
                    $size_check->save();
                }

                $id_array[] = $size_check->id;
            }
            else
            {
                if($key)
                {
                    $details = new default_predefined_models_details;
                    $details->model_id = $model->id;
                    $details->model = $key;
                    $details->value = $request->size_values[$x] ? $request->size_values[$x] : 0;
                    $details->measure = $request->size_measure[$x];
                    $details->price_impact = $request->price_impact[$x] == 1 ? 1 : 0;
                    $details->impact_type = $request->impact_type[$x];
                    $details->m1_impact = $request->price_impact[$x] == 2 ? 1 : 0;
                    $details->m2_impact = $request->price_impact[$x] == 3 ? 1 : 0;
                    $details->save();

                    $id_array[] = $details->id;
                }
            }

        }

        default_predefined_models_details::whereNotIn('id',$id_array)->where('model_id',$model->id)->delete();

        return redirect()->route('default-models-index');
    }

    public function edit($id)
    {
        $model = default_predefined_models::where('id',$id)->first();

        if(!$model)
        {
            return redirect()->back();
        }

        $cats = Category::get();
        $models_data = default_predefined_models_details::where('model_id',$model->id)->get();

        return view('admin.default_predefined_models.create',compact('model','models_data','cats'));
    }

    public function destroy($id)
    {
        $model = default_predefined_models::where('id',$id)->first();

        if(!$model)
        {
            return redirect()->back();
        }

        $model->delete();
        default_predefined_models_details::where('model_id',$id)->delete();

        Session::flash('success', 'Model deleted successfully.');
        return redirect()->route('default-models-index');

    }
}
