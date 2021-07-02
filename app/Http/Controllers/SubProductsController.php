<?php

namespace App\Http\Controllers;

use App\sub_products_sizes;
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
            $removed = explode(',', $request->removed);
            sub_products_sizes::whereIn('id',$removed)->delete();

            sub_products::where('id',$request->sub_id)->update(['title' => $request->title]);

            $sub = sub_products_sizes::where('sub_id',$request->sub_id)->get();

            if(count($sub) == 0)
            {
                foreach ($request->sub_codes as $i => $key)
                {
                    if($key && $request->sub_product_titles[$i])
                    {
                        $sub = new sub_products_sizes;
                        $sub->sub_id = $request->sub_id;
                        $sub->unique_code = $key;
                        $sub->title = $request->sub_product_titles[$i];
                        $sub->size1_value = $request->size1_value[$i];
                        $sub->size2_value = $request->size2_value[$i];
                        $sub->save();
                    }
                }
            }
            else
            {
                if(count($request->sub_codes) > 0)
                {
                    foreach ($request->sub_codes as $s => $key)
                    {
                        $sub_check = sub_products_sizes::where('sub_id',$request->sub_id)->skip($s)->first();

                        if($sub_check)
                        {
                            if($key && $request->sub_product_titles[$s])
                            {
                                $sub_check->unique_code = $key;
                                $sub_check->title = $request->sub_product_titles[$s];
                                $sub_check->size1_value = $request->size1_value[$s];
                                $sub_check->size2_value = $request->size2_value[$s];
                                $sub_check->save();
                            }
                        }
                        else
                        {
                            if($key && $request->sub_product_titles[$s])
                            {
                                $sub = new sub_products_sizes;
                                $sub->sub_id = $request->sub_id;
                                $sub->unique_code = $key;
                                $sub->title = $request->sub_product_titles[$s];
                                $sub->size1_value = $request->size1_value[$s];
                                $sub->size2_value = $request->size2_value[$s];
                                $sub->save();
                            }
                        }
                    }
                }
                else
                {
                    sub_products_sizes::where('sub_id',$request->sub_id)->delete();
                }
            }

            Session::flash('success', 'Sub Product updated successfully.');
        }
        else
        {
            $sub_product = new sub_products;

            $sub_product->title = $request->title;
            $sub_product->save();

            foreach ($request->sub_codes as $i => $key)
            {
                if($key && $request->sub_product_titles[$i])
                {
                    $sub = new sub_products_sizes;
                    $sub->sub_id = $sub_product->id;
                    $sub->unique_code = $key;
                    $sub->title = $request->sub_product_titles[$i];
                    $sub->size1_value = $request->size1_value[$i];
                    $sub->size2_value = $request->size2_value[$i];
                    $sub->save();
                }
            }

            Session::flash('success', 'Sub Product added successfully.');
        }

        return redirect()->back();
    }

    public function edit($id)
    {
        $sub_product = sub_products::findOrFail($id);

        $sub_data = sub_products_sizes::where('sub_id',$id)->get();

        return view('admin.sub_products.create',compact('sub_product','sub_data'));
    }

    public function destroy($id)
    {
        $sub_product = sub_products::findOrFail($id);
        $sub_product->delete();

        sub_products_sizes::where('sub_id',$id)->delete();
        Session::flash('success', 'Sub Product deleted successfully.');
        return redirect()->route('admin-sub-products-index');

    }
}
