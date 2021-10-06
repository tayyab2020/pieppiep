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
use App\model_features;
use App\price_tables;
use App\product;
use App\product_features;
use App\product_ladderbands;
use App\product_models;
use App\Products;
use App\retailer_labor_costs;
use App\retailer_margins;
use App\retailers_requests;
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
        $this->middleware('auth:user');
    }

    public function productsModelsByBrands(Request $request)
    {
        $models = Model1::where('brand_id','=',$request->id)->get();

        return $models;
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

        if($user->can('user-products'))
        {
            if($user->role_id == 4)
            {
                $cats = Products::leftjoin('categories','categories.id','=','products.category_id')->leftjoin('brands','brands.id','=','products.brand_id')->leftjoin('models','models.id','=','products.model_id')->where('products.user_id',$user_id)->orderBy('products.id','desc')->select('products.*','categories.cat_name as category','brands.cat_name as brand','models.cat_name as model')->get();

                return view('admin.product.index',compact('cats'));
            }
            else
            {
                $cats = Products::leftJoin('retailer_margins', function($join) use($user_id){
                    $join->on('products.id', '=', 'retailer_margins.product_id')
                        ->where('retailer_margins.retailer_id', '=', $user_id);
                })->leftJoin('retailer_labor_costs', function($join) use($user_id){
                    $join->on('products.id', '=', 'retailer_labor_costs.product_id')
                        ->where('retailer_labor_costs.retailer_id', '=', $user_id);
                })->leftjoin('retailers_requests','retailers_requests.supplier_id','=','products.user_id')->leftjoin('users','users.id','=','products.user_id')->leftjoin('categories','categories.id','=','products.category_id')->leftjoin('brands','brands.id','=','products.brand_id')->leftjoin('models','models.id','=','products.model_id')->where('retailers_requests.retailer_id',$user_id)->where('retailers_requests.status',1)->where('retailers_requests.active',1)->orderBy('products.id','desc')->select('products.*','retailer_labor_costs.labor','retailer_margins.margin as retailer_margin','users.company_name','categories.cat_name as category','brands.cat_name as brand','models.cat_name as model')->get();

                return view('admin.product.index',compact('cats'));
            }
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function storeRetailerMargins(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }
        $products = $request->product_ids;

        foreach($products as $i => $key)
        {
            $check = retailer_margins::where('product_id',$key)->where('retailer_id',$user_id);

            if($check->first())
            {
                $check->update(['margin' => $request->margin[$i] ? $request->margin[$i] : 100]);
            }
            else
            {
                if(is_numeric($request->margin[$i]))
                {
                    $post = new retailer_margins;
                    $post->product_id = $key;
                    $post->retailer_id = $user_id;
                    $post->margin = $request->margin[$i] ? $request->margin[$i] : 100;
                    $post->save();
                }
            }

            $check1 = retailer_labor_costs::where('product_id',$key)->where('retailer_id',$user_id);

            if($check1->first())
            {
                $check1->update(['labor' => $request->labor[$i] ? $request->labor[$i] : 0]);
            }
            else
            {
                if(is_numeric($request->labor[$i]))
                {
                    $post = new retailer_labor_costs;
                    $post->product_id = $key;
                    $post->retailer_id = $user_id;
                    $post->labor = $request->labor[$i] ? $request->labor[$i] : 0;
                    $post->save();
                }
            }
        }

        Session::flash('success', 'Task completed successfully.');
        return redirect()->route('admin-product-index');
    }


    public function resetSupplierMargins()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        retailer_margins::where('retailer_id',$user_id)->delete();

        Session::flash('success', 'Task completed successfully.');
        return redirect()->route('admin-product-index');
    }


    public function create()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('product-create'))
        {
            $categories = Category::where('user_id',$user_id)->get();
            $brands = Brand::where('user_id',$user_id)->get();
            /*$models = Model1::get();*/
            $tables = price_tables::where('connected',1)->where('user_id',$user_id)->get();
            $features_headings = features::where('user_id',$user_id)->get();

            return view('admin.product.create',compact('categories','brands','tables','features_headings'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function pricesTables(Request $request)
    {
        $tables = price_tables::where('id',$request->id)->get();

        return $tables;
    }

    public function import()
    {
        $user = Auth::guard('user')->user();

        if($user->can('product-import'))
        {
            return view('admin.product.import');
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
        $user = Auth::guard('user')->user();

        if($user->can('product-export'))
        {
            ini_set('memory_limit', '-1');
            return Excel::download(new ProductsExport(),'products.xlsx');
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function copy($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('product-copy'))
        {
            $product = Products::where('id','=',$id)->where('user_id',$user_id)->first();

            if(!$product)
            {
                return redirect()->back();
            }

            $product_title = $product->title;
            $count = 1;

            while (Products::where('title',$product_title)->exists()) {

                $temp = substr($product_title, 0, strrpos($product_title, ' copy'));

                if(!$temp)
                {
                    $temp = $product_title;
                }

                $product_title = "{$temp} copy " . $count++;
            }

            $product->title = $product_title;

            $product_slug = $product->slug;
            $count = 1;

            while (Products::where('slug',$product_slug)->exists()) {

                $temp = substr($product_slug, 0, strrpos($product_slug, '-copy'));

                if(!$temp)
                {
                    $temp = $product_slug;
                }

                $product_slug = "{$temp}-copy-" . $count++;
            }

            $product->slug = $product_slug;
            $product->photo = NULL;

            $newPost = $product->replicate();
            $newPost->save();
            $product_id = $newPost->id;

            $colors_data = colors::where('product_id','=',$id)->get();

            foreach ($colors_data as $color)
            {
                $color->product_id = $product_id;
                $newPost = $color->replicate();
                $newPost->save();
            }

            $features_data = product_features::where('product_id','=',$id)->get();

            foreach ($features_data as $feature)
            {
                $feature->product_id = $product_id;
                $newPost = $feature->replicate();
                $newPost->save();
            }

            $ladderband_data = product_ladderbands::where('product_id','=',$id)->get();

            foreach ($ladderband_data as $ladderband)
            {
                $ladderband->product_id = $product_id;
                $newPost = $ladderband->replicate();
                $newPost->save();
            }

            $estimated_prices_data = estimated_prices::where('product_id','=',$id)->get();

            foreach ($estimated_prices_data as $estimated_price)
            {
                $estimated_price->product_id = $product_id;
                $newPost = $estimated_price->replicate();
                $newPost->save();
            }

            Session::flash('success', 'Product copied successfully!');
            return redirect()->back();
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function store(StoreValidationRequest3 $request)
    {
        $input = $request->all();

        $prices = preg_replace("/,([\s])+/",",",$request->estimated_price);
        $colors = $request->colors;
        $features = $request->feature_headings;
        $models = $request->models;
        $sub_products = $request->sub_codes;
        $feature_row = array();
        $feature_id = array();

        if($prices)
        {
            $pricesArray = explode(',', $prices);
        }
        else
        {
            $pricesArray = [];
        }

        if($input['ladderband'])
        {
            if(!$input['ladderband_value'])
            {
                $input['ladderband_value'] = 0;
            }
        }

        $input['margin'] = is_numeric($input['margin']) ? $input['margin'] : NULL;

        if($request->cat_id)
        {
            if($request->removed1)
            {
                $removed1 = explode(',', $request->removed1);
            }
            else
            {
                $removed1 = [];
            }

            if($request->removed)
            {
                $removed = explode(',', $request->removed);
            }
            else
            {
                $removed = [];
            }

            if($request->removed_ladderband)
            {
                $removed_ladderband = explode(',', $request->removed_ladderband);
            }
            else
            {
                $removed_ladderband = [];
            }

            if($request->removed_colors)
            {
                $removed_colors = explode(',', $request->removed_colors);
            }
            else
            {
                $removed_colors = [];
            }

            product_features::whereIn('id',$removed)->delete();
            product_ladderbands::whereIn('id',$removed_ladderband)->delete();
            colors::whereIn('id',$removed_colors)->delete();
            product_models::whereIn('id',$removed1)->delete();
            model_features::whereIn('model_id',$removed1)->delete();
            $model_ids = product_models::where('product_id',$request->cat_id)->pluck('id');
            model_features::whereIn('model_id',$model_ids)->whereIn('product_feature_id',$removed)->delete();

            $cat = Products::where('id',$request->cat_id)->first();

            if($file = $request->file('photo'))
            {
                \File::delete(public_path() .'/assets/images/'.$cat->photo);
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
                $input['photo'] = $name;
            }

            $cat->fill($input)->save();

            $fea = product_features::where('product_id',$request->cat_id)->where('sub_feature',0)->get();

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
                        $fea->max_size = NULL; /*$request->max_size[$f] ? str_replace(",",".",$request->max_size[$f]) : NULL;*/
                        $fea->price_impact = $request->price_impact[$f];
                        $fea->impact_type = $request->impact_type[$f];
                        $fea->variable = $request->variable[$f];
                        $fea->save();

                        $s_titles = 'features'.$request->f_rows[$f];
                        $sub_features = $request->$s_titles;

                        foreach($sub_features as $s => $sub)
                        {
                            $s_value = 'feature_values'.$request->f_rows[$f];
                            $s_price_impact = 'price_impact'.$request->f_rows[$f];
                            $s_impact_type = 'impact_type'.$request->f_rows[$f];
                            $s_variable = 'variable'.$request->f_rows[$f];

                            if($sub != NULL)
                            {
                                $sub_feature = new product_features;
                                $sub_feature->product_id = $request->cat_id;
                                $sub_feature->heading_id = $key;
                                $sub_feature->main_id = $fea->id;
                                $sub_feature->sub_feature = 1;
                                $sub_feature->title = $sub;
                                $sub_feature->value = $request->$s_value[$s] ? $request->$s_value[$s] : 0;
                                $sub_feature->price_impact = $request->$s_price_impact[$s];
                                $sub_feature->impact_type = $request->$s_impact_type[$s];
                                $sub_feature->variable = $request->$s_variable[$s];
                                $sub_feature->save();
                            }
                        }

                        $feature_row[] = $request->f_rows[$f];
                        $feature_id[] = $fea->id;
                    }
                }
            }
            else
            {
                if(count($features) > 0)
                {
                    foreach ($features as $f => $key)
                    {
                        $fea_check = product_features::where('product_id',$request->cat_id)->where('sub_feature',0)->skip($f)->first();

                        if($fea_check)
                        {
                            if($key != NULL && $request->features[$f] != NULL)
                            {
                                $fea_check->title = $request->features[$f];
                                $fea_check->heading_id = $key;
                                $fea_check->value = $request->feature_values[$f] ? $request->feature_values[$f] : 0;
                                $fea_check->max_size = NULL; /*$request->max_size[$f] ? str_replace(",",".",$request->max_size[$f]) : NULL;*/
                                $fea_check->price_impact = $request->price_impact[$f];
                                $fea_check->impact_type = $request->impact_type[$f];
                                $fea_check->variable = $request->variable[$f];
                                $fea_check->save();

                                $s_titles = 'features'.$request->f_rows[$f];
                                $sub_features = $request->$s_titles;

                                foreach($sub_features as $s => $sub)
                                {
                                    $sub_fea_check = product_features::where('main_id',$fea_check->id)->skip($s)->first();

                                    $s_value = 'feature_values'.$request->f_rows[$f];
                                    $s_price_impact = 'price_impact'.$request->f_rows[$f];
                                    $s_impact_type = 'impact_type'.$request->f_rows[$f];
                                    $s_variable = 'variable'.$request->f_rows[$f];

                                    if($sub_fea_check)
                                    {
                                        if($sub != NULL)
                                        {
                                            $sub_fea_check->heading_id = $key;
                                            $sub_fea_check->main_id = $fea_check->id;
                                            $sub_fea_check->sub_feature = 1;
                                            $sub_fea_check->title = $sub;
                                            $sub_fea_check->value = $request->$s_value[$s] ? $request->$s_value[$s] : 0;
                                            $sub_fea_check->price_impact = $request->$s_price_impact[$s];
                                            $sub_fea_check->impact_type = $request->$s_impact_type[$s];
                                            $sub_fea_check->variable = $request->$s_variable[$s];
                                            $sub_fea_check->save();
                                        }
                                    }
                                    else
                                    {
                                        if($sub != NULL)
                                        {
                                            $sub_feature = new product_features;
                                            $sub_feature->product_id = $request->cat_id;
                                            $sub_feature->heading_id = $key;
                                            $sub_feature->main_id = $fea_check->id;
                                            $sub_feature->sub_feature = 1;
                                            $sub_feature->title = $sub;
                                            $sub_feature->value = $request->$s_value[$s] ? $request->$s_value[$s] : 0;
                                            $sub_feature->price_impact = $request->$s_price_impact[$s];
                                            $sub_feature->impact_type = $request->$s_impact_type[$s];
                                            $sub_feature->variable = $request->$s_variable[$s];
                                            $sub_feature->save();
                                        }
                                    }
                                }

                                $feature_row[] = $request->f_rows[$f];
                                $feature_id[] = $fea_check->id;
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
                                $fea->max_size = NULL; /*$request->max_size[$f] ? str_replace(",",".",$request->max_size[$f]) : NULL;*/
                                $fea->price_impact = $request->price_impact[$f];
                                $fea->impact_type = $request->impact_type[$f];
                                $fea->variable = $request->variable[$f];
                                $fea->save();

                                $s_titles = 'features'.$request->f_rows[$f];
                                $sub_features = $request->$s_titles;

                                foreach($sub_features as $s => $sub)
                                {
                                    $s_value = 'feature_values'.$request->f_rows[$f];
                                    $s_price_impact = 'price_impact'.$request->f_rows[$f];
                                    $s_impact_type = 'impact_type'.$request->f_rows[$f];
                                    $s_variable = 'variable'.$request->f_rows[$f];

                                    if($sub != NULL)
                                    {
                                        $sub_feature = new product_features;
                                        $sub_feature->product_id = $request->cat_id;
                                        $sub_feature->heading_id = $key;
                                        $sub_feature->main_id = $fea->id;
                                        $sub_feature->sub_feature = 1;
                                        $sub_feature->title = $sub;
                                        $sub_feature->value = $request->$s_value[$s] ? $request->$s_value[$s] : 0;
                                        $sub_feature->price_impact = $request->$s_price_impact[$s];
                                        $sub_feature->impact_type = $request->$s_impact_type[$s];
                                        $sub_feature->variable = $request->$s_variable[$s];
                                        $sub_feature->save();
                                    }
                                }

                                $feature_row[] = $request->f_rows[$f];
                                $feature_id[] = $fea->id;
                            }
                        }
                    }
                }
                else
                {
                    $features_ids = product_features::where('product_id',$request->cat_id)->pluck('id');
                    product_features::where('product_id',$request->cat_id)->delete();
                    $model_ids = product_models::where('product_id',$request->cat_id)->pluck('id');
                    model_features::whereIn('model_id',$model_ids)->whereIn('product_feature_id',$features_ids)->delete();
                }
            }

            foreach ($models as $m => $temp)
            {
                $model_check = product_models::where('product_id',$request->cat_id)->skip($m)->first();

                if($model_check)
                {
                    if($temp != NULL && $request->model_values[$m] != NULL)
                    {
                        $model_check->model = $temp;
                        $model_check->value = $request->model_values[$m];
                        $model_check->max_size = $request->model_max_size[$m] ? str_replace(",", ".", $request->model_max_size[$m]) : NULL;
                        $model_check->price_impact = $request->model_price_impact[$m];
                        $model_check->impact_type = $request->model_impact_type[$m];
                        $model_check->childsafe = $request->childsafe[$m];
                        $model_check->save();
                    }

                    foreach ($feature_row as $a => $abc)
                    {
                        $model_features_check = model_features::where('model_id',$model_check->id)->skip($a)->first();
                        $selected_feature = 'selected_model_feature' . $abc;

                        if(isset($request->$selected_feature[$m]))
                        {
                            $link = $request->$selected_feature[$m];
                        }
                        else
                        {
                            var_dump($m);
                            exit();
                        }

                        if($model_features_check)
                        {
                            $model_features_check->model_id = $model_check->id;
                            $model_features_check->product_feature_id = $feature_id[$a];
                            $model_features_check->linked = $link;
                            $model_features_check->save();
                        }
                        else
                        {
                            $model_feature = new model_features;
                            $model_feature->model_id = $model_check->id;
                            $model_feature->product_feature_id = $feature_id[$a];
                            $model_feature->linked = $link;
                            $model_feature->save();
                        }
                    }

                }
                else
                {
                    if($temp != NULL && $request->model_values[$m] != NULL) {

                        $model = new product_models;
                        $model->product_id = $request->cat_id;
                        $model->model = $temp;
                        $model->value = $request->model_values[$m];
                        $model->max_size = $request->model_max_size[$m] ? str_replace(",", ".", $request->model_max_size[$m]) : NULL;
                        $model->price_impact = $request->model_price_impact[$m];
                        $model->impact_type = $request->model_impact_type[$m];
                        $model->childsafe = $request->childsafe[$m];
                        $model->save();

                        foreach ($feature_row as $a => $abc)
                        {
                            $selected_feature = 'selected_model_feature' . $abc;
                            $link = $request->$selected_feature[$m];

                            $model_feature = new model_features;
                            $model_feature->model_id = $model->id;
                            $model_feature->product_feature_id = $feature_id[$a];
                            $model_feature->linked = $link;
                            $model_feature->save();
                        }
                    }
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

            $col = colors::where('product_id',$request->cat_id)->get();

            if(count($col) == 0)
            {
                foreach ($colors as $c => $key)
                {
                    if($key != NULL && $request->color_codes[$c] != NULL && $request->price_tables[$c] != NULL)
                    {
                        $col = new colors;
                        $col->title = $key;
                        $col->color_code = $request->color_codes[$c];
                        $col->max_height = $request->color_max_height[$c] ? str_replace(",",".",$request->color_max_height[$c]) : NULL;
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
                                $col_check->max_height = $request->color_max_height[$c] ? str_replace(",",".",$request->color_max_height[$c]) : NULL;
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
                                $col->max_height = $request->color_max_height[$c] ? str_replace(",",".",$request->color_max_height[$c]) : NULL;
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
            return redirect()->route('admin-product-edit',$request->cat_id);
        }
        else
        {
            $user = Auth::guard('user')->user();
            $user_id = $user->id;
            $main_id = $user->main_id;

            if($main_id)
            {
                $user_id = $main_id;
            }
            $input['user_id'] = $user_id;

            $check = Products::leftjoin('categories','categories.id','=','products.category_id')->leftjoin('brands','brands.id','=','products.brand_id')->where('products.user_id',$user_id)->where('products.title', 'LIKE', '%'.$request->title.'%')->where('products.model_number',$request->model_number)->where('categories.id',$request->category_id)->where('brands.id',$request->brand_id)->select('products.*')->first();

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
                        $feature->max_size = NULL; /*$request->max_size[$f] ? str_replace(",",".",$request->max_size[$f]) : NULL;*/
                        $feature->price_impact = $request->price_impact[$f];
                        $feature->impact_type = $request->impact_type[$f];
                        $feature->variable = $request->variable[$f];
                        $feature->save();

                        $s_titles = 'features'.$request->f_rows[$f];
                        $sub_features = $request->$s_titles;

                        foreach($sub_features as $s => $sub)
                        {
                            $s_value = 'feature_values'.$request->f_rows[$f];
                            $s_price_impact = 'price_impact'.$request->f_rows[$f];
                            $s_impact_type = 'impact_type'.$request->f_rows[$f];
                            $s_variable = 'variable'.$request->f_rows[$f];

                            if($sub != NULL)
                            {
                                $sub_feature = new product_features;
                                $sub_feature->product_id = $cat->id;
                                $sub_feature->heading_id = $key;
                                $sub_feature->main_id = $feature->id;
                                $sub_feature->sub_feature = 1;
                                $sub_feature->title = $sub;
                                $sub_feature->value = $request->$s_value[$s] ? $request->$s_value[$s] : 0;
                                $sub_feature->price_impact = $request->$s_price_impact[$s];
                                $sub_feature->impact_type = $request->$s_impact_type[$s];
                                $sub_feature->variable = $request->$s_variable[$s];
                                $sub_feature->save();
                            }
                        }

                        $feature_row[] = $request->f_rows[$f];
                        $feature_id[] = $feature->id;
                    }
                }

                foreach ($models as $m => $temp)
                {
                    if($temp != NULL && $request->model_values[$m] != NULL) {

                        $model = new product_models;
                        $model->product_id = $cat->id;
                        $model->model = $temp;
                        $model->value = $request->model_values[$m];
                        $model->max_size = $request->model_max_size[$m] ? str_replace(",", ".", $request->model_max_size[$m]) : NULL;
                        $model->price_impact = $request->model_price_impact[$m];
                        $model->impact_type = $request->model_impact_type[$m];
                        $model->childsafe = $request->childsafe[$m];
                        $model->save();

                        foreach ($feature_row as $a => $abc)
                        {
                            $selected_feature = 'selected_model_feature' . $abc;
                            $link = $request->$selected_feature[$m];

                            $model_feature = new model_features;
                            $model_feature->model_id = $model->id;
                            $model_feature->product_feature_id = $feature_id[$a];
                            $model_feature->linked = $link;
                            $model_feature->save();
                        }
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
                        $col->max_height = $request->color_max_height[$c] ? str_replace(",",".",$request->color_max_height[$c]) : NULL;
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
                return redirect()->route('admin-product-index');
            }
            else
            {
                $route = route('admin-product-edit',$check->id);
                Session::flash('unsuccess', 'Product already exists with same title, model number, category and brand. You can edit that product <a style="color: #b44b33;font-weight: bold;" href="'.$route.'">here</a>');
                return redirect()->route('admin-product-create');
            }
        }
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

        if($user->can('product-edit'))
        {
            $cats = Products::where('id','=',$id)->where('user_id',$user_id)->first();

            if(!$cats)
            {
                return redirect()->back();
            }

            $colors_data = colors::leftjoin('price_tables','price_tables.id','=','colors.table_id')->where('colors.product_id','=',$id)->select('colors.id','colors.title as color','colors.color_code','colors.table_id','colors.max_height','price_tables.title as table')->get();
            $features_data = product_features::where('product_id',$id)->where('sub_feature',0)->get();
            $sub_features_data = product_features::where('product_id',$id)->where('sub_feature',1)->get();
            $ladderband_data = product_ladderbands::where('product_id',$id)->get();
            $categories = Category::where('user_id',$user_id)->get();
            $brands = Brand::where('user_id',$user_id)->get();
            /*$models = Model1::get();*/
            $tables = price_tables::where('connected',1)->where('user_id',$user_id)->get();
            $features_headings = features::where('user_id',$user_id)->get();
            $models = product_models::with(['features' => function($query)
            {
                $query->leftjoin('product_features','product_features.id','=','model_features.product_feature_id')
                    ->leftjoin('features','features.id','=','product_features.heading_id')
                    ->select('model_features.*','features.title as heading','product_features.title as feature_title');

            }])->where('product_id',$id)->get();

            return view('admin.product.create',compact('ladderband_data','cats','categories','brands','models','tables','colors_data','features_data','sub_features_data','features_headings'));
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

        if($user->can('product-delete'))
        {
            $cat = Products::where('id',$id)->where('user_id',$user_id)->first();

            if(!$cat)
            {
                return redirect()->back();
            }

            product_features::where('product_id',$id)->delete();
            product_ladderbands::where('product_id',$id)->delete();
            colors::where('product_id',$id)->delete();
            estimated_prices::where('product_id',$id)->delete();
            $model_ids = product_models::where('product_id',$id)->pluck('id');
            product_models::where('product_id',$id)->delete();
            model_features::whereIn('model_id',$model_ids)->delete();

            if($cat->photo == null){
                $cat->delete();
                Session::flash('success', 'Product deleted successfully.');
                return redirect()->route('admin-product-index');
            }

            \File::delete(public_path() .'/assets/images/'.$cat->photo);
            $cat->delete();
            Session::flash('success', 'Product deleted successfully.');
            return redirect()->route('admin-product-index');
        }
        else
        {
            return redirect()->route('user-login');
        }
    }
}
