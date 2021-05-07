<?php

namespace App\Http\Controllers;

use App\Brand;
use App\colors;
use App\estimated_prices;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Model1;
use App\product;
use App\Products;
use App\vats;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest5;
use Auth;
use App\Generalsetting;
use Mollie\Laravel\Facades\Mollie;
use App\service_types;
use App\sub_services;
use App\handyman_products;
use App\carts;
use Illuminate\Database\Eloquent\SoftDeletes;
use Maatwebsite\Excel\Concerns\FromCollection;
use Excel;

class ColorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $colors = colors::orderBy('id','desc')->get();

        return view('admin.color.index',compact('colors'));
    }

    public function create()
    {
        return view('admin.color.create');
    }


    public function store(StoreValidationRequest5 $request)
    {
        if($request->id)
        {
            colors::where('id',$request->id)->update(['title' => $request->title, 'color_code' => $request->color_code]);

            Session::flash('success', 'Color edited successfully.');
        }
        else
        {
            $color = new colors;
            $color->title = $request->title;
            $color->color_code = $request->color_code;
            $color->save();

            Session::flash('success', 'Color created successfully.');
        }

        return redirect()->route('admin-color-index');
    }

    public function edit($id)
    {
        $color = colors::where('id','=',$id)->first();

        return view('admin.color.create',compact('color'));
    }

    public function destroy($id)
    {
        $color = colors::where('id',$id)->first();
        $color->delete();

        Session::flash('success', 'Color deleted successfully.');
        return redirect()->route('admin-color-index');
    }
}
