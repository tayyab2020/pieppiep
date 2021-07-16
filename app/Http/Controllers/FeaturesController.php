<?php

namespace App\Http\Controllers;

use App\product_features;
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

        if($user->can('user-features'))
        {
            $features = features::where('user_id',$user_id)->orderBy('id','desc')->get();

            return view('admin.features.index',compact('features'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function create()
    {
        $user = Auth::guard('user')->user();

        if($user->can('create-feature'))
        {
            return view('admin.features.create');
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

        if($request->heading_id)
        {
            features::where('id',$request->heading_id)->update(['title' => $request->title, 'order_no' => $request->order_no]);
            Session::flash('success', 'Feature updated successfully.');
        }
        else
        {
            $feature = new features;
            $feature->user_id = $user_id;
            $feature->title = $request->title;
            $feature->order_no = $request->order_no;
            $feature->save();

            Session::flash('success', 'New Feature added successfully.');
        }

        return redirect()->route('admin-feature-index');
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

        if($user->can('edit-feature'))
        {
            $feature = features::where('id',$id)->where('user_id',$user_id)->first();

            if(!$feature)
            {
                return redirect()->back();
            }

            return view('admin.features.create',compact('feature'));
        }
        else
        {
            return redirect()->route('user-login');
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

        if($user->can('delete-feature'))
        {
            $feature = features::where('id',$id)->where('user_id',$user_id)->first();

            if(!$feature)
            {
                return redirect()->back();
            }

            $feature->delete();
            Session::flash('success', 'Feature deleted successfully.');
            return redirect()->route('admin-feature-index');
        }
        else
        {
            return redirect()->route('user-login');
        }

    }
}
