<?php

namespace App\Http\Controllers;

use App\Brand;
use App\brand_edit_requests;
use App\Model1;
use App\Sociallink;
use App\User;
use App\vats;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest1;
use App\Http\Requests\UpdateValidationRequest;
use Auth;
use App\Generalsetting;
use Mollie\Laravel\Facades\Mollie;
use App\service_types;
use App\sub_services;
use App\handyman_products;
use App\carts;
use Illuminate\Database\Eloquent\SoftDeletes;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
        $this->sl = Sociallink::findOrFail(1);
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

        if($user->can('user-brands'))
        {
            $cats = Brand::where(function($query) use($user_id) {
                $query->where('user_id',$user_id)->orWhere(function($query1) use($user_id) {
                    $query1->whereRaw("find_in_set($user_id,other_suppliers)")->where('trademark',0);
                });
            })->orderBy('id','desc')->get();

            return view('admin.brand.index',compact('cats','user_id'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function otherSuppliersBrands()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->role_id == 4)
        {
            $brands = Brand::where('user_id','!=',$user_id)->where('trademark',0)->get();

            return view('user.supplier_brands',compact('brands','user_id'));
        }
    }

    public function SupplierBrandsStore(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        $brand_ids = $request->supplier_brands ? $request->supplier_brands : array();
        $brands = Brand::where('user_id','!=',$user_id)->get();

        foreach ($brands as $key)
        {
            $other_suppliers = $key->other_suppliers ? explode(',',$key->other_suppliers) : array();

            if(in_array($key->id,$brand_ids))
            {
                if(!in_array($user_id,$other_suppliers))
                {
                    $other_suppliers[] = $user_id;
                    $other_suppliers = implode(',',$other_suppliers);
                    $key->other_suppliers = $other_suppliers ? $other_suppliers : NULL;
                    $key->save();
                }
            }

            if(!$request->supplier_brands || !in_array($key->id,$brand_ids))
            {
                if (($index = array_search($user_id, $other_suppliers)) !== false) {

                    unset($other_suppliers[$index]);
                    $other_suppliers = implode(',',$other_suppliers);
                    $key->other_suppliers = $other_suppliers ? $other_suppliers : NULL;
                    $key->save();

                    $brand_edit_request = brand_edit_requests::where('brand_id',$key->id)->where('user_id',$user_id)->first();

                    if($brand_edit_request)
                    {
                        if($brand_edit_request->photo != null){
                            \File::delete(public_path() .'/assets/images/'.$brand_edit_request->photo);
                        }

                        $brand_edit_request->delete();
                    }
                }
            }
        }

        Session::flash('success', 'List updated successfully!');

        return redirect()->back();
    }

    public function create()
    {
        $user = Auth::guard('user')->user();
        $main_id = $user->main_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
        }

        $user_id = $user->id;

        if($user->can('brand-create'))
        {
            return view('admin.brand.create',compact('user_id'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function store(StoreValidationRequest1 $request)
    {
        $user = Auth::guard('user')->user();
        $main_id = $user->main_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
        }

        $user_id = $user->id;

        $check_name = Brand::where('cat_name','LIKE','%'.$request->cat_name.'%')->where('user_id',$user_id)->first();

        if($check_name)
        {
            Session::flash('unsuccess', 'Brand name already in use.');
            return redirect()->back()->withInput();
        }

        $check_slug = Brand::where('cat_slug','LIKE','%'.$request->cat_slug.'%')->where('user_id',$user_id)->first();

        if($check_slug)
        {
            Session::flash('unsuccess', 'Slug already in use.');
            return redirect()->back()->withInput();
        }

        $check_name1 = Brand::where('cat_name','LIKE','%'.$request->cat_name.'%')->where('user_id','!=',$user_id)->first();

        if($check_name1)
        {
            Session::flash('unsuccess', 'Brand name is already taken, If you are allowed to use it send us a message.');
            return redirect()->back()->withInput();
        }

        $check_slug1 = Brand::where('cat_slug','LIKE','%'.$request->cat_slug.'%')->where('user_id','!=',$user_id)->first();

        if($check_slug1)
        {
            Session::flash('unsuccess', 'Slug is already taken, If you are allowed to use it send us a message.');
            return redirect()->back()->withInput();
        }

        exit();

        if($request->cat_id)
        {
            $cat = Brand::where('id',$request->cat_id)->where('user_id',$user_id)->first();

            if($cat)
            {
                Session::flash('success', 'Brand edited successfully.');
            }
            else
            {
                $check = brand_edit_requests::where('brand_id',$request->cat_id)->where('user_id',$user_id)->first();

                if(!$check)
                {
                    $check = new brand_edit_requests;
                    $check->user_id = $user_id;
                    $check->brand_id = $request->cat_id;

                    Session::flash('success', 'Brand edit request has been created successfully.');
                }
                else
                {
                    Session::flash('success', 'Brand edit request has been updated successfully.');
                }

                if($file = $request->file('photo'))
                {
                    $name = time().$file->getClientOriginalName();
                    $file->move('assets/images',$name);
                    if($check->photo != null)
                    {
                        \File::delete(public_path() .'/assets/images/'.$check->photo);
                    }
                    $check->photo = $name;
                }

                $check->cat_name = $request->cat_name;
                $check->cat_slug = $request->cat_slug;
                $check->description = $request->description;
                $check->save();

                $admin_email = $this->sl->admin_email;
                $supplier_company = $user->company_name;
                $brand = Brand::where('id',$request->cat_id)->pluck('cat_name')->first();

                \Mail::send(array(), array(), function ($message) use ($admin_email,$supplier_company,$brand) {
                    $message->to($admin_email)
                        ->from('info@vloerofferte.nl')
                        ->subject('Brand Edit Request')
                        ->setBody('Dear Nordin Adoui, A new brand edit request has been submitted by <b>'.$supplier_company.'</b> for brand: <b>'.$brand.'</b>.', 'text/html');
                });

                return redirect()->route('admin-brand-index');
            }
        }
        else
        {
            $cat = new Brand;
            Session::flash('success', 'New Brand added successfully.');
        }

        $input = $request->all();
        $input['user_id'] = $user_id;

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

        return redirect()->route('admin-brand-index');
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

        if($user->can('brand-edit'))
        {
            $cats = Brand::where('id','=',$id)->first();

            if(!$cats)
            {
                return redirect()->back();
            }

            return view('admin.brand.create',compact('cats','user_id'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function update(UpdateValidationRequest $request, $id)
    {

        $vat = vats::where('id',$request->vat)->first();

        if(!$request->main_service)
        {

            $i =0;

            foreach ($request->sub_service as $key) {

                if($request->s_id[$i] != 0)
                {

                    $update = sub_services::where('id',$request->s_id[$i])->update(['cat_id'=>$key]);

                }
                else
                {

                    $sub_services = new sub_services;
                    $sub_services->cat_id = $key;
                    $sub_services->sub_id = $id;
                    $sub_services->save();

                }

                $i++;

            }
        }

        if($request->variable_questions)
        {
            $request['variable_questions'] = 1;
        }
        else
        {
            $request['variable_questions'] = 0;
        }

        $cat = Category::findOrFail($id);

        $input = $request->all();

        $input['vat_id'] = $vat->id;
        $input['vat_percentage'] = $vat->vat_percentage;
        $input['vat_rule'] = $vat->rule;
        $input['vat_code'] = $vat->code;

        if ($file = $request->file('photo'))
        {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images',$name);
            if($cat->photo != null)
            {
                \File::delete(public_path() .'/assets/images/'.$cat->photo);
            }
            $input['photo'] = $name;
        }

        $cat->update($input);
        Session::flash('success', 'Service updated successfully.');
        return redirect()->route('admin-cat-index');
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

        if($user->can('brand-delete'))
        {
            $cat = Brand::where('id',$id)->where('user_id',$user_id)->first();

            if(!$cat)
            {
                return redirect()->back();
            }

            if($cat->photo != null){
                \File::delete(public_path() .'/assets/images/'.$cat->photo);
            }

            $cat->delete();
            brand_edit_requests::where('brand_id',$id)->delete();
            Session::flash('success', 'Brand deleted successfully.');
            return redirect()->route('admin-brand-index');
        }
        else
        {
            return redirect()->route('user-login');
        }
    }
}
