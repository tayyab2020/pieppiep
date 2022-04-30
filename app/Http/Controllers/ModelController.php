<?php

namespace App\Http\Controllers;

use App\Brand;
use App\brand_edit_requests;
use App\Model1;
use App\Sociallink;
use App\type_edit_requests;
use App\User;
use App\vats;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest2;
use App\Http\Requests\UpdateValidationRequest;
use Auth;
use App\Generalsetting;
use Mollie\Laravel\Facades\Mollie;
use App\service_types;
use App\sub_services;
use App\handyman_products;
use App\carts;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelController extends Controller
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

        if($user->can('user-models'))
        {
            $cats = Model1::leftjoin('brands','brands.id','=','models.brand_id')->where(function($query) use($user_id) {
                $query->where('models.user_id',$user_id)->orWhere(function($query1) use($user_id) {
                    $query1->whereRaw("find_in_set($user_id,brands.other_suppliers)")->where('brands.trademark',0);
                });
            })->orderBy('models.id','desc')->select('models.*','brands.cat_name as brand')->get();

            return view('admin.model.index',compact('cats','user_id'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function otherSuppliersTypes()
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
            $types = Model1::leftjoin('brands','brands.id','=','models.brand_id')->where('brands.user_id','!=',$user_id)->where('brands.trademark',0)->select('brands.*','models.id as type_id','models.cat_name as type')->get();

            return view('user.supplier_types',compact('types','user_id'));
        }
    }

    public function SupplierTypesStore(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        $type_ids = $request->supplier_types ? $request->supplier_types : array();
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
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('model-create'))
        {
            $brands = Brand::where('user_id',$user_id)->get();

            return view('admin.model.create',compact('brands'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function CustomValidations($id,$user_id,$title,$slug)
    {
        if($id)
        {
            $check_name = Model1::where('id','!=',$id)->where('cat_name',$title)->where('user_id',$user_id)->first();

            if($check_name)
            {
                Session::flash('unsuccess', 'Type title already in use.');
                return redirect()->back()->withInput();
            }

            $check_slug = Model1::where('id','!=',$id)->where('cat_slug',$slug)->where('user_id',$user_id)->first();

            if($check_slug)
            {
                Session::flash('unsuccess', 'Slug already in use.');
                return redirect()->back()->withInput();
            }

            $check_name1 = Model1::where('id','!=',$id)->where('cat_name',$title)->where('user_id','!=',$user_id)->first();

            if($check_name1)
            {
                Session::flash('unsuccess', 'Type title is already taken, If you are allowed to use it than send us a message.');
                return redirect()->back()->withInput();
            }

            $check_slug1 = Model1::where('id','!=',$id)->where('cat_slug',$slug)->where('user_id','!=',$user_id)->first();

            if($check_slug1)
            {
                Session::flash('unsuccess', 'Slug is already taken, If you are allowed to use it send us a message.');
                return redirect()->back()->withInput();
            }
        }
        else
        {
            $check_name = Model1::where('cat_name',$title)->where('user_id',$user_id)->first();

            if($check_name)
            {
                Session::flash('unsuccess', 'Type title already in use.');
                return redirect()->back()->withInput();
            }

            $check_slug = Model1::where('cat_slug',$slug)->where('user_id',$user_id)->first();

            if($check_slug)
            {
                Session::flash('unsuccess', 'Slug already in use.');
                return redirect()->back()->withInput();
            }

            $check_name1 = Model1::where('cat_name',$title)->where('user_id','!=',$user_id)->first();

            if($check_name1)
            {
                Session::flash('unsuccess', 'Type title is already taken, If you are allowed to use it than send us a message.');
                return redirect()->back()->withInput();
            }

            $check_slug1 = Model1::where('cat_slug',$slug)->where('user_id','!=',$user_id)->first();

            if($check_slug1)
            {
                Session::flash('unsuccess', 'Slug is already taken, If you are allowed to use it send us a message.');
                return redirect()->back()->withInput();
            }
        }

        return NULL;
    }

    public function store(StoreValidationRequest2 $request)
    {
        $user = Auth::guard('user')->user();
        $main_id = $user->main_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
        }

        $user_id = $user->id;

        $validations = $this->CustomValidations($request->cat_id ? $request->cat_id : NULL,$user_id,$request->cat_name,$request->cat_slug);

        if($validations)
        {
            return $validations;
        }

        if($request->cat_id)
        {
            $cat = Model1::where('id',$request->cat_id)->where('user_id',$user_id)->first();

            if($cat)
            {
                Session::flash('success', 'Type edited successfully.');
            }
            else
            {
                $check = type_edit_requests::where('type_id',$request->cat_id)->where('user_id',$user_id)->first();

                if(!$check)
                {
                    $check = new type_edit_requests;
                    $check->user_id = $user_id;
                    $check->brand_id = $request->brand_id;
                    $check->type_id = $request->cat_id;

                    Session::flash('success', 'Type edit request has been created successfully.');
                }
                else
                {
                    Session::flash('success', 'Type edit request has been updated successfully.');
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
                $type = Model1::where('id',$request->cat_id)->pluck('cat_name')->first();

                \Mail::send(array(), array(), function ($message) use ($admin_email,$supplier_company,$type) {
                    $message->to($admin_email)
                        ->from('info@vloerofferte.nl')
                        ->subject('Brand Edit Request')
                        ->setBody('Dear Nordin Adoui, A new type edit request has been submitted by <b>'.$supplier_company.'</b> for type: <b>'.$type.'</b>.', 'text/html');
                });

                return redirect()->route('admin-model-index');
            }
        }
        else
        {
            $cat = new Model1;
            Session::flash('success', 'New Type added successfully.');
        }

        $input = $request->all();
        $input['user_id'] = $user_id;

        if($file = $request->file('photo'))
        {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images',$name);
            $input['photo'] = $name;
        }

        $cat->fill($input)->save();

        return redirect()->route('admin-model-index');
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

        if($user->can('model-edit'))
        {
            $cats = Model1::where('id','=',$id)->first();

            if(!$cats)
            {
                return redirect()->back();
            }

            if($user_id == $cats->user_id)
            {
                $brands = Brand::where('user_id',$user_id)->get();
            }
            else
            {
                $brands = NULL;
            }

            $type_edit_request = type_edit_requests::where('type_id',$cats->id)->where('user_id',$user_id)->first();

            return view('admin.model.create',compact('cats','brands','type_edit_request','user_id'));
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

        if($user->can('model-delete'))
        {
            $cat = Model1::where('id','=',$id)->where('user_id',$user_id)->first();

            if(!$cat)
            {
                return redirect()->back();
            }

            if($cat->photo != null){
                \File::delete(public_path() .'/assets/images/'.$cat->photo);
            }

            $type_edit_request = type_edit_requests::where('type_id',$id)->get();

            foreach ($type_edit_request as $key)
            {
                if($key->photo != null){
                    \File::delete(public_path() .'/assets/images/'.$key->photo);
                }

                $key->delete();
            }

            $cat->delete();
            Session::flash('success', 'Type deleted successfully.');
            return redirect()->route('admin-model-index');
        }
        else
        {
            return redirect()->route('user-login');
        }
    }
}
