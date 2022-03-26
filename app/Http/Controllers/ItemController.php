<?php

namespace App\Http\Controllers;

use App\items;
use App\sub_categories;
use App\User;
use App\users;
use Illuminate\Http\Request;
use App\Category;
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
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $items = items::leftjoin('users','users.id','=','items.user_id')->select('items.*','users.name','users.family_name')->get();

        return view('admin.item.index',compact('items'));
    }

    public function create()
    {
        $categories = Category::get();
        $retailers = User::where('role_id',2)->where('status',1)->where('active',1)->get();

        return view('admin.item.create',compact('categories','retailers'));
    }

    public function store(StoreValidationRequest $request)
    {
        if($request->item_id)
        {
            $item = items::where('id',$request->item_id)->first();

            if ($item->photo != null) {
                \File::delete(public_path() .'/assets/item_images/'.$item->photo);
            }

            Session::flash('success', 'Item updated successfully.');
        }
        else
        {
            $item = new items;
            Session::flash('success', 'New Item added successfully.');
        }

        $input = $request->all();
        $photo = '';

        if ($file = $request->file('photo'))
        {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/item_images',$name);
            $photo = $name;
        }

        $sub_categories = implode(',', $request->sub_category_id);
        $products = implode(',', $request->products);

        $item->cat_name = $request->title;
        $item->user_id = $request->retailer_id;
        $item->category_id = $request->category_id;
        $item->sub_category_ids = $sub_categories ? $sub_categories : NULL;
        $item->photo = $photo;
        $item->description = $request->description;
        $item->rate = str_replace(",",".",$request->rate);
        $item->sell_rate = str_replace(",",".",$request->sell_rate);
        $item->products = $products ? $products : NULL;
        $item->save();

        return redirect()->route('admin-item-index');
    }

    public function edit($id)
    {
        $item = items::where('id',$id)->first();
        $categories = Category::get();
        $sub_categories = sub_categories::where('parent_id',$item->category_id)->get();
        $retailers = User::where('role_id',2)->where('status',1)->where('active',1)->get();

        if(!$item)
        {
            return redirect()->back();
        }

        return view('admin.item.create',compact('item','categories','sub_categories','retailers'));
    }

    public function update(UpdateValidationRequest $request, $id)
    {

        $item = items::findOrFail($id);
        $input = $request->all();

        if($file = $request->file('photo'))
        {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/item_images',$name);
            if($item->photo != null)
            {
                unlink(public_path().'/assets/item_images/'.$item->photo);
            }
            $input['photo'] = $name;
        }
        else
        {
            if($item->photo != null)
            {
                unlink(public_path().'/assets/item_images/'.$item->photo);
            }

            $input['photo'] = '';
        }

        $item = items::where('id',$id)->update(['cat_name' => $request->title, 'user_id' => $request->handyman, 'photo' => $input['photo'], 'description' => $request->description, 'rate' => $request->rate]);

        Session::flash('success', 'Item updated successfully.');
        return redirect()->route('admin-item-index');
    }

    public function destroy($id)
    {
        $item = items::where('id',$id)->first();

        if(!$item)
        {
            return redirect()->back();
        }

        if($item->photo == null){
            $item->delete();
            Session::flash('success', 'Item deleted successfully.');
            return redirect()->route('admin-item-index');
        }

        \File::delete(public_path().'/assets/item_images/'.$item->photo);
        $item->delete();
        Session::flash('success', 'Item deleted successfully.');
        return redirect()->route('admin-item-index');

    }
}
