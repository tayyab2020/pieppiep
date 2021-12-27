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
use App\features;
use App\supplier_categories;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function preparePayment()
    {
        $api_key = Generalsetting::findOrFail(1);

        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey($api_key->mollie);
        $payment = $mollie->payments->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => '10.00', // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            'description' => 'My first API payment',
            'webhookUrl' => route('webhooks.mollie'),
            'redirectUrl' => route('front.index'),
        ]);

        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function MyCategoriesIndex()
    {
        $user = Auth::guard('admin')->user();
        $suppliers = User::where('role_id',4)->get();

        //$data = features::leftjoin("my_categories",\DB::raw("FIND_IN_SET(my_categories.id,features.category_ids)"),">",\DB::raw("'0'"))->get();

        if($user)
        {
            $cats = my_categories::orderBy('id','desc')->get();

            return view('admin.category.my_categories_index',compact('cats'));
        }
        else
        {
            return redirect()->route('front.index');
        }
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

        if($user->can('user-categories'))
        {
            $cats = Category::where('user_id',$user_id)->orderBy('id','desc')->get();

            return view('admin.category.index',compact('cats'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function MyCategoryCreate()
    {
        $user = Auth::guard('admin')->user();
        $suppliers = User::where('role_id',4)->get();

        if($user)
        {
            return view('admin.category.create_my_category',compact('suppliers'));
        }
        else
        {
            return redirect()->route('front.index');
        }
    }

    public function create()
    {
        $user = Auth::guard('user')->user();

        if($user->can('category-create'))
        {
            return view('admin.category.create');
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function MyCategoryStore(StoreValidationRequest $request)
    {
        $user = Auth::guard('admin')->user();

        if($request->cat_id)
        {
            $cat = my_categories::where('id',$request->cat_id)->first();
            Session::flash('success', 'Category edited successfully.');
        }
        else
        {
            $cat = new my_categories;
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

    public function store(StoreValidationRequest $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        $request['main_service'] = 1;

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
        $input['user_id'] = $user_id;


        if ($file = $request->file('photo'))
        {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images',$name);
            $input['photo'] = $name;
        }

        $cat->fill($input)->save();

        return redirect()->route('admin-cat-index');
    }

    public function MyCategoryEdit($id)
    {
        $user = Auth::guard('admin')->user();
        $suppliers = User::where('role_id',4)->get();

        if($user)
        {
            $cats = my_categories::where('id','=',$id)->first();
            $category_suppliers = supplier_categories::where('category_id',$id)->pluck('user_id')->toArray();

            if(!$cats)
            {
                return redirect()->back();
            }

            return view('admin.category.create_my_category',compact('cats','suppliers','category_suppliers'));
        }
        else
        {
            return redirect()->route('front.index');
        }
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

        if($user->can('category-edit'))
        {
            $cats = Category::where('id','=',$id)->where('user_id',$user_id)->first();

            if(!$cats)
            {
                return redirect()->back();
            }

            return view('admin.category.create',compact('cats'));
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

    public function MyCategoryDestroy($id)
    {
        $user = Auth::guard('admin')->user();

        if($user)
        {
            $cat = my_categories::where('id',$id)->first();
            supplier_categories::where('category_id',$id)->delete();

            if(!$cat)
            {
                return redirect()->back();
            }

            if($cat->photo == null){
                $cat->delete();
                Session::flash('success', 'Category deleted successfully.');
                return redirect()->route('admin-my-cat-index');
            }

            \File::delete(public_path() .'/assets/images/'.$cat->photo);
            $cat->delete();
            Session::flash('success', 'Category deleted successfully.');
            return redirect()->route('admin-my-cat-index');
        }
        else
        {
            return redirect()->route('front.index');
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

        if($user->can('category-delete'))
        {
            $cat = Category::where('id',$id)->where('user_id',$user_id)->first();

            if(!$cat)
            {
                return redirect()->back();
            }

            if($cat->photo == null){
                $cat->delete();
                Session::flash('success', 'Category deleted successfully.');
                return redirect()->route('admin-cat-index');
            }

            \File::delete(public_path() .'/assets/images/'.$cat->photo);
            $cat->delete();
            Session::flash('success', 'Category deleted successfully.');
            return redirect()->route('admin-cat-index');
        }
        else
        {
            return redirect()->route('user-login');
        }
    }
}
