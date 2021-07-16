<?php

namespace App\Http\Controllers;

use App\items;
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

        if($user->can('user-items'))
        {
            $items = items::leftjoin('users','users.id','=','items.user_id')->where('items.user_id',$user_id)->orderBy('items.id','desc')->select('items.*','users.name','users.family_name')->get();

            return view('admin.item.index',compact('items'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function create()
    {
        $user = Auth::guard('user')->user();

        if($user->can('create-item'))
        {
            return view('admin.item.create');
        }
        else
        {
            return redirect()->route('user-login');
        }
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

        $item = new items;
        $input = $request->all();
        $photo = '';

        if ($file = $request->file('photo'))
        {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/item_images',$name);
            $photo = $name;
        }

        $item->cat_name = $request->title;
        $item->user_id = $user_id;
        $item->photo = $photo;
        $item->description = $request->description;
        $item->rate = $request->rate;
        $item->save();


        Session::flash('success', 'New Item added successfully.');
        return redirect()->route('admin-item-index');
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

        if($user->can('edit-item'))
        {
            $item = items::where('id',$id)->where('user_id',$user_id)->first();

            if(!$item)
            {
                return redirect()->back();
            }

            return view('admin.item.edit',compact('item'));
        }
        else
        {
            return redirect()->route('user-login');
        }
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
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('delete-item'))
        {
            $item = items::where('id',$id)->where('user_id',$user_id)->first();

            if(!$item)
            {
                return redirect()->back();
            }

            if($item->photo == null){
                $item->delete();
                Session::flash('success', 'Item deleted successfully.');
                return redirect()->route('admin-item-index');
            }

            unlink(public_path().'/assets/item_images/'.$item->photo);
            $item->delete();
            Session::flash('success', 'Item deleted successfully.');
            return redirect()->route('admin-item-index');
        }
        else
        {
            return redirect()->route('user-login');
        }

    }
}
