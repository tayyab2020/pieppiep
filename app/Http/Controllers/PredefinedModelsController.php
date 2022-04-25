<?php

namespace App\Http\Controllers;

use App\predefined_models;
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
use App\supplier_categories;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Database\Eloquent\SoftDeletes;

class PredefinedModelsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('user-models'))
        {
            $models = predefined_models::where('user_id',$user_id)->orderBy('id','desc')->get();
            $default_models = default_predefined_models::orderBy('id','desc')->get();

            return view('admin.predefined_models.index',compact('models','default_models'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function create()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        $cats = Category::leftjoin('supplier_categories','supplier_categories.category_id','=','categories.id')->where('supplier_categories.user_id',$user_id)->select('categories.*')->get();

        if($user->can('model-create'))
        {
            return view('admin.predefined_models.create',compact('cats'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function store(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        $category_ids = implode(",",$request->model_category);

        if(!$request->default_model && $request->heading_id)
        {
            $model = predefined_models::where('id',$request->heading_id)->first();
            Session::flash('success', 'Model updated successfully.');
        }
        else
        {
            $model = new predefined_models;
            Session::flash('success', 'New Model added successfully.');
        }

        $model->user_id = $user_id;
        $model->model = $request->title;
        $model->value = $request->value ? $request->value : 0;
        $model->measure = $request->measure;
        $model->price_impact = $request->price_impact == 1 ? 1 : 0;
        $model->impact_type = $request->impact_type;
        $model->m1_impact = $request->price_impact == 2 ? 1 : 0;
        $model->m2_impact = $request->price_impact == 3 ? 1 : 0;
        $model->category_ids = $category_ids;
        $model->default_model_id = $request->default_model ? $request->heading_id : NULL;
        $model->save();

        return redirect()->route('predefined-model-index');
    }

    public function edit($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if(\Request::route()->getName() == 'predefined-model-edit')
        {
            if($user->can('model-edit'))
            {
                $model = predefined_models::where('id',$id)->where('user_id',$user_id)->first();

                if(!$model)
                {
                    return redirect()->back();
                }

                $cats = Category::leftjoin('supplier_categories','supplier_categories.category_id','=','categories.id')->where('supplier_categories.user_id',$user_id)->select('categories.*')->get();

                return view('admin.predefined_models.create',compact('model','cats'));
            }
            else
            {
                return redirect()->route('user-login');
            }
        }
        else
        {
            if($user->can('model-edit'))
            {
                $model = default_predefined_models::where('id',$id)->first();

                if(!$model)
                {
                    return redirect()->back();
                }

                $cats = Category::leftjoin('supplier_categories','supplier_categories.category_id','=','categories.id')->where('supplier_categories.user_id',$user_id)->select('categories.*')->get();

                return view('admin.predefined_models.create',compact('model','cats'));
            }
            else
            {
                return redirect()->route('user-login');
            }
        }
    }

    public function destroy($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('model-delete'))
        {
            $model = predefined_models::where('id',$id)->where('user_id',$user_id)->first();

            if(!$model)
            {
                return redirect()->back();
            }

            $model->delete();

            Session::flash('success', 'Model deleted successfully.');
            return redirect()->route('predefined-model-index');
        }
        else
        {
            return redirect()->route('user-login');
        }

    }
}
