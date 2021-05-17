<?php

namespace App\Http\Controllers;

use App\Brand;
use App\color;
use App\colors;
use App\estimated_prices;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Model1;
use App\price_tables;
use App\product;
use App\Products;
use App\vats;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest3;
use App\Http\Requests\UpdateValidationRequest;
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

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function productsModelsByBrands(Request $request)
    {
        $models = Model1::where('brand_id','=',$request->id)->get();

        return $models;
    }

    public function index()
    {
        $cats = Products::leftjoin('categories','categories.id','=','products.category_id')->leftjoin('brands','brands.id','=','products.brand_id')->leftjoin('models','models.id','=','products.model_id')->orderBy('products.id','desc')->select('products.*','categories.cat_name as category','brands.cat_name as brand','models.cat_name as model')->get();

        return view('admin.product.index',compact('cats'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $tables = price_tables::where('connected',1)->get();

        return view('admin.product.create',compact('categories','brands','tables'));
    }

    public function pricesTables(Request $request)
    {
        $tables = price_tables::where('id',$request->id)->get();

        return $tables;
    }

    public function import()
    {
        return view('admin.product.import');
    }

    public function PostImport(Request $request)
    {
        ini_set('memory_limit', '-1');
        $extension = strtolower($request->excel_file->getClientOriginalExtension());

        if(!in_array($extension, ['csv', 'xls', 'xlsx']))
        {
            return redirect()->back()->withErrors("File should be of format xlsx, xls or csv")->withInput();
        }

        $import = new ProductsImport;
        Excel::import($import,request()->file('excel_file'));


        if(count($import->data) > 0)
        {
            $product = Products::where('excel',1)->whereNotIn('id', $import->data)->get();

            foreach ($product as $key)
            {
                if($key->photo != null){
                    \File::delete(public_path() .'/assets/images/'.$key->photo);
                }
                handyman_products::where('product_id',$key->id)->delete();
                $key->delete();
            }
        }

        Session::flash('success', 'Task completed successfully.');
        return redirect()->route('admin-product-index');
    }

    public function PostExport(Request $request)
    {
        ini_set('memory_limit', '-1');
        return Excel::download(new ProductsExport(),'products.xlsx');
    }

    public function store(StoreValidationRequest3 $request)
    {
        $prices = preg_replace("/,([\s])+/",",",$request->estimated_price);
        $colors = $request->colors;

        if($prices)
        {
            $pricesArray = explode(',', $prices);
        }
        else
        {
            $pricesArray = [];
        }

        $input = $request->all();

        if($request->cat_id)
        {
            $cat = Products::where('id',$request->cat_id)->first();

            if($file = $request->file('photo'))
            {
                \File::delete(public_path() .'/assets/images/'.$cat->photo);
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
                $input['photo'] = $name;
            }

            $cat->fill($input)->save();

            $col = color::where('product_id',$request->cat_id)->get();

            if(count($col) == 0)
            {
                foreach ($colors as $c => $key)
                {
                    if($key != NULL && $request->color_codes[$c] != NULL && $request->price_tables[$c] != NULL)
                    {
                        $col = new colors;
                        $col->title = $key;
                        $col->color_code = $request->color_codes[$c];
                        $col->product_id = $request->cat_id;
                        $col->table_id = $request->price_tables[$c];
                        $col->save();
                    }
                }
            }
            else
            {
                if(count($colors) > 0)
                {
                    foreach ($colors as $c => $key)
                    {
                        $col_check = colors::where('product_id',$request->cat_id)->skip($c)->first();

                        if($col_check)
                        {
                            if($key != NULL && $request->color_codes[$c] != NULL && $request->price_tables[$c] != NULL)
                            {
                                $col_check->title = $key;
                                $col_check->color_code = $request->color_codes[$c];
                                $col_check->table_id = $request->price_tables[$c];
                                $col_check->save();
                            }
                        }
                        else
                        {
                            if($key != NULL && $request->color_codes[$c] != NULL && $request->price_tables[$c] != NULL)
                            {
                                $col = new colors;
                                $col->title = $key;
                                $col->color_code = $request->color_codes[$c];
                                $col->product_id = $request->cat_id;
                                $col->table_id = $request->price_tables[$c];
                                $col->save();
                            }
                        }
                    }
                }
                else
                {
                    colors::where('product_id',$request->cat_id)->delete();
                }
            }

            $est = estimated_prices::where('product_id',$request->cat_id)->get();

            if(count($est) == 0)
            {
                foreach ($pricesArray as $price)
                {
                    $est = new estimated_prices;
                    $est->product_id = $request->cat_id;
                    $est->price = $price;
                    $est->save();
                }
            }
            else
            {
                if(count($pricesArray) > 0)
                {
                    foreach ($pricesArray as $x => $price)
                    {
                        $est_check = estimated_prices::where('product_id',$request->cat_id)->skip($x)->first();

                        if($est_check)
                        {
                            $est_check->price = $pricesArray[$x];
                            $est_check->save();
                        }
                        else
                        {
                            $temp = new estimated_prices;
                            $temp->product_id = $request->cat_id;
                            $temp->price = $pricesArray[$x];
                            $temp->save();
                        }
                    }
                }
                else
                {
                    estimated_prices::where('product_id',$request->cat_id)->delete();
                }
            }

            Session::flash('success', 'Product edited successfully.');
        }
        else
        {
            $check = Products::leftjoin('categories','categories.id','=','products.category_id')->leftjoin('brands','brands.id','=','products.brand_id')->leftjoin('models','models.id','=','products.model_id')->where('products.title', 'LIKE', '%'.$request->title.'%')->where('products.model_number',$request->model_number)->where('categories.id',$request->category_id)->where('brands.id',$request->brand_id)->where('models.id',$request->model_id)->select('products.*')->first();

            if(!$check)
            {
                $cat = new Products();

                if($file = $request->file('photo'))
                {
                    \File::delete(public_path() .'/assets/images/'.$cat->photo);
                    $name = time().$file->getClientOriginalName();
                    $file->move('assets/images',$name);
                    $input['photo'] = $name;
                }

                $cat->fill($input)->save();

                foreach ($colors as $c => $key)
                {
                    if($key != NULL && $request->color_codes[$c] != NULL && $request->price_tables[$c] != NULL)
                    {
                        $col = new colors;
                        $col->title = $key;
                        $col->color_code = $request->color_codes[$c];
                        $col->product_id = $cat->id;
                        $col->table_id = $request->price_tables[$c];
                        $col->save();
                    }
                }

                foreach ($pricesArray as $x => $price)
                {
                    $est = new estimated_prices;
                    $est->product_id = $cat->id;
                    $est->price = $price;
                    $est->save();
                }

                Session::flash('success', 'New Product added successfully.');
            }
            else
            {

                if($file = $request->file('photo'))
                {
                    \File::delete(public_path() .'/assets/images/'.$check->photo);
                    $name = time().$file->getClientOriginalName();
                    $file->move('assets/images',$name);
                    $input['photo'] = $name;
                }

                $check->fill($input)->save();

                $col = color::where('product_id',$check->id)->get();

                if(count($col) == 0)
                {
                    foreach ($colors as $c => $key)
                    {
                        if($key != NULL && $request->color_codes[$c] != NULL && $request->price_tables[$c] != NULL)
                        {
                            $col = new colors;
                            $col->title = $key;
                            $col->color_code = $request->color_codes[$c];
                            $col->product_id = $check->id;
                            $col->table_id = $request->price_tables[$c];
                            $col->save();
                        }
                    }
                }
                else
                {
                    if(count($colors) > 0)
                    {
                        foreach ($colors as $c => $key)
                        {
                            $col_check = colors::where('product_id',$check->id)->skip($c)->first();

                            if($col_check)
                            {
                                if($key != NULL && $request->color_codes[$c] != NULL && $request->price_tables[$c] != NULL)
                                {
                                    $col_check->title = $key;
                                    $col_check->color_code = $request->color_codes[$c];
                                    $col_check->table_id = $request->price_tables[$c];
                                    $col_check->save();
                                }
                            }
                            else
                            {
                                if($key != NULL && $request->color_codes[$c] != NULL && $request->price_tables[$c] != NULL)
                                {
                                    $col = new colors;
                                    $col->title = $key;
                                    $col->color_code = $request->color_codes[$c];
                                    $col->product_id = $check->id;
                                    $col->table_id = $request->price_tables[$c];
                                    $col->save();
                                }
                            }
                        }
                    }
                    else
                    {
                        colors::where('product_id',$check->id)->delete();
                    }
                }

                $est = estimated_prices::where('product_id',$check->id)->get();

                if(count($est) == 0)
                {
                    foreach ($pricesArray as $price)
                    {
                        $est = new estimated_prices;
                        $est->product_id = $check->id;
                        $est->price = $price;
                        $est->save();
                    }
                }
                else
                {
                    if(count($pricesArray) > 0)
                    {
                        foreach ($pricesArray as $x => $price)
                        {
                            $est_check = estimated_prices::where('product_id',$check->id)->skip($x)->first();

                            if($est_check)
                            {
                                $est_check->price = $pricesArray[$x];
                                $est_check->save();
                            }
                            else
                            {
                                $temp = new estimated_prices;
                                $temp->product_id = $check->id;
                                $temp->price = $pricesArray[$x];
                                $temp->save();
                            }
                        }
                    }
                    else
                    {
                        estimated_prices::where('product_id',$check->id)->delete();
                    }
                }

                Session::flash('success', 'Product edited successfully.');
            }
        }

        return redirect()->route('admin-product-index');
    }

    public function edit($id)
    {
        $cats = Products::where('id','=',$id)->first();

        $colors_data = colors::leftjoin('price_tables','price_tables.id','=','colors.table_id')->where('colors.product_id','=',$id)->select('colors.title as color','colors.color_code','colors.table_id','price_tables.title as table')->get();

        $categories = Category::all();
        $brands = Brand::all();
        $models = Model1::where('brand_id',$cats->brand_id)->get();
        $tables = price_tables::where('connected',1)->get();

        return view('admin.product.create',compact('cats','categories','brands','models','tables','colors_data'));
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

    public function destroy($id)
    {
        $cat = Products::findOrFail($id);
        estimated_prices::where('product_id',$id)->delete();

        if($cat->photo == null){
            $cat->delete();
            Session::flash('success', 'Product deleted successfully.');
            return redirect()->route('admin-product-index');
        }

        \File::delete(public_path() .'/assets/images/'.$cat->photo);
        handyman_products::where('product_id',$id)->delete();
        $cat->delete();
        Session::flash('success', 'Product deleted successfully.');
        return redirect()->route('admin-product-index');
    }
}
