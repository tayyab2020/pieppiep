<?php

namespace App\Http\Controllers;

use App\default_predefined_models;
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
        $model->value = $request->value ? $request->value : 0;
        $model->measure = $request->measure;
        $model->price_impact = $request->price_impact == 1 ? 1 : 0;
        $model->impact_type = $request->impact_type;
        $model->m1_impact = $request->price_impact == 2 ? 1 : 0;
        $model->m2_impact = $request->price_impact == 3 ? 1 : 0;
        $model->category_ids = $category_ids;
        $model->save();

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

        return view('admin.default_predefined_models.create',compact('model','cats'));
    }

    public function destroy($id)
    {
        $model = default_predefined_models::where('id',$id)->first();

        if(!$model)
        {
            return redirect()->back();
        }

        $model->delete();

        Session::flash('success', 'Model deleted successfully.');
        return redirect()->route('default-models-index');

    }
}
