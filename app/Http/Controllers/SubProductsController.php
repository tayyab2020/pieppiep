<?php

namespace App\Http\Controllers;

use App\feature_sub_products;
use App\features;
use App\sub_products;
use App\User;
use App\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use Auth;
use App\Generalsetting;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


    public function index()
    {
        $sub_products = sub_products::orderBy('id','desc')->get();

        return view('admin.sub_products.index',compact('sub_products'));
    }

    public function create()
    {
        return view('admin.sub_products.create');
    }

    public function store(Request $request)
    {
        if($request->sub_id)
        {
            sub_products::where('id',$request->sub_id)->update(['title' => $request->title]);

            Session::flash('success', 'Sub Product updated successfully.');
            return redirect()->route('admin-sub-products-index');
        }
        else
        {
            $sub_product = new sub_products;

            $sub_product->title = $request->title;
            $sub_product->save();

            Session::flash('success', 'New Feature added successfully.');
        }

        return redirect()->route('admin-sub-products-index');
    }

    public function edit($id)
    {
        $sub_product = sub_products::findOrFail($id);

        return view('admin.sub_products.create',compact('sub_product'));
    }

    public function destroy($id)
    {
        $sub_product = sub_products::findOrFail($id);
        $sub_product->delete();

        Session::flash('success', 'Sub Product deleted successfully.');
        return redirect()->route('admin-sub-products-index');

    }
}
