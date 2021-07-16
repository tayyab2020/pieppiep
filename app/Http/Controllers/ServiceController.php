<?php

namespace App\Http\Controllers;

use App\colors;
use App\Service;
use App\vats;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest4;
use App\Http\Requests\UpdateValidationRequest;
use Auth;
use App\Generalsetting;
use Mollie\Laravel\Facades\Mollie;
use App\service_types;
use App\sub_services;
use App\handyman_products;
use App\carts;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceController extends Controller
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

        if($user->can('my-services'))
        {
            $services = Service::orderBy('id','desc')->where('user_id',$user_id)->get();

            return view('admin.service.index',compact('services'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function create()
    {
        $user = Auth::guard('user')->user();

        if($user->can('service-create'))
        {
            return view('admin.service.create');
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function store(StoreValidationRequest4 $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($request->service_id)
        {
            $service = Service::where('id',$request->service_id)->first();
            Session::flash('success', 'Service edited successfully.');
        }
        else
        {
            $service = new Service;
            Session::flash('success', 'New Service added successfully.');
        }

        $input = $request->all();
        $input['user_id'] = $user_id;

        if ($file = $request->file('photo'))
        {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images',$name);
            $input['photo'] = $name;
        }

        $service->fill($input)->save();

        return redirect()->route('admin-service-index');
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

        if($user->can('service-edit'))
        {
            $cats = Service::where('id','=',$id)->where('user_id',$user_id)->first();

            if(!$cats)
            {
                return redirect()->back();
            }

            return view('admin.service.create',compact('cats'));
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

        if($user->can('service-delete'))
        {
            $service = Service::where('id',$id)->where('user_id',$user_id)->first();

            if(!$service)
            {
                return redirect()->back();
            }

            if($service->photo == null){
                $service->delete();
                Session::flash('success', 'Service deleted successfully.');
                return redirect()->route('admin-service-index');
            }

            \File::delete(public_path() .'/assets/images/'.$service->photo);
            $service->delete();
            Session::flash('success', 'Service deleted successfully.');
            return redirect()->route('admin-service-index');
        }
        else
        {
            return redirect()->route('user-login');
        }
    }
}
