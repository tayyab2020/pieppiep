<?php

namespace App\Http\Controllers;

use App\colors;
use App\Service;
use App\vats;
use Illuminate\Http\Request;
use App\Category;
use App\sub_categories;
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
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $services = Service::orderBy('id','desc')->get();

        return view('admin.service.index',compact('services'));
    }

    public function create()
    {
        $categories = Category::get();
        return view('admin.service.create',compact('categories'));
    }

    public function store(StoreValidationRequest4 $request)
    {
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

        if($file = $request->file('photo'))
        {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images',$name);
            $input['photo'] = $name;
        }

        $sub_categories = implode(',', $request->sub_category_id);
        $input['sub_category_ids'] = $sub_categories ? $sub_categories : NULL;

        $service->fill($input)->save();

        return redirect()->route('admin-service-index');
    }

    public function edit($id)
    {
        $cats = Service::where('id','=',$id)->first();
        $categories = Category::get();
        $sub_categories = sub_categories::where('parent_id',$cats->category_id)->get();

        return view('admin.service.create',compact('cats','categories','sub_categories'));
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

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
}
