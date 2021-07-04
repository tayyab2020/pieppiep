<?php

namespace App\Http\Controllers;

use App\Brand;
use App\color;
use App\colors;
use App\estimated_prices;
use App\Exports\ProductsExport;
use App\features;
use App\Imports\ProductsImport;
use App\Model1;
use App\price_tables;
use App\product;
use App\product_features;
use App\product_ladderbands;
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
        $features_headings = features::all();

        return view('admin.product.create',compact('categories','brands','tables','features_headings'));
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
        $features = $request->feature_headings;
        $sub_products = $request->sub_codes;

        if($prices)
        {
            $pricesArray = explode(',', $prices);
        }
        else
        {
            $pricesArray = [];
        }

        $input = $request->all();

        if($input['ladderband'])
        {
            if(!$input['ladderband_value'])
            {
                $input['ladderband_value'] = 0;
            }
        }


        if($request->cat_id)
        {
            $removed = explode(',', $request->removed);
            $removed_ladderband = explode(',', $request->removed_ladderband);
            product_features::whereIn('id',$removed)->delete();
            product_ladderbands::whereIn('id',$removed_ladderband)->delete();

            $removed_colors = explode(',', $request->removed_colors);
            colors::whereIn('id',$removed_colors)->delete();

            $cat = Products::where('id',$request->cat_id)->first();

            if($file = $request->file('photo'))
            {
                \File::delete(public_path() .'/assets/images/'.$cat->photo);
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
                $input['photo'] = $name;
            }

            $cat->fill($input)->save();

            $fea = product_features::where('product_id',$request->cat_id)->get();

            if(count($fea) == 0)
            {
                foreach ($features as $f => $key)
                {
                    if($key != NULL && $request->features[$f] != NULL)
                    {
                        $fea = new product_features;
                        $fea->title = $request->features[$f];
                        $fea->value = $request->feature_values[$f] ? $request->feature_values[$f] : 0;
                        $fea->product_id = $request->cat_id;
                        $fea->heading_id = $key;
                        $fea->max_size = $request->max_size[$f] ? str_replace(",",".",$request->max_size[$f]) : NULL;
                        $fea->price_impact = $request->price_impact[$f];
                        $fea->impact_type = $request->impact_type[$f];
                        $fea->save();
                    }
                }
            }
            else
            {
                if(count($features) > 0)
                {
                    foreach ($features as $f => $key)
                    {
                        $fea_check = product_features::where('product_id',$request->cat_id)->skip($f)->first();

                        if($fea_check)
                        {
                            if($key != NULL && $request->features[$f] != NULL)
                            {
                                $fea_check->title = $request->features[$f];
                                $fea_check->heading_id = $key;
                                $fea_check->value = $request->feature_values[$f] ? $request->feature_values[$f] : 0;
                                $fea_check->max_size = $request->max_size[$f] ? str_replace(",",".",$request->max_size[$f]) : NULL;
                                $fea_check->price_impact = $request->price_impact[$f];
                                $fea_check->impact_type = $request->impact_type[$f];
                                $fea_check->save();
                            }
                        }
                        else
                        {
                            if($key != NULL && $request->features[$f] != NULL)
                            {
                                $fea = new product_features;
                                $fea->product_id = $request->cat_id;
                                $fea->title = $request->features[$f];
                                $fea->heading_id = $key;
                                $fea->value = $request->feature_values[$f] ? $request->feature_values[$f] : 0;
                                $fea->max_size = $request->max_size[$f] ? str_replace(",",".",$request->max_size[$f]) : NULL;
                                $fea->price_impact = $request->price_impact[$f];
                                $fea->impact_type = $request->impact_type[$f];
                                $fea->save();
                            }
                        }
                    }
                }
                else
                {
                    product_features::where('product_id',$request->cat_id)->delete();
                }
            }

            $sub_pro = product_ladderbands::where('product_id',$request->cat_id)->get();

            if(count($sub_pro) == 0)
            {
                foreach ($sub_products as $s => $key)
                {
                    if($key != NULL && $request->sub_product_titles[$s] != NULL)
                    {
                        $sub_pro = new product_ladderbands;
                        $sub_pro->title = $request->sub_product_titles[$s];
                        $sub_pro->product_id = $request->cat_id;
                        $sub_pro->code = $key;
                        $sub_pro->size1_value = $request->size1_value[$s];
                        $sub_pro->size2_value = $request->size2_value[$s];
                        $sub_pro->save();
                    }
                }
            }
            else
            {
                if(count($sub_products) > 0)
                {
                    foreach ($sub_products as $s => $key)
                    {
                        $sub_check = product_ladderbands::where('product_id',$request->cat_id)->skip($s)->first();

                        if($sub_check)
                        {
                            if($key != NULL && $request->sub_product_titles[$s] != NULL)
                            {
                                $sub_check->title = $request->sub_product_titles[$s];
                                $sub_check->code = $key;
                                $sub_check->size1_value = $request->size1_value[$s];
                                $sub_check->size2_value = $request->size2_value[$s];
                                $sub_check->save();
                            }
                        }
                        else
                        {
                            if($key != NULL && $request->sub_product_titles[$s] != NULL)
                            {
                                $sub_pro = new product_ladderbands;
                                $sub_pro->title = $request->sub_product_titles[$s];
                                $sub_pro->product_id = $request->cat_id;
                                $sub_pro->code = $key;
                                $sub_pro->size1_value = $request->size1_value[$s];
                                $sub_pro->size2_value = $request->size2_value[$s];
                                $sub_pro->save();
                            }
                        }
                    }
                }
                else
                {
                    product_ladderbands::where('product_id',$request->cat_id)->delete();
                }
            }

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

                foreach ($features as $f => $key)
                {
                    if($key != NULL && $request->features[$f] != NULL)
                    {
                        $feature = new product_features;
                        $feature->product_id = $cat->id;
                        $feature->title = $request->features[$f];
                        $feature->heading_id = $key;
                        $feature->value = $request->feature_values[$f] ? $request->feature_values[$f] : 0;
                        $feature->max_size = $request->max_size[$f] ? str_replace(",",".",$request->max_size[$f]) : NULL;
                        $feature->price_impact = $request->price_impact[$f];
                        $feature->impact_type = $request->impact_type[$f];
                        $feature->save();
                    }
                }

                foreach ($sub_products as $s => $key)
                {
                    if($key != NULL && $request->sub_product_titles[$s] != NULL)
                    {
                        $sub_pro = new product_ladderbands;
                        $sub_pro->title = $request->sub_product_titles[$s];
                        $sub_pro->product_id = $cat->id;
                        $sub_pro->code = $key;
                        $sub_pro->size1_value = $request->size1_value[$s];
                        $sub_pro->size2_value = $request->size2_value[$s];
                        $sub_pro->save();
                    }
                }

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

                $fea = product_features::where('product_id',$check->id)->get();

                if(count($fea) == 0)
                {
                    foreach ($features as $f => $key)
                    {
                        if($key != NULL && $request->features[$f] != NULL)
                        {
                            $feature = new product_features;
                            $feature->product_id = $check->id;
                            $feature->title = $request->features[$f];
                            $feature->heading_id = $key;
                            $feature->value = $request->feature_values[$f] ? $request->feature_values[$f] : 0;
                            $feature->max_size = $request->max_size[$f] ? str_replace(",",".",$request->max_size[$f]) : NULL;
                            $feature->price_impact = $request->price_impact[$f];
                            $feature->impact_type = $request->impact_type[$f];
                            $feature->save();
                        }
                    }
                }
                else
                {
                    if(count($features) > 0)
                    {
                        foreach ($features as $f => $key)
                        {
                            $fea_check = product_features::where('product_id',$check->id)->skip($f)->first();

                            if($fea_check)
                            {
                                if($key != NULL && $request->features[$f] != NULL)
                                {
                                    $fea_check->title = $request->features[$f];
                                    $fea_check->heading_id = $key;
                                    $fea_check->value = $request->feature_values[$f] ? $request->feature_values[$f] : 0;
                                    $fea_check->max_size = $request->max_size[$f] ? str_replace(",",".",$request->max_size[$f]) : NULL;
                                    $fea_check->price_impact = $request->price_impact[$f];
                                    $fea_check->impact_type = $request->impact_type[$f];
                                    $fea_check->save();
                                }
                            }
                            else
                            {
                                if($key != NULL && $request->features[$f] != NULL)
                                {
                                    $fea = new product_features;
                                    $fea->title = $request->features[$f];
                                    $fea->heading_id = $key;
                                    $fea->value = $request->feature_values[$f] ? $request->feature_values[$f] : 0;
                                    $fea->max_size = $request->max_size[$f] ? str_replace(",",".",$request->max_size[$f]) : NULL;
                                    $fea->product_id = $check->id;
                                    $fea->price_impact = $request->price_impact[$f];
                                    $fea->impact_type = $request->impact_type[$f];
                                    $fea->save();
                                }
                            }
                        }
                    }
                    else
                    {
                        product_features::where('product_id',$check->id)->delete();
                    }
                }

                $sub_pro = product_ladderbands::where('product_id',$check->id)->get();

                if(count($sub_pro) == 0)
                {
                    foreach ($sub_products as $s => $key)
                    {
                        if($key != NULL && $request->sub_product_titles[$s] != NULL)
                        {
                            $sub_pro = new product_ladderbands;
                            $sub_pro->title = $request->sub_product_titles[$s];
                            $sub_pro->product_id = $check->id;
                            $sub_pro->code = $key;
                            $sub_pro->size1_value = $request->size1_value[$s];
                            $sub_pro->size2_value = $request->size2_value[$s];
                            $sub_pro->save();
                        }
                    }
                }
                else
                {
                    if(count($sub_products) > 0)
                    {
                        foreach ($sub_products as $s => $key)
                        {
                            $sub_check = product_ladderbands::where('product_id',$check->id)->skip($s)->first();

                            if($sub_check)
                            {
                                if($key != NULL && $request->sub_product_titles[$s] != NULL)
                                {
                                    $sub_check->title = $request->sub_product_titles[$s];
                                    $sub_check->code = $key;
                                    $sub_check->size1_value = $request->size1_value[$s];
                                    $sub_check->size2_value = $request->size2_value[$s];
                                    $sub_check->save();
                                }
                            }
                            else
                            {
                                if($key != NULL && $request->sub_product_titles[$s] != NULL)
                                {
                                    $sub_pro = new product_ladderbands;
                                    $sub_pro->title = $request->sub_product_titles[$s];
                                    $sub_pro->product_id = $check->id;
                                    $sub_pro->code = $key;
                                    $sub_pro->size1_value = $request->size1_value[$s];
                                    $sub_pro->size2_value = $request->size2_value[$s];
                                    $sub_pro->save();
                                }
                            }
                        }
                    }
                    else
                    {
                        product_ladderbands::where('product_id',$check->id)->delete();
                    }
                }

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

        if($request->cat_id)
        {
            return redirect()->route('admin-product-edit',$request->cat_id);
        }
        else
        {
            return redirect()->route('admin-product-index');
        }
    }

    public function edit($id)
    {
        $cats = Products::where('id','=',$id)->first();

        $colors_data = colors::leftjoin('price_tables','price_tables.id','=','colors.table_id')->where('colors.product_id','=',$id)->select('colors.id','colors.title as color','colors.color_code','colors.table_id','price_tables.title as table')->get();
        $features_data = product_features::where('product_id',$id)->get();
        $ladderband_data = product_ladderbands::where('product_id',$id)->get();
        $categories = Category::all();
        $brands = Brand::all();
        $models = Model1::where('brand_id',$cats->brand_id)->get();
        $tables = price_tables::where('connected',1)->get();
        $features_headings = features::all();

        return view('admin.product.create',compact('ladderband_data','cats','categories','brands','models','tables','colors_data','features_data','features_headings'));
    }


    public function destroy($id)
    {
        $cat = Products::findOrFail($id);
        product_features::where('product_id',$id)->delete();
        product_ladderbands::where('product_id',$id)->delete();
        colors::where('product_id',$id)->delete();
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
