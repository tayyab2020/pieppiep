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
        $this->middleware('auth:admin');
    }


    public function index()
    {
        $items = items::leftjoin('users','users.id','=','items.user_id')->orderBy('items.id','desc')->select('items.*','users.name','users.family_name')->get();

        return view('admin.item.index',compact('items'));
    }

    public function create()
    {
        $handymen = User::where('role_id',2)->where('active',1)->get();

        return view('admin.item.create',compact('handymen'));
    }

    public function store(StoreValidationRequest $request)
    {

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
        $item->user_id = $request->handyman;
        $item->photo = $photo;
        $item->description = $request->description;
        $item->rate = $request->rate;
        $item->save();


        Session::flash('success', 'New Item added successfully.');
        return redirect()->route('admin-item-index');
    }

    public function edit($id)
    {
        $item = items::findOrFail($id);

        $handymen = User::where('role_id',2)->where('active',1)->get();

        return view('admin.item.edit',compact('item','handymen'));
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
        $item = items::findOrFail($id);

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
}
