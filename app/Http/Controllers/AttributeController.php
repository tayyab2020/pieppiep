<?php

namespace App\Http\Controllers;

use App\vats;
use Illuminate\Http\Request;
use App\Category;
use App\my_categories;
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
use App\attributes;
use App\attributes_options;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeController extends Controller
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

        if($user->role_id == 4)
        {
            $attributes = attributes::where('user_id',$user_id)->where('main_id',NULL)->orderBy('id','desc')->get();

            return view('admin.attribute.index',compact('attributes'));
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

        $cats = my_categories::where('user_id',$user_id)->orWhere('user_id',0)->get();

        if($user->role_id == 4)
        {
            return view('admin.attribute.create',compact('cats'));
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

        if($request->attribute_id)
        {
            $attributes = attributes::where('id',$request->attribute_id)->first();
            Session::flash('success', 'Attribute edited successfully.');
        }
        else
        {
            $attributes = new attributes;
            Session::flash('success', 'New Attribute added successfully.');
        }

        $attributes->user_id = $user_id;
        $attributes->title = $request->title;
        $attributes->value = $request->value;
        $attributes->type = $request->attribute_type;
        $attributes->is_required = $request->attribute_required;
        $attributes->is_unique = $request->attribute_unique;
        $attributes->category_id = $request->attribute_category;
        $attributes->impact_type = $request->impact_type;
        $attributes->price_impact = $request->price_impact;
        $attributes->m1_impact = $request->m1_impact;
        $attributes->m2_impact = $request->m2_impact;
        $attributes->filter = $request->attribute_filter;
        $attributes->save();

        $attribute_main_id = $attributes->id; 

        if($request->attribute_type == 'Select' || $request->attribute_type == 'Multiselect' || $request->attribute_type == 'Checkbox')
        {
            $attribute_options_title = $request->attribute_option_title;

            foreach($attribute_options_title as $x => $key)
            {
                $attribute_options_check = attributes_options::where('attribute_id',$attribute_main_id)->skip($x)->first();

                if($attribute_options_check)
                {
                    if($key)
                    {
                        $attribute_options_check->attribute_id = $attribute_main_id;
                        $attribute_options_check->title = $key;
                        $attribute_options_check->position = $request->attribute_option_position[$x] ? $request->attribute_option_position[$x] : 0;
                        $attribute_options_check->save();
                    }
                }
                else
                {
                    if($key)
                    {
                        $options = new attributes_options;
                        $options->attribute_id = $attribute_main_id;
                        $options->title = $key;
                        $options->position = $request->attribute_option_position[$x] ? $request->attribute_option_position[$x] : 0;
                        $options->save();
                    }
                }
            }

            $x = $x + 1;

            $count = attributes_options::count();
            attributes_options::where('attribute_id',$attribute_main_id)->take($count)->skip($x)->get()->each(function($row){ $row->delete(); });

        }
        else
        {
            attributes_options::where('attribute_id',$attribute_main_id)->delete();
        }

        $sub_attributes_title = $request->sub_attribute_title;

        foreach($sub_attributes_title as $a => $key1)
        {
            $sub_attribute_check = attributes::where('main_id',$attribute_main_id)->skip($a)->first();

            if($sub_attribute_check)
            {
                if($key1)
                {
                    $sub_attribute_check->title = $key1;
                    $sub_attribute_check->value = $request->sub_attribute_value[$a] ? $request->sub_attribute_value[$a] : 0;
                    $sub_attribute_check->type = $request->attribute_type;
                    $sub_attribute_check->is_required = $request->sub_attribute_required[$a];
                    $sub_attribute_check->is_unique = $request->sub_attribute_unique[$a];
                    $sub_attribute_check->category_id = $request->attribute_category;
                    $sub_attribute_check->impact_type = $request->sub_attribute_impact_type[$a];
                    $sub_attribute_check->price_impact = $request->sub_attribute_price_impact[$a];
                    $sub_attribute_check->m1_impact = $request->sub_attribute_m1_impact[$a];
                    $sub_attribute_check->m2_impact = $request->sub_attribute_m2_impact[$a];
                    $sub_attribute_check->filter = $request->attribute_filter;
                    $sub_attribute_check->save();
                }
            }
            else
            {
                if($key1)
                {
                    $sub_attribute = new attributes;
                    $sub_attribute->user_id = $user_id;
                    $sub_attribute->main_id = $attribute_main_id;
                    $sub_attribute->title = $key1;
                    $sub_attribute->value = $request->sub_attribute_value[$a] ? $request->sub_attribute_value[$a] : 0;
                    $sub_attribute->type = $request->attribute_type;
                    $sub_attribute->is_required = $request->sub_attribute_required[$a];
                    $sub_attribute->is_unique = $request->sub_attribute_unique[$a];
                    $sub_attribute->category_id = $request->attribute_category;
                    $sub_attribute->impact_type = $request->sub_attribute_impact_type[$a];
                    $sub_attribute->price_impact = $request->sub_attribute_price_impact[$a];
                    $sub_attribute->m1_impact = $request->sub_attribute_m1_impact[$a];
                    $sub_attribute->m2_impact = $request->sub_attribute_m2_impact[$a];
                    $sub_attribute->filter = $request->attribute_filter;
                    $sub_attribute->save();
                }
            }
        }

        $a = $a + 1;

        $count = attributes::where('main_id',$attribute_main_id)->count();
        attributes::where('main_id',$attribute_main_id)->take($count)->skip($a)->get()->each(function($row){ $row->delete(); });

        return redirect()->route('admin-attribute-index');
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

        if($user->role_id == 4)
        {
            $attributes = attributes::where('id','=',$id)->where('user_id',$user_id)->first();
            $sub_attributes = attributes::where('main_id','=',$id)->where('attributes.user_id',$user_id)->get();
            $options = attributes_options::where('attribute_id',$id)->get();
            $cats = my_categories::where('user_id',$user_id)->orWhere('user_id',0)->get();

            if(!$attributes)
            {
                return redirect()->back();
            }

            return view('admin.attribute.create',compact('attributes','sub_attributes','options','cats'));
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

        if($user->role_id == 4)
        {
            attributes::where('id',$id)->where('user_id',$user_id)->delete();
            attributes::where('main_id',$id)->where('user_id',$user_id)->delete();
            attributes_options::where('attribute_id',$id)->delete();
            Session::flash('success', 'Attribute deleted successfully.');
            return redirect()->route('admin-attribute-index');
        }
        else
        {
            return redirect()->route('user-login');
        }
    }
}
