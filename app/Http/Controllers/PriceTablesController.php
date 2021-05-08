<?php

namespace App\Http\Controllers;

use App\Brand;
use App\color;
use App\colors;
use App\estimated_prices;
use App\Exports\ProductsExport;
use App\Imports\PricesImport;
use App\Imports\ProductsImport;
use App\Model1;
use App\price_tables;
use App\prices;
use App\product;
use App\Products;
use App\vats;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest6;
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

class PriceTablesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $cats = price_tables::orderBy('id','desc')->get();

        return view('admin.price_tables.index',compact('cats'));
    }

    public function create()
    {
        return view('admin.price_tables.create');
    }

    public function import()
    {
        $tables = price_tables::where('connected',0)->get();

        return view('admin.price_tables.import',compact('tables'));
    }

    public function PostImport(Request $request)
    {
        ini_set('memory_limit', '-1');
        $extension = strtolower($request->excel_file->getClientOriginalExtension());

        if(!in_array($extension, ['csv', 'xls', 'xlsx']))
        {
            return redirect()->back()->withErrors("File should be of format xlsx, xls or csv")->withInput();
        }

        $import = new PricesImport($request->table_id);
        Excel::import($import,request()->file('excel_file'));

        if(count($import->data) > 0)
        {
            price_tables::where('id',$request->table_id)->update(['connected' => 1]);
        }

        Session::flash('success', 'Task completed successfully.');
        return redirect()->route('admin-price-tables');
    }

    public function PostExport(Request $request)
    {
        ini_set('memory_limit', '-1');
        return Excel::download(new ProductsExport(),'products.xlsx');
    }

    public function store(StoreValidationRequest6 $request)
    {

        if($request->id)
        {
            price_tables::where('id',$request->id)->update(['title' => $request->title]);
            Session::flash('success', 'Table edited successfully.');
        }
        else
        {
            $post = new price_tables;
            $post->title = $request->title;
            $post->save();

            Session::flash('success', 'New Table added successfully.');
        }

        return redirect()->route('admin-price-tables');
    }

    public function edit($id)
    {
        $cats = price_tables::where('id',$id)->first();

        return view('admin.price_tables.create',compact('cats'));
    }

    public function viewPrices($id)
    {
        $data = price_tables::where('id',$id)->first();

        $widths = price_tables::leftjoin('prices','prices.table_id','=','price_tables.id')->where('price_tables.id',$id)->pluck('prices.x_axis')->toArray();
        $widths = array_unique($widths);

        if(!$widths[0])
        {
            $widths = [];
        }

        $heights = price_tables::leftjoin('prices','prices.table_id','=','price_tables.id')->where('price_tables.id',$id)->pluck('prices.y_axis')->toArray();
        $heights = array_unique($heights);

        if(!$heights[0])
        {
            $heights = [];
        }

        $org_heights = [];

        $prices = [];

        foreach ($heights as $height)
        {
            $prices[$height] = price_tables::leftjoin('prices','prices.table_id','=','price_tables.id')->where('price_tables.id',$id)->where('prices.y_axis',$height)->select('prices.*','price_tables.id','price_tables.title')->get()->toArray();

            $org_heights[] = $height;
        }

        return view('admin.price_tables.prices', compact('widths','org_heights','prices','data'));
    }

    public function destroy($id)
    {
        prices::where('table_id',$id)->delete();
        price_tables::where('id',$id)->delete();

        Session::flash('success', 'Price table and prices are deleted successfully.');
        return redirect()->route('admin-price-tables');
    }

    public function destroyPrices($id)
    {
        prices::where('table_id',$id)->delete();
        price_tables::where('id',$id)->update(['connected' => 0]);

        Session::flash('success', 'Prices are deleted successfully.');
        return redirect()->route('admin-price-tables');
    }
}
