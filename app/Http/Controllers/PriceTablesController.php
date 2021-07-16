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

        if($user->can('user-price-tables'))
        {
            $cats = price_tables::where('user_id',$user_id)->orderBy('id','desc')->get();

            return view('admin.price_tables.index',compact('cats'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function create()
    {
        $user = Auth::guard('user')->user();

        if($user->can('create-price-table'))
        {
            return view('admin.price_tables.create');
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function import()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('import-price-table'))
        {
            $tables = price_tables::where('connected',0)->where('user_id',$user_id)->get();

            return view('admin.price_tables.import',compact('tables'));
        }
        else
        {
            return redirect()->route('user-login');
        }
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
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($request->id)
        {
            price_tables::where('id',$request->id)->update(['title' => $request->title]);
            Session::flash('success', 'Table edited successfully.');
        }
        else
        {
            $post = new price_tables;
            $post->title = $request->title;
            $post->user_id = $user_id;
            $post->save();

            Session::flash('success', 'New Table added successfully.');
        }

        return redirect()->route('admin-price-tables');
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

        if($user->can('edit-price-table'))
        {
            $cats = price_tables::where('id',$id)->where('user_id',$user_id)->first();

            if(!$cats)
            {
                return redirect()->back();
            }

            return view('admin.price_tables.create',compact('cats'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function viewPrices($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('view-price-table'))
        {
            $data = price_tables::where('id',$id)->where('user_id',$user_id)->first();

            if(!$data)
            {
                return redirect()->back();
            }

            $widths = price_tables::leftjoin('prices','prices.table_id','=','price_tables.id')->where('price_tables.id',$id)->where('price_tables.user_id',$user_id)->pluck('prices.x_axis')->toArray();
            $widths = array_unique($widths);

            if(!$widths[0])
            {
                $widths = [];
            }

            $heights = price_tables::leftjoin('prices','prices.table_id','=','price_tables.id')->where('price_tables.id',$id)->where('price_tables.user_id',$user_id)->pluck('prices.y_axis')->toArray();
            $heights = array_unique($heights);

            if(!$heights[0])
            {
                $heights = [];
            }

            $org_heights = [];

            $prices = [];

            foreach ($heights as $height)
            {
                $prices[$height] = price_tables::leftjoin('prices','prices.table_id','=','price_tables.id')->where('price_tables.id',$id)->where('price_tables.user_id',$user_id)->where('prices.y_axis',$height)->select('prices.*','price_tables.id','price_tables.title')->get()->toArray();

                $org_heights[] = $height;
            }

            return view('admin.price_tables.prices', compact('widths','org_heights','prices','data'));
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

        if($user->can('delete-price-table'))
        {
            $data = price_tables::where('id',$id)->where('user_id',$user_id)->first();

            if(!$data)
            {
                return redirect()->back();
            }

            prices::where('table_id',$id)->delete();
            price_tables::where('id',$id)->where('user_id',$user_id)->delete();

            Session::flash('success', 'Price table and prices are deleted successfully.');
            return redirect()->route('admin-price-tables');
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function destroyPrices($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('delete-prices'))
        {
            $data = price_tables::where('id',$id)->where('user_id',$user_id)->first();

            if(!$data)
            {
                return redirect()->back();
            }

            prices::where('table_id',$id)->delete();
            price_tables::where('id',$id)->where('user_id',$user_id)->update(['connected' => 0]);

            Session::flash('success', 'Prices are deleted successfully.');
            return redirect()->route('admin-price-tables');
        }
        else
        {
            return redirect()->route('user-login');
        }
    }
}
