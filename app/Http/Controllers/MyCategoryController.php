<?php

namespace App\Http\Controllers;

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

class MyCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function MyCategoriesIndex()
    {
        $suppliers = User::where('role_id',4)->get();

        //$data = features::leftjoin("categories",\DB::raw("FIND_IN_SET(categories.id,features.category_ids)"),">",\DB::raw("'0'"))->get();

        $cats = Category::orderBy('id','desc')->get();
        return view('admin.category.my_categories_index',compact('cats'));
    }

    public function MyCategoryCreate()
    {
        $suppliers = User::where('role_id',4)->get();
        return view('admin.category.create_my_category',compact('suppliers'));
    }

    public function MyCategoryStore(StoreValidationRequest $request)
    {
        if($request->cat_id)
        {
            $cat = Category::where('id',$request->cat_id)->first();
            Session::flash('success', 'Category edited successfully.');
        }
        else
        {
            $cat = new Category;
            Session::flash('success', 'New Category added successfully.');
        }

        $input = $request->all();

        if ($file = $request->file('photo'))
        {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images',$name);
            $input['photo'] = $name;
        }

        $cat->fill($input)->save();

        if($request->sub_category_title)
        {
            $sub_categories = $request->sub_category_title;
            $sub_category_ids = $request->sub_category_id;
            $id_array = [];

            foreach($sub_categories as $x => $key1)
            {
                $check1 = sub_categories::where('id',$sub_category_ids[$x])->first();

                if(!$check1)
                {
                    if($key1 && $request->sub_category_slug[$x])
                    {
                        $check1 = new sub_categories;
                        $check1->main_id = $cat->id;
                        $check1->cat_name = $key1;
                        $check1->cat_slug = $request->sub_category_slug[$x];
                        $check1->description = $request->sub_category_description[$x];
                        $check1->save();

                        $id_array[] = $check1->id;
                    }
                }
                else
                {
                    if($key1 && $request->sub_category_slug[$x])
                    {
                        $check1->main_id = $cat->id;
                        $check1->cat_name = $key1;
                        $check1->cat_slug = $request->sub_category_slug[$x];
                        $check1->description = $request->sub_category_description[$x];
                        $check1->save();
                    }

                    $id_array[] = $check1->id;
                }

            }

            sub_categories::whereNotIn('id',$id_array)->where('main_id',$cat->id)->delete();
        }
        else
        {
            sub_categories::where('main_id',$cat->id)->delete();
        }


        if($request->suppliers)
        {
            $supplier_ids = $request->suppliers;

            foreach($supplier_ids as $s => $key)
            {
                $check = supplier_categories::where('category_id',$cat->id)->skip($s)->first();

                if($check)
                {
                    $check->user_id = $key;
                    $check->save();
                }
                else
                {
                    $post = new supplier_categories;
                    $post->category_id = $cat->id;
                    $post->user_id = $key;
                    $post->save();
                }
            }

            $s = $s + 1;

            $count = supplier_categories::count();
            supplier_categories::where('category_id',$cat->id)->take($count)->skip($s)->get()->each(function($row){ $row->delete(); });
        }
        else
        {
            supplier_categories::where('category_id',$cat->id)->delete();
        }

        return redirect()->route('admin-my-cat-index');
    }

    public function MyCategoryEdit($id)
    {
        $suppliers = User::where('role_id',4)->get();

        $cats = Category::with('sub_categories')->where('id','=',$id)->first();

        $category_suppliers = supplier_categories::where('category_id',$id)->pluck('user_id')->toArray();

        if(!$cats)
        {
            return redirect()->back();
        }

        return view('admin.category.create_my_category',compact('cats','suppliers','category_suppliers'));
    }

    public function MyCategoryDestroy($id)
    {
        $cat = Category::where('id',$id)->first();

        if(!$cat)
        {
            return redirect()->back();
        }

        if($cat->photo == null){
            $cat->delete();
            sub_categories::where('main_id',$id)->delete();
            supplier_categories::where('category_id',$id)->delete();
            Session::flash('success', 'Category deleted successfully.');
            return redirect()->route('admin-my-cat-index');
        }

        \File::delete(public_path() .'/assets/images/'.$cat->photo);
        $cat->delete();
        sub_categories::where('main_id',$id)->delete();
        supplier_categories::where('category_id',$id)->delete();
        Session::flash('success', 'Category deleted successfully.');
        return redirect()->route('admin-my-cat-index');
    }

}
