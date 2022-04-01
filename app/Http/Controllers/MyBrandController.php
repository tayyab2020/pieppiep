<?php

namespace App\Http\Controllers;

use App\Brand;
use App\brand_edit_requests;
use App\Http\Requests\StoreValidationRequest7;
use App\vats;
use Illuminate\Http\Request;
use App\Category;
use App\sub_categories;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use Auth;
use App\Generalsetting;
use Mollie\Laravel\Facades\Mollie;
use App\service_types;
use App\sub_services;
use App\handyman_products;
use App\carts;
use App\features;
use App\supplier_categories;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyBrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $brands = Brand::leftjoin("users",\DB::raw("FIND_IN_SET(users.id,brands.other_suppliers)"),">",\DB::raw("'0'"))->leftjoin("users as main","main.id","=","brands.user_id")->select('brands.*','users.company_name','main.company_name as main_supplier')->orderBy('brands.id','desc')->get();

        return view('admin.brand.my_brands_index',compact('brands'));
    }

    public function create()
    {
        $suppliers = User::where('role_id',4)->get();
        return view('admin.brand.create_my_brand',compact('suppliers'));
    }

    public function store(StoreValidationRequest7 $request)
    {
        if($request->edit_request_id)
        {
            $post = Brand::where('id',$request->brand_id)->first();
            $post->cat_name = $request->edit_title;
            $post->cat_slug = $request->edit_slug;
            $post->description = $request->edit_description;

            if($request->temp_edit_photo || $request->edit_photo)
            {
                \File::delete(public_path() .'/assets/images/'.$post->photo);

                if($file = $request->file('edit_photo'))
                {
                    $name = time().$file->getClientOriginalName();
                    $file->move('assets/images',$name);
                    $post->photo = $name;
                }
                else
                {
                    $post->photo = $request->temp_edit_photo;
                }
            }

            $post->save();

            brand_edit_requests::where('id',$request->edit_request_id)->delete();
            Session::flash('success', 'Brand edited successfully.');
        }
        else
        {
            if($request->brand_id)
            {
                $cat = Brand::where('id',$request->brand_id)->first();
                Session::flash('success', 'Brand edited successfully.');
            }
            else
            {
                $cat = new Brand();
                Session::flash('success', 'New Brand added successfully.');
            }

            $input = $request->all();
            $input['user_id'] = 0;
            $input['other_suppliers'] = isset($input['other_suppliers']) ? implode(',',$input['other_suppliers']) : NULL;
            $other_suppliers_array = $request->other_suppliers ? $request->other_suppliers : array();

            $brand_edit_requests = brand_edit_requests::where('brand_id',$request->brand_id)->whereNotIn('user_id',$other_suppliers_array)->get();

            foreach ($brand_edit_requests as $key)
            {
                if($key->photo != null)
                {
                    \File::delete(public_path() .'/assets/images/'.$key->photo);
                }

                $key->delete();
            }

            if($file = $request->file('photo'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
                if($cat->photo != null)
                {
                    \File::delete(public_path() .'/assets/images/'.$cat->photo);
                }
                $input['photo'] = $name;
            }

            $cat->fill($input)->save();
        }

        return redirect()->route('admin-my-brand-index');
    }

    public function edit($id)
    {
        $brand = Brand::where('id',$id)->first();

        if(!$brand)
        {
            return redirect()->back();
        }

        $suppliers = User::where('role_id',4)->where('id','!=',$brand->user_id)->get();

        if($brand->other_suppliers)
        {
            $supplier_ids = explode(',',$brand->other_suppliers);
        }
        else
        {
            $supplier_ids = array();
        }

        return view('admin.brand.create_my_brand',compact('brand','supplier_ids','suppliers'));
    }

    public function editRequests($id)
    {
        $requests = brand_edit_requests::leftjoin('users','users.id','=','brand_edit_requests.user_id')->where('brand_edit_requests.brand_id',$id)->select('brand_edit_requests.*','users.company_name')->get();

        return view('admin.brand.edit_requests',compact('requests'));
    }

    public function editRequest($id)
    {
        $brand = brand_edit_requests::leftjoin('brands','brands.id','=','brand_edit_requests.brand_id')->where('brand_edit_requests.id',$id)->select('brands.*','brand_edit_requests.id as edit_request_id','brand_edit_requests.cat_name as edit_title','brand_edit_requests.cat_slug as edit_slug','brand_edit_requests.photo as edit_photo','brand_edit_requests.description as edit_description')->first();

        $suppliers = User::where('role_id',4)->where('id','!=',$brand->user_id)->get();

        if($brand->other_suppliers)
        {
            $supplier_ids = explode(',',$brand->other_suppliers);
        }
        else
        {
            $supplier_ids = array();
        }

        return view('admin.brand.create_my_brand',compact('brand','suppliers','supplier_ids'));
    }

    public function destroy($id)
    {
        $cat = Brand::where('id',$id)->first();

        if(!$cat)
        {
            return redirect()->back();
        }

        if($cat->photo != null){
            \File::delete(public_path() .'/assets/images/'.$cat->photo);
        }

        Session::flash('success', 'Brand deleted successfully.');

        $cat->delete();
        brand_edit_requests::where('brand_id',$id)->delete();
        return redirect()->route('admin-my-brand-index');
    }

}
