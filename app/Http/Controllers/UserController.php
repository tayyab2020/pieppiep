<?php

namespace App\Http\Controllers;

use App\Brand;
use App\color;
use App\colors;
use App\custom_quotations;
use App\custom_quotations_data;
use App\customers_details;
use App\email_templates;
use App\Jobs\SendOrder;
use App\Jobs\CreateOrder;
use App\Jobs\UpdateDates;
use App\model_features;
use App\new_orders;
use App\new_orders_features;
use App\new_orders_sub_products;
use App\product_ladderbands;
use App\features;
use App\handyman_quotes;
use App\handyman_services;
use App\instruction_manual;
use App\items;
use App\Model1;
use App\new_quotations;
use App\new_quotations_data;
use App\new_quotations_data_calculations;
use App\new_orders_calculations;
use App\new_quotations_features;
use App\new_quotations_sub_products;
use App\new_invoices;
use App\new_invoices_data;
use App\new_invoices_data_calculations;
use App\new_invoices_features;
use App\new_invoices_sub_products;
use App\new_negative_invoices;
use App\product;
use App\product_features;
use App\product_models;
use App\Products;
use App\quotation_invoices_data;
use App\quotation_invoices;
use App\quotes;
use App\requests_q_a;
use App\retailer_labor_costs;
use App\retailers_requests;
use App\Service;
use Illuminate\Http\Request;
use App\User;
use App\Category;
use App\sub_categories;
use App\service_types;
use Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Language;
use App\handyman_products;
use App\Generalsetting;
use App\bookings;
use Carbon\Carbon;
use DateTime;
use App\handyman_terminals;
use App\handyman_unavailability;
use App\carts;
use App\invoices;
use Illuminate\Support\Facades\Redirect;
use Crypt;
use App\users;
use App\user_languages;
use App\handyman_temporary;
use App\booking_images;
use App\Sociallink;
use App\sub_services;
use App\cancelled_invoices;
use App\handyman_unavailability_hours;
use App\supplier_categories;
use File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use PDF;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Symfony\Component\Process\Process;
use App\retailer_services;

class UserController extends Controller
{

    public $lang;
    public $gs;
    public $sl;

    public function __construct()
    {
        $this->middleware('auth:user', ['except' => ['UserServices', 'AddCart', 'Services', 'DeleteSubServices', 'UserSubServices', 'SubServices']]);

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } //whether ip is from remote address
        else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }


        $language = user_languages::where('ip', '=', $ip_address)->first();
        $this->sl = Sociallink::findOrFail(1);


        if ($language == '') {

            $language = new user_languages;
            $language->ip = $ip_address;
            $language->lang = 'eng';
            $language->save();
        }


        if ($language->lang == 'eng') {

            $this->lang = Language::where('lang', '=', 'eng')->first();
            \App::setLocale('en');

        } else {

            $this->lang = Language::where('lang', '=', 'du')->first();
            \App::setLocale('du');

        }

        $this->gs = Generalsetting::where('backend',1)->first();
    }

    public function SelectQuotationsType()
    {
        $type = 1;
        return view('user.select_type', compact('type'));
    }

    public function SelectInvoicesType()
    {
        $type = 2;
        return view('user.select_type', compact('type'));
    }

    public function CreateNewQuotation()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('create-new-quotation'))
        {
            $customers = customers_details::where('retailer_id', $user_id)->get();

            if($user->role_id == 2)
            {
                $products = array();
                $suppliers = User::leftjoin('retailers_requests','retailers_requests.retailer_id','=','users.id')->where('users.id',$user_id)->where('retailers_requests.status',1)->where('retailers_requests.active',1)->pluck('retailers_requests.supplier_id');
                $suppliers = User::whereIn('id',$suppliers)->get();
            }
            else
            {
                return redirect()->route('user-login');
                /*$products = Products::where('user_id',$user_id)->get();
                $suppliers = array();*/
            }

            return view('user.create_new_quotation1', compact('products','customers','suppliers'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function GetSupplierProducts(Request $request)
    {
        $blind_category_id = Category::where('cat_name','LIKE', '%Blinds%')->orWhere('cat_name','LIKE', '%Binnen zonwering%')->pluck('id')->first();
        $data = Products::where('user_id',$request->id)->where('category_id',$blind_category_id)->get();

        return $data;
    }

    public function SupplierCategories()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->role_id == 4)
        {
            $feature_categories = Category::all();
            $my_categories = supplier_categories::where('user_id',$user_id)->pluck('category_id')->toArray();

            return view('user.supplier_categories',compact('feature_categories','my_categories'));
        }
    }

    public function SupplierCategoriesStore(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($request->supplier_categories)
        {
            $category_ids = $request->supplier_categories;

            foreach($category_ids as $s => $key)
            {
                $check = supplier_categories::where('user_id',$user_id)->skip($s)->first();

                if($check)
                {
                    $check->category_id = $key;
                    $check->save();
                }
                else
                {
                    $post = new supplier_categories;
                    $post->category_id = $key;
                    $post->user_id = $user_id;
                    $post->save();
                }
            }

            $s = $s + 1;

            $count = supplier_categories::count();
            supplier_categories::where('user_id',$user_id)->take($count)->skip($s)->get()->each(function($row){ $row->delete(); });
        }
        else
        {
            supplier_categories::where('user_id',$user_id)->delete();
        }

        Session::flash('success', 'List updated successfully!');

        return redirect()->back();
    }

    public function GetColors(Request $request)
    {
        if($request->type == 'service')
        {
            $data = Service::leftjoin('retailer_services','retailer_services.service_id','=','services.id')->where('services.id',$request->id)->select('services.*','retailer_services.sell_rate')->first();
        }
        elseif($request->type == 'item')
        {
            $data = items::where('id',$request->id)->first();
        }
        else
        {
            if($request->model)
            {
                $data = Products::leftjoin('product_models','product_models.product_id','=','products.id')->where('product_models.id',$request->model)->where('products.id',$request->id)->select('products.*','product_models.measure','product_models.estimated_price_per_box','product_models.estimated_price_quantity','product_models.estimated_price','product_models.max_width')->first();
            }
            else
            {
                $data = Products::where('id',$request->id)->with('colors')->with('models')->first();
            }
        }

        return $data;
    }

    public function GetPrice(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($request->type != 'floors')
        {
            $request->width = (int)$request->width;
            $request->height = (int)$request->height;
            $max_x_axis = colors::leftjoin('prices','prices.table_id','=','colors.table_id')->where('colors.id',$request->color)->where('colors.product_id',$request->product)->max('prices.x_axis');
            $max_y_axis = colors::leftjoin('prices','prices.table_id','=','colors.table_id')->where('colors.id',$request->color)->where('colors.product_id',$request->product)->max('prices.y_axis');

            if($max_x_axis >= $request->width && $max_y_axis >= $request->height)
            {
                $price = colors::leftjoin('prices','prices.table_id','=','colors.table_id')->where('colors.id',$request->color)->where('colors.product_id',$request->product)->where('prices.x_axis','>=',$request->width)->where('prices.y_axis','>=',$request->height)->select('colors.max_height','prices.value')->first();

                if($price->max_height && ($request->height >= $price->max_height))
                {
                    $data[0] = ['value' => 'y_axis', 'max_height' => $price->max_height];
                }
                else
                {
                    $features = features::whereHas('features', function($query) use($request)
                    {
                        $query->leftjoin('model_features','model_features.product_feature_id','=','product_features.id')
                            ->where('model_features.model_id',$request->model)->where('model_features.linked',1)
                            ->where('product_features.product_id','=',$request->product)
                            ->select('product_features.*');

                    })->with(['features' => function($query) use($request)
                    {
                        $query->leftjoin('model_features','model_features.product_feature_id','=','product_features.id')
                            ->where('model_features.model_id',$request->model)->where('model_features.linked',1)
                            ->where('product_features.product_id','=',$request->product)
                            ->select('product_features.*');

                    }])->orderBy('features.quote_order_no','ASC')->get();

                    $model = product_models::where('id',$request->model)->first();

                    if($request->margin)
                    {
                        $margin = Products::leftJoin('retailer_margins','retailer_margins.product_id','=','products.id')->where('products.id',$request->product)->where('retailer_margins.retailer_id', '=', $user_id)->select('products.margin','retailer_margins.margin as retailer_margin')->first();
                    }
                    else
                    {
                        $margin = '';
                    }

                    $labor = retailer_labor_costs::where('product_id',$request->product)->where('retailer_id', '=', $user_id)->first();

                    $data = array($price,$features,$margin,$model,$labor);
                }
            }
            else if($max_x_axis < $request->width && $max_y_axis < $request->height)
            {
                $data[0] = ['value' => 'both', 'max_width' => $max_x_axis, 'max_height' => $max_y_axis];
            }
            else if($max_x_axis < $request->width)
            {
                $data[0] = ['value' => 'x_axis', 'max_width' => $max_x_axis];
            }
            else
            {
                $data[0] = ['value' => 'y_axis', 'max_height' => $max_y_axis];
            }
        }
        else
        {
            $price = '';

            $features = features::whereHas('features', function($query) use($request)
            {
                $query->leftjoin('model_features','model_features.product_feature_id','=','product_features.id')
                    ->where('model_features.model_id',$request->model)->where('model_features.linked',1)
                    ->where('product_features.product_id','=',$request->product)
                    ->select('product_features.*');

            })->with(['features' => function($query) use($request)
            {
                $query->leftjoin('model_features','model_features.product_feature_id','=','product_features.id')
                    ->where('model_features.model_id',$request->model)->where('model_features.linked',1)
                    ->where('product_features.product_id','=',$request->product)
                    ->select('product_features.*');

            }])->orderBy('features.quote_order_no','ASC')->get();

            $model = product_models::where('id',$request->model)->first();

            $margin = Products::leftJoin('retailer_margins','retailer_margins.product_id','=','products.id')->where('products.id',$request->product)->where('retailer_margins.retailer_id', '=', $user_id)->select('products.margin','retailer_margins.margin as retailer_margin')->first();

            $labor = retailer_labor_costs::where('product_id',$request->product)->where('retailer_id', '=', $user_id)->first();

            $data = array($price,$features,$margin,$model,$labor);
        }

        return $data;
    }

    public function GetFeaturePrice(Request $request)
    {
        $feature = product_features::where('id',$request->id)->first();

        $sub_features = product_features::where('main_id',$request->id)->get();

        $data = array($feature,$sub_features);

        return $data;
    }

    public function GetSubProductsSizes(Request $request)
    {
        $data = product_ladderbands::where('product_id',$request->product_id)->get();

        return $data;
    }

    public function PrefixSettings()
    {
        $user = Auth::guard('user')->user();
        $main_id = $user->main_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->get();
        }

        if ($user->role_id == 3) {
            return redirect()->route('user-login');
        }

        $user_id = $user->id;

        if($user->role_id == 2)
        {
            $last_quotation_number = new_quotations::where('creator_id',$user_id)->latest()->pluck('quotation_invoice_number')->first();
            $last_order_number = '';
            $last_invoice_number = new_invoices::where('creator_id',$user_id)->latest()->pluck('invoice_number')->first();
        }
        else
        {
            $last_quotation_number = '';
            $last_order_number = new_orders::where('supplier_id',$user_id)->latest()->pluck('order_number')->first();
            $last_invoice_number = '';
        }

        return view('user.prefix_settings',compact('user','last_quotation_number','last_order_number','last_invoice_number'));
    }

    public function SavePrefixSettings(Request $request)
    {
        $flag = 0;
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;
        $msg = "";

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->role_id == 2)
        {
            $quotation_number = $request->quotation_client_id ? date("Y") . "-" . sprintf('%04u', $user_id) . '-' . $request->quotation_counter : date("Y") . '-' . $request->quotation_counter;
            $check_quotation = new_quotations::where('quotation_invoice_number',$quotation_number)->where('creator_id',$user_id)->first();

            if($check_quotation)
            {
                $flag = 1;
                $msg .= 'Quotation number: '.$quotation_number.' already in system. Kindly change counter.<br>';
            }

            $invoice_number = $request->invoice_client_id ? date("Y") . "-" . sprintf('%04u', $user_id) . '-' . $request->invoice_counter : date("Y") . '-' . $request->invoice_counter;
            $check_invoice = new_invoices::where('invoice_number',$invoice_number)->where('creator_id',$user_id)->first();

            if($check_invoice)
            {
                $flag = 1;
                $msg .= 'Invoice number: '.$invoice_number.' already in system. Kindly change counter.';
            }

            if($flag)
            {
                Session::flash('unsuccess', $msg);
                return redirect()->back();
            }

            User::where('id',$request->user_id)->update(['quotation_prefix' => $request->quotation_prefix ? $request->quotation_prefix : 'OF', 'counter' => ltrim($request->quotation_counter, '0'), 'quotation_client_id' => $request->quotation_client_id, 'invoice_prefix' => $request->invoice_prefix ? $request->invoice_prefix : 'INV', 'counter_invoice' => ltrim($request->invoice_counter, '0'), 'invoice_client_id' => $request->invoice_client_id]);
        }
        else
        {
            $order_number = $request->order_client_id ? date("Y") . "-" . sprintf('%04u', $user_id) . '-' . $request->order_counter : date("Y") . '-' . $request->order_counter;
            $check_order = new_orders::where('order_number',$order_number)->where('supplier_id',$user_id)->first();

            if($check_order)
            {
                $flag = 1;
                $msg .= 'Order number '.$order_number.' already in system. Kindly change counter.';
            }

            if($flag)
            {
                Session::flash('unsuccess', $msg);
                return redirect()->back();
            }

            User::where('id',$request->user_id)->update(['order_prefix' => $request->order_prefix ? $request->order_prefix : 'OR', 'counter_order' => ltrim($request->order_counter, '0'), 'order_client_id' => $request->order_client_id]);
        }

        Session::flash('success', 'Information updated successfully.');

        return redirect()->back();
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

        if ($user->role_id == 3) {
            return redirect()->route('user-login');
        }

        if($user->can('show-dashboard'))
        {
            if($user->role_id == 2)
            {
                $suppliers = User::leftjoin('retailers_requests','retailers_requests.retailer_id','=','users.id')->where('users.id',$user_id)->where('retailers_requests.status',1)->where('retailers_requests.active',1)->pluck('retailers_requests.supplier_id');
                $orders = new_orders::leftjoin('new_quotations','new_quotations.id','=','new_orders.quotation_id')->leftjoin('customers_details','customers_details.id','=','new_quotations.customer_details')->leftjoin('users','users.id','=','new_orders.supplier_id')->whereIn('new_orders.supplier_id',$suppliers)->where('new_quotations.finished',1)->orderBy('new_orders.id', 'desc')->take(10)->select('users.company_name','customers_details.name','new_orders.delivery_date','new_orders.order_date','new_orders.approved','new_quotations.*')->get();
            }
            else
            {
                $orders = new_orders::leftjoin('new_quotations','new_quotations.id','=','new_orders.quotation_id')->leftjoin('customers_details','customers_details.id','=','new_quotations.customer_details')->leftjoin('users','users.id','=','new_orders.supplier_id')->where('new_orders.supplier_id',$user->id)->where('new_quotations.finished',1)->orderBy('new_orders.id', 'desc')->take(10)->select('users.company_name','customers_details.name','new_orders.delivery_date','new_orders.order_date','new_orders.approved','new_quotations.*')->get();
            }

            $commission_percentage = Generalsetting::findOrFail(1);

            $start = strtotime(date('Y-m-01', strtotime('0 month')));
            $end = strtotime(date('Y-m-01', strtotime('-5 month')));

            $dates = array();
            $month = $start;

            while ($end < $month) {
                $dates[] = date('Y-m-01', $month);
                $month = strtotime("-1 month", $month);
            }

            $invoices_chart = array();
            $quotes_chart = array();

            $dates = array_reverse($dates);

            foreach ($dates as $date) {

                $c_date = date('m', strtotime($date));

                $month_chart = new_quotations::where('creator_id', $user_id)->whereMonth('created_at', '=', $c_date)->get();

                $invoice_total = 0;
                $quotes_count = 0;
                $quotes_total = 0;
                $quotes_accepted_total = 0;

                foreach ($month_chart as $value) {

                    if($value->invoice)
                    {
                        $invoice_total = $invoice_total + $value->grand_total;
                    }

                    $quotes_count = $quotes_count + 1;
                    $quotes_total = $quotes_total + $value->grand_total;

                    if($value->accepted)
                    {
                        $quotes_accepted_total = $quotes_accepted_total + $value->grand_total;
                    }

                }

                /*$invoice_total = number_format((float)$invoice_total, 2, ',', '.');*/

                $quotes_chart[] = array('date' => $date, 'Quotes' => $quotes_total, 'Accepted' => $quotes_accepted_total);
                $invoices_chart[] = array('date' => $date, 'Invoices Total' => $invoice_total);
            }

            ini_set('precision', 10);
            ini_set('serialize_precision', 10);

            $invoices_chart = json_encode($invoices_chart);
            $quotes_chart = json_encode($quotes_chart);

            return view('user.dashboard', compact('user','commission_percentage','invoices_chart','quotes_chart','orders'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function QuotationRequests()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;
        $invoices = array();

        $requests = quotes::leftjoin('categories', 'categories.id', '=', 'quotes.quote_service')->leftjoin('services', 'services.id', '=', 'quotes.quote_service1')->where('quotes.user_id', $user_id)->select('quotes.*', 'categories.cat_name','services.title')->orderBy('quotes.created_at','desc')->get();

        foreach ($requests as $key) {
            $invoices[] = new_quotations::where('quote_request_id', $key->id)->where('approved', 1)->get();
        }


        return view('user.client_quote_requests', compact('requests', 'invoices'));
    }

    public function HandymanQuotationRequests()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('handyman-quotation-requests'))
        {
            $invoices = array();

            $requests = handyman_quotes::leftjoin('quotes', 'quotes.id', '=', 'handyman_quotes.quote_id')->leftjoin('categories', 'categories.id', '=', 'quotes.quote_service')->leftjoin('brands', 'brands.id', '=', 'quotes.quote_brand')->leftjoin('product_models', 'product_models.id', '=', 'quotes.quote_model')->leftjoin('services','services.id','=','quotes.quote_service1')->where('handyman_quotes.handyman_id', $user_id)->select('quotes.*', 'categories.cat_name', 'services.title', 'handyman_quotes.quote_id', 'handyman_quotes.handyman_id','brands.cat_name as brand_name','product_models.model as model_name')->orderBy('quotes.created_at','desc')->get();

            foreach ($requests as $key) {
                $invoices[] = new_quotations::where('quote_request_id', $key->quote_id)->where('creator_id', $key->handyman_id)->first();
                // $invoices[] = quotation_invoices::where('quote_id', $key->quote_id)->where('handyman_id', $key->handyman_id)->first();
            }

            return view('user.quote_requests', compact('requests', 'invoices'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function Retailers()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('supplier-retailers'))
        {
            $users = User::leftjoin('retailers_requests','retailers_requests.retailer_id','=','users.id')->where('users.role_id','=',2)->where('retailers_requests.supplier_id','=',$user_id)->orderBy('users.created_at','desc')->select('users.*','retailers_requests.status','retailers_requests.active')->get();

            return view('user.retailers',compact('users'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function DetailsRetailer($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('retailer-details'))
        {
            $user = User::leftjoin('retailers_requests','retailers_requests.retailer_id','=','users.id')->where('users.role_id','=',2)->where('users.id',$id)->where('retailers_requests.supplier_id','=',$user_id)->first();

            if(!$user)
            {
                return redirect()->back();
            }

            return view('user.retailer_details',compact('user'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function AcceptRetailerRequest(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        $supplier = User::where('id',$user_id)->first();
        $supplier_name = $supplier->name;
        $retailer = User::where('id',$request->retailer_id)->first();
        $retailer_email = $retailer->email;

        retailers_requests::where('retailer_id',$request->retailer_id)->where('supplier_id',$user_id)->update(['status' => 1, 'active' => 1]);

        \Mail::send(array(), array(), function ($message) use ($retailer_email, $supplier_name) {
            $message->to($retailer_email)
                ->from('info@vloerofferte.nl')
                ->subject('Request Accepted!')
                ->setBody("Supplier Mr/Mrs " . $supplier_name . " has accepted your request.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
        });

        Session::flash('success', 'Request accepted successfully!');

        return redirect()->back();
    }

    public function SuspendRetailerRequest(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        $supplier = User::where('id',$user_id)->first();
        $supplier_name = $supplier->name;
        $retailer = User::where('id',$request->retailer_id)->first();
        $retailer_email = $retailer->email;

        if($request->active)
        {
            retailers_requests::where('retailer_id',$request->retailer_id)->where('supplier_id',$user_id)->update(['status' => 1, 'active' => 1]);

            \Mail::send(array(), array(), function ($message) use ($retailer_email, $supplier_name) {
                $message->to($retailer_email)
                    ->from('info@vloerofferte.nl')
                    ->subject('Request Accepted!')
                    ->setBody("Supplier Mr/Mrs " . $supplier_name . " has reactivated your request.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
            });

            Session::flash('success', 'Request activated successfully!');
        }
        else
        {
            retailers_requests::where('retailer_id',$request->retailer_id)->where('supplier_id',$user_id)->update(['status' => 1, 'active' => 0]);

            \Mail::send(array(), array(), function ($message) use ($retailer_email, $supplier_name) {
                $message->to($retailer_email)
                    ->from('info@vloerofferte.nl')
                    ->subject('Request Accepted!')
                    ->setBody("Supplier Mr/Mrs " . $supplier_name . " has suspended your request.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
            });

            Session::flash('success', 'Request suspended successfully!');
        }

        return redirect()->back();
    }

    public function DeleteRetailerRequest(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        $supplier = User::where('id',$user_id)->first();
        $supplier_name = $supplier->name;
        $retailer = User::where('id',$request->retailer_id)->first();
        $retailer_email = $retailer->email;

        retailers_requests::where('retailer_id',$request->retailer_id)->where('supplier_id',$user_id)->delete();

        \Mail::send(array(), array(), function ($message) use ($retailer_email, $supplier_name) {
            $message->to($retailer_email)
                ->from('info@vloerofferte.nl')
                ->subject('Request Accepted!')
                ->setBody("Supplier Mr/Mrs " . $supplier_name . " has deleted your request. You can no longer see details of this supplier.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
        });

        Session::flash('success', 'Request deleted successfully!');

        return redirect()->back();
    }

    public function Suppliers()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('retailer-suppliers'))
        {
            $users = User::leftjoin('retailers_requests', function($join) use($user_id){
                $join->on('users.id', '=', 'retailers_requests.supplier_id');
                $join->where('retailers_requests.retailer_id',$user_id);
            })->where('users.role_id','=',4)->orderBy('users.created_at','desc')->select('users.*','retailers_requests.status','retailers_requests.active')->get();

            $products = array();
            $categories = array();

            foreach ($users as $key) {

                if($key->status && $key->active)
                {
                    $products[] = Products::where('user_id',$key->id)->get();
                    $categories[] = supplier_categories::leftjoin('categories','categories.id','=','supplier_categories.category_id')->where('supplier_categories.user_id',$key->id)->orderBy('categories.id','desc')->select('categories.cat_name')->get();
                }
                else
                {
                    $products[] = array();
                    $categories[] = array();
                }

            }

            return view('user.suppliers',compact('users','products','categories'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function DetailsSupplier($id)
    {
        $user = Auth::guard('user')->user();

        if($user->can('supplier-details'))
        {
            $user = User::where('id',$id)->where('role_id','=',4)->first();

            if(!$user)
            {
                return redirect()->back();
            }

            return view('user.supplier_details',compact('user'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function SendRequestSupplier(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        $retailer = User::where('id',$user_id)->first();
        $retailer_name = $retailer->name;
        $supplier = User::where('id',$request->supplier_id)->first();
        $supplier_email = $supplier->email;

        $check = retailers_requests::where('retailer_id',$user_id)->where('supplier_id',$request->supplier_id)->first();

        if($check)
        {
            \Mail::send(array(), array(), function ($message) use ($supplier_email, $retailer_name) {
                $message->to($supplier_email)
                    ->from('info@vloerofferte.nl')
                    ->subject('Retailer Request!')
                    ->setBody("Retailer Mr/Mrs " . $retailer_name . " request for the client role is pending for your further action. Visit your dashboard panel to view details.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
            });
        }
        else
        {
            $post = new retailers_requests;
            $post->retailer_id = $user_id;
            $post->supplier_id = $request->supplier_id;
            $post->status = 0;
            $post->save();

            \Mail::send(array(), array(), function ($message) use ($supplier_email, $retailer_name) {
                $message->to($supplier_email)
                    ->from('info@vloerofferte.nl')
                    ->subject('Retailer Request!')
                    ->setBody("A retailer Mr/Mrs " . $retailer_name . " submitted request to become your client. Visit your dashboard panel to view details.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
            });
        }

        Session::flash('success', 'Request submitted successfully!');

        return redirect()->back();
    }

    public function HandymanQuotations($id = '')
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('quotations'))
        {
            if ($id) {
                $invoices = quotation_invoices::leftjoin('quotes', 'quotes.id', '=', 'quotation_invoices.quote_id')->leftjoin('users', 'users.id', '=', 'quotation_invoices.handyman_id')->where('quotation_invoices.handyman_id', $user_id)->where('quotation_invoices.quote_id', $id)->where('quotation_invoices.invoice', 0)->orderBy('quotation_invoices.id', 'desc')->select('quotes.*', 'quotation_invoices.review_text', 'quotation_invoices.delivery_date', 'quotation_invoices.id as invoice_id', 'quotation_invoices.invoice', 'quotation_invoices.ask_customization', 'quotation_invoices.approved', 'quotation_invoices.accepted', 'quotation_invoices.quotation_invoice_number', 'quotation_invoices.tax', 'quotation_invoices.subtotal', 'quotation_invoices.grand_total', 'quotation_invoices.created_at as invoice_date', 'users.name', 'users.family_name')->get();
            } else {
                $invoices = quotation_invoices::leftjoin('quotes', 'quotes.id', '=', 'quotation_invoices.quote_id')->leftjoin('users', 'users.id', '=', 'quotation_invoices.handyman_id')->where('quotation_invoices.handyman_id', $user_id)->where('quotation_invoices.invoice', 0)->orderBy('quotation_invoices.id', 'desc')->select('quotes.*', 'quotation_invoices.review_text', 'quotation_invoices.delivery_date', 'quotation_invoices.id as invoice_id', 'quotation_invoices.invoice', 'quotation_invoices.ask_customization', 'quotation_invoices.approved', 'quotation_invoices.accepted', 'quotation_invoices.quotation_invoice_number', 'quotation_invoices.tax', 'quotation_invoices.subtotal', 'quotation_invoices.grand_total', 'quotation_invoices.created_at as invoice_date', 'users.name', 'users.family_name')->get();
            }

            return view('user.quote_invoices', compact('invoices'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function CustomerQuotations($id = '')
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('customer-quotations'))
        {
            if ($id) {

                $invoices = custom_quotations::leftjoin('users', 'users.id', '=', 'custom_quotations.user_id')->where('custom_quotations.handyman_id', $user_id)->where('custom_quotations.id', $id)->where('custom_quotations.status','!=',3)->orderBy('custom_quotations.created_at', 'desc')->select('custom_quotations.*', 'custom_quotations.id as invoice_id', 'custom_quotations.created_at as invoice_date', 'users.name', 'users.family_name')->get();

                return view('user.quote_invoices', compact('invoices'));

            } else {

                $invoices = custom_quotations::leftjoin('users', 'users.id', '=', 'custom_quotations.user_id')->where('custom_quotations.handyman_id', $user_id)->where('custom_quotations.status','!=',3)->orderBy('custom_quotations.created_at', 'desc')->select('custom_quotations.*', 'custom_quotations.id as invoice_id', 'custom_quotations.created_at as invoice_date', 'users.name', 'users.family_name')->get();

            }
        }
        else
        {
            $invoices = collect(new custom_quotations());
        }

        if($user->can('create-new-quotation'))
        {
            if($user_role == 2)
            {
                $new_invoices = new_quotations::leftjoin('customers_details', 'customers_details.id', '=', 'new_quotations.customer_details')->leftjoin('quotes', 'quotes.id', '=', 'new_quotations.quote_request_id')->where('new_quotations.creator_id', $user_id)->where('new_quotations.status','!=',3)->orderBy('new_quotations.created_at', 'desc')->select('new_quotations.*', 'new_quotations.id as invoice_id', 'new_quotations.created_at as invoice_date', 'customers_details.name', 'customers_details.family_name', 'quotes.quote_name', 'quotes.quote_familyname')->with('orders')->with('invoices')->get();
            }
            else
            {
                $new_invoices = new_quotations::leftjoin('new_orders', 'new_orders.quotation_id', '=', 'new_quotations.id')->leftjoin('customers_details', 'customers_details.id', '=', 'new_quotations.customer_details')->leftjoin('quotes', 'quotes.id', '=', 'new_quotations.quote_request_id')->where('new_orders.supplier_id', $user_id)->where('new_quotations.finished',1)->orderBy('new_quotations.created_at', 'desc')->select('new_quotations.*', 'new_quotations.id as invoice_id', 'new_orders.order_sent', 'new_orders.id as data_id', 'new_quotations.created_at as invoice_date', 'new_orders.order_number','new_orders.approved as data_approved','new_orders.processing as data_processing','new_orders.delivered as data_delivered', 'customers_details.name', 'customers_details.family_name', 'quotes.quote_name', 'quotes.quote_familyname')->with('invoices')->get();
                $new_invoices = $new_invoices->unique('invoice_id');
            }
        }
        else
        {
            $new_invoices = collect(new new_quotations());
        }

        $invoices = $invoices->concat($new_invoices);

        if($invoices)
        {
            return view('user.quotations', compact('invoices'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function CustomerInvoices($id = '')
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;
        $user_role = $user->role_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user_role == 2)
        {
            $new_invoices = new_invoices::leftjoin('new_quotations','new_quotations.id','=','new_invoices.quotation_id')->leftjoin('customers_details', 'customers_details.id', '=', 'new_invoices.customer_details')->leftjoin('quotes', 'quotes.id', '=', 'new_invoices.quote_request_id')->where('new_invoices.creator_id', $user_id)->where('new_invoices.invoice',1)->orderBy('new_invoices.created_at', 'desc')->select('new_invoices.*', 'new_quotations.quotation_invoice_number', 'new_invoices.id as invoice_id', 'new_invoices.created_at as invoice_date', 'customers_details.name', 'customers_details.family_name', 'quotes.quote_name', 'quotes.quote_familyname')->with('data')->get();
            $new_negative_invoices = new_negative_invoices::leftjoin('new_quotations','new_quotations.id','=','new_invoices.quotation_id')->leftjoin('customers_details', 'customers_details.id', '=', 'new_invoices.customer_details')->where('new_invoices.creator_id', $user_id)->orderBy('new_invoices.created_at', 'desc')->select('new_invoices.*', 'new_quotations.quotation_invoice_number', 'new_invoices.id as invoice_id', 'new_invoices.created_at as invoice_date', 'customers_details.name', 'customers_details.family_name')->with('data')->get();
            $new_invoices = $new_invoices->concat($new_negative_invoices);
        }
        else
        {
            $new_invoices = '';
        }

        if($user->can('customer-invoices'))
        {
            if ($id) {

                $invoices = custom_quotations::leftjoin('users', 'users.id', '=', 'custom_quotations.user_id')->where('custom_quotations.handyman_id', $user_id)->where('custom_quotations.id', $id)->where('custom_quotations.status','=',3)->orderBy('custom_quotations.created_at', 'desc')->select('custom_quotations.*', 'custom_quotations.id as invoice_id', 'custom_quotations.created_at as invoice_date', 'users.name', 'users.family_name')->get();

                return view('user.quote_invoices', compact('invoices'));

            } else {
                $invoices = custom_quotations::leftjoin('users', 'users.id', '=', 'custom_quotations.user_id')->where('custom_quotations.handyman_id', $user_id)->where('custom_quotations.status','=',3)->orderBy('custom_quotations.created_at', 'desc')->select('custom_quotations.*', 'custom_quotations.id as invoice_id', 'custom_quotations.created_at as invoice_date', 'users.name', 'users.family_name')->get();
            }
        }
        else
        {
            $invoices = '';
        }

        $invoices = $invoices->concat($new_invoices);

        if($invoices)
        {
            return view('user.invoices', compact('invoices'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function HandymanQuotationsInvoices($id = '')
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $check = 0;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if(\Route::currentRouteName() == 'quotations-invoices'){

            if($user->can('quotations-invoices'))
            {
                $check = 1;
            }

        }

        if(\Route::currentRouteName() == 'commission-invoices'){

            if($user->can('commission-invoices'))
            {
                $check = 1;
            }

        }

        if($check)
        {
            if ($id) {
                $invoices = quotation_invoices::leftjoin('quotes', 'quotes.id', '=', 'quotation_invoices.quote_id')->leftjoin('users', 'users.id', '=', 'quotation_invoices.handyman_id')->where('quotation_invoices.handyman_id', $user_id)->where('quotation_invoices.quote_id', $id)->where('quotation_invoices.invoice', 1)->orderBy('quotation_invoices.created_at', 'desc')->select('quotes.*', 'quotation_invoices.review_text', 'quotation_invoices.delivery_date', 'quotation_invoices.delivered', 'quotation_invoices.received', 'quotation_invoices.commission_percentage', 'quotation_invoices.commission', 'quotation_invoices.total_receive', 'quotation_invoices.id as invoice_id', 'quotation_invoices.invoice', 'quotation_invoices.ask_customization', 'quotation_invoices.approved', 'quotation_invoices.accepted', 'quotation_invoices.quotation_invoice_number', 'quotation_invoices.tax', 'quotation_invoices.subtotal', 'quotation_invoices.grand_total', 'quotation_invoices.created_at as invoice_date', 'users.name', 'users.family_name')->get();
            } else {
                $invoices = quotation_invoices::leftjoin('quotes', 'quotes.id', '=', 'quotation_invoices.quote_id')->leftjoin('users', 'users.id', '=', 'quotation_invoices.handyman_id')->where('quotation_invoices.handyman_id', $user_id)->where('quotation_invoices.invoice', 1)->orderBy('quotation_invoices.created_at', 'desc')->select('quotes.*', 'quotation_invoices.review_text', 'quotation_invoices.delivery_date', 'quotation_invoices.delivered', 'quotation_invoices.received', 'quotation_invoices.commission_percentage', 'quotation_invoices.commission', 'quotation_invoices.total_receive', 'quotation_invoices.id as invoice_id', 'quotation_invoices.invoice', 'quotation_invoices.ask_customization', 'quotation_invoices.approved', 'quotation_invoices.accepted', 'quotation_invoices.quotation_invoice_number', 'quotation_invoices.tax', 'quotation_invoices.subtotal', 'quotation_invoices.grand_total', 'quotation_invoices.created_at as invoice_date', 'users.name', 'users.family_name')->get();
            }

            return view('user.quote_invoices', compact('invoices'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function Quotations($id = '')
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;

        if ($id) {
            $invoices = new_quotations::leftjoin('quotes', 'quotes.id', '=', 'new_quotations.quote_request_id')->leftjoin('users', 'users.id', '=', 'new_quotations.creator_id')->where('quotes.user_id', $user_id)->where('quotes.status', '<', 3)->where('new_quotations.quote_request_id', $id)->where('new_quotations.invoice', 0)->where('new_quotations.approved', 1)->orderBy('new_quotations.created_at', 'desc')->select('quotes.*', 'new_quotations.review_text', 'new_quotations.ask_customization', 'new_quotations.approved', 'new_quotations.accepted', 'new_quotations.id as invoice_id', 'new_quotations.quotation_invoice_number', 'new_quotations.tax_amount as tax', 'new_quotations.subtotal', 'new_quotations.grand_total', 'new_quotations.created_at as invoice_date', 'new_quotations.accept_date', 'new_quotations.delivery_date', 'users.name', 'users.family_name', 'users.address', 'users.postcode', 'users.city', 'users.phone')->get();
        } else {
            $invoices = new_quotations::leftjoin('quotes', 'quotes.id', '=', 'new_quotations.quote_request_id')->leftjoin('users', 'users.id', '=', 'new_quotations.creator_id')->where('quotes.user_id', $user_id)->where('quotes.status', '<', 3)->where('new_quotations.invoice', 0)->where('new_quotations.approved', 1)->orderBy('new_quotations.created_at', 'desc')->select('quotes.*', 'new_quotations.review_text', 'new_quotations.ask_customization', 'new_quotations.approved', 'new_quotations.accepted', 'new_quotations.id as invoice_id', 'new_quotations.quotation_invoice_number', 'new_quotations.tax_amount as tax', 'new_quotations.subtotal', 'new_quotations.grand_total', 'new_quotations.created_at as invoice_date', 'new_quotations.accept_date', 'new_quotations.delivery_date', 'users.name', 'users.family_name', 'users.address', 'users.postcode', 'users.city', 'users.phone')->get();
        }

        return view('user.client_quote_invoices', compact('invoices'));
    }

    public function ClientNewQuotations()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;

        $invoices = new_quotations::leftjoin('users', 'users.id', '=', 'new_quotations.creator_id')->where('new_quotations.user_id', $user_id)->where('new_quotations.approved', 1)->orderBy('new_quotations.created_at', 'desc')->select('new_quotations.*', 'new_quotations.id as invoice_id', 'new_quotations.created_at as invoice_date', 'users.name', 'users.family_name', 'users.address', 'users.postcode', 'users.city', 'users.phone')->get();

        return view('user.client_quote_invoices', compact('invoices'));
    }

    public function CustomQuotations($id = '')
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;

        if ($id) {
            $invoices = custom_quotations::leftjoin('users', 'users.id', '=', 'custom_quotations.handyman_id')->where('custom_quotations.user_id', $user_id)->where('custom_quotations.id', $id)->where('custom_quotations.approved', 1)->orderBy('custom_quotations.created_at', 'desc')->select('custom_quotations.*', 'custom_quotations.id as invoice_id', 'custom_quotations.created_at as invoice_date', 'users.name', 'users.family_name', 'users.address', 'users.postcode', 'users.city', 'users.phone')->get();
        } else {
            $invoices = custom_quotations::leftjoin('users', 'users.id', '=', 'custom_quotations.handyman_id')->where('custom_quotations.user_id', $user_id)->where('custom_quotations.approved', 1)->orderBy('custom_quotations.created_at', 'desc')->select('custom_quotations.*', 'custom_quotations.id as invoice_id', 'custom_quotations.created_at as invoice_date', 'users.name', 'users.family_name', 'users.address', 'users.postcode', 'users.city', 'users.phone')->get();
        }

        return view('user.client_quote_invoices', compact('invoices'));
    }

    public function QuotationsInvoices($id = '')
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;

        if ($id) {
            $invoices = quotation_invoices::leftjoin('quotes', 'quotes.id', '=', 'quotation_invoices.quote_id')->leftjoin('users', 'users.id', '=', 'quotation_invoices.handyman_id')->where('quotes.user_id', $user_id)->where('quotes.status', '=', 3)->where('quotation_invoices.quote_id', $id)->where('quotation_invoices.invoice', 1)->where('quotation_invoices.approved', 1)->select('quotes.*', 'quotation_invoices.review_text', 'quotation_invoices.delivered', 'quotation_invoices.received', 'quotation_invoices.ask_customization', 'quotation_invoices.approved', 'quotation_invoices.accepted', 'quotation_invoices.id as invoice_id', 'quotation_invoices.quotation_invoice_number', 'quotation_invoices.tax', 'quotation_invoices.subtotal', 'quotation_invoices.grand_total', 'quotation_invoices.created_at as invoice_date', 'quotation_invoices.accept_date', 'quotation_invoices.delivery_date', 'users.name', 'users.family_name', 'users.address', 'users.postcode', 'users.city', 'users.phone')->orderBy('quotation_invoices.created_at', 'desc')->get();
        } else {
            $invoices = quotation_invoices::leftjoin('quotes', 'quotes.id', '=', 'quotation_invoices.quote_id')->leftjoin('users', 'users.id', '=', 'quotation_invoices.handyman_id')->where('quotes.user_id', $user_id)->where('quotes.status', '=', 3)->where('quotation_invoices.invoice', 1)->where('quotation_invoices.approved', 1)->select('quotes.*', 'quotation_invoices.review_text', 'quotation_invoices.delivered', 'quotation_invoices.received', 'quotation_invoices.ask_customization', 'quotation_invoices.approved', 'quotation_invoices.accepted', 'quotation_invoices.id as invoice_id', 'quotation_invoices.quotation_invoice_number', 'quotation_invoices.tax', 'quotation_invoices.subtotal', 'quotation_invoices.grand_total', 'quotation_invoices.created_at as invoice_date', 'quotation_invoices.accept_date', 'quotation_invoices.delivery_date', 'users.name', 'users.family_name', 'users.address', 'users.postcode', 'users.city', 'users.phone')->orderBy('quotation_invoices.created_at', 'desc')->get();
        }

        return view('user.client_quote_invoices', compact('invoices'));
    }

    public function QuoteRequest($id)
    {
        $request = quotes::leftjoin('categories', 'categories.id', '=', 'quotes.quote_service')->leftjoin('brands', 'brands.id', '=', 'quotes.quote_brand')->leftjoin('models', 'models.id', '=', 'quotes.quote_type')->leftjoin('product_models', 'product_models.id', '=', 'quotes.quote_model')->leftjoin('colors', 'colors.id', '=', 'quotes.quote_color')->leftjoin('services','services.id','=','quotes.quote_service1')->where('quotes.id', $id)->select('quotes.*', 'categories.cat_name','services.title','brands.cat_name as brand_name','product_models.model as model_name','models.cat_name as type_title','colors.title as color')->withCount('quotations')->first();

        $q_a = requests_q_a::where('request_id', $id)->get();

        return view('user.client_quote_request', compact('request',  'q_a'));
    }

    public function DownloadQuoteRequest($id,$user_id = NULL,$role = NULL,$type = NULL)
    {
        if($type != 'api')
        {
            $user = Auth::guard('user')->user();
            $user_id = $user->id;
            $role = $user->role_id;
        }

        $quote = quotes::leftjoin('categories', 'categories.id', '=', 'quotes.quote_service')->leftjoin('brands','brands.id','=','quotes.quote_brand')->leftjoin('models','models.id','=','quotes.quote_type')->leftjoin('product_models','product_models.id','=','quotes.quote_model')->leftjoin('colors','colors.id','=','quotes.quote_color')->leftjoin('services','services.id','=','quotes.quote_service1')->where('quotes.id', $id)->where('quotes.user_id', $user_id)->select('quotes.*', 'categories.cat_name','services.title','brands.cat_name as brand_name','product_models.model as model_name','models.cat_name as type_title','colors.title as color')->first();

        $q_a = requests_q_a::where('request_id', $id)->get();

        if ($quote) {

            $quote_number = $quote->quote_number;

            $filename = $quote_number . '.pdf';

            if($role == 3)
            {
                $file = public_path() . '/assets/adminQuotesPDF/' . $filename;
            }
            else
            {
                $file = public_path() . '/assets/quotesPDF/' . $filename;
            }

            if (!file_exists($file)) {

                ini_set('max_execution_time', 180);

                $pdf = PDF::loadView('admin.user.pdf_quote', compact('quote', 'q_a','role'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140,'isRemoteEnabled' => true]);

                if($role == 3)
                {
                    $pdf->save(public_path() . '/assets/adminQuotesPDF/' . $filename);
                }
                else
                {
                    $pdf->save(public_path() . '/assets/quotesPDF/' . $filename);
                }
            }

            if($type != 'api')
            {
                if($role == 3)
                {
                    return response()->download(public_path("assets/adminQuotesPDF/{$filename}"));
                }
                else
                {
                    return response()->download(public_path("assets/quotesPDF/{$filename}"));
                }
            }
            else
            {
                return 'true';
            }

        } else {

            if($type != 'api')
            {
                return redirect('aanbieder/quotation-requests');
            }
            else
            {
                return 'Invalid';
            }
        }
    }

    public function DownloadQuoteInvoice($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('download-quote-invoice'))
        {
            $invoice = quotation_invoices::where('id', $id)->where('handyman_id', $user_id)->first();

            if (!$invoice) {
                return redirect()->route('quotations');
            }

            $quotation_invoice_number = $invoice->quotation_invoice_number;

            $filename = $quotation_invoice_number . '.pdf';

            if($user_role == 2 && $invoice->invoice != 1)
            {
                return response()->download(public_path("assets/quotationsPDF/HandymanQuotations/{$filename}"));
            }
            else
            {
                return response()->download(public_path("assets/quotationsPDF/{$filename}"));
            }
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function DownloadCommissionInvoice($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        $invoice = new_quotations::where('id', $id)->where('creator_id', $user_id)->first();

        if (!$invoice) {
            return redirect()->route('quotations');
        }

        $commission_invoice_number = $invoice->commission_invoice_number;

        $filename = $commission_invoice_number . '.pdf';

        return response()->download(public_path("assets/CommissionInvoices/{$filename}"));
    }

    public function DownloadCustomQuotation($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('download-custom-quotation'))
        {
            $invoice = custom_quotations::where('id', $id)->where('handyman_id', $user_id)->first();

            if (!$invoice) {
                return redirect()->back();
            }

            $quotation_invoice_number = $invoice->quotation_invoice_number;

            $filename = $quotation_invoice_number . '.pdf';

            return response()->download(public_path("assets/customQuotations/{$filename}"));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function DownloadClientQuoteInvoice($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;

        $invoice = new_quotations::leftjoin('quotes', 'quotes.id', '=', 'new_quotations.quote_request_id')->where('new_quotations.id', $id)->where('quotes.user_id', $user_id)->first();

        if (!$invoice) {
            return redirect()->route('client-quotations');
        }

        $quotation_invoice_number = $invoice->quotation_invoice_number;

        $filename = $quotation_invoice_number . '.pdf';

        return response()->download(public_path("assets/newQuotations/{$filename}"));
    }

    public function DownloadClientCustomQuoteInvoice($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;

        $invoice = custom_quotations::where('custom_quotations.id', $id)->where('custom_quotations.user_id', $user_id)->first();

        if (!$invoice) {
            return redirect()->back();
        }

        $quotation_invoice_number = $invoice->quotation_invoice_number;

        $filename = $quotation_invoice_number . '.pdf';

        return response()->download(public_path("assets/customQuotations/{$filename}"));
    }

    public function AskCustomization(Request $request)
    {
        $id = $request->invoice_id;
        $review_text = $request->review_text;

        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;

        if($request->type == 1)
        {
            $invoice = quotation_invoices::leftjoin('quotes', 'quotes.id', '=', 'quotation_invoices.quote_id')->leftjoin('users', 'users.id', '=', 'quotation_invoices.handyman_id')->where('quotation_invoices.id', $id)->where('quotes.user_id', $user_id)->first();

            if (!$invoice) {
                return redirect()->back();
            }

            quotation_invoices::where('id', $id)->update(['ask_customization' => 1, 'review_text' => $review_text]);
        }
        else
        {
            $invoice = new_quotations::leftjoin('users', 'users.id', '=', 'new_quotations.creator_id')->where('new_quotations.id', $id)->where('new_quotations.user_id', $user_id)->first();

            if (!$invoice) {
                return redirect()->back();
            }

            new_quotations::where('id', $id)->update(['ask_customization' => 1, 'review_text' => $review_text]);
        }

        $creator_email = $invoice->email;
        $creator_name = $invoice->name;

        \Mail::send(array(), array(), function ($message) use ($creator_email, $creator_name, $invoice, $user) {
            $message->to($creator_email)
                ->from('info@vloerofferte.nl')
                ->subject(__('text.Quotation Review Request!'))
                ->setBody("Dear Mr/Mrs " . $creator_name . ",<br><br>Mr/Mrs " . $user->name . " submitted review request against your quotation QUO# " . $invoice->quotation_invoice_number . "<br>Kindly take further action on this request.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
        });


        $admin_email = $this->sl->admin_email;

        \Mail::send(array(), array(), function ($message) use ($admin_email, $creator_name, $invoice, $user) {
            $message->to($admin_email)
                ->from('info@vloerofferte.nl')
                ->subject('Quotation Review Request!')
                ->setBody("A quotation review request has been submitted by Mr/Mrs " . $user->name . " against quotation QUO# " . $invoice->quotation_invoice_number . "<br>Retailer: " . $creator_name . "<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
        });


        Session::flash('success', __('text.Request submitted successfully!'));

        return redirect()->back();
    }

    public function CustomQuotationAskCustomization(Request $request)
    {
        $id = $request->invoice_id;
        $review_text = $request->review_text;

        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;

        $invoice = custom_quotations::leftjoin('users', 'users.id', '=', 'custom_quotations.handyman_id')->where('custom_quotations.id', $id)->where('custom_quotations.user_id', $user_id)->first();

        if (!$invoice) {
            return redirect()->back();
        }


        custom_quotations::where('id', $id)->update(['ask_customization' => 1, 'review_text' => $review_text]);

        $handyman_email = $invoice->email;
        $user_name = $invoice->name;

        \Mail::send(array(), array(), function ($message) use ($handyman_email, $user_name, $invoice, $user) {
            $message->to($handyman_email)
                ->from('info@vloerofferte.nl')
                ->subject(__('text.Quotation Review Request!'))
                ->setBody("Dear Mr/Mrs " . $user_name . ",<br><br>Mr/Mrs " . $user->name . " submitted review request against your quotation QUO# " . $invoice->quotation_invoice_number . "<br>Kindly take further action on this request.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
        });


        /*$admin_email = $this->sl->admin_email;

        \Mail::send(array(), array(), function ($message) use($admin_email,$user_name,$invoice,$user) {
            $message->to($admin_email)
                ->from('info@vloerofferte.nl')
                ->subject('Quotation Review Request!')
                ->setBody("A quotation review request has been submitted by Mr/Mrs ".$user->name.' '.$user->family_name." against quotation QUO# ".$invoice->quotation_invoice_number."<br>Handyman: ".$user_name."<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
        });*/


        Session::flash('success', __('text.Request submitted successfully!'));

        return redirect()->back();
    }


    public function AcceptQuotation($request,$user_id)
    {
        $now = date('d-m-Y H:i:s');
        $time = strtotime($now);
        $time = date('H:i:s',$time);
        $delivery_date = $request->delivery_date . ' ' . $time;

        $invoice = new_quotations::leftjoin('quotes', 'quotes.id', '=', 'new_quotations.quote_request_id')->leftjoin('new_quotations_data', 'new_quotations_data.quotation_id', '=', 'new_quotations.id')->leftjoin('users','users.id','=','new_quotations.creator_id')->where('new_quotations.id', $request->invoice_id)->where('quotes.user_id', $user_id)->select('new_quotations_data.*', 'new_quotations.created_at', 'new_quotations.quote_request_id as quote_id','new_quotations.description as other_info', 'new_quotations.tax_amount as tax', 'new_quotations.grand_total', 'new_quotations.quotation_invoice_number', 'users.compressed_photo', 'users.quotation_prefix', 'users.name', 'users.family_name', 'users.company_name','users.address','users.postcode','users.city','users.tax_number','users.registration_number','users.email','users.phone')->get();

        if (count($invoice) == 0) {
            return 'false';
        }

        if($request->change_address == 1)
        {
            quotes::where('id', $invoice[0]->quote_id)->update(['status' => 2,'quote_delivery' => $delivery_date,'quote_zipcode' => $request->delivery_address,'quote_postcode' => $request->postcode,'quote_city' => $request->city]);

            if($request->update == 1)
            {
                User::where('id',$user_id)->update(['address' => $request->delivery_address,'postcode' => $request->postcode,'city' => $request->city]);
            }
        }
        else
        {
            quotes::where('id', $invoice[0]->quote_id)->update(['status' => 2, 'quote_delivery' => $delivery_date]);
        }

        $quote = quotes::leftjoin('categories','categories.id','=','quotes.quote_service')->leftjoin('brands','brands.id','=','quotes.quote_brand')->leftjoin('product_models','product_models.id','=','quotes.quote_model')->leftjoin('models','models.id','=','quotes.quote_type')->leftjoin('colors','colors.id','=','quotes.quote_color')->leftjoin('services','services.id','=','quotes.quote_service1')->leftjoin('users','users.id','=','quotes.user_id')->where('quotes.id',$invoice[0]->quote_id)->select('quotes.*','categories.cat_name','services.title','brands.cat_name as brand_name','product_models.model as model_name','models.cat_name as type_title','colors.title as color','users.postcode','users.city','users.address')->first();

        $quotation_invoice_number = $invoice[0]->quotation_invoice_number;
        $filename = $quotation_invoice_number . '.pdf';
        $service_fee = $this->gs->service_fee;

        new_quotations::where('id', $request->invoice_id)->update(['service_fee' => $service_fee, 'status' => 2, 'ask_customization' => 0, 'accepted' => 1, 'accept_date' => $now, 'delivery_date' => $delivery_date]);

        $request = new_quotations::where('id', $request->invoice_id)->with('data')->first();
        $user = $invoice[0];
        $client = '';

        $request->products = $request->data;
        $request->retailer_delivery_date = $request->delivery_date;
        $request->total_amount = $request->grand_total;

        foreach ($request->products as $i => $key) {

            $total_discount[$i] = str_replace('.', ',',$key->total_discount);
            $request->total_discount = $total_discount;

            $rate[$i] = $key->rate;
            $request->rate = $rate;

            $qty[$i] = str_replace('.', ',',$key->qty);
            $request->qty = $qty;

            $total[$i] = $key->total;
            $request->total = $total;

            $measure[$i] = $key->measure;
            $request->measure = $measure;

            if ($key->item_id != 0) {

                $product_titles[] = items::where('id',$key->item_id)->pluck('cat_name')->first();
                $color_titles[] = '';
                $model_titles[] = '';

            }
            elseif ($key->service_id != 0) {

                $product_titles[] = Service::where('id',$key->service_id)->pluck('title')->first();
                $color_titles[] = '';
                $model_titles[] = '';

            }
            else
            {
                $product_titles[] = product::where('id',$key->product_id)->pluck('title')->first();
                $color_titles[] = colors::where('id',$key->color)->pluck('title')->first();
                $model_titles[] = product_models::where('id',$key->model_id)->pluck('model')->first();
            }

            $calculations[$i] = $key->calculations()->get();
            $request->calculations = $calculations;

            if($key->item_id != 0)
            {
                $request->products[$i] = $key->item_id . 'I';
            }
            elseif($key->service_id != 0)
            {
                $request->products[$i] = $key->service_id . 'S';
            }
            else
            {
                $request->products[$i] = $key->product_id;
            }
        }

        ini_set('max_execution_time', 180);

        $date = $invoice[0]->created_at;
        $role = 'retailer';
        $form_type = 1;
        $re_edit = 1;

        $pdf = PDF::loadView('user.pdf_new_quotation_1', compact('re_edit','form_type','role','product_titles','color_titles','model_titles','date','client','user','request','quotation_invoice_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 160,'isRemoteEnabled' => true]);
        $file = public_path() . '/assets/newQuotations/' . $filename;
        $pdf->save($file);

        $q_a = requests_q_a::where('request_id',$quote->id)->get();

        $quote_number = $quote->quote_number;

        $filename = $quote_number.'.pdf';

        $role = 3;

        ini_set('max_execution_time', 180);

        $pdf = PDF::loadView('admin.user.pdf_quote',compact('delivery_date','quote','q_a','role'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140,'isRemoteEnabled' => true]);

        $pdf->save(public_path().'/assets/adminQuotesPDF/'.$filename);

        $role = 2;

        $pdf = PDF::loadView('admin.user.pdf_quote',compact('delivery_date','quote','q_a','role'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140,'isRemoteEnabled' => true]);

        $pdf->save(public_path().'/assets/quotesPDF/'.$filename);

        $retailer_email = $invoice[0]->email;
        $user_name = $invoice[0]->name;

        $link = url('/') . '/aanbieder/dashboard';

        if($this->lang->lang == 'du')
        {
            $msg = "Beste " . $user_name . ",<br><br>Gefeliciteerd de klant heeft je offerte geaccepteerd QUO# " . $invoice[0]->quotation_invoice_number . "<br>Zodra, de klant het volledig bedrag heeft voldaan ontvang je de contactgegevens, bezorgadres en bezorgmoment. Je ontvang van ons een mail als de klant heeft betaald, tot die tijd adviseren we je de goederen nog niet te leveren. <a href='" . $link . "'>Klik hier</a> om naar je dashboard te gaan.<br><br>Met vriendelijke groeten,<br><br>Vloerofferte";
        }
        else
        {
            $msg = "Congratulations! Dear Mr/Mrs " . $user_name . ",<br><br>Your quotation QUO# " . $invoice[0]->quotation_invoice_number . " has been accepted by your client.<br>You can convert your quotation into invoice once job is completed,<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
        }

        \Mail::send(array(), array(), function ($message) use ($msg, $retailer_email, $user_name, $invoice) {
            $message->to($retailer_email)
                ->from('info@vloerofferte.nl')
                ->subject(__('text.Quotation Accepted!'))
                ->setBody($msg, 'text/html');
        });


        $admin_email = $this->sl->admin_email;

        \Mail::send(array(), array(), function ($message) use ($admin_email, $user_name, $invoice) {
            $message->to($admin_email)
                ->from('info@vloerofferte.nl')
                ->subject('Quotation Accepted!')
                ->setBody("A quotation QUO# " . $invoice[0]->quotation_invoice_number . " has been accepted.<br>Retailer: " . $user_name . "<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
        });

        return 'true';
    }


    public function PayQuotation($data,$pay_invoice_id,$language,$user_id)
    {
        $quote_id = $data->id;
        $retailer_id = $data->creator_id;
        $quotation_invoice_number = $data->quotation_invoice_number;

        $total_mollie = number_format((float)$data->grand_total, 2, '.', '');
        $settings = Generalsetting::where('backend',1)->first();
        $description = 'Payment for Quotation No. ' . $quotation_invoice_number;

        $inv_encrypt = Crypt::encrypt($pay_invoice_id);
        $commission_percentage = $settings->commission_percentage;
        $commission = $total_mollie * ($commission_percentage/100);
        $commission = number_format((float)$commission, 2, '.', '');
//        $commission_vat = ($commission/(21 + 100)) * 100;
//        $commission_vat = $commission - $commission_vat;

        $total_receive = $total_mollie - $commission;
        $total_receive = number_format((float)$total_receive, 2, '.', '');

        $commission_invoice_number = explode('-',  $quotation_invoice_number);
        unset($commission_invoice_number[1]);
        $commission_invoice_number = implode("-",$commission_invoice_number);
        $vloerofferte_url = Generalsetting::where('backend',0)->pluck('site')->first();

        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey($settings->mollie);
        $payment = $mollie->payments->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => $total_mollie, // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            'description' => $description,
            'webhookUrl' => route('webhooks.quotation_payment'),
            'redirectUrl' => $vloerofferte_url.'aanbieder/quotation-payment-redirect-page/' . $inv_encrypt,
            "metadata" => [
                "invoice_id" => $pay_invoice_id,
                "quote_id" => $quote_id,
                "retailer_id" => $retailer_id,
                "quotation_invoice_number" => $quotation_invoice_number,
                "commission_invoice_number" => $commission_invoice_number,
                "paid_amount" => $total_mollie,
                "commission_percentage" => $commission_percentage,
                "commission" => $commission,
                "total_receive" => $total_receive,
                "language" => $language,
                "user_id" => $user_id
            ],
        ]);

        return redirect($payment->getCheckoutUrl(), 303);
    }



    public function CustomQuotationAcceptQuotation($id)
    {

        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;

        $invoice = custom_quotations::leftjoin('users', 'users.id', '=', 'custom_quotations.handyman_id')->where('custom_quotations.id', $id)->where('custom_quotations.user_id', $user_id)->where('custom_quotations.status',1)->first();

        if (!$invoice) {
            return redirect()->back();
        }


        custom_quotations::where('id', $id)->update(['status' => 2, 'ask_customization' => 0, 'accepted' => 1]);

        $handyman_email = $invoice->email;
        $user_name = $invoice->name;

        \Mail::send(array(), array(), function ($message) use ($handyman_email, $user_name, $invoice, $user) {
            $message->to($handyman_email)
                ->from('info@vloerofferte.nl')
                ->subject(__('text.Quotation Accepted!'))
                ->setBody("Congratulations! Dear Mr/Mrs " . $user_name . ",<br><br>Mr/Mrs " . $user->name . " has accepted your quotation QUO# " . $invoice->quotation_invoice_number . "<br>You can convert your quotation into invoice once job is completed,<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
        });


        /*$admin_email = $this->sl->admin_email;

        \Mail::send(array(), array(), function ($message) use($admin_email,$user_name,$invoice,$user) {
            $message->to($admin_email)
                ->from('info@vloerofferte.nl')
                ->subject('Quotation Accepted!')
                ->setBody("A quotation QUO# ".$invoice->quotation_invoice_number." has been accepted by Mr/Mrs ".$user->name.' '.$user->family_name."<br>Handyman: ".$user_name."<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
        });*/

        Session::flash('success', __('text.Quotation accepted successfully!'));

        return redirect()->back();
    }

    public function AcceptNewQuotationMail($id)
    {
        $id = Crypt::decrypt($id);

        $invoice = new_quotations::leftjoin('users', 'users.id', '=', 'new_quotations.creator_id')->where('new_quotations.id', $id)->where('new_quotations.status',1)->first();

        if (!$invoice) {
            return redirect()->route('front.index');
        }

        new_quotations::where('id', $id)->update(['status' => 2, 'ask_customization' => 0, 'accepted' => 1]);

        $creator_email = $invoice->email;
        $creator_name = $invoice->name;

        \Mail::send(array(), array(), function ($message) use ($creator_email, $creator_name, $invoice) {
            $message->to($creator_email)
                ->from('info@pieppiep.com')
                ->subject(__('text.Quotation Accepted!'))
                ->setBody("Congratulations! Dear Mr/Mrs " . $creator_name . ",<br><br> Quotation QUO# " . $invoice->quotation_invoice_number . " has been accepted.<br><br>Kind regards,<br><br>Klantenservice<br><br> Pieppiep", 'text/html');
        });

        return view('front.thankyou1');
    }

    public function AcceptNewQuotation($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;

        if($user_role == 2)
        {
            $main_id = $user->main_id;

            if($main_id)
            {
                $user = User::where('id',$main_id)->first();
                $user_id = $user->id;
            }

            $invoice = new_quotations::leftjoin('users', 'users.id', '=', 'new_quotations.user_id')->leftjoin('customers_details', 'customers_details.id', '=', 'new_quotations.customer_details')->where('new_quotations.id', $id)->where('new_quotations.creator_id', $user_id)->where('new_quotations.status',1)->select('users.email','customers_details.name','customers_details.family_name')->first();

            if (!$invoice) {
                return redirect()->back();
            }

            new_quotations::where('id', $id)->update(['status' => 2, 'ask_customization' => 0, 'accepted' => 1]);

            $client_email = $invoice->email;
            $client_name = $invoice->name . ' ' . $invoice->family_name;

            \Mail::send(array(), array(), function ($message) use ($client_email, $client_name, $invoice, $user) {
                $message->to($client_email)
                    ->from('info@pieppiep.com')
                    ->subject(__('text.Quotation Accepted!'))
                    ->setBody("Hi " . $client_name . ",<br><br><b>" . $user->company_name . "</b> has accepted Quotation: <b>" . $invoice->quotation_invoice_number . "</b> on your behalf.<br><br>Kind regards,<br><br>Klantenservice<br><br> Pieppiep", 'text/html');
            });
        }
        else
        {
            $invoice = new_quotations::leftjoin('users', 'users.id', '=', 'new_quotations.creator_id')->where('new_quotations.id', $id)->where('new_quotations.user_id', $user_id)->where('new_quotations.status',1)->first();

            if (!$invoice) {
                return redirect()->back();
            }

            new_quotations::where('id', $id)->update(['status' => 2, 'ask_customization' => 0, 'accepted' => 1]);

            $creator_email = $invoice->email;
            $creator_name = $invoice->name;

            \Mail::send(array(), array(), function ($message) use ($creator_email, $creator_name, $invoice, $user) {
                $message->to($creator_email)
                    ->from('info@pieppiep.com')
                    ->subject(__('text.Quotation Accepted!'))
                    ->setBody("Congratulations! Dear Mr/Mrs " . $creator_name . ",<br><br>Mr/Mrs " . $user->name . " has accepted your quotation QUO# " . $invoice->quotation_invoice_number . "<br><br>Kind regards,<br><br>Klantenservice<br><br> Pieppiep", 'text/html');
            });


            /*$admin_email = $this->sl->admin_email;

            \Mail::send(array(), array(), function ($message) use($admin_email,$user_name,$invoice,$user) {
                $message->to($admin_email)
                    ->from('info@pieppiep.nl')
                    ->subject('Quotation Accepted!')
                    ->setBody("A quotation QUO# ".$invoice->quotation_invoice_number." has been accepted by Mr/Mrs ".$user->name.' '.$user->family_name."<br>Handyman: ".$user_name."<br><br>Kind regards,<br><br>Klantenservice<br><br> Pieppiep", 'text/html');
            });*/
        }

        Session::flash('success', __('text.Quotation accepted successfully!'));

        return redirect()->back();
    }

    public function HandymanQuoteRequest($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('handyman-quote-request'))
        {
            $request = quotes::leftjoin('categories', 'categories.id', '=', 'quotes.quote_service')->leftjoin('brands', 'brands.id', '=', 'quotes.quote_brand')->leftjoin('product_models', 'product_models.id', '=', 'quotes.quote_model')->leftjoin('models', 'models.id', '=', 'quotes.quote_type')->leftjoin('colors', 'colors.id', '=', 'quotes.quote_color')->leftjoin('services','services.id','=','quotes.quote_service1')->where('quotes.id', $id)->select('quotes.*', 'categories.cat_name','services.title','brands.cat_name as brand_name','product_models.model as model_name','models.cat_name as type_title','colors.title as color')->first();

            $q_a = requests_q_a::where('request_id', $id)->get();

            $invoice = quotation_invoices::where('quote_id', $request->id)->where('handyman_id', $user_id)->first();

            $products = Products::all();

            return view('user.quote_request', compact('request', 'products', 'invoice', 'q_a'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function HandymanCreateQuote($id = NULL)
    {
        if($id)
        {
            $request_id = Crypt::decrypt($id);
            $quote = quotes::where('id',$request_id)->first();
            $quote_qty = $quote->quote_qty;

            if($quote->quote_service)
            {
                $model = product_models::where('id',$quote->quote_model)->pluck('model')->first();
                $color = colors::where('id',$quote->quote_color)->pluck('title')->first();
                $product_request = Products::leftjoin('product_models','product_models.product_id','=','products.id')->leftjoin('colors','colors.product_id','=','products.id')->leftjoin('users','users.id','=','products.user_id')->where('product_models.model',$model)->where('colors.title',$color)->where('products.sub_category_id',$quote->quote_service)->where('products.brand_id',$quote->quote_brand)->where('products.model_id',$quote->quote_type)->select('products.*','users.id as supplier_id','users.company_name','product_models.id as model_id','product_models.model','product_models.measure','product_models.estimated_price_per_box','product_models.estimated_price_quantity','product_models.estimated_price','product_models.max_width','colors.id as color_id','colors.title as color')->first();
            }
            else
            {
                $product_request = Service::leftjoin('retailer_services','retailer_services.service_id','=','services.id')->where('services.id',$quote->quote_service1)->select('services.*','retailer_services.sell_rate')->first();
            }
        }
        else
        {
            $request_id = '';
            $product_request = '';
            $quote = '';
            $quote_qty = '';
        }

        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;
        $check = 0;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
            $user_id = $user->id;
        }

        if(\Route::currentRouteName() == 'create-custom-quotation')
        {
            if($user->can('create-custom-quotation'))
            {
                $check = 1;
            }
        }

        if(\Route::currentRouteName() == 'create-direct-invoice')
        {
            if($user->can('create-direct-invoice'))
            {
                $check = 1;
            }
        }

        if($check)
        {
            if ($user_role == 2) {

                // $all_products = Products::leftjoin('handyman_products', 'handyman_products.product_id', '=', 'products.id')->leftjoin('categories', 'categories.id', '=', 'products.category_id')->where('handyman_products.handyman_id', $user_id)->select('products.*','categories.cat_name','handyman_products.sell_rate as rate')->get();
                // $all_services = Service::leftjoin('handyman_services', 'handyman_services.service_id', '=', 'services.id')->where('handyman_services.handyman_id', $user_id)->select('services.*','handyman_services.sell_rate as rate')->get();
                // $items = items::where('user_id',$user_id)->get();

                // $settings = Generalsetting::findOrFail(1);

                // $vat_percentage = $settings->vat;
                // $customers = User::where('parent_id', $user_id)->get();

                $customers = customers_details::where('retailer_id', $user_id)->get();
                $floor_category_id = Category::where('cat_name','LIKE', '%Floors%')->orWhere('cat_name','LIKE', '%Vloeren%')->pluck('id')->first();
                $suppliers = User::leftjoin('retailers_requests','retailers_requests.retailer_id','=','users.id')->leftjoin('supplier_categories','supplier_categories.user_id','=','retailers_requests.supplier_id')->where('supplier_categories.category_id',$floor_category_id)->where('users.id',$user_id)->where('retailers_requests.status',1)->where('retailers_requests.active',1)->pluck('retailers_requests.supplier_id');
                $products = products::leftjoin('users','users.id','=','products.user_id')->whereIn('products.user_id',$suppliers)->where('products.category_id',$floor_category_id)->with('colors')->with('models')->select('products.*','users.name','users.family_name','users.company_name')->get();
                $services = Service::leftjoin('retailer_services', 'retailer_services.service_id', '=', 'services.id')->where('retailer_services.retailer_id', $user_id)->select('services.*','retailer_services.sell_rate as rate')->get();
                $items = items::leftjoin('categories','categories.id','=','items.category_id')->where('items.user_id',$user_id)->select('items.*','categories.cat_name as category')->get();

                return view('user.create_custom_quote1', compact('products','customers','suppliers','user','services','items','request_id','product_request','quote_qty','quote'));
            } else {
                return redirect()->back();
            }
        }
        else
        {
            return redirect()->route('user-login');
        }

    }

    public function Customers()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('customers'))
        {
            $customers = customers_details::leftjoin('users','users.id','=','customers_details.user_id')->where('customers_details.retailer_id',$user_id)->select('customers_details.*','users.email')->get();

            return view('user.customers',compact('customers'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function Employees()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $role_id = $user->role_id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('employees'))
        {
            if($role_id == 2)
            {
                $employees = User::with('permissions')->where('role_id',2)->where('main_id',$user_id)->where('id','!=',$user->id)->get();
            }
            else
            {
                $employees = User::with('permissions')->where('role_id',4)->where('main_id',$user_id)->where('id','!=',$user->id)->get();
            }

            return view('user.employees',compact('employees'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function EmployeePermissions($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($user->can('employee-permissions'))
        {

            if(!$main_id)
            {
                $main_id = $user_id;
            }

            if($user_id != $id)
            {
                $permissions = Permission::all();
                $user = User::with('permissions')->where('id',$id)->where('main_id',$main_id)->first();

                if($user)
                {
                    return view('user.employee_permission',compact('permissions','user'));
                }
                else
                {
                    return redirect()->route('user-dashboard');
                }
            }
            else
            {
                return redirect()->route('user-dashboard');
            }
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function EmployeePermissionStore(Request $request)
    {
        $user = User::find($request->user_id);

        $user->syncPermissions($request->permissions);

        Session::flash('success', 'Permission(s) assigned successfully');
        return redirect()->route('employee-permissions',$request->user_id);
    }

    public function CreateCustomerForm()
    {
        $user = Auth::guard('user')->user();

        if($user->can('handyman-user-create'))
        {
            return view('user.create_customer');
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function CreateEmployeeForm()
    {
        $user = Auth::guard('user')->user();

        if($user->can('employee-create'))
        {
            return view('user.create_employee');
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function EditCustomer($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($user->can('edit-customer'))
        {

            if($main_id)
            {
                $user_id = $main_id;
            }

            $customer = customers_details::leftjoin('users','users.id','=','customers_details.user_id')->where('customers_details.user_id',$id)->where('customers_details.retailer_id', $user_id)->select('customers_details.*','users.email')->first();

            if($customer)
            {
                return view('user.create_customer',compact('customer'));
            }
            else
            {
                return redirect()->route('user-dashboard');
            }
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function EditEmployee($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($user->can('edit-employee'))
        {
            if(!$main_id)
            {
                $main_id = $user_id;
            }

            if($user_id != $id)
            {
                $employee = User::where('id',$id)->where('main_id',$main_id)->first();

                if($employee)
                {
                    return view('user.create_employee',compact('employee'));
                }
                else
                {
                    return redirect()->route('user-dashboard');
                }
            }
            else
            {
                return redirect()->route('user-dashboard');
            }
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function DeleteCustomer($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($user->can('delete-customer'))
        {
            if($main_id)
            {
                $user_id = $main_id;
            }

            $delete = customers_details::where('user_id',$id)->where('retailer_id',$user_id)->delete();

            if($delete)
            {
                Session::flash('success', __('text.Customer deleted successfully'));
                return redirect()->route('customers');
            }
            else
            {
                return redirect()->route('user-dashboard');
            }
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function DeleteEmployee($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($user->can('delete-employee'))
        {
            if(!$main_id)
            {
                $main_id = $user_id;
            }

            if($user_id != $id)
            {
                $delete = User::where('id',$id)->where('main_id',$main_id)->delete();

                if($delete)
                {
                    Session::flash('success', 'Employee deleted successfully');
                    return redirect()->route('employees');
                }
                else
                {
                    return redirect()->route('user-dashboard');
                }
            }
            else
            {
                return redirect()->route('user-dashboard');
            }
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function PostCustomer(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($request->org_id)
        {
            customers_details::where('id',$request->org_id)->update(['name' => $request->name, 'family_name' => $request->family_name, 'business_name' => $request->business_name, 'address' => $request->address, 'postcode' => $request->postcode, 'city' => $request->city, 'phone' => $request->phone, 'email' => $request->email]);

            Session::flash('success', 'Customer details updated successfully');
            return redirect()->route('customers');
        }
        else
        {
            $check = User::where('email',$request->email)->first();

            if($check)
            {

                if($check->role_id == 3)
                {
                    if($check->parent_id == $user_id)
                    {
                        Session::flash('unsuccess', __('text.User already created'));
                        return redirect()->route('customers');
                    }
                    else
                    {
                        $check1 = customers_details::where('user_id',$check->id)->where('retailer_id',$user_id)->first();

                        if($check1)
                        {
                            Session::flash('unsuccess', 'This email is already linked with your customer account. Kindly update that specific account from customers page.');
                            return redirect()->route('customers');
                        }
                        else
                        {
                            $details = new customers_details();

                            $details->user_id = $check->id;
                            $details->retailer_id = $user_id;
                            $details->name = $request->name;
                            $details->family_name = $request->family_name;
                            $details->business_name = $request->business_name;
                            $details->postcode = $request->postcode;
                            $details->address = $request->address;
                            $details->city = $request->city;
                            $details->phone = $request->phone;
                            $details->save();

                            Session::flash('success', 'Customer account created successfully');
                            return redirect()->route('customers');
                        }
                    }
                }
                else
                {
                    Session::flash('unsuccess', 'This email address is already taken');
                    return redirect()->route('customers');
                }
            }
            else
            {
                $user_name = $request->name;
                $user_email = $request->email;

                $retailer = User::where('id',$user_id)->first();
                $retailer_name = $retailer->name;
                $company_name = $retailer->company_name;

                $org_password = Str::random(8);
                $password = Hash::make($org_password);

                $user = new User;
                $user->category_id = 20;
                $user->role_id = 3;
                $user->password = $password;
                $user->name = $request->name;
                $user->family_name = $request->family_name;
                $user->business_name = $request->business_name;
                $user->address = $request->address;
                $user->postcode = $request->postcode;
                $user->city = $request->city;
                $user->phone = $request->phone;
                $user->email = $request->email;
                $user->parent_id = $user_id;
                $user->allowed = 0;
                $user->save();

                $details = new customers_details();
                $input = $request->all();

                $details->user_id = $user->id;
                $details->retailer_id = $user_id;
                $details->name = $request->name;
                $details->family_name = $request->family_name;
                $details->business_name = $request->business_name;
                $details->postcode = $request->postcode;
                $details->address = $request->address;
                $details->city = $request->city;
                $details->phone = $request->phone;
                $details->save();

                $input['id'] = $user->id;

                $link = url('/') . '/aanbieder/client-new-quotations';

                if($this->lang->lang == 'du')
                {
                    $msg = "Beste $user_name,<br><br>Er is een account voor je gecreëerd door " . $retailer_name . ". Hier kan je offertes bekijken, verzoek tot aanpassen of de offerte accepteren. <a href='" . $link . "'>Klik hier</a>, om je naar je persoonlijke dashboard te gaan.<br><br><b>Wachtwoord:</b><br><br>Je wachtwoord is: " . $org_password . "<br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br>$company_name";
                }
                else
                {
                    $msg = "Dear Mr/Mrs " . $user_name . ",<br><br>Your account has been created by retailer " . $retailer_name . " for quotations. Kindly complete your profile and change your password. You can go to your dashboard through <a href='" . $link . "'>here.</a><br><br>Your Password: " . $org_password . "<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte<br><br>$company_name";
                }

                \Mail::send(array(), array(), function ($message) use ($msg, $user_email, $user_name, $retailer_name, $link, $org_password) {
                    $message->to($user_email)
                        ->from('info@vloerofferte.nl')
                        ->subject(__('text.Account Created!'))
                        ->setBody($msg, 'text/html');
                });

                Session::flash('success', 'Customer account created successfully');
                return redirect()->route('customers');
            }
        }
    }

    public function PostEmployee(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $role_id = $user->role_id;
        $company_name = $user->company_name;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($request->emp_id)
        {

            if($request->password)
            {
                $this->validate($request, [
                    'email' => [
                        'required',
                        'string',
                        'email',
                        Rule::unique('users')->where(function($query) use($request) {
                            $query->where('allowed', '=', '1')->where('deleted_at', NULL)->where('id', '!=', $request->emp_id);
                        })
                    ],
                    'name'   => 'required|regex:/(^[A-Za-z ]+$)+/|max:15',
                    'family_name' => 'required|regex:/(^[A-Za-z ]+$)+/|max:15',
                    /*'company_name' => 'required',*/
                    'registration_number' => 'required',
                    'postcode' => 'required',
                    'city' => 'required',
                    /*'bank_account' => 'required',*/
                    /*'tax_number' => 'required',*/
                    'address' => 'required',
                    'phone' => 'required',
                    'password' => 'required|min:8|confirmed',
                ],

                    [
                        'email.required' => $this->lang->erv,
                        'email.unique' => $this->lang->euv,
                        'name.required' => $this->lang->nrv,
                        'name.max' => $this->lang->nmv,
                        'name.regex' => $this->lang->niv,
                        'family_name.required' => $this->lang->fnrv,
                        'family_name.max' => $this->lang->fnmrv,
                        'family_name.regex' => $this->lang->fniv,
                        /*'company_name.required' => $this->lang->cnrv,*/
                        'registration_number.required' => $this->lang->rnrv,
                        /*'bank_account.required' => $this->lang->barv,
                        'tax_number.required' => $this->lang->tnrv,*/
                        'postcode.required' => $this->lang->pcrv,
                        'city.required' => $this->lang->crv,
                        'address.required' => $this->lang->arv,
                        'phone.required' => $this->lang->prv,
                        'password.required' => $this->lang->parv,
                        'password.min' => $this->lang->pamv,
                        'password.confirmed' => $this->lang->pacv,
                    ]);

                User::where('id',$request->emp_id)->update(['name' => $request->name, 'family_name' => $request->family_name, 'registration_number' => $request->registration_number, 'company_name' => $company_name, 'address' => $request->address, 'postcode' => $request->postcode, 'city' => $request->city, 'phone' => $request->phone, 'email' => $request->email, 'password' => bcrypt($request['password'])]);
            }
            else
            {
                $this->validate($request, [
                    'email' => [
                        'required',
                        'string',
                        'email',
                        Rule::unique('users')->where(function($query) use($request) {
                            $query->where('allowed', '=', '1')->where('deleted_at', NULL)->where('id', '!=', $request->emp_id);
                        })
                    ],
                    'name'   => 'required|regex:/(^[A-Za-z ]+$)+/|max:15',
                    'family_name' => 'required|regex:/(^[A-Za-z ]+$)+/|max:15',
                    /*'company_name' => 'required',*/
                    'registration_number' => 'required',
                    'postcode' => 'required',
                    'city' => 'required',
                    /*'bank_account' => 'required',*/
                    /*'tax_number' => 'required',*/
                    'address' => 'required',
                    'phone' => 'required',
                ],

                    [
                        'email.required' => $this->lang->erv,
                        'email.unique' => $this->lang->euv,
                        'name.required' => $this->lang->nrv,
                        'name.max' => $this->lang->nmv,
                        'name.regex' => $this->lang->niv,
                        'family_name.required' => $this->lang->fnrv,
                        'family_name.max' => $this->lang->fnmrv,
                        'family_name.regex' => $this->lang->fniv,
                        /*'company_name.required' => $this->lang->cnrv,*/
                        'registration_number.required' => $this->lang->rnrv,
                        /*'bank_account.required' => $this->lang->barv,
                        'tax_number.required' => $this->lang->tnrv,*/
                        'postcode.required' => $this->lang->pcrv,
                        'city.required' => $this->lang->crv,
                        'address.required' => $this->lang->arv,
                        'phone.required' => $this->lang->prv,
                    ]);

                User::where('id',$request->emp_id)->update(['name' => $request->name, 'family_name' => $request->family_name, 'registration_number' => $request->registration_number, 'company_name' => $company_name, 'address' => $request->address, 'postcode' => $request->postcode, 'city' => $request->city, 'phone' => $request->phone, 'email' => $request->email]);
            }


            Session::flash('success', 'Employee information updated successfully');
            return redirect()->route('employees');
        }
        else
        {

            $this->validate($request, [
                'email' => [
                    'required',
                    'string',
                    'email',
                    Rule::unique('users')->where(function($query) {
                        $query->where('allowed', '=', '1')->where('deleted_at', NULL);
                    })
                ],
                'name'   => 'required|regex:/(^[A-Za-z ]+$)+/|max:15',
                'family_name' => 'required|regex:/(^[A-Za-z ]+$)+/|max:15',
                /*'company_name' => 'required',*/
                'registration_number' => 'required',
                'postcode' => 'required',
                'city' => 'required',
                /*'bank_account' => 'required',*/
                /*'tax_number' => 'required',*/
                'address' => 'required',
                'phone' => 'required',
                'password' => 'required|min:8|confirmed',
            ],

                [
                    'email.required' => $this->lang->erv,
                    'email.unique' => $this->lang->euv,
                    'name.required' => $this->lang->nrv,
                    'name.max' => $this->lang->nmv,
                    'name.regex' => $this->lang->niv,
                    'family_name.required' => $this->lang->fnrv,
                    'family_name.max' => $this->lang->fnmrv,
                    'family_name.regex' => $this->lang->fniv,
                    /*'company_name.required' => $this->lang->cnrv,*/
                    'registration_number.required' => $this->lang->rnrv,
                    /*'bank_account.required' => $this->lang->barv,
                    'tax_number.required' => $this->lang->tnrv,*/
                    'postcode.required' => $this->lang->pcrv,
                    'city.required' => $this->lang->crv,
                    'address.required' => $this->lang->arv,
                    'phone.required' => $this->lang->prv,
                    'password.required' => $this->lang->parv,
                    'password.min' => $this->lang->pamv,
                    'password.confirmed' => $this->lang->pacv,
                ]);


            $user = new User;
            $user->category_id = $request->category_id;
            $user->role_id = $role_id;
            $user->password = bcrypt($request['password']);
            $user->name = $request->name;
            $user->family_name = $request->family_name;
            $user->registration_number = $request->registration_number;
            $user->company_name = $company_name;
            $user->address = $request->address;
            $user->postcode = $request->postcode;
            $user->city = $request->city;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->main_id = $user_id;
            $user->status = 1;
            $user->active = 0;
            $user->is_featured = 1;
            $user->featured = 0;
            $user->save();

            $check_permission = Permission::where('name','=','show-dashboard')->first();

            if($check_permission)
            {
                $user->givePermissionTo('show-dashboard');
            }
            else
            {
                Permission::create(['guard_name' => 'user', 'name' => 'show-dashboard']);
                $user->givePermissionTo('show-dashboard');
            }

            Session::flash('success', 'Employee created successfully!');
            return redirect()->route('employees');
        }
    }

    public function InstructionManual()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;

        if ($user->role_id == 3) {
            return redirect()->route('user-login');
        }


        if($user->can('instruction-manual'))
        {
            $data = instruction_manual::first();

            return view('user.instruction_manual',compact('data'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function CreateCustomer(Request $request)
    {
        /*$this->validate($request, [
            'password' => 'required|min:8',
        ],

            [
                'password.min' => $this->lang->pamv,

            ]);*/

        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;
        $input = $request->all();

        if($main_id)
        {
            $user_id = $main_id;
        }

        $flag = 0;
        $flag1 = 0;
        $check = User::where('email', $request->email)->first();

        if ($check) {

            /*if($check->role_id == 3)
            {
                $check1 = customers_details::where('user_id',$check->id)->where('retailer_id',$user_id)->first();

                if($check1)
                {
                    $response = array('data' => $check, 'message' => __('text.User already created'));
                    return $response;
                }
                else
                {
                    $flag1 = 1;
                }
            }
            else
            {
                $response = array('data' => $check, 'message' => 'This email address is already taken');
                return $response;
            }*/

            $check1 = customers_details::where('user_id',$check->id)->where('retailer_id',$user_id)->first();

            if($check1)
            {
                $response = array('data' => $check, 'message' => __('text.User already created'));
                return $response;
            }
            else
            {
                $flag1 = 1;
            }

        }
        else
        {
            $flag = 1;
        }

        if($flag)
        {
            $user = new User;

            $user_name = $request->name;
            $user_email = $request->email;

            $retailer = User::where('id',$user_id)->first();
            $retailer_name = $retailer->name;
            $company_name = $retailer->company_name;

            $org_password = Str::random(8);
            $password = Hash::make($org_password);

            $user->role_id = 3;
            $user->category_id = 20;
            $user->name = $request->name;
            $user->family_name = $request->family_name;
            $user->business_name = $request->business_name;
            $user->postcode = $request->postcode;
            $user->address = $request->address;
            $user->city = $request->city;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = $password;
            $user->parent_id = $user_id;
            $user->allowed = 0;
            $user->save();

            $details = new customers_details();

            $details->user_id = $user->id;
            $details->retailer_id = $user_id;
            $details->name = $request->name;
            $details->family_name = $request->family_name;
            $details->business_name = $request->business_name;
            $details->postcode = $request->postcode;
            $details->address = $request->address;
            $details->city = $request->city;
            $details->phone = $request->phone;
            $details->save();

            $input['id'] = $details->id;

            $link = url('/') . '/aanbieder/client-new-quotations';

            if($this->lang->lang == 'du')
            {
                $msg = "Beste $user_name,<br><br>Er is een account voor je gecreëerd door " . $retailer_name . ". Hier kan je offertes bekijken, verzoek tot aanpassen of de offerte accepteren. <a href='" . $link . "'>Klik hier</a>, om je naar je persoonlijke dashboard te gaan.<br><br><b>Wachtwoord:</b><br><br>Je wachtwoord is: " . $org_password . "<br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br>$company_name";
            }
            else
            {
                $msg = "Dear Mr/Mrs " . $user_name . ",<br><br>Your account has been created by retailer " . $retailer_name . " for quotations. Kindly complete your profile and change your password. You can go to your dashboard through <a href='" . $link . "'>here.</a><br><br>Your Password: " . $org_password . "<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte<br><br>$company_name";
            }

            \Mail::send(array(), array(), function ($message) use ($msg, $user_email, $user_name, $retailer_name, $link, $org_password) {
                $message->to($user_email)
                    ->from('info@vloerofferte.nl')
                    ->subject(__('text.Account Created!'))
                    ->setBody($msg, 'text/html');
            });
        }

        if($flag1)
        {
            $details = new customers_details();

            $details->user_id = $check->id;
            $details->retailer_id = $user_id;
            $details->name = $request->name;
            $details->family_name = $request->family_name;
            $details->business_name = $request->business_name;
            $details->postcode = $request->postcode;
            $details->address = $request->address;
            $details->city = $request->city;
            $details->phone = $request->phone;
            $details->save();

            $input['id'] = $details->id;
        }

        $response = array('data' => $input, 'message' => __('text.New customer created successfully'));
        return $response;

    }

    public function GetCustomerEmail(Request $request)
    {
        $id = $request->id;
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;
        $req_type = $request->type;

        if($main_id)
        {
            $user_id = $main_id;
            $user = User::where('id',$main_id)->first();
        }

        if($request->customer_type == 0)
        {
            $data = new_quotations::leftjoin('quotes','quotes.id','=','new_quotations.quote_request_id')->where('new_quotations.id',$id)->select('new_quotations.*','quotes.quote_name as name','quotes.quote_email as email')->first();
        }
        else
        {
            $data = new_quotations::leftjoin('users','users.id','=','new_quotations.user_id')->where('new_quotations.id',$id)->select('new_quotations.*','users.name','users.email')->first();
        }

        if($req_type == 'quotation')
        {
            $mail_template = email_templates::where('type','quotation')->where('user_id',$user_id)->first();

            if(!$mail_template)
            {
                $mail_subject_template = 'Offerte: {offerte_nummer}';
                $mail_body_template = '<div class="OutlineElement Ltr  BCX0 SCXW193241479" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow: visible; cursor: text; clear: both; position: relative; direction: ltr; color: rgb(0, 0, 0); font-family: &quot;Segoe UI&quot;, &quot;Segoe UI Web&quot;, Arial, Verdana, sans-serif; font-size: 12px;"><p class="Paragraph SCXW193241479 BCX0" paraid="1734808987" paraeid="{d22048a8-261e-4878-810c-cb993567f9d4}{183}" style="margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none; color: windowtext;"><span data-contrast="none" xml:lang="NL-NL" lang="NL-NL" class="TextRun SCXW193241479 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-variant-ligatures: none !important; color: rgb(85, 85, 85); font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif;"><span class="NormalTextRun SCXW193241479 BCX0" data-ccp-parastyle="Normal (Web)" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent;">Beste {aan_voornaam},</span></span></p><p class="Paragraph SCXW193241479 BCX0" paraid="1734808987" paraeid="{d22048a8-261e-4878-810c-cb993567f9d4}{183}" style="margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none; color: windowtext;"><span data-contrast="none" xml:lang="NL-NL" lang="NL-NL" class="TextRun SCXW193241479 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-variant-ligatures: none !important; color: rgb(85, 85, 85); font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif;"><span class="NormalTextRun SCXW193241479 BCX0" data-ccp-parastyle="Normal (Web)" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent;"><br></span></span></p></div><div class="OutlineElement Ltr  BCX0 SCXW193241479" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow: visible; cursor: text; clear: both; position: relative; direction: ltr;"><p class="Paragraph SCXW193241479 BCX0" paraid="2025117577" paraeid="{d22048a8-261e-4878-810c-cb993567f9d4}{193}" style="font-family: &quot;Segoe UI&quot;, &quot;Segoe UI Web&quot;, Arial, Verdana, sans-serif; font-size: 12px; color: windowtext; margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none;"><span data-contrast="none" xml:lang="NL-NL" lang="NL-NL" class="TextRun SCXW193241479 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-variant-ligatures: none !important; color: rgb(85, 85, 85); font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif;"><span class="NormalTextRun SCXW193241479 BCX0" data-ccp-parastyle="Normal (Web)" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent;">Hierbij de offerte met offertenummer {offerte_nummer}.</span></span><span class="LineBreakBlob BlobObject DragDrop SCXW193241479 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-size: 12pt; line-height: 18px; font-family: WordVisiCarriageReturn_MSFontService, open_sansregular, open_sansregular_EmbeddedFont, sans-serif; color: rgb(85, 85, 85);"><span class="SCXW193241479 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; white-space: pre !important;">&nbsp;</span><br class="SCXW193241479 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; white-space: pre !important;"></span></p><p class="Paragraph SCXW193241479 BCX0" paraid="2025117577" paraeid="{d22048a8-261e-4878-810c-cb993567f9d4}{193}" style="margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none;"><br></p><p class="Paragraph SCXW193241479 BCX0" paraid="2025117577" paraeid="{d22048a8-261e-4878-810c-cb993567f9d4}{193}" style="margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none;"><span style="color: rgb(85, 85, 85); font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif; font-size: 16px; font-variant-ligatures: none;">{Click here to accept this quote directly online}</span><br></p></div><div class="OutlineElement Ltr  BCX0 SCXW193241479" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow: visible; cursor: text; clear: both; position: relative; direction: ltr; color: rgb(0, 0, 0); font-family: &quot;Segoe UI&quot;, &quot;Segoe UI Web&quot;, Arial, Verdana, sans-serif; font-size: 12px;"><p class="Paragraph SCXW193241479 BCX0" paraid="1287498014" paraeid="{d22048a8-261e-4878-810c-cb993567f9d4}{217}" style="margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none; color: windowtext;"><span style="color: rgb(85, 85, 85); font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif; font-size: 12pt;">&nbsp;</span></p></div><div class="OutlineElement Ltr  BCX0 SCXW193241479" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow: visible; cursor: text; clear: both; position: relative; direction: ltr; color: rgb(0, 0, 0); font-family: &quot;Segoe UI&quot;, &quot;Segoe UI Web&quot;, Arial, Verdana, sans-serif; font-size: 12px;"><p class="Paragraph SCXW193241479 BCX0" paraid="588099994" paraeid="{067a829f-0db6-4a3a-8ad2-66efb8a422c4}{36}" style="margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none; color: windowtext;"><span data-contrast="none" xml:lang="NL-NL" lang="NL-NL" class="TextRun SCXW193241479 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-variant-ligatures: none !important; color: rgb(85, 85, 85); font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif;">Met vriendelijke groet,</span><span class="LineBreakBlob BlobObject DragDrop SCXW193241479 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-size: 12pt; line-height: 18px; font-family: WordVisiCarriageReturn_MSFontService, open_sansregular, open_sansregular_EmbeddedFont, sans-serif; color: rgb(85, 85, 85);"><span class="SCXW193241479 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; white-space: pre !important;">&nbsp;</span><br class="SCXW193241479 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; white-space: pre !important;"></span><span data-contrast="none" xml:lang="NL-NL" lang="NL-NL" class="TextRun SCXW193241479 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-variant-ligatures: none !important; color: rgb(85, 85, 85); font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif;"><span class="NormalTextRun SCXW193241479 BCX0" data-ccp-parastyle="Normal (Web)" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent;">{van_voornaam}</span></span><span class="LineBreakBlob BlobObject DragDrop SCXW193241479 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-size: 12pt; line-height: 18px; font-family: WordVisiCarriageReturn_MSFontService, open_sansregular, open_sansregular_EmbeddedFont, sans-serif; color: rgb(85, 85, 85);"><br class="SCXW193241479 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; white-space: pre !important;"></span><span data-contrast="none" xml:lang="NL-NL" lang="NL-NL" class="TextRun SCXW193241479 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-variant-ligatures: none !important; color: rgb(85, 85, 85); font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif;"><span class="NormalTextRun SCXW193241479 BCX0" data-ccp-parastyle="Normal (Web)" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent;">{van_bedrijfsnaam}</span></span></p></div>';
            }
            else
            {
                $mail_subject_template = $mail_template->subject;
                $mail_body_template = $mail_template->body;
            }

            $link = route('accept-new-quotation-mail', ['id' => Crypt::encrypt($data->id)]);

            $mail_subject_template = str_replace('{offerte_nummer}',$data->quotation_invoice_number,$mail_subject_template);
            $mail_body_template = str_replace('{aan_voornaam}',$data->name,$mail_body_template);
            $mail_body_template = str_replace('{offerte_nummer}',$data->quotation_invoice_number,$mail_body_template);
            $mail_body_template = str_replace('{Click here to accept this quote directly online}','Click <a style="color: blue;" href="'.$link.'">here</a> to accept this quote directly online',$mail_body_template);
            $mail_body_template = str_replace('{Klik hier om de offerte te accepteren}','Klik <a style="color: blue;" href="'.$link.'">hier</a> om de offerte te accepteren',$mail_body_template);
            $mail_body_template = str_replace('{van_voornaam}',$user->name,$mail_body_template);
            $mail_body_template = str_replace('{van_bedrijfsnaam}',$user->company_name,$mail_body_template);
        }
        else if($req_type == 'order')
        {
            $mail_template = email_templates::where('type','order')->where('user_id',$user_id)->first();

            if(!$mail_template)
            {
                $mail_subject_template = 'Order: {order_nummer}';
                $mail_body_template = '<div class="OutlineElement Ltr  BCX0 SCXW88000976" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow: visible; cursor: text; clear: both; position: relative; direction: ltr; color: rgb(0, 0, 0); font-family: &quot;Segoe UI&quot;, &quot;Segoe UI Web&quot;, Arial, Verdana, sans-serif; font-size: 12px;"><p class="Paragraph SCXW88000976 BCX0" paraid="1492123990" paraeid="{067a829f-0db6-4a3a-8ad2-66efb8a422c4}{70}" style="margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none; color: windowtext;"><span data-contrast="none" xml:lang="NL-NL" lang="NL-NL" class="TextRun SCXW88000976 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-variant-ligatures: none !important; color: rgb(85, 85, 85); font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif;"><span class="NormalTextRun SCXW88000976 BCX0" data-ccp-parastyle="Normal (Web)" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent;">Beste {aan_voornaam},</span></span></p><p class="Paragraph SCXW88000976 BCX0" paraid="1492123990" paraeid="{067a829f-0db6-4a3a-8ad2-66efb8a422c4}{70}" style="margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none; color: windowtext;"><span class="EOP SCXW88000976 BCX0" data-ccp-props="{&quot;134233117&quot;:true,&quot;134233118&quot;:true,&quot;201341983&quot;:0,&quot;335559739&quot;:300,&quot;335559740&quot;:240}" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif; color: rgb(85, 85, 85);"><br></span></p></div><div class="OutlineElement Ltr  BCX0 SCXW88000976" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow: visible; cursor: text; clear: both; position: relative; direction: ltr; color: rgb(0, 0, 0); font-family: &quot;Segoe UI&quot;, &quot;Segoe UI Web&quot;, Arial, Verdana, sans-serif; font-size: 12px;"><p class="Paragraph SCXW88000976 BCX0" paraid="175123627" paraeid="{067a829f-0db6-4a3a-8ad2-66efb8a422c4}{80}" style="margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none; color: windowtext;"><span class="LineBreakBlob BlobObject DragDrop SCXW88000976 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-size: 12pt; line-height: 18px; font-family: WordVisiCarriageReturn_MSFontService, open_sansregular, open_sansregular_EmbeddedFont, sans-serif; color: rgb(85, 85, 85);"><span class="NormalTextRun SCXW140321656 BCX0" data-ccp-parastyle="Normal (Web)" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif; font-variant-ligatures: none;">Hiebij de order met ordernummer {order_nummer}.</span></span></p><p class="Paragraph SCXW88000976 BCX0" paraid="175123627" paraeid="{067a829f-0db6-4a3a-8ad2-66efb8a422c4}{80}" style="margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none; color: windowtext;"><span class="EOP SCXW88000976 BCX0" data-ccp-props="{&quot;134233117&quot;:true,&quot;134233118&quot;:true,&quot;201341983&quot;:0,&quot;335559739&quot;:300,&quot;335559740&quot;:240}" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif; color: rgb(85, 85, 85);">&nbsp;</span></p></div><div class="OutlineElement Ltr  BCX0 SCXW88000976" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow: visible; cursor: text; clear: both; position: relative; direction: ltr; color: rgb(0, 0, 0); font-family: &quot;Segoe UI&quot;, &quot;Segoe UI Web&quot;, Arial, Verdana, sans-serif; font-size: 12px;"><p class="Paragraph SCXW88000976 BCX0" paraid="1552157293" paraeid="{067a829f-0db6-4a3a-8ad2-66efb8a422c4}{102}" style="margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none; color: windowtext;"><span data-contrast="none" xml:lang="NL-NL" lang="NL-NL" class="TextRun SCXW88000976 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-variant-ligatures: none !important; color: rgb(85, 85, 85); font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif;">Graag ontvangen we hier een orderbevestiging van.</span></p></div><div class="OutlineElement Ltr  BCX0 SCXW88000976" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow: visible; cursor: text; clear: both; position: relative; direction: ltr; color: rgb(0, 0, 0); font-family: &quot;Segoe UI&quot;, &quot;Segoe UI Web&quot;, Arial, Verdana, sans-serif; font-size: 12px;"><p class="Paragraph SCXW88000976 BCX0" paraid="2113674558" paraeid="{067a829f-0db6-4a3a-8ad2-66efb8a422c4}{108}" style="margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none; color: windowtext;"><span data-contrast="none" xml:lang="NL-NL" lang="NL-NL" class="TextRun SCXW88000976 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-variant-ligatures: none !important; color: rgb(85, 85, 85); font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif;">Met vriendelijke groet,</span><span class="LineBreakBlob BlobObject DragDrop SCXW88000976 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-size: 12pt; line-height: 18px; font-family: WordVisiCarriageReturn_MSFontService, open_sansregular, open_sansregular_EmbeddedFont, sans-serif; color: rgb(85, 85, 85);"><br class="SCXW88000976 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; white-space: pre !important;"></span><span data-contrast="none" xml:lang="NL-NL" lang="NL-NL" class="TextRun SCXW88000976 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-variant-ligatures: none !important; color: rgb(85, 85, 85); font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif;"><span class="NormalTextRun SCXW88000976 BCX0" data-ccp-parastyle="Normal (Web)" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent;">{van_voornaam}</span></span><span class="LineBreakBlob BlobObject DragDrop SCXW88000976 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-size: 12pt; line-height: 18px; font-family: WordVisiCarriageReturn_MSFontService, open_sansregular, open_sansregular_EmbeddedFont, sans-serif; color: rgb(85, 85, 85);"><br class="SCXW88000976 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; white-space: pre !important;"></span><span data-contrast="none" xml:lang="NL-NL" lang="NL-NL" class="TextRun SCXW88000976 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-variant-ligatures: none !important; color: rgb(85, 85, 85); font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif;"><span class="NormalTextRun SCXW88000976 BCX0" data-ccp-parastyle="Normal (Web)" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent;">{van_bedrijfsnaam}</span></span></p></div>';
            }
            else
            {
                $mail_subject_template = $mail_template->subject;
                $mail_body_template = $mail_template->body;
            }
        }
        else
        {
            $mail_template = email_templates::where('type','invoice')->where('user_id',$user_id)->first();

            if(!$mail_template)
            {
                $mail_subject_template = 'Factuur: {factuur_nummer}';
                $mail_body_template = '<div class="OutlineElement Ltr  BCX0 SCXW91431922" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow: visible; cursor: text; clear: both; position: relative; direction: ltr; color: rgb(0, 0, 0); font-family: &quot;Segoe UI&quot;, &quot;Segoe UI Web&quot;, Arial, Verdana, sans-serif; font-size: 12px;"><p class="Paragraph SCXW91431922 BCX0" paraid="1500201224" paraeid="{d22048a8-261e-4878-810c-cb993567f9d4}{95}" style="margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none; color: windowtext;"><span data-contrast="none" xml:lang="NL-NL" lang="NL-NL" class="TextRun SCXW91431922 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-variant-ligatures: none !important; color: rgb(85, 85, 85); font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif;"><span class="NormalTextRun SCXW91431922 BCX0" data-ccp-parastyle="Normal (Web)" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent;">Beste {aan_voornaam},</span></span></p></div><div class="OutlineElement Ltr  BCX0 SCXW91431922" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow: visible; cursor: text; clear: both; position: relative; direction: ltr; color: rgb(0, 0, 0); font-family: &quot;Segoe UI&quot;, &quot;Segoe UI Web&quot;, Arial, Verdana, sans-serif; font-size: 12px;"><p class="Paragraph SCXW91431922 BCX0" paraid="44738701" paraeid="{d22048a8-261e-4878-810c-cb993567f9d4}{105}" style="margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none; color: windowtext;"><span data-contrast="none" xml:lang="NL-NL" lang="NL-NL" class="TextRun SCXW91431922 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-variant-ligatures: none !important; color: rgb(85, 85, 85); font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif;"><span class="NormalTextRun SCXW91431922 BCX0" data-ccp-parastyle="Normal (Web)" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent;"><br></span></span></p><p class="Paragraph SCXW91431922 BCX0" paraid="44738701" paraeid="{d22048a8-261e-4878-810c-cb993567f9d4}{105}" style="margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none; color: windowtext;"><span class="LineBreakBlob BlobObject DragDrop SCXW91431922 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-size: 12pt; line-height: 18px; font-family: WordVisiCarriageReturn_MSFontService, open_sansregular, open_sansregular_EmbeddedFont, sans-serif; color: rgb(85, 85, 85);"><span class="NormalTextRun  BCX0 SCXW141786481" data-ccp-parastyle="Normal (Web)" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif; font-variant-ligatures: none;">Hierbij de factuur met factuurnummer {factuur_nummer}.</span></span></p><p class="Paragraph SCXW91431922 BCX0" paraid="44738701" paraeid="{d22048a8-261e-4878-810c-cb993567f9d4}{105}" style="margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none; color: windowtext;"><br></p></div><div class="OutlineElement Ltr  BCX0 SCXW91431922" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow: visible; cursor: text; clear: both; position: relative; direction: ltr; color: rgb(0, 0, 0); font-family: &quot;Segoe UI&quot;, &quot;Segoe UI Web&quot;, Arial, Verdana, sans-serif; font-size: 12px;"><p class="Paragraph SCXW91431922 BCX0" paraid="1765816471" paraeid="{d22048a8-261e-4878-810c-cb993567f9d4}{151}" style="margin-bottom: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; overflow-wrap: break-word; vertical-align: baseline; font-kerning: none; color: windowtext;"><span data-contrast="none" xml:lang="NL-NL" lang="NL-NL" class="TextRun SCXW91431922 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-variant-ligatures: none !important; color: rgb(85, 85, 85); font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif;">Met vriendelijke groet,</span><span class="LineBreakBlob BlobObject DragDrop SCXW91431922 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-size: 12pt; line-height: 18px; font-family: WordVisiCarriageReturn_MSFontService, open_sansregular, open_sansregular_EmbeddedFont, sans-serif; color: rgb(85, 85, 85);"><span class="SCXW91431922 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; white-space: pre !important;">&nbsp;</span><br class="SCXW91431922 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; white-space: pre !important;"></span><span data-contrast="none" xml:lang="NL-NL" lang="NL-NL" class="TextRun SCXW91431922 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-variant-ligatures: none !important; color: rgb(85, 85, 85); font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif;"><span class="NormalTextRun SCXW91431922 BCX0" data-ccp-parastyle="Normal (Web)" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent;">{van_voornaam}</span></span><span class="LineBreakBlob BlobObject DragDrop SCXW91431922 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-size: 12pt; line-height: 18px; font-family: WordVisiCarriageReturn_MSFontService, open_sansregular, open_sansregular_EmbeddedFont, sans-serif; color: rgb(85, 85, 85);"><br class="SCXW91431922 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; white-space: pre !important;"></span><span data-contrast="none" xml:lang="NL-NL" lang="NL-NL" class="TextRun SCXW91431922 BCX0" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent; font-variant-ligatures: none !important; color: rgb(85, 85, 85); font-size: 12pt; line-height: 18px; font-family: open_sansregular, open_sansregular_EmbeddedFont, sans-serif;"><span class="NormalTextRun SCXW91431922 BCX0" data-ccp-parastyle="Normal (Web)" style="margin: 0px; padding: 0px; user-select: text; -webkit-user-drag: none; -webkit-tap-highlight-color: transparent;">{van_bedrijfsnaam}</span></span></p></div>';
            }
            else
            {
                $mail_subject_template = $mail_template->subject;
                $mail_body_template = $mail_template->body;
            }

            $mail_subject_template = str_replace('{factuur_nummer}',$data->invoice_number,$mail_subject_template);
            $mail_body_template = str_replace('{aan_voornaam}',$data->name,$mail_body_template);
            $mail_body_template = str_replace('{factuur_nummer}',$data->invoice_number,$mail_body_template);
            $mail_body_template = str_replace('{van_voornaam}',$user->name,$mail_body_template);
            $mail_body_template = str_replace('{van_bedrijfsnaam}',$user->company_name,$mail_body_template);
        }

        $post = array($data->email,$mail_subject_template,$mail_body_template);

        return $post;
    }

    public function DownloadHandymanQuoteRequest($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('download-handyman-quote-request'))
        {
            $quote = quotes::leftjoin('categories', 'categories.id', '=', 'quotes.quote_service')->leftjoin('brands', 'brands.id', '=', 'quotes.quote_brand')->leftjoin('models', 'models.id', '=', 'quotes.quote_model')->leftjoin('services','services.id','=','quotes.quote_service1')->leftjoin('handyman_quotes', 'handyman_quotes.quote_id', '=', 'quotes.id')->where('quotes.id', $id)->where('handyman_quotes.handyman_id', $user_id)->select('quotes.*','categories.cat_name','services.title','brands.cat_name as brand_name','models.cat_name as model_name')->first();

            $q_a = requests_q_a::where('request_id', $id)->get();

            if ($quote) {

                $date = strtotime($quote->created_at);

                $quote_number = $quote->quote_number;

                $filename = $quote_number . '.pdf';

                $file = public_path() . '/assets/quotesPDF/' . $filename;

                if (!file_exists($file)) {

                    $role = 2;

                    ini_set('max_execution_time', 180);

                    $pdf = PDF::loadView('admin.user.pdf_quote', compact('quote', 'q_a','role'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140,'isRemoteEnabled' => true]);

                    $pdf->save(public_path() . '/assets/quotesPDF/' . $filename);
                }

                return response()->download(public_path("assets/quotesPDF/{$filename}"));
            } else {
                return redirect('aanbieder/dashboard');
            }
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function CreateQuotation($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('create-quotation'))
        {
            $quote = quotes::leftjoin('handyman_quotes', 'handyman_quotes.quote_id', '=', 'quotes.id')->where('quotes.id', $id)->where('handyman_quotes.handyman_id', $user_id)->select('quotes.*')->first();

            $all_products = Products::leftjoin('handyman_products', 'handyman_products.product_id', '=', 'products.id')->leftjoin('categories', 'categories.id', '=', 'products.category_id')->where('handyman_products.handyman_id', $user_id)->select('products.*','categories.cat_name','handyman_products.sell_rate as rate')->get();
            $all_services = Service::leftjoin('handyman_services', 'handyman_services.service_id', '=', 'services.id')->where('handyman_services.handyman_id', $user_id)->select('services.*','handyman_services.sell_rate as rate')->get();
            $items = items::where('user_id', $user_id)->get();

            $settings = Generalsetting::findOrFail(1);

            $vat_percentage = $settings->vat;

            if ($quote) {
                return view('user.create_quotation', compact('quote', 'vat_percentage', 'items', 'all_services', 'all_products', 'user_id'));
            } else {
                return redirect('aanbieder/dashboard');
            }
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function ViewQuotation($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $check = 0;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if(\Route::currentRouteName() == 'view-handyman-quotation')
        {
            if($user->can('view-handyman-quotation'))
            {
                $check = 1;
            }
        }

        if(\Route::currentRouteName() == 'edit-handyman-quotation')
        {
            if($user->can('edit-handyman-quotation'))
            {
                $check = 1;
            }
        }

        if(\Route::currentRouteName() == 'create-handyman-invoice')
        {
            if($user->can('create-handyman-invoice'))
            {
                $check = 1;
            }
        }

        if($check)
        {
            $settings = Generalsetting::findOrFail(1);

            $vat_percentage = $settings->vat;

            $quotation = quotation_invoices::leftjoin('quotation_invoices_data', 'quotation_invoices_data.quotation_id', '=', 'quotation_invoices.id')->leftjoin('quotes', 'quotes.id', '=', 'quotation_invoices.quote_id')->where('quotation_invoices.id', $id)->where('quotation_invoices.handyman_id', $user_id)->select('quotation_invoices.*', 'quotes.quote_zipcode', 'quotes.quote_postcode', 'quotes.quote_city', 'quotes.id as quote_id', 'quotes.quote_number', 'quotes.created_at as quote_date', 'quotation_invoices_data.id as data_id', 'quotation_invoices_data.product_title', 'quotation_invoices_data.s_i_id', 'quotation_invoices_data.b_i_id', 'quotation_invoices_data.m_i_id', 'quotation_invoices_data.item', 'quotation_invoices_data.is_service', 'quotation_invoices_data.service', 'quotation_invoices_data.brand', 'quotation_invoices_data.model', 'quotation_invoices_data.rate', 'quotation_invoices_data.qty', 'quotation_invoices_data.description as data_description', 'quotation_invoices_data.estimated_date', 'quotation_invoices_data.amount')->get();

            $all_products = Products::leftjoin('handyman_products', 'handyman_products.product_id', '=', 'products.id')->leftjoin('categories', 'categories.id', '=', 'products.category_id')->where('handyman_products.handyman_id', $user_id)->select('products.*','categories.cat_name','handyman_products.sell_rate as rate')->get();
            $all_services = Service::leftjoin('handyman_services', 'handyman_services.service_id', '=', 'services.id')->where('handyman_services.handyman_id', $user_id)->select('services.*','handyman_services.sell_rate as rate')->get();
            $items = items::where('user_id', $user_id)->get();

            if (count($quotation) != 0) {

                return view('user.quotation', compact('quotation', 'vat_percentage', 'user_id', 'all_products', 'all_services', 'items'));

            } else {
                return redirect('aanbieder/dashboard');
            }
        }
        else
        {
            return redirect()->route('user-login');
        }

    }

    public function ViewCustomQuotation($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $check = 0;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if(\Route::currentRouteName() == 'view-custom-quotation')
        {
            if($user->can('view-custom-quotation'))
            {
                $check = 1;
            }
        }

        if(\Route::currentRouteName() == 'edit-custom-quotation')
        {
            if($user->can('edit-custom-quotation'))
            {
                $check = 1;
            }
        }

        if(\Route::currentRouteName() == 'create-custom-invoice')
        {
            if($user->can('create-custom-invoice'))
            {
                $check = 1;
            }
        }

        if($check)
        {
            $settings = Generalsetting::findOrFail(1);

            $vat_percentage = $settings->vat;

            $quotation = custom_quotations::leftjoin('custom_quotations_data', 'custom_quotations_data.quotation_id', '=', 'custom_quotations.id')->where('custom_quotations.id', $id)->where('custom_quotations.handyman_id', $user_id)->select('custom_quotations.*', 'custom_quotations_data.id as data_id', 'custom_quotations_data.product_title', 'custom_quotations_data.s_i_id', 'custom_quotations_data.b_i_id', 'custom_quotations_data.m_i_id', 'custom_quotations_data.item', 'custom_quotations_data.is_service', 'custom_quotations_data.service', 'custom_quotations_data.brand', 'custom_quotations_data.model', 'custom_quotations_data.rate', 'custom_quotations_data.qty', 'custom_quotations_data.description as data_description', 'custom_quotations_data.estimated_date', 'custom_quotations_data.amount')->get();

            $all_products = Products::leftjoin('handyman_products', 'handyman_products.product_id', '=', 'products.id')->leftjoin('categories', 'categories.id', '=', 'products.category_id')->where('handyman_products.handyman_id', $user_id)->select('products.*','categories.cat_name','handyman_products.sell_rate as rate')->get();
            $all_services = Service::leftjoin('handyman_services', 'handyman_services.service_id', '=', 'services.id')->where('handyman_services.handyman_id', $user_id)->select('services.*','handyman_services.sell_rate as rate')->get();
            $items = items::where('user_id',$user_id)->get();

            if (count($quotation) != 0) {

                return view('user.quotation', compact('quotation', 'all_products', 'all_services', 'vat_percentage', 'items', 'user_id'));

            } else {
                return redirect('aanbieder/dashboard');
            }
        }
        else
        {
            return redirect()->route('user-login');
        }

    }

    public function ViewClientQuotation($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;

        $check = new_quotations::leftjoin('quotes', 'quotes.id', '=', 'new_quotations.quote_request_id')->where('new_quotations.id', $id)->where('quotes.user_id', $user_id)->first();

        if($check)
        {
            $invoice = new_quotations_data::leftjoin('new_quotations','new_quotations.id','=','new_quotations_data.quotation_id')->leftjoin('products','products.id','=','new_quotations_data.product_id')->where('new_quotations.id', $id)->select('new_quotations.*','new_quotations_data.item_id','new_quotations_data.service_id','new_quotations.delivery_date as retailer_delivery_date','new_quotations.installation_date as retailer_installation_date','new_quotations.id as invoice_id','new_quotations_data.box_quantity','new_quotations_data.measure','new_quotations_data.max_width','new_quotations_data.order_number','new_quotations_data.discount','new_quotations_data.labor_discount','new_quotations_data.total_discount','new_quotations_data.price_before_labor','new_quotations_data.labor_impact','new_quotations_data.model_impact_value','new_quotations_data.childsafe','new_quotations_data.childsafe_question','new_quotations_data.childsafe_answer','new_quotations_data.childsafe_x','new_quotations_data.childsafe_y','new_quotations_data.childsafe_diff','new_quotations_data.model_id','new_quotations_data.delivery_days','new_quotations_data.delivery_date','new_quotations_data.id','new_quotations_data.supplier_id','new_quotations_data.product_id','new_quotations_data.row_id','new_quotations_data.rate','new_quotations_data.basic_price','new_quotations_data.qty','new_quotations_data.amount','new_quotations_data.color','new_quotations_data.width','new_quotations_data.width_unit','new_quotations_data.height','new_quotations_data.height_unit','new_quotations_data.price_based_option','new_quotations_data.base_price','new_quotations_data.supplier_margin','new_quotations_data.retailer_margin','products.ladderband','products.ladderband_value','products.ladderband_price_impact','products.ladderband_impact_type')
                ->with(['features' => function($query)
                {
                    $query->leftjoin('features','features.id','=','new_quotations_features.feature_id')
                        /*->where('new_quotations_features.sub_feature',0)*/
                        ->select('new_quotations_features.*','features.title','features.comment_box');
                }])
                ->with(['sub_features' => function($query)
                {
                    $query->leftjoin('product_features','product_features.id','=','new_quotations_features.feature_id')
                        /*->where('new_quotations_features.sub_feature',1)*/
                        ->select('new_quotations_features.*','product_features.title');
                }])->with('calculations')->get();

            if (!$invoice) {
                return redirect()->back();
            }

            $supplier_products = array();
            $product_titles = array();
            $item_titles = array();
            $service_titles = array();
            $color_titles = array();
            $model_titles = array();
            $product_suppliers = array();
            $sub_products = array();
            $colors = array();
            $models = array();
            $features = array();
            $sub_features = array();

            $f = 0;
            $s = 0;

            foreach ($invoice as $i => $item)
            {
                $product_titles[] = product::where('id',$item->product_id)->pluck('title')->first();
                $item_titles[] = items::leftjoin('categories','categories.id','=','items.category_id')->where('items.id',$item->item_id)->select('items.cat_name','categories.cat_name as category')->first();
                $service_titles[] = Service::where('id',$item->service_id)->pluck('title')->first();
                $color_titles[] = colors::where('id',$item->color)->pluck('title')->first();
                $model_titles[] = product_models::where('id',$item->model_id)->pluck('model')->first();
                $product_suppliers[] = User::where('id',$item->supplier_id)->first();

                foreach ($item->features as $feature)
                {
                    $features[$f] = product_features::leftjoin('model_features','model_features.product_feature_id','=','product_features.id')->where('product_features.product_id',$item->product_id)->where('product_features.heading_id',$feature->feature_id)->where('product_features.sub_feature',0)->where('model_features.model_id',$item->model_id)->where('model_features.linked',1)->select('product_features.*')->get();

                    if($feature->ladderband)
                    {
                        $sub_products[$i] = new_quotations_sub_products::leftjoin('product_ladderbands','product_ladderbands.id','=','new_quotations_sub_products.sub_product_id')->where('new_quotations_sub_products.feature_row_id',$feature->id)->select('new_quotations_sub_products.*','product_ladderbands.title','product_ladderbands.code')->get();
                    }

                    $f = $f + 1;
                }

                foreach ($item->sub_features as $sub_feature)
                {
                    $sub_features[$s] = product_features::where('product_id',$item->product_id)->where('main_id',$sub_feature->feature_id)->get();
                    $s = $s + 1;
                }
            }

            return view('user.client_new_quotation', compact('product_titles','color_titles','model_titles','product_suppliers','features','sub_features','invoice','sub_products'));
        }
        else
        {
            return redirect()->back();
        }
    }

    public function ViewClientCustomQuotation($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;

        $settings = Generalsetting::findOrFail(1);

        $vat_percentage = $settings->vat;

        $quotation = custom_quotations::leftjoin('custom_quotations_data', 'custom_quotations_data.quotation_id', '=', 'custom_quotations.id')->where('custom_quotations.id', $id)->where('custom_quotations.user_id', $user_id)->select('custom_quotations.*', 'custom_quotations_data.id as data_id', 'custom_quotations_data.s_i_id', 'custom_quotations_data.b_i_id', 'custom_quotations_data.m_i_id', 'custom_quotations_data.item', 'custom_quotations_data.service', 'custom_quotations_data.brand', 'custom_quotations_data.model', 'custom_quotations_data.rate', 'custom_quotations_data.qty', 'custom_quotations_data.description as data_description', 'custom_quotations_data.estimated_date', 'custom_quotations_data.amount')->get();

        if (count($quotation) != 0) {
            $services = Category::all();

            $items = items::all();

            return view('user.client_quotation', compact('quotation', 'services', 'vat_percentage', 'items'));
        } else {
            return redirect('aanbieder/quotation-requests');
        }
    }

    public function NewOrders()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;
        $user_role = $user->role_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user_role == 2)
        {
            $invoices = new_quotations::leftjoin('customers_details', 'customers_details.id', '=', 'new_quotations.customer_details')->where('new_quotations.creator_id', $user_id)->select('new_quotations.*', 'new_quotations.id as invoice_id', 'new_quotations.created_at as invoice_date', 'customers_details.name', 'customers_details.family_name')->with('orders')->get();

            return view('user.quote_invoices', compact('invoices'));
        }
        else
        {
            return redirect()->route('user-login');
        }

    }

    public function NewInvoices()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;
        $user_role = $user->role_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user_role == 2)
        {
            $invoices = new_quotations::leftjoin('customers_details', 'customers_details.id', '=', 'new_quotations.customer_details')->where('new_quotations.creator_id', $user_id)->where('new_quotations.invoice',1)->orderBy('new_quotations.created_at', 'desc')->select('new_quotations.*', 'new_quotations.id as invoice_id', 'new_quotations.invoice_date', 'customers_details.name', 'customers_details.family_name')->with('data')->get();

            return view('user.quote_invoices', compact('invoices'));
        }
        else
        {
            return redirect()->route('user-login');
        }

    }

    public function NewQuotations()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;
        $user_role = $user->role_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('create-new-quotation'))
        {
            if($user_role == 2)
            {
                $invoices = new_quotations::leftjoin('customers_details', 'customers_details.id', '=', 'new_quotations.customer_details')->where('new_quotations.creator_id', $user_id)->where('new_quotations.status','!=',3)->orderBy('new_quotations.created_at', 'desc')->select('new_quotations.*', 'new_quotations.id as invoice_id', 'new_quotations.created_at as invoice_date', 'customers_details.name', 'customers_details.family_name')->with('data')->get();
            }
            else
            {
                $invoices = new_quotations::leftjoin('new_quotations_data', 'new_quotations_data.quotation_id', '=', 'new_quotations.id')->leftjoin('customers_details', 'customers_details.id', '=', 'new_quotations.customer_details')->where('new_quotations_data.supplier_id', $user_id)->where('new_quotations.finished',1)->orderBy('new_quotations.created_at', 'desc')->select('new_quotations.*', 'new_quotations.id as invoice_id', 'new_quotations_data.id as data_id', 'new_quotations.created_at as invoice_date', 'new_quotations_data.order_number','new_quotations_data.approved as data_approved','new_quotations_data.processing as data_processing','new_quotations_data.delivered as data_delivered', 'customers_details.name', 'customers_details.family_name')->get();
                $invoices = $invoices->unique('invoice_id');
            }

            return view('user.quote_invoices', compact('invoices'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function EditNewQuotation($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if(\Route::currentRouteName() == 'view-new-quotation')
        {
            $check = new_quotations::where('id',$id)->where('creator_id',$user_id)->first();
        }
        else
        {
            $check = new_invoices::where('quotation_id',$id)->where('creator_id',$user_id)->first();
        }

        if($check)
        {
            $customers = customers_details::where('retailer_id', $user_id)->get();

            if($check->form_type == 1)
            {
                if($user_role == 2)
                {
                    $floor_category_id = Category::where('cat_name','LIKE', '%Floors%')->orWhere('cat_name','LIKE', '%Vloeren%')->pluck('id')->first();
                    $suppliers = User::leftjoin('retailers_requests','retailers_requests.retailer_id','=','users.id')->leftjoin('supplier_categories','supplier_categories.user_id','=','retailers_requests.supplier_id')->where('supplier_categories.category_id',$floor_category_id)->where('users.id',$user_id)->where('retailers_requests.status',1)->where('retailers_requests.active',1)->pluck('retailers_requests.supplier_id');
                    $products = products::leftjoin('users','users.id','=','products.user_id')->whereIn('products.user_id',$suppliers)->where('products.category_id',$floor_category_id)->with('colors')->with('models')->select('products.*','users.name','users.family_name','users.company_name')->get();
                }
                else
                {
                    $floor_category_id = Category::where('cat_name','LIKE', '%Floors%')->orWhere('cat_name','LIKE', '%Vloeren%')->pluck('id')->first();
                    $products = products::where('user_id',$user_id)->where('category_id',$floor_category_id)->with('colors')->with('models')->get();
                }
            }
            else
            {
                if($user_role == 2)
                {
                    $suppliers = User::leftjoin('retailers_requests','retailers_requests.retailer_id','=','users.id')->where('users.id',$user_id)->where('retailers_requests.status',1)->where('retailers_requests.active',1)->pluck('retailers_requests.supplier_id');
                    $suppliers = User::whereIn('id',$suppliers)->get();
                    $products = array();
                }
                else
                {
                    $blinds_category_id = Category::where('cat_name','LIKE', '%Blinds%')->orWhere('cat_name','LIKE', '%Binnen zonwering%')->pluck('id')->first();
                    $products = Products::where('user_id',$user_id)->where('category_id',$blinds_category_id)->with('colors')->with('models')->get();
                    $suppliers = array();
                }
            }

            if(\Route::currentRouteName() == 'view-new-quotation')
            {
                $invoice = new_quotations_data::leftjoin('new_quotations','new_quotations.id','=','new_quotations_data.quotation_id')->leftjoin('products','products.id','=','new_quotations_data.product_id')->where('new_quotations.id', $id)->where('new_quotations.creator_id', $user_id)->select('new_quotations.*','new_quotations_data.item_id','new_quotations_data.service_id','new_quotations.delivery_date as retailer_delivery_date','new_quotations.installation_date as retailer_installation_date','new_quotations.id as invoice_id','new_quotations_data.box_quantity','new_quotations_data.measure','new_quotations_data.max_width','new_quotations_data.order_number','new_quotations_data.discount','new_quotations_data.labor_discount','new_quotations_data.total_discount','new_quotations_data.price_before_labor','new_quotations_data.labor_impact','new_quotations_data.model_impact_value','new_quotations_data.childsafe','new_quotations_data.childsafe_question','new_quotations_data.childsafe_answer','new_quotations_data.childsafe_x','new_quotations_data.childsafe_y','new_quotations_data.childsafe_diff','new_quotations_data.model_id','new_quotations_data.delivery_days','new_quotations_data.delivery_date','new_quotations_data.id','new_quotations_data.supplier_id','new_quotations_data.product_id','new_quotations_data.row_id','new_quotations_data.rate','new_quotations_data.basic_price','new_quotations_data.qty','new_quotations_data.amount','new_quotations_data.color','new_quotations_data.width','new_quotations_data.width_unit','new_quotations_data.height','new_quotations_data.height_unit','new_quotations_data.price_based_option','new_quotations_data.base_price','new_quotations_data.supplier_margin','new_quotations_data.retailer_margin','products.ladderband','products.ladderband_value','products.ladderband_price_impact','products.ladderband_impact_type')
                    ->with(['features' => function($query)
                    {
                        $query->leftjoin('features','features.id','=','new_quotations_features.feature_id')
                            /*->where('new_quotations_features.sub_feature',0)*/
                            ->select('new_quotations_features.*','features.title','features.comment_box');

                    }])
                    ->with(['sub_features' => function($query)
                    {
                        $query->leftjoin('product_features','product_features.id','=','new_quotations_features.feature_id')
                            /*->where('new_quotations_features.sub_feature',1)*/
                            ->select('new_quotations_features.*','product_features.title');

                    }])->with('calculations')->get();
            }
            else
            {
                $invoice = array();

                if(\Route::currentRouteName() == 'create-new-negative-invoice')
                {
                    $invoice = new_invoices_data::leftjoin('new_invoices','new_invoices.id','=','new_invoices_data.invoice_id')->leftjoin('products','products.id','=','new_invoices_data.product_id')->where('new_invoices.negative_invoice',1)->where('new_invoices.quotation_id', $id)->where('new_invoices.creator_id', $user_id)->select('new_invoices.*','new_invoices_data.item_id','new_invoices_data.service_id','new_invoices.delivery_date as retailer_delivery_date','new_invoices.installation_date as retailer_installation_date','new_invoices.id as invoice_id','new_invoices_data.box_quantity','new_invoices_data.measure','new_invoices_data.max_width','new_invoices_data.discount','new_invoices_data.labor_discount','new_invoices_data.total_discount','new_invoices_data.price_before_labor','new_invoices_data.labor_impact','new_invoices_data.model_impact_value','new_invoices_data.childsafe','new_invoices_data.childsafe_question','new_invoices_data.childsafe_answer','new_invoices_data.childsafe_x','new_invoices_data.childsafe_y','new_invoices_data.childsafe_diff','new_invoices_data.model_id','new_invoices_data.delivery_days','new_invoices_data.delivery_date','new_invoices_data.id','new_invoices_data.supplier_id','new_invoices_data.product_id','new_invoices_data.row_id','new_invoices_data.rate','new_invoices_data.basic_price','new_invoices_data.qty','new_invoices_data.amount','new_invoices_data.color','new_invoices_data.width','new_invoices_data.width_unit','new_invoices_data.height','new_invoices_data.height_unit','new_invoices_data.price_based_option','new_invoices_data.base_price','new_invoices_data.supplier_margin','new_invoices_data.retailer_margin','products.ladderband','products.ladderband_value','products.ladderband_price_impact','products.ladderband_impact_type')
                        ->with(['features' => function($query)
                        {
                            $query->leftjoin('features','features.id','=','new_invoices_features.feature_id')
                                /*->where('new_quotations_features.sub_feature',0)*/
                                ->select('new_invoices_features.*','features.title','features.comment_box');

                        }])
                        ->with(['sub_features' => function($query)
                        {
                            $query->leftjoin('product_features','product_features.id','=','new_invoices_features.feature_id')
                                /*->where('new_quotations_features.sub_feature',1)*/
                                ->select('new_invoices_features.*','product_features.title');

                        }])->with('calculations')->get();
                }

                if(count($invoice) == 0)
                {
                    $invoice = new_invoices_data::leftjoin('new_invoices','new_invoices.id','=','new_invoices_data.invoice_id')->leftjoin('products','products.id','=','new_invoices_data.product_id')->where('new_invoices.negative_invoice',0)->where('new_invoices.quotation_id', $id)->where('new_invoices.creator_id', $user_id)->select('new_invoices.*','new_invoices_data.item_id','new_invoices_data.service_id','new_invoices.delivery_date as retailer_delivery_date','new_invoices.installation_date as retailer_installation_date','new_invoices.id as invoice_id','new_invoices_data.box_quantity','new_invoices_data.measure','new_invoices_data.max_width','new_invoices_data.discount','new_invoices_data.labor_discount','new_invoices_data.total_discount','new_invoices_data.price_before_labor','new_invoices_data.labor_impact','new_invoices_data.model_impact_value','new_invoices_data.childsafe','new_invoices_data.childsafe_question','new_invoices_data.childsafe_answer','new_invoices_data.childsafe_x','new_invoices_data.childsafe_y','new_invoices_data.childsafe_diff','new_invoices_data.model_id','new_invoices_data.delivery_days','new_invoices_data.delivery_date','new_invoices_data.id','new_invoices_data.supplier_id','new_invoices_data.product_id','new_invoices_data.row_id','new_invoices_data.rate','new_invoices_data.basic_price','new_invoices_data.qty','new_invoices_data.amount','new_invoices_data.color','new_invoices_data.width','new_invoices_data.width_unit','new_invoices_data.height','new_invoices_data.height_unit','new_invoices_data.price_based_option','new_invoices_data.base_price','new_invoices_data.supplier_margin','new_invoices_data.retailer_margin','products.ladderband','products.ladderband_value','products.ladderband_price_impact','products.ladderband_impact_type')
                        ->with(['features' => function($query)
                        {
                            $query->leftjoin('features','features.id','=','new_invoices_features.feature_id')
                                /*->where('new_quotations_features.sub_feature',0)*/
                                ->select('new_invoices_features.*','features.title','features.comment_box');

                        }])
                        ->with(['sub_features' => function($query)
                        {
                            $query->leftjoin('product_features','product_features.id','=','new_invoices_features.feature_id')
                                /*->where('new_quotations_features.sub_feature',1)*/
                                ->select('new_invoices_features.*','product_features.title');

                        }])->with('calculations')->get();
                }
            }

            if (!$invoice) {
                return redirect()->back();
            }

            $supplier_products = array();
            $product_titles = array();
            $item_titles = array();
            $service_titles = array();
            $color_titles = array();
            $model_titles = array();
            $product_suppliers = array();
            $sub_products = array();
            $colors = array();
            $models = array();
            $features = array();
            $sub_features = array();

            $f = 0;
            $s = 0;

            foreach ($invoice as $i => $item)
            {
                if($check->form_type == 1)
                {
                    $floor_category_id = Category::where('cat_name','LIKE', '%Floors%')->orWhere('cat_name','LIKE', '%Vloeren%')->pluck('id')->first();
                    $product_titles[] = product::where('id',$item->product_id)->where('category_id',$floor_category_id)->pluck('title')->first();
                    $item_titles[] = items::leftjoin('categories','categories.id','=','items.category_id')->where('items.id',$item->item_id)->select('items.cat_name','categories.cat_name as category')->first();
                    $service_titles[] = Service::where('id',$item->service_id)->pluck('title')->first();
                    $color_titles[] = colors::where('id',$item->color)->pluck('title')->first();
                    $model_titles[] = product_models::where('id',$item->model_id)->pluck('model')->first();
                    $product_suppliers[] = User::where('id',$item->supplier_id)->first();
                }
                else
                {
                    $blinds_category_id = Category::where('cat_name','LIKE', '%Blinds%')->orWhere('cat_name','LIKE', '%Binnen zonwering%')->pluck('id')->first();
                    $supplier_products[$i] = Products::where('user_id',$item->supplier_id)->where('category_id',$blinds_category_id)->get();
                    $colors[$i] = colors::where('product_id',$item->product_id)->get();
                    $models[$i] = product_models::where('product_id',$item->product_id)->get();
                }

                foreach ($item->features as $feature)
                {
                    $features[$f] = product_features::leftjoin('model_features','model_features.product_feature_id','=','product_features.id')->where('product_features.product_id',$item->product_id)->where('product_features.heading_id',$feature->feature_id)->where('product_features.sub_feature',0)->where('model_features.model_id',$item->model_id)->where('model_features.linked',1)->select('product_features.*')->get();

                    if($feature->ladderband)
                    {
                        if(\Route::currentRouteName() == 'view-new-quotation')
                        {
                            $sub_products[$i] = new_quotations_sub_products::leftjoin('product_ladderbands','product_ladderbands.id','=','new_quotations_sub_products.sub_product_id')->where('new_quotations_sub_products.feature_row_id',$feature->id)->select('new_quotations_sub_products.*','product_ladderbands.title','product_ladderbands.code')->get();
                        }
                        else
                        {
                            $sub_products[$i] = new_invoices_sub_products::leftjoin('product_ladderbands','product_ladderbands.id','=','new_invoices_sub_products.sub_product_id')->where('new_invoices_sub_products.feature_row_id',$feature->id)->select('new_invoices_sub_products.*','product_ladderbands.title','product_ladderbands.code')->get();
                        }
                    }

                    $f = $f + 1;
                }

                foreach ($item->sub_features as $sub_feature)
                {
                    $sub_features[$s] = product_features::where('product_id',$item->product_id)->where('main_id',$sub_feature->feature_id)->get();
                    $s = $s + 1;
                }
            }

            if($check->form_type == 1)
            {
                if($user_role == 2)
                {
                    $services = Service::leftjoin('retailer_services', 'retailer_services.service_id', '=', 'services.id')->where('retailer_services.retailer_id', $user_id)->select('services.*','retailer_services.sell_rate as rate')->get();
                    $items = items::leftjoin('categories','categories.id','=','items.category_id')->where('items.user_id',$user_id)->select('items.*','categories.cat_name as category')->get();
                    return view('user.create_custom_quote1', compact('products','product_titles','item_titles','service_titles','color_titles','model_titles','product_suppliers','features','sub_features','customers','invoice','sub_products','services','items'));
                }
                else
                {
                    return view('user.create_custom_quote1', compact('products','product_titles','color_titles','model_titles','product_suppliers','features','sub_features','customers','invoice','sub_products'));
                }
            }
            else
            {
                return view('user.create_new_quotation1', compact('products','supplier_products','suppliers','colors','models','features','sub_features','customers','invoice','sub_products'));
            }
        }
        else
        {
            return redirect()->back();
        }
    }

    public function EditOrder($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if(\Route::currentRouteName() == 'edit-order')
        {
            if($user_role == 2)
            {
                $check = new_orders::leftjoin('new_quotations','new_quotations.id','=','new_orders.quotation_id')->where('new_orders.id',$id)->where('new_quotations.creator_id',$user_id)->select('new_quotations.*','new_orders.approved','new_orders.order_sent','new_orders.supplier_id','new_orders.quotation_id')->first();
            }
            else
            {
                $check = new_orders::leftjoin('new_quotations','new_quotations.id','=','new_orders.quotation_id')->where('new_orders.quotation_id',$id)->where('new_orders.supplier_id',$user_id)->select('new_quotations.*','new_orders.approved','new_orders.order_sent','new_orders.supplier_id','new_orders.quotation_id')->first();
            }
        }
        else
        {
            $check = new_orders::leftjoin('new_quotations','new_quotations.id','=','new_orders.quotation_id')->where('new_orders.quotation_id',$id)->where('new_quotations.creator_id',$user_id)->select('new_quotations.*','new_orders.approved','new_orders.order_sent','new_orders.supplier_id','new_orders.quotation_id')->first();
        }

        if($check)
        {            
            $quotation_id = $check->quotation_id;
            $supplier_id = $check->supplier_id;
            
            if(\Route::currentRouteName() == 'edit-order')
            {
                if($check->form_type == 1)
                {
                    $floor_category_id = Category::where('cat_name','LIKE', '%Floors%')->orWhere('cat_name','LIKE', '%Vloeren%')->pluck('id')->first();
                    $products = products::leftjoin('users','users.id','=','products.user_id')->where('user_id',$supplier_id)->where('products.category_id',$floor_category_id)->with('colors')->with('models')->select('products.*','users.name','users.family_name','users.company_name')->get();
                }
                else
                {
                    $blinds_category_id = Category::where('cat_name','LIKE', '%Blinds%')->orWhere('cat_name','LIKE', '%Binnen zonwering%')->pluck('id')->first();
                    $products = Products::where('user_id',$supplier_id)->where('category_id',$blinds_category_id)->with('colors')->with('models')->get();
                }

                $suppliers = array();

                $invoice = new_orders::leftjoin('products','products.id','=','new_orders.product_id')->where('new_orders.quotation_id', $quotation_id)->where('new_orders.supplier_id',$supplier_id)->select('new_orders.*','products.ladderband','products.ladderband_value','products.ladderband_price_impact','products.ladderband_impact_type')
                    ->with(['features' => function($query)
                    {
                        $query->leftjoin('features','features.id','=','new_orders_features.feature_id')
                            ->select('new_orders_features.*','features.title','features.comment_box');

                    }])
                    ->with(['sub_features' => function($query)
                    {
                        $query->leftjoin('product_features','product_features.id','=','new_orders_features.feature_id')
                            ->select('new_orders_features.*','product_features.title');

                    }])->with('calculations')->get();
            }
            else
            {
                $products = array();

                if($check->form_type == 1)
                {
                    $suppliers = array();
                }
                else
                {
                    $suppliers = User::leftjoin('retailers_requests','retailers_requests.retailer_id','=','users.id')->where('users.id',$user_id)->where('retailers_requests.status',1)->where('retailers_requests.active',1)->pluck('retailers_requests.supplier_id');
                    $suppliers = User::whereIn('id',$suppliers)->get();
                }

                $invoice = new_orders::leftjoin('products','products.id','=','new_orders.product_id')->where('new_orders.quotation_id', $quotation_id)->select('new_orders.*','products.ladderband','products.ladderband_value','products.ladderband_price_impact','products.ladderband_impact_type')
                    ->with(['features' => function($query)
                    {
                        $query->leftjoin('features','features.id','=','new_orders_features.feature_id')
                            ->select('new_orders_features.*','features.title','features.comment_box');

                    }])
                    ->with(['sub_features' => function($query)
                    {
                        $query->leftjoin('product_features','product_features.id','=','new_orders_features.feature_id')
                            ->select('new_orders_features.*','product_features.title');

                    }])->with('calculations')->get();

            }

            if (!$invoice) {
                return redirect()->back();
            }

            $supplier_products = array();
            $sub_products = array();
            $colors = array();
            $models = array();
            $features = array();
            $sub_features = array();

            $f = 0;
            $s = 0;

            foreach ($invoice as $i => $item)
            {
                if($check->form_type == 1)
                {
                    if(\Route::currentRouteName() == 'view-order')
                    {
                        $floor_category_id = Category::where('cat_name','LIKE', '%Floors%')->orWhere('cat_name','LIKE', '%Vloeren%')->pluck('id')->first();
                        $supplier_products[] = Products::where('user_id',$item->supplier_id)->where('category_id',$floor_category_id)->get();
                    }
                    
                    $product_titles[] = product::where('id',$item->product_id)->pluck('title')->first();
                    $color_titles[] = colors::where('id',$item->color)->pluck('title')->first();
                    $model_titles[] = product_models::where('id',$item->model_id)->pluck('model')->first();
                    $product_suppliers[] = User::where('id',$item->supplier_id)->first();
                }
                else
                {
                    if(\Route::currentRouteName() == 'view-order')
                    {
                        $blinds_category_id = Category::where('cat_name','LIKE', '%Blinds%')->orWhere('cat_name','LIKE', '%Binnen zonwering%')->pluck('id')->first();
                        $supplier_products[$i] = Products::where('user_id',$item->supplier_id)->where('category_id',$blinds_category_id)->get();
                    }
                    
                    $colors[$i] = colors::where('product_id',$item->product_id)->get();
                    $models[$i] = product_models::where('product_id',$item->product_id)->get();
                }

                foreach ($item->features as $feature)
                {
                    $features[$f] = product_features::leftjoin('model_features','model_features.product_feature_id','=','product_features.id')->where('product_features.product_id',$item->product_id)->where('product_features.heading_id',$feature->feature_id)->where('product_features.sub_feature',0)->where('model_features.model_id',$item->model_id)->where('model_features.linked',1)->select('product_features.*')->get();

                    if($feature->ladderband)
                    {
                        $sub_products[$i] = new_orders_sub_products::leftjoin('product_ladderbands','product_ladderbands.id','=','new_orders_sub_products.sub_product_id')->where('new_orders_sub_products.feature_row_id',$feature->id)->select('new_orders_sub_products.*','product_ladderbands.title','product_ladderbands.code')->get();
                    }

                    $f = $f + 1;
                }

                foreach ($item->sub_features as $sub_feature)
                {
                    $sub_features[$s] = product_features::where('product_id',$item->product_id)->where('main_id',$sub_feature->feature_id)->get();
                    $s = $s + 1;
                }
            }

            if($check->form_type == 1)
            {
                return view('user.edit_order1', compact('product_titles','color_titles','model_titles','product_suppliers','check','suppliers','supplier_products','products','colors','models','features','sub_features','invoice','sub_products'));
            }
            else
            {
                return view('user.edit_order', compact('check','suppliers','supplier_products','products','colors','models','features','sub_features','invoice','sub_products'));
            }
        }
        else
        {
            return redirect()->back();
        }
    }

    public function DownloadNewQuotation($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        $invoice = new_quotations::where('id', $id)->where('creator_id', $user_id)->first();

        if (!$invoice) {
            return redirect()->back();
        }

        $quotation_invoice_number = $invoice->quotation_invoice_number;
        $filename = $quotation_invoice_number . '.pdf';

        return response()->download(public_path("assets/newQuotations/{$filename}"));
    }

    public function DownloadInvoicePDF($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;
        $main_id = $user->main_id;

        if($user_role == 2)
        {
            if($main_id)
            {
                $user_id = $main_id;
            }

            $invoice = new_invoices::where('id', $id)->where('creator_id', $user_id)->first();
        }
        else
        {
            $invoice = new_invoices::where('id', $id)->where('user_id', $user_id)->first();
        }

        if (!$invoice) {
            return redirect()->back();
        }

        $invoice_number = $invoice->invoice_number;
        $filename = $invoice_number . '.pdf';

        return response()->download(public_path("assets/newInvoices/{$filename}"));
    }

    public function DownloadNegativeInvoicePDF($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;
        $main_id = $user->main_id;

        if($user_role == 2)
        {
            if($main_id)
            {
                $user_id = $main_id;
            }

            $invoice = new_negative_invoices::where('quotation_id', $id)->where('creator_id', $user_id)->first();
        }
        else
        {
            $invoice = new_negative_invoices::where('quotation_id', $id)->where('user_id', $user_id)->first();
        }

        if (!$invoice) {
            return redirect()->back();
        }

        $invoice_number = $invoice->invoice_number;
        $filename = $invoice_number . '.pdf';

        return response()->download(public_path("assets/newNegativeInvoices/{$filename}"));
    }

    public function DownloadFullOrderPDF($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user_role == 2)
        {
            $check = new_quotations::where('id',$id)->where('creator_id',$user_id)->first();
        }
        else
        {
            $check = '';

        }

        if (!$check) {
            return redirect()->back();
        }

        $order_number = $check->quotation_invoice_number;
        $filename = $order_number . '.pdf';

        return response()->download(public_path("assets/Orders/{$filename}"));

    }

    public function DownloadOrderPDF($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user_role == 2)
        {
            $check = new_orders::leftjoin('new_quotations','new_quotations.id','=','new_orders.quotation_id')->where('new_orders.id',$id)->where('new_quotations.creator_id',$user_id)->where('new_quotations.finished',1)->first();
            // $check = new_quotations_data::leftjoin('new_quotations','new_quotations.id','=','new_quotations_data.quotation_id')->where('new_quotations_data.id',$id)->where('new_quotations.creator_id',$user_id)->where('new_quotations.finished',1)->first();
        }
        else
        {
            $check = new_orders::leftjoin('new_quotations','new_quotations.id','=','new_orders.quotation_id')->where('new_orders.id',$id)->where('new_orders.supplier_id',$user_id)->where('new_quotations.finished',1)->first();
            // $check = new_quotations_data::leftjoin('new_quotations','new_quotations.id','=','new_quotations_data.quotation_id')->where('new_quotations_data.id',$id)->where('new_quotations_data.supplier_id',$user_id)->where('new_quotations.finished',1)->first();
        }

        if (!$check) {
            return redirect()->back();
        }

        $order_number = $check->order_number;
        $filename = $order_number . '.pdf';

        return response()->download(public_path("assets/supplierQuotations/{$filename}"));

    }

    public function DownloadOrderConfirmationPDF($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user_role == 2)
        {
            $check = new_orders::leftjoin('new_quotations','new_quotations.id','=','new_orders.quotation_id')->where('new_orders.id',$id)->where('new_quotations.creator_id',$user_id)->where('new_quotations.finished',1)->first();
            // $check = new_quotations_data::leftjoin('new_quotations','new_quotations.id','=','new_quotations_data.quotation_id')->where('new_quotations_data.id',$id)->where('new_quotations.creator_id',$user_id)->where('new_quotations.finished',1)->first();
        }
        else
        {
            $check = new_orders::leftjoin('new_quotations','new_quotations.id','=','new_orders.quotation_id')->where('new_orders.id',$id)->where('new_orders.supplier_id',$user_id)->where('new_orders.approved',1)->first();
            // $check = new_quotations_data::leftjoin('new_quotations','new_quotations.id','=','new_quotations_data.quotation_id')->where('new_quotations_data.id',$id)->where('new_quotations_data.supplier_id',$user_id)->where('new_quotations_data.approved',1)->first();
        }

        if (!$check) {
            return redirect()->back();
        }

        $order_number = $check->order_number;
        $filename = $order_number . '.pdf';

        return response()->download(public_path("assets/supplierApproved/{$filename}"));
    }

    public function DownloadClientNewQuotation($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;

        $invoice = new_quotations::where('id', $id)->where('user_id', $user_id)->first();

        if (!$invoice) {
            return redirect()->route('client-new-quotations');
        }

        $quotation_invoice_number = $invoice->quotation_invoice_number;

        $filename = $quotation_invoice_number . '.pdf';

        return response()->download(public_path("assets/newQuotations/{$filename}"));
    }

    public function StoreNewOrder(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;
        $user_role = $user->role_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
            $user_id = $user->id;
        }

        $products = $request->products;
        $client = customers_details::leftjoin('users','users.id','=','customers_details.user_id')->where('customers_details.id', $request->customer)->select('customers_details.*','users.email')->first();

        if($request->form_type == 2)
        {
            $order_number = new_orders::where('quotation_id',$request->quotation_id)->where('supplier_id',$request->supplier_id)->first();
            $order_number = $order_number->order_number;
            $order_ids = new_orders::where('quotation_id',$request->quotation_id)->where('supplier_id',$request->supplier_id)->pluck('id');
            new_orders::where('quotation_id',$request->quotation_id)->where('supplier_id',$request->supplier_id)->delete();
        }
        else
        {
            $order_ids = new_orders::where('quotation_id',$request->quotation_id)->pluck('id');
            new_orders::where('quotation_id',$request->quotation_id)->delete();
            $order_numbers = array();
        }

        $order_feature_ids = new_orders_features::whereIn('order_data_id',$order_ids)->pluck('id');
        new_orders_features::whereIn('order_data_id',$order_ids)->delete();
        new_orders_sub_products::whereIn('feature_row_id',$order_feature_ids)->delete();

        if($request->category == 1)
        {
            new_orders_calculations::whereIn('order_id',$order_ids)->delete();
        }

        foreach ($products as $i => $key) {

            $sub_titles[$i] = '';
            $row_id = $request->row_id[$i];
            $product_titles[] = product::where('id',$key)->pluck('title')->first();
            $color_titles[] = colors::where('id',$request->colors[$i])->pluck('title')->first();
            $model_titles[] = product_models::where('id',$request->models[$i])->pluck('model')->first();

            date_default_timezone_set('Europe/Amsterdam');
            $delivery_date = date('Y-m-d', strtotime( $request->retailer_delivery_date . ' -1 day' ));
            $is_weekend = date('N', strtotime($delivery_date)) >= 6;

            while($is_weekend)
            {
                $delivery_date = date('Y-m-d', strtotime($delivery_date. '- 1 day'));
                $is_weekend = date('N', strtotime($delivery_date)) >= 6;
            }
            
            // $delivery_date = date('Y-m-d', strtotime("+".$request->delivery_days[$i].' days'));
            // $is_weekend = date('N', strtotime($delivery_date)) >= 6;

            // while($is_weekend)
            // {
            //     $delivery_date = date('Y-m-d', strtotime($delivery_date. '+ 1 days'));
            //     $is_weekend = date('N', strtotime($delivery_date)) >= 6;
            // }

            if($request->form_type == 1)
            {
                $suppliers[] = User::where('id',$request->suppliers[$i])->first();

                if($request->order_number[$i])
                {
                    $order_number = $request->order_number[$i];
                }
                else
                {
                    $order_number = new_orders::where('quotation_id',$request->quotation_id)->where('supplier_id',$request->suppliers[$i])->pluck('order_number')->first();

                    if(!$order_number)
                    {
                        $counter_order = $suppliers[$i]->counter_order;
                        $order_number = $suppliers[$i]->order_client_id ? date("Y") . "-" . sprintf('%04u', $suppliers[$i]->id) . '-' . sprintf('%06u', $counter_order) : date("Y") . "-" . sprintf('%06u', $counter_order);
                        $counter_order = $counter_order + 1;
                        User::where('id',$request->suppliers[$i])->update(['counter_order' => $counter_order]);
                    }
                }

                $order_numbers[$i] = $order_number;
            }
            else
            {
                $supplier_data = User::where('id',$request->supplier_id)->first();
            }

            $order = new new_orders;
            $order->order_number = $order_number;
            $order->quotation_id = $request->quotation_id;
            $order->supplier_id = $request->form_type == 1 ? $request->suppliers[$i] : $request->supplier_id;
            $order->product_id = (int)$key;
            $order->row_id = $row_id;
            $order->model_id = $request->models[$i];
            $order->model_impact_value = 0;
            $order->color = $request->colors[$i];
            $order->rate = 0;
            $order->basic_price = 0;
            $order->qty = $request->qty[$i] ? str_replace(',', '.',$request->qty[$i]) : 0;
            $order->amount = 0;
            $order->delivery_days = $request->delivery_days[$i];
            $order->delivery_date = $delivery_date;
            $order->price_before_labor = 0;
            $order->labor_impact = 0;
            $order->discount = 0;
            $order->labor_discount = 0;
            $order->total_discount = 0;
            $order->base_price = 0;
            $order->supplier_margin = 0;
            $order->retailer_margin = 0;

            if($request->category == 2)
            {
                $order->width = str_replace(',', '.',$request->width[$i]);
                $order->width_unit = $request->width_unit[$i];
                $order->height = str_replace(',', '.',$request->height[$i]);
                $order->height_unit = $request->height_unit[$i];
                $order->box_quantity = NULL;
                $order->measure = NULL;
                $order->max_width = NULL;
            }
            else
            {
                $order->width = 0;
                $order->width_unit = "";
                $order->height = 0;
                $order->height_unit = "";
                $order->box_quantity = $request->estimated_price_quantity[$i];
                $order->measure = $request->measure[$i];
                $order->max_width = $request->max_width[$i];
            }

            if($request->childsafe[$i])
            {
                $order->childsafe = $request->childsafe[$i];

                $childsafe_question = 'childsafe_option'.$row_id;
                $order->childsafe_question = $request->$childsafe_question;

                $childsafe_diff = 'childsafe_diff'.$row_id;
                $order->childsafe_diff = $request->$childsafe_diff;

                $childsafe_answer = 'childsafe_answer'.$row_id;
                $order->childsafe_answer = $request->$childsafe_answer;

                $childsafe_x = 'childsafe_x'.$row_id;
                $order->childsafe_x = $request->$childsafe_x;

                $childsafe_y = 'childsafe_y'.$row_id;
                $order->childsafe_y = $request->$childsafe_y;
            }

            $order->save();

            if($request->category == 1)
            {
                $calculator_row = 'calculator_row'.$row_id;
                $calculator_row = $request->$calculator_row;

                foreach($calculator_row as $c => $cal)
                {
                    $description = 'attribute_description'.$row_id;
                    $width = 'width'.$row_id;
                    $height = 'height'.$row_id;
                    $cutting_lose = 'cutting_lose_percentage'.$row_id;
                    $box_quantity_supplier = 'box_quantity_supplier'.$row_id;
                    $box_quantity = 'box_quantity'.$row_id;
                    $total_boxes = 'total_boxes'.$row_id;
                    $max_width = 'max_width'.$row_id;
                    $turn = 'turn'.$row_id;

                    if(is_numeric( $cal ) && floor( $cal ) != $cal)
                    {
                        $parent_row = floor($cal);
                    }
                    else
                    {
                        $parent_row = NULL;
                    }

                    $order_calculations = new new_orders_calculations;
                    $order_calculations->order_id = $order->id;
                    $order_calculations->calculator_row = $cal;
                    $order_calculations->parent_row = $parent_row;
                    $order_calculations->description = $request->$description[$c];
                    $order_calculations->width = $request->$width[$c] ? str_replace(',', '.',$request->$width[$c]) : NULL;
                    $order_calculations->height = $request->$height[$c] ? str_replace(',', '.',$request->$height[$c]) : NULL;
                    $order_calculations->cutting_lose = $request->$cutting_lose[$c];
                    $order_calculations->box_quantity_supplier = $request->$box_quantity_supplier[$c];
                    $order_calculations->box_quantity = $request->$box_quantity[$c];
                    $order_calculations->total_boxes = $request->$total_boxes[$c];
                    $order_calculations->max_width = $request->$max_width[$c];
                    $order_calculations->turn = $request->$turn[$c];
                    $order_calculations->save();
                }
            }

            $feature_row = 'features'.$row_id;
            $features = $request->$feature_row;

            if($features)
            {
                foreach($features as $f => $key1)
                {
                    $f_row = 'f_id'.$row_id;
                    $f_ids = $request->$f_row;

                    $f_row1 = 'f_price'.$row_id;
                    $f_prices = $request->$f_row1;

                    $is_sub = 'sub_feature'.$row_id;
                    $is_sub_feature = $request->$is_sub;

                    $comment = 'comment-'.$row_id.'-'.$f_ids[$f];
                    $comment = $request->$comment;

                    if($f_ids[$f] == 0)
                    {
                        $post_order_features = new new_orders_features;
                        $post_order_features->order_data_id = $order->id;
                        $post_order_features->price = $f_prices[$f];
                        $post_order_features->feature_id = $f_ids[$f];
                        $post_order_features->feature_sub_id = 0;
                        $post_order_features->ladderband = $key1;
                        $post_order_features->save();

                        if($key1)
                        {
                            $size1 = 'sizeA'.$row_id[$f];
                            $size1_value = $request->$size1;

                            $size2 = 'sizeB'.$row_id[$f];
                            $size2_value = $request->$size2;

                            $sub = 'sub_product_id'.$row_id[$f];
                            $sub_value = $request->$sub;

                            foreach ($sub_value as $s => $key2)
                            {
                                $post_orders_sub_products = new new_orders_sub_products;
                                $post_orders_sub_products->feature_row_id = $post_order_features->id;
                                $post_orders_sub_products->sub_product_id = $key2;
                                $post_orders_sub_products->size1_value = $size1_value[$s];
                                $post_orders_sub_products->size2_value = $size2_value[$s];
                                $post_orders_sub_products->save();

                                if($size1_value[$s] == 1 || $size2_value[$s] == 1)
                                {
                                    $sub_titles[$i] = product_ladderbands::where('product_id',$key)->where('id',$key2)->first();

                                    if($size1_value[$s] == 1)
                                    {
                                        $sub_titles[$i]->size = '38mm';
                                    }
                                    else
                                    {
                                        $sub_titles[$i]->size = '25mm';
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        $post_order_features = new new_orders_features;
                        $post_order_features->order_data_id = $order->id;
                        $post_order_features->price = $f_prices[$f];
                        $post_order_features->feature_id = $f_ids[$f];
                        $post_order_features->feature_sub_id = $key1;
                        $post_order_features->sub_feature = $is_sub_feature[$f];
                        $post_order_features->comment = $comment;
                        $post_order_features->save();
                    }

                    $feature_sub_titles[$i][] = product_features::leftjoin('features','features.id','=','product_features.heading_id')->where('product_features.product_id',$key)->where('product_features.id',$key1)->select('product_features.*','features.title as main_title','features.order_no','features.id as f_id')->first();

                }
            }
            else
            {
                $feature_sub_titles[$i] = array();
            }

        }

        if($request->form_type == 1)
        {
            $quotation_invoice_number = $request->quotation_invoice_number;
            $filename = $quotation_invoice_number . '.pdf';
            ini_set('max_execution_time', 180);

            $role = 'supplier2';
            $date = $request->created_at;

            if($request->category == 1)
            {
                $form_type = 1;
                $pdf = PDF::loadView('user.pdf_new_quotation_1', compact('suppliers','order_numbers','form_type','role','product_titles','color_titles','model_titles','feature_sub_titles','sub_titles','date','client','user','request','quotation_invoice_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 160,'isRemoteEnabled' => true]);
            }
            else
            {
                $form_type = 2;
                $pdf = PDF::loadView('user.pdf_new_quotation', compact('form_type','suppliers','order_numbers','role','product_titles','color_titles','model_titles','feature_sub_titles','sub_titles','date','client','user','request','quotation_invoice_number'))->setPaper('letter', 'landscape')->setOptions(['dpi' => 160,'isRemoteEnabled' => true]);
            }
            
            $file = public_path() . '/assets/Orders/' . $filename;
            $pdf->save($file);

            Session::flash('success', 'Order has been updated successfully!');
            return redirect()->route('customer-quotations');
        }
        else{

            $quotation_id = $request->quotation_id;
            $request->products = new_orders::where('quotation_id',$quotation_id)->where('supplier_id',$request->supplier_id)->get();
            $product_titles = array();
            $color_titles = array();
            $model_titles = array();
            $sub_titles = array();
            $qty = array();
            $width = array();
            $width_unit = array();
            $height = array();
            $height_unit = array();
            $comments = array();
            $delivery = array();
            $labor_impact = array();
            $price_before_labor = array();
            $discount = array();
            $rate = array();
            $labor_discount = array();
            $total = array();
            $total_discount = array();
            $feature_sub_titles = array();

            foreach ($request->products as $x => $temp)
            {
                $feature_sub_titles[$x][] = array();
                $product_titles[] = product::where('id',$temp->product_id)->pluck('title')->first();
                $color_titles[] = colors::where('id',$temp->color)->pluck('title')->first();
                $model_titles[] = product_models::where('id',$temp->model_id)->pluck('model')->first();
                $qty[] = $temp->qty;
                $width[] = $temp->width;
                $width_unit[] = $temp->width_unit;
                $height[] = $temp->height;
                $height_unit[] = $temp->height_unit;
                $delivery[] = $temp->delivery_date;
                $labor_impact[] = $temp->labor_impact;
                $price_before_labor[] = $temp->price_before_labor;
                $discount[] = $temp->discount;
                $rate[] = $temp->rate;
                $labor_discount[] = $temp->labor_discount;
                $total[] = $temp->amount;
                $total_discount[] = $temp->total_discount;

                $features = new_orders_features::where('order_data_id',$temp->id)->get();

                foreach ($features as $f => $feature)
                {
                    if($feature->feature_id == 0)
                    {
                        if($feature->ladderband)
                        {
                            $sub_product = new_orders_sub_products::where('feature_row_id',$feature->id)->get();

                            foreach ($sub_product as $sub)
                            {
                                if($sub->size1_value == 1 || $sub->size2_value == 1)
                                {
                                    $sub_titles[$x] = product_ladderbands::where('product_id',$temp->product_id)->where('id',$sub->sub_product_id)->first();

                                    if($sub->size1_value == 1)
                                    {
                                        $sub_titles[$x]->size = '38mm';
                                    }
                                    else
                                    {
                                        $sub_titles[$x]->size = '25mm';
                                    }
                                }
                            }
                        }
                    }

                    $feature_sub_titles[$x][] = product_features::leftjoin('features','features.id','=','product_features.heading_id')->where('product_features.product_id',$temp->product_id)->where('product_features.id',$feature->feature_sub_id)->select('product_features.*','features.title as main_title','features.order_no','features.id as f_id')->first();
                    $comments[$x][] = $feature->comment;
                }
            }

            $request->qty = $qty;
            $request->width = $width;
            $request->width_unit = $width_unit;
            $request->height = $height;
            $request->height_unit = $height_unit;
            $request->delivery_date = $delivery;
            $request->labor_impact = $labor_impact;
            $request->price_before_labor = $price_before_labor;
            $request->discount = $discount;
            $request->rate = $rate;
            $request->labor_discount = $labor_discount;
            $request->total = $total;
            $request->total_discount = $total_discount;

            $quotation_invoice_number = $request->quotation_invoice_number;
            $filename = $order_number . '.pdf';
            $file = public_path() . '/assets/supplierQuotations/' . $filename;

            ini_set('max_execution_time', 180);

            $date = $request->created_at;

            if($request->category == 1)
            {
                $role = 'supplier3';
                $form_type = 1;
                $pdf = PDF::loadView('user.pdf_new_quotation_1', compact('supplier_data','form_type','role','product_titles','color_titles','model_titles','feature_sub_titles','sub_titles','date','client','user','request','quotation_invoice_number','order_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 160,'isRemoteEnabled' => true]);
            }
            else
            {
                $role = 'supplier1';
                $form_type = 2;
                $pdf = PDF::loadView('user.pdf_new_quotation', compact('supplier_data','form_type','role','comments','product_titles','color_titles','model_titles','feature_sub_titles','sub_titles','date','client','user','request', 'quotation_invoice_number','order_number'))->setPaper('letter', 'landscape')->setOptions(['dpi' => 160,'isRemoteEnabled' => true]);
            }

            $pdf->save($file);

            Session::flash('success', 'Order has been updated successfully!');

            if($user_role == 2)
            {
                return redirect()->route('new-orders');
            }
            else
            {
                return redirect()->route('customer-quotations');
            }
        }

    }

    public function StoreNewQuotation(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;
        $form_type = $request->form_type;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
            $user_id = $user->id;
        }

        $user_name = $user->name;
        $counter = $user->counter;
        $user_email = $user->email;
        $company_name = $user->company_name;
        $products = $request->products;

        $client = customers_details::leftjoin('users','users.id','=','customers_details.user_id')->where('customers_details.id', $request->customer)->select('customers_details.*','users.email')->first();

        if($request->quotation_id)
        {
            if($request->is_invoice)
            {
                if($form_type == 2)
                {
                    if(!$request->negative_invoice)
                    {
                        new_invoices::where('id',$request->quotation_id)->update(['delivery_date' => $request->retailer_delivery_date,'installation_date' => $request->installation_date,'price_before_labor_total' => str_replace(',', '.',$request->price_before_labor_total), 'labor_cost_total' => str_replace(',', '.',$request->labor_cost_total), 'net_amount' => str_replace(',', '.',$request->net_amount), 'tax_amount' => str_replace(',', '.',$request->tax_amount), 'customer_details' => $request->customer, 'user_id' => $client->user_id, 'ask_customization' => 0, 'subtotal' => str_replace(',', '.',$request->total_amount), 'grand_total' => str_replace(',', '.',$request->total_amount), 'mail_to' => $request->mail_to]);
                    }
                    else
                    {
                        if($request->negative_invoice_id)
                        {
                            new_negative_invoices::where('id',$request->negative_invoice_id)->update(['delivery_date' => $request->retailer_delivery_date,'installation_date' => $request->installation_date,'price_before_labor_total' => str_replace(',', '.',$request->price_before_labor_total), 'labor_cost_total' => str_replace(',', '.',$request->labor_cost_total), 'net_amount' => str_replace(',', '.',$request->net_amount), 'tax_amount' => str_replace(',', '.',$request->tax_amount), 'customer_details' => $request->customer, 'user_id' => $client->user_id, 'ask_customization' => 0, 'subtotal' => str_replace(',', '.',$request->total_amount), 'grand_total' => str_replace(',', '.',$request->total_amount), 'mail_to' => $request->mail_to]);
                        }
                    }
                }
                else
                {
                    if(!$request->negative_invoice)
                    {
                        new_invoices::where('id',$request->quotation_id)->update(['delivery_date' => $request->retailer_delivery_date,'installation_date' => $request->installation_date,'price_before_labor_total' => str_replace(',', '.',$request->price_before_labor_total), 'labor_cost_total' => 0, 'net_amount' => str_replace(',', '.',$request->net_amount), 'tax_amount' => str_replace(',', '.',$request->tax_amount), 'customer_details' => $request->quote_request_id ? 0 : $request->customer, 'user_id' => $request->quote_request_id ? 0 : $client->user_id, 'ask_customization' => 0, 'subtotal' => str_replace(',', '.',$request->total_amount), 'grand_total' => str_replace(',', '.',$request->total_amount), 'mail_to' => $request->mail_to]);
                    }
                    else
                    {
                        if($request->negative_invoice_id)
                        {
                            new_negative_invoices::where('id',$request->negative_invoice_id)->update(['delivery_date' => $request->retailer_delivery_date,'installation_date' => $request->installation_date,'price_before_labor_total' => str_replace(',', '.',$request->price_before_labor_total), 'labor_cost_total' => 0, 'net_amount' => str_replace(',', '.',$request->net_amount), 'tax_amount' => str_replace(',', '.',$request->tax_amount), 'customer_details' => $request->quote_request_id ? 0 : $request->customer, 'user_id' => $request->quote_request_id ? 0 : $client->user_id, 'ask_customization' => 0, 'subtotal' => str_replace(',', '.',$request->total_amount), 'grand_total' => str_replace(',', '.',$request->total_amount), 'mail_to' => $request->mail_to]);
                        }
                    }
                }

                if(!$request->negative_invoice)
                {
                    $data_ids = new_invoices_data::where('invoice_id',$request->quotation_id)->pluck('id');
                    $feature_ids = new_invoices_features::whereIn('invoice_data_id',$data_ids)->pluck('id');

                    new_invoices_data::where('invoice_id',$request->quotation_id)->delete();

                    if($form_type == 1)
                    {
                        new_invoices_data_calculations::whereIn('invoice_data_id',$data_ids)->delete();
                    }

                    new_invoices_features::whereIn('invoice_data_id',$data_ids)->delete();
                    new_invoices_sub_products::whereIn('feature_row_id',$feature_ids)->delete();

                    $invoice = new_invoices::where('id',$request->quotation_id)->first();
                    $invoice_number = $invoice->invoice_number;
                }
                else
                {
                    if(!$request->negative_invoice_id)
                    {
                        new_invoices::where('id',$request->quotation_id)->update(['has_negative_invoice' => 1]);

                        $counter_negative_invoice = $user->counter_invoice;
                        $invoice_number = $user->invoice_client_id ? date("Y") . "-" . sprintf('%04u', $user_id) . '-' . sprintf('%06u', $counter_negative_invoice) : date("Y") . '-' . sprintf('%06u', $counter_negative_invoice);
                        $counter_negative_invoice = $counter_negative_invoice + 1;
                        $user->counter_invoice = $counter_negative_invoice;
                        $user->save();

                        $org_invoice_data = new_invoices::where('id',$request->quotation_id)->first();
                        $org_invoice_data->invoice_number = $invoice_number;
                        $org_invoice_data->negative_invoice = 1;
                        $org_invoice_data->vat_percentage = 21;
                        $org_invoice_data->subtotal = str_replace(',', '.',$request->total_amount);
                        $org_invoice_data->grand_total = str_replace(',', '.',$request->total_amount);
                        $org_invoice_data->price_before_labor_total = str_replace(',', '.',$request->price_before_labor_total);

                        if($form_type == 2)
                        {
                            $org_invoice_data->user_id = $client->user_id;
                            $org_invoice_data->customer_details = $request->customer;
                            $org_invoice_data->labor_cost_total = str_replace(',', '.',$request->labor_cost_total);
                        }
                        else
                        {
                            $org_invoice_data->user_id = $request->quote_request_id ? 0 : $client->user_id;
                            $org_invoice_data->customer_details = $request->quote_request_id ? 0 : $request->customer;
                            $org_invoice_data->labor_cost_total = 0;
                        }

                        $org_invoice_data->net_amount = str_replace(',', '.',$request->net_amount);
                        $org_invoice_data->tax_amount = str_replace(',', '.',$request->tax_amount);
                        $org_invoice_data->delivery_date = $request->retailer_delivery_date;
                        $org_invoice_data->installation_date = $request->installation_date;
                        $invoice = $org_invoice_data->replicate();
                        $invoice->setTable('new_invoices');
                        $invoice->save();
                    }
                    else
                    {
                        $invoice = new_negative_invoices::where('id',$request->negative_invoice_id)->first();
                        $invoice_number = $invoice->invoice_number;
                    }

                    $data_ids = new_invoices_data::where('invoice_id',$request->negative_invoice_id)->pluck('id');
                    $feature_ids = new_invoices_features::whereIn('invoice_data_id',$data_ids)->pluck('id');

                    new_invoices_data::where('invoice_id',$request->negative_invoice_id)->delete();

                    if($form_type == 1)
                    {
                        new_invoices_data_calculations::whereIn('invoice_data_id',$data_ids)->delete();
                    }

                    new_invoices_features::whereIn('invoice_data_id',$data_ids)->delete();
                    new_invoices_sub_products::whereIn('feature_row_id',$feature_ids)->delete();
                }
            }
            else
            {
                $ask = new_quotations::where('id',$request->quotation_id)->pluck('ask_customization')->first();

                if($form_type == 2)
                {
                    new_quotations::where('id',$request->quotation_id)->update(['delivery_date' => $request->retailer_delivery_date,'installation_date' => $request->installation_date,'price_before_labor_total' => str_replace(',', '.',$request->price_before_labor_total), 'labor_cost_total' => str_replace(',', '.',$request->labor_cost_total), 'net_amount' => str_replace(',', '.',$request->net_amount), 'tax_amount' => str_replace(',', '.',$request->tax_amount), 'customer_details' => $request->customer, 'user_id' => $client->user_id, 'ask_customization' => 0, 'subtotal' => str_replace(',', '.',$request->total_amount), 'grand_total' => str_replace(',', '.',$request->total_amount), 'mail_to' => $request->mail_to]);
                }
                else
                {
                    new_quotations::where('id',$request->quotation_id)->update(['delivery_date' => $request->retailer_delivery_date,'installation_date' => $request->installation_date,'price_before_labor_total' => str_replace(',', '.',$request->price_before_labor_total), 'labor_cost_total' => 0, 'net_amount' => str_replace(',', '.',$request->net_amount), 'tax_amount' => str_replace(',', '.',$request->tax_amount), 'customer_details' => $request->quote_request_id ? 0 : $request->customer, 'user_id' => $request->quote_request_id ? 0 : $client->user_id, 'ask_customization' => 0, 'subtotal' => str_replace(',', '.',$request->total_amount), 'grand_total' => str_replace(',', '.',$request->total_amount), 'mail_to' => $request->mail_to]);
                }

                $data_ids = new_quotations_data::where('quotation_id',$request->quotation_id)->pluck('id');
                $feature_ids = new_quotations_features::whereIn('quotation_data_id',$data_ids)->pluck('id');

                $order_ids = new_orders::where('quotation_id',$request->quotation_id)->pluck('id');
                $order_feature_ids = new_orders_features::whereIn('order_data_id',$order_ids)->pluck('id');

                new_quotations_data::where('quotation_id',$request->quotation_id)->delete();

                if($form_type == 1)
                {
                    new_quotations_data_calculations::whereIn('quotation_data_id',$data_ids)->delete();
                    new_orders_calculations::whereIn('order_id',$order_ids)->delete();
                }

                new_quotations_features::whereIn('quotation_data_id',$data_ids)->delete();
                new_quotations_sub_products::whereIn('feature_row_id',$feature_ids)->delete();

                new_orders::where('quotation_id',$request->quotation_id)->delete();
                new_orders_features::whereIn('order_data_id',$order_ids)->delete();
                new_orders_sub_products::whereIn('feature_row_id',$order_feature_ids)->delete();

                $invoice = new_quotations::where('id',$request->quotation_id)->first();
                $quotation_invoice_number = $invoice->quotation_invoice_number;
            }

        }
        else
        {
            $quotation_invoice_number = $user->quotation_client_id ? date("Y") . "-" . sprintf('%04u', $user_id) . '-' . sprintf('%06u', $counter) : date("Y") . '-' . sprintf('%06u', $counter);

            $invoice = new new_quotations();
            $invoice->quote_request_id = $request->quote_request_id;
            $invoice->form_type = $form_type;
            $invoice->quotation_invoice_number = $quotation_invoice_number;
            $invoice->creator_id = $user_id;
            $invoice->vat_percentage = 21;
            $invoice->subtotal = str_replace(',', '.',$request->total_amount);
            $invoice->grand_total = str_replace(',', '.',$request->total_amount);
            $invoice->price_before_labor_total = str_replace(',', '.',$request->price_before_labor_total);

            if($form_type == 2)
            {
                $invoice->user_id = $client->user_id;
                $invoice->customer_details = $request->customer;
                $invoice->labor_cost_total = str_replace(',', '.',$request->labor_cost_total);
            }
            else
            {
                $invoice->user_id = $request->quote_request_id ? 0 : $client->user_id;
                $invoice->customer_details = $request->quote_request_id ? 0 : $request->customer;
                $invoice->labor_cost_total = 0;
            }
            
            $invoice->net_amount = str_replace(',', '.',$request->net_amount);
            $invoice->tax_amount = str_replace(',', '.',$request->tax_amount);
            $invoice->delivery_date = $request->retailer_delivery_date;
            $invoice->installation_date = $request->installation_date;
            $invoice->save();

            if($form_type == 1 && $request->quote_request_id)
            {
                $quote = quotes::where('id', $request->quote_request_id)->update(['status' => 1]);
            }
            
        }

        $order_numbers = array();
        $feature_sub_titles = array();

        foreach ($products as $i => $key) {

            /*$feature_titles[$i][] = 'empty';*/
            $feature_sub_titles[$i][] = array();
            $sub_titles[$i] = '';
            $row_id = $request->row_id[$i];
            
            if (strpos($key, 'I') > -1) {

                $product_titles[] = items::where('id',(int)$key)->pluck('cat_name')->first();
                $color_titles[] = '';
                $model_titles[] = '';
                $suppliers[] = NULL;

            }
            elseif (strpos($key, 'S') > -1) {

                $product_titles[] = Service::where('id',(int)$key)->pluck('title')->first();
                $color_titles[] = '';
                $model_titles[] = '';
                $suppliers[] = NULL;

            }
            else
            {
                $product_titles[] = product::where('id',$key)->pluck('title')->first();
                $color_titles[] = colors::where('id',$request->colors[$i])->pluck('title')->first();
                $model_titles[] = product_models::where('id',$request->models[$i])->pluck('model')->first();
                $suppliers[] = User::where('id',$request->suppliers[$i])->first();
            }

            date_default_timezone_set('Europe/Amsterdam');
            $delivery_date = date('Y-m-d', strtotime( $request->retailer_delivery_date . ' -1 day' ));
            $is_weekend = date('N', strtotime($delivery_date)) >= 6;

            while($is_weekend)
            {
                $delivery_date = date('Y-m-d', strtotime($delivery_date. '- 1 day'));
                $is_weekend = date('N', strtotime($delivery_date)) >= 6;
            }

            // $delivery_date = date('Y-m-d', strtotime("+".$request->delivery_days[$i].' days'));
            // $is_weekend = date('N', strtotime($delivery_date)) >= 6;

            // while($is_weekend)
            // {
            //     $delivery_date = date('Y-m-d', strtotime($delivery_date. '+ 1 days'));
            //     $is_weekend = date('N', strtotime($delivery_date)) >= 6;
            // }

            if(!$request->is_invoice)
            {
                $invoice_items = new new_quotations_data;
                $invoice_items->quotation_id = $invoice->id;

                if (strpos($key, 'I') > -1) {

                    $order_numbers[$i] = '';

                    $invoice_items->item_id = (int)$key;
                    $invoice_items->service_id = 0;
                    $invoice_items->supplier_id = 0;
                    $invoice_items->product_id = 0;
                    $invoice_items->model_id = 0;
                    $invoice_items->color = 0;

                }
                elseif (strpos($key, 'S') > -1) {

                    $order_numbers[$i] = '';

                    $invoice_items->item_id = 0;
                    $invoice_items->service_id = (int)$key;
                    $invoice_items->supplier_id = 0;
                    $invoice_items->product_id = 0;
                    $invoice_items->model_id = 0;
                    $invoice_items->color = 0;

                }
                else {

                    if(!$request->order_number[$i])
                    {
                        $order_number = new_orders::where('quotation_id',$invoice->id)->where('supplier_id',$request->suppliers[$i])->pluck('order_number')->first();

                        if(!$order_number)
                        {
                            $counter_order = $suppliers[$i]->counter_order;
                            $order_number = $suppliers[$i]->order_client_id ? date("Y") . "-" . sprintf('%04u', $suppliers[$i]->id) . '-' . sprintf('%06u', $counter_order) : date("Y") . '-' . sprintf('%06u', $counter_order);
                            $counter_order = $counter_order + 1;
                            User::where('id',$suppliers[$i]->id)->update(['counter_order' => $counter_order]);
                        }
                    }
                    else
                    {
                        $order_number = $request->order_number[$i];
                    }

                    $order_numbers[$i] = $order_number;

                    $invoice_items->order_number = $order_number;
                    $invoice_items->item_id = 0;
                    $invoice_items->service_id = 0;
                    $invoice_items->supplier_id = $request->suppliers[$i] ? $request->suppliers[$i] : $user_id;
                    $invoice_items->product_id = (int)$key;
                    $invoice_items->model_id = $request->models[$i];
                    $invoice_items->color = $request->colors[$i];

                }

                if($form_type == 2)
                {
                    $invoice_items->model_impact_value = $request->model_impact_value[$i];
                    $invoice_items->width = str_replace(',', '.',$request->width[$i]);
                    $invoice_items->width_unit = $request->width_unit[$i];
                    $invoice_items->height = str_replace(',', '.',$request->height[$i]);
                    $invoice_items->height_unit = $request->height_unit[$i];
                    $invoice_items->price_based_option = $request->price_based_option[$i];
                    $invoice_items->labor_impact = $request->labor_impact[$i] ? str_replace(',', '.',$request->labor_impact[$i]) : 0;
                    $invoice_items->supplier_margin = $request->supplier_margin[$i] ? $request->supplier_margin[$i] : 0;
                    $invoice_items->retailer_margin = $request->retailer_margin[$i] ? $request->retailer_margin[$i] : 0;
                    $invoice_items->labor_discount = $request->labor_discount[$i] ? $request->labor_discount[$i] : 0;
                    $invoice_items->basic_price = $request->basic_price[$i];
                    $invoice_items->box_quantity = NULL;
                    $invoice_items->measure = NULL;
                    $invoice_items->max_width = NULL;
                }
                else
                {
                    $invoice_items->model_impact_value = 0;
                    $invoice_items->width = 0;
                    $invoice_items->width_unit = "";
                    $invoice_items->height = 0;
                    $invoice_items->height_unit = "";
                    $invoice_items->price_based_option = 0;
                    $invoice_items->labor_impact = 0;
                    $invoice_items->supplier_margin = 0;
                    $invoice_items->retailer_margin = 0;
                    $invoice_items->labor_discount = 0;
                    $invoice_items->basic_price = 0;
                    $invoice_items->box_quantity = $request->estimated_price_quantity[$i] ? $request->estimated_price_quantity[$i] : 0;
                    $invoice_items->measure = $request->measure[$i] ? $request->measure[$i] : 0;
                    $invoice_items->max_width = $request->max_width[$i] ? $request->max_width[$i] : 0;
                }

                $invoice_items->row_id = $row_id;
                $invoice_items->rate = $request->rate[$i];
                $invoice_items->qty = $request->qty[$i] ? str_replace(',', '.',$request->qty[$i]) : 0;
                $invoice_items->amount = $request->total[$i];
                $invoice_items->delivery_days = $request->delivery_days[$i] ? $request->delivery_days[$i] : 1;
                $invoice_items->delivery_date = $delivery_date;
                $invoice_items->price_before_labor = $request->price_before_labor[$i] ? str_replace(',', '.',$request->price_before_labor[$i]) : 0;
                $invoice_items->discount = $request->discount[$i] ? $request->discount[$i] : 0;
                $invoice_items->total_discount = $request->total_discount[$i] ? str_replace(',', '.',$request->total_discount[$i]) : 0;
                $invoice_items->base_price = $request->base_price[$i] ? $request->base_price[$i] : 0;

                if (strpos($key, 'I') == 0 && strpos($key, 'S') == 0) {

                    $order = new new_orders;
                    $order->order_number = $order_number;
                    $order->quotation_id = $invoice->id;
                    $order->supplier_id = $request->suppliers[$i] ? $request->suppliers[$i] : $user_id;
                    $order->product_id = (int)$key;
                    $order->row_id = $row_id;
                    $order->model_id = $request->models[$i];
                    $order->color = $request->colors[$i];
                    $order->rate = $request->rate[$i];
                    $order->qty = $request->qty[$i] ? str_replace(',', '.',$request->qty[$i]) : 0;
                    $order->amount = $request->total[$i];
                    $order->delivery_days = $request->delivery_days[$i];
                    $order->delivery_date = $delivery_date;
                    $order->price_before_labor = $request->price_before_labor[$i] ? str_replace(',', '.',$request->price_before_labor[$i]) : 0;
                    $order->discount = $request->discount[$i] ? $request->discount[$i] : 0;
                    $order->total_discount = $request->total_discount[$i] ? str_replace(',', '.',$request->total_discount[$i]) : 0;
                    $order->base_price = $request->base_price[$i] ? $request->base_price[$i] : 0;

                    if($request->childsafe[$i])
                    {
                        $invoice_items->childsafe = $request->childsafe[$i];
                        $order->childsafe = $request->childsafe[$i];

                        $childsafe_question = 'childsafe_option'.$row_id;
                        $invoice_items->childsafe_question = $request->$childsafe_question;
                        $order->childsafe_question = $request->$childsafe_question;

                        $childsafe_diff = 'childsafe_diff'.$row_id;
                        $invoice_items->childsafe_diff = $request->$childsafe_diff;
                        $order->childsafe_diff = $request->$childsafe_diff;

                        $childsafe_answer = 'childsafe_answer'.$row_id;
                        $invoice_items->childsafe_answer = $request->$childsafe_answer;
                        $order->childsafe_answer = $request->$childsafe_answer;

                        $childsafe_x = 'childsafe_x'.$row_id;
                        $invoice_items->childsafe_x = $request->$childsafe_x;
                        $order->childsafe_x = $request->$childsafe_x;

                        $childsafe_y = 'childsafe_y'.$row_id;
                        $invoice_items->childsafe_y = $request->$childsafe_y;
                        $order->childsafe_y = $request->$childsafe_y;
                    }

                    if($form_type == 2)
                    {
                        $order->model_impact_value = $request->model_impact_value[$i];
                        $order->width = str_replace(',', '.',$request->width[$i]);
                        $order->width_unit = $request->width_unit[$i];
                        $order->height = str_replace(',', '.',$request->height[$i]);
                        $order->height_unit = $request->height_unit[$i];
                        $order->price_based_option = $request->price_based_option[$i];
                        $order->labor_impact = $request->labor_impact[$i] ? str_replace(',', '.',$request->labor_impact[$i]) : 0;
                        $order->labor_discount = $request->labor_discount[$i] ? $request->labor_discount[$i] : 0;
                        $order->supplier_margin = $request->supplier_margin[$i] ? $request->supplier_margin[$i] : 0;
                        $order->retailer_margin = $request->retailer_margin[$i] ? $request->retailer_margin[$i] : 0;
                        $order->basic_price = $request->basic_price[$i];
                        $order->box_quantity = NULL;
                        $order->measure = NULL;
                        $order->max_width = NULL;
                    }
                    else
                    {
                        $order->model_impact_value = 0;
                        $order->width = 0;
                        $order->width_unit = "";
                        $order->height = 0;
                        $order->height_unit = "";
                        $order->price_based_option = 0;
                        $order->labor_impact = 0;
                        $order->labor_discount = 0;
                        $order->supplier_margin = 0;
                        $order->retailer_margin = 0;
                        $order->basic_price = 0;
                        $order->box_quantity = $request->estimated_price_quantity[$i];
                        $order->measure = $request->measure[$i];
                        $order->max_width = $request->max_width[$i];
                    }

                    $invoice_items->save();
                    $order->save();

                    if($form_type == 1)
                    {
                        $calculator_row = 'calculator_row'.$row_id;
                        $calculator_row = $request->$calculator_row;

                        foreach($calculator_row as $c => $cal)
                        {
                            $description = 'attribute_description'.$row_id;
                            $width = 'width'.$row_id;
                            $height = 'height'.$row_id;
                            $cutting_lose = 'cutting_lose_percentage'.$row_id;
                            $box_quantity_supplier = 'box_quantity_supplier'.$row_id;
                            $box_quantity = 'box_quantity'.$row_id;
                            $total_boxes = 'total_boxes'.$row_id;
                            $max_width = 'max_width'.$row_id;
                            $turn = 'turn'.$row_id;

                            if(is_numeric( $cal ) && floor( $cal ) != $cal)
                            {
                                $parent_row = floor($cal);
                            }
                            else
                            {
                                $parent_row = NULL;
                            }

                            $calculations = new new_quotations_data_calculations;
                            $calculations->quotation_data_id = $invoice_items->id;
                            $calculations->calculator_row = $cal;
                            $calculations->parent_row = $parent_row;
                            $calculations->description = $request->$description[$c];
                            $calculations->width = $request->$width[$c] ? str_replace(',', '.',$request->$width[$c]) : NULL;
                            $calculations->height = $request->$height[$c] ? str_replace(',', '.',$request->$height[$c]) : NULL;
                            $calculations->cutting_lose = $request->$cutting_lose[$c];
                            $calculations->box_quantity_supplier = $request->$box_quantity_supplier[$c];
                            $calculations->box_quantity = $request->$box_quantity[$c];
                            $calculations->total_boxes = $request->$total_boxes[$c];
                            $calculations->max_width = $request->$max_width[$c];
                            $calculations->turn = $request->$turn[$c];
                            $calculations->save();

                            $order_calculations = new new_orders_calculations;
                            $order_calculations->order_id = $order->id;
                            $order_calculations->calculator_row = $cal;
                            $order_calculations->parent_row = $parent_row;
                            $order_calculations->description = $request->$description[$c];
                            $order_calculations->width = $request->$width[$c] ? str_replace(',', '.',$request->$width[$c]) : NULL;
                            $order_calculations->height = $request->$height[$c] ? str_replace(',', '.',$request->$height[$c]) : NULL;
                            $order_calculations->cutting_lose = $request->$cutting_lose[$c];
                            $order_calculations->box_quantity_supplier = $request->$box_quantity_supplier[$c];
                            $order_calculations->box_quantity = $request->$box_quantity[$c];
                            $order_calculations->total_boxes = $request->$total_boxes[$c];
                            $order_calculations->max_width = $request->$max_width[$c];
                            $order_calculations->turn = $request->$turn[$c];
                            $order_calculations->save();
                        }
                    }

                    $feature_row = 'features'.$row_id;
                    $features = $request->$feature_row;

                    if($features)
                    {
                        foreach($features as $f => $key1)
                        {
                            $f_row = 'f_id'.$row_id;
                            $f_ids = $request->$f_row;

                            $f_row1 = 'f_price'.$row_id;
                            $f_prices = $request->$f_row1;

                            $is_sub = 'sub_feature'.$row_id;
                            $is_sub_feature = $request->$is_sub;

                            $comment = 'comment-'.$row_id.'-'.$f_ids[$f];
                            $comment = $request->$comment;

                            if($f_ids[$f] == 0)
                            {
                                $post = new new_quotations_features;
                                $post->quotation_data_id = $invoice_items->id;
                                $post->price = $f_prices[$f];
                                $post->feature_id = $f_ids[$f];
                                $post->feature_sub_id = 0;
                                $post->ladderband = $key1;
                                $post->save();

                                $post_order_features = new new_orders_features;
                                $post_order_features->order_data_id = $order->id;
                                $post_order_features->price = $f_prices[$f];
                                $post_order_features->feature_id = $f_ids[$f];
                                $post_order_features->feature_sub_id = 0;
                                $post_order_features->ladderband = $key1;
                                $post_order_features->save();

                                if($key1)
                                {
                                    $size1 = 'sizeA'.$row_id[$f];
                                    $size1_value = $request->$size1;

                                    $size2 = 'sizeB'.$row_id[$f];
                                    $size2_value = $request->$size2;

                                    $sub = 'sub_product_id'.$row_id[$f];
                                    $sub_value = $request->$sub;

                                    foreach ($sub_value as $s => $key2)
                                    {
                                        $post1 = new new_quotations_sub_products;
                                        $post1->feature_row_id = $post->id;
                                        $post1->sub_product_id = $key2;
                                        $post1->size1_value = $size1_value[$s];
                                        $post1->size2_value = $size2_value[$s];
                                        $post1->save();

                                        $post_orders_sub_products = new new_orders_sub_products;
                                        $post_orders_sub_products->feature_row_id = $post_order_features->id;
                                        $post_orders_sub_products->sub_product_id = $key2;
                                        $post_orders_sub_products->size1_value = $size1_value[$s];
                                        $post_orders_sub_products->size2_value = $size2_value[$s];
                                        $post_orders_sub_products->save();

                                        if($size1_value[$s] == 1 || $size2_value[$s] == 1)
                                        {
                                            $sub_titles[$i] = product_ladderbands::where('product_id',$key)->where('id',$key2)->first();

                                            if($size1_value[$s] == 1)
                                            {
                                                $sub_titles[$i]->size = '38mm';
                                            }
                                            else
                                            {
                                                $sub_titles[$i]->size = '25mm';
                                            }
                                        }
                                    }
                                }
                            }
                            else
                            {
                                $post = new new_quotations_features;
                                $post->quotation_data_id = $invoice_items->id;
                                $post->price = $f_prices[$f];
                                $post->feature_id = $f_ids[$f];
                                $post->feature_sub_id = $key1;
                                $post->sub_feature = $is_sub_feature[$f];
                                $post->comment = $comment;
                                $post->save();

                                $post_order_features = new new_orders_features;
                                $post_order_features->order_data_id = $order->id;
                                $post_order_features->price = $f_prices[$f];
                                $post_order_features->feature_id = $f_ids[$f];
                                $post_order_features->feature_sub_id = $key1;
                                $post_order_features->sub_feature = $is_sub_feature[$f];
                                $post_order_features->comment = $comment;
                                $post_order_features->save();
                            }

                            /*$feature_titles[$i][] = features::where('id',$f_ids[$f])->first();*/
                            $feature_sub_titles[$i][] = product_features::leftjoin('features','features.id','=','product_features.heading_id')->where('product_features.product_id',$key)->where('product_features.id',$key1)->select('product_features.*','features.title as main_title','features.order_no','features.id as f_id')->first();
                        }
                    }
                    else
                    {
                        $feature_sub_titles[$i] = array();
                    }
                }
                else
                {
                    $invoice_items->save();
                    $feature_sub_titles[$i] = array();
                }
            }
            else
            {
                $invoice_items = new new_invoices_data;
                $invoice_items->invoice_id = $invoice->id;
                $invoice_items->row_id = $row_id;

                if (strpos($key, 'I') > -1) {

                    $invoice_items->item_id = (int)$key;
                    $invoice_items->service_id = 0;
                    $invoice_items->supplier_id = 0;
                    $invoice_items->product_id = 0;
                    $invoice_items->model_id = 0;
                    $invoice_items->color = 0;

                }
                elseif (strpos($key, 'S') > -1) {

                    $invoice_items->item_id = 0;
                    $invoice_items->service_id = (int)$key;
                    $invoice_items->supplier_id = 0;
                    $invoice_items->product_id = 0;
                    $invoice_items->model_id = 0;
                    $invoice_items->color = 0;

                }
                else {

                    $invoice_items->item_id = 0;
                    $invoice_items->service_id = 0;
                    $invoice_items->supplier_id = $request->suppliers[$i] ? $request->suppliers[$i] : $user_id;
                    $invoice_items->product_id = (int)$key;
                    $invoice_items->model_id = $request->models[$i];
                    $invoice_items->color = $request->colors[$i];

                }

                if($form_type == 2)
                {
                    $invoice_items->model_impact_value = $request->model_impact_value[$i];
                    $invoice_items->width = str_replace(',', '.',$request->width[$i]);
                    $invoice_items->width_unit = $request->width_unit[$i];
                    $invoice_items->height = str_replace(',', '.',$request->height[$i]);
                    $invoice_items->height_unit = $request->height_unit[$i];
                    $invoice_items->price_based_option = $request->price_based_option[$i];
                    $invoice_items->labor_impact = $request->labor_impact[$i] ? str_replace(',', '.',$request->labor_impact[$i]) : 0;
                    $invoice_items->supplier_margin = $request->supplier_margin[$i] ? $request->supplier_margin[$i] : 0;
                    $invoice_items->retailer_margin = $request->retailer_margin[$i] ? $request->retailer_margin[$i] : 0;
                    $invoice_items->labor_discount = $request->labor_discount[$i] ? $request->labor_discount[$i] : 0;
                    $invoice_items->basic_price = $request->basic_price[$i];
                    $invoice_items->box_quantity = NULL;
                    $invoice_items->measure = NULL;
                    $invoice_items->max_width = NULL;
                }
                else
                {
                    $invoice_items->model_impact_value = 0;
                    $invoice_items->width = 0;
                    $invoice_items->width_unit = "";
                    $invoice_items->height = 0;
                    $invoice_items->height_unit = "";
                    $invoice_items->price_based_option = 0;
                    $invoice_items->labor_impact = 0;
                    $invoice_items->supplier_margin = 0;
                    $invoice_items->retailer_margin = 0;
                    $invoice_items->labor_discount = 0;
                    $invoice_items->basic_price = 0;
                    $invoice_items->box_quantity = $request->estimated_price_quantity[$i];
                    $invoice_items->measure = $request->measure[$i];
                    $invoice_items->max_width = $request->max_width[$i];
                }

                $invoice_items->rate = $request->rate[$i];
                $invoice_items->qty = $request->qty[$i] ? str_replace(',', '.',$request->qty[$i]) : 0;
                $invoice_items->amount = $request->total[$i];
                $invoice_items->delivery_days = $request->delivery_days[$i];
                $invoice_items->delivery_date = $delivery_date;
                $invoice_items->price_before_labor = $request->price_before_labor[$i] ? str_replace(',', '.',$request->price_before_labor[$i]) : 0;
                $invoice_items->discount = $request->discount[$i] ? $request->discount[$i] : 0;
                $invoice_items->total_discount = $request->total_discount[$i] ? str_replace(',', '.',$request->total_discount[$i]) : 0;
                $invoice_items->base_price = $request->base_price[$i] ? $request->base_price[$i] : 0;

                if (strpos($key, 'I') == 0 && strpos($key, 'S') == 0) {

                    if($request->childsafe[$i])
                    {
                        $invoice_items->childsafe = $request->childsafe[$i];

                        $childsafe_question = 'childsafe_option'.$row_id;
                        $invoice_items->childsafe_question = $request->$childsafe_question;

                        $childsafe_diff = 'childsafe_diff'.$row_id;
                        $invoice_items->childsafe_diff = $request->$childsafe_diff;

                        $childsafe_answer = 'childsafe_answer'.$row_id;
                        $invoice_items->childsafe_answer = $request->$childsafe_answer;

                        $childsafe_x = 'childsafe_x'.$row_id;
                        $invoice_items->childsafe_x = $request->$childsafe_x;

                        $childsafe_y = 'childsafe_y'.$row_id;
                        $invoice_items->childsafe_y = $request->$childsafe_y;
                    }

                    $invoice_items->save();

                    if($form_type == 1)
                    {
                        $calculator_row = 'calculator_row'.$row_id;
                        $calculator_row = $request->$calculator_row;

                        foreach($calculator_row as $c => $cal)
                        {
                            $description = 'attribute_description'.$row_id;
                            $width = 'width'.$row_id;
                            $height = 'height'.$row_id;
                            $cutting_lose = 'cutting_lose_percentage'.$row_id;
                            $box_quantity_supplier = 'box_quantity_supplier'.$row_id;
                            $box_quantity = 'box_quantity'.$row_id;
                            $total_boxes = 'total_boxes'.$row_id;
                            $max_width = 'max_width'.$row_id;
                            $turn = 'turn'.$row_id;

                            if(is_numeric( $cal ) && floor( $cal ) != $cal)
                            {
                                $parent_row = floor($cal);
                            }
                            else
                            {
                                $parent_row = NULL;
                            }

                            $calculations = new new_invoices_data_calculations;
                            $calculations->invoice_data_id = $invoice_items->id;
                            $calculations->calculator_row = $cal;
                            $calculations->parent_row = $parent_row;
                            $calculations->description = $request->$description[$c];
                            $calculations->width = $request->$width[$c] ? str_replace(',', '.',$request->$width[$c]) : NULL;
                            $calculations->height = $request->$height[$c] ? str_replace(',', '.',$request->$height[$c]) : NULL;
                            $calculations->cutting_lose = $request->$cutting_lose[$c];
                            $calculations->box_quantity_supplier = $request->$box_quantity_supplier[$c];
                            $calculations->box_quantity = $request->$box_quantity[$c];
                            $calculations->total_boxes = $request->$total_boxes[$c];
                            $calculations->max_width = $request->$max_width[$c];
                            $calculations->turn = $request->$turn[$c];
                            $calculations->save();
                        }
                    }

                    $feature_row = 'features'.$row_id;
                    $features = $request->$feature_row;

                    if($features)
                    {
                        foreach($features as $f => $key1)
                        {
                            $f_row = 'f_id'.$row_id;
                            $f_ids = $request->$f_row;

                            $f_row1 = 'f_price'.$row_id;
                            $f_prices = $request->$f_row1;

                            $is_sub = 'sub_feature'.$row_id;
                            $is_sub_feature = $request->$is_sub;

                            $comment = 'comment-'.$row_id.'-'.$f_ids[$f];
                            $comment = $request->$comment;

                            if($f_ids[$f] == 0)
                            {
                                $post = new new_invoices_features;
                                $post->invoice_data_id = $invoice_items->id;
                                $post->price = $f_prices[$f];
                                $post->feature_id = $f_ids[$f];
                                $post->feature_sub_id = 0;
                                $post->ladderband = $key1;
                                $post->save();

                                if($key1)
                                {
                                    $size1 = 'sizeA'.$row_id[$f];
                                    $size1_value = $request->$size1;

                                    $size2 = 'sizeB'.$row_id[$f];
                                    $size2_value = $request->$size2;

                                    $sub = 'sub_product_id'.$row_id[$f];
                                    $sub_value = $request->$sub;

                                    foreach ($sub_value as $s => $key2)
                                    {
                                        $post1 = new new_invoices_sub_products;
                                        $post1->feature_row_id = $post->id;
                                        $post1->sub_product_id = $key2;
                                        $post1->size1_value = $size1_value[$s];
                                        $post1->size2_value = $size2_value[$s];
                                        $post1->save();

                                        if($size1_value[$s] == 1 || $size2_value[$s] == 1)
                                        {
                                            $sub_titles[$i] = product_ladderbands::where('product_id',$key)->where('id',$key2)->first();

                                            if($size1_value[$s] == 1)
                                            {
                                                $sub_titles[$i]->size = '38mm';
                                            }
                                            else
                                            {
                                                $sub_titles[$i]->size = '25mm';
                                            }
                                        }
                                    }
                                }
                            }
                            else
                            {
                                $post = new new_invoices_features;
                                $post->invoice_data_id = $invoice_items->id;
                                $post->price = $f_prices[$f];
                                $post->feature_id = $f_ids[$f];
                                $post->feature_sub_id = $key1;
                                $post->sub_feature = $is_sub_feature[$f];
                                $post->comment = $comment;
                                $post->save();
                            }

                            /*$feature_titles[$i][] = features::where('id',$f_ids[$f])->first();*/
                            $feature_sub_titles[$i][] = product_features::leftjoin('features','features.id','=','product_features.heading_id')->where('product_features.product_id',$key)->where('product_features.id',$key1)->select('product_features.*','features.title as main_title','features.order_no','features.id as f_id')->first();
                        }
                    }
                    else
                    {
                        $feature_sub_titles[$i] = array();
                    }

                }
                else
                {
                    $invoice_items->save();
                    $feature_sub_titles[$i] = array();
                }
            }
        }

        if(!$request->is_invoice)
        {
            $filename = $quotation_invoice_number . '.pdf';

            if($request->quotation_id)
            {
                if($ask && !$request->quote_request_id)
                {
                    \Mail::send(array(), array(), function ($message) use ($client, $quotation_invoice_number) {
                        $message->to($client->email)
                            ->from('info@vloerofferte.nl')
                            ->subject('Quotation updated!')
                            ->setBody("Quotation QUO# <b>" . $quotation_invoice_number . "</b> have been updated by retailer on your review request.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
                    });
                }

                Session::flash('success',__('text.Quotation has been updated successfully. Order will be updated soon in background process.'));
            }
            else
            {
                $counter = $counter + 1;

                User::where('id',$user_id)->update(['counter' => $counter]);

                Session::flash('success', __('text.Quotation has been created successfully. Order will be created soon in background process.'));
            }

            ini_set('max_execution_time', 180);

            $date = $invoice->created_at;
            $role = 'retailer';

            $pdf = PDF::loadView('user.pdf_new_quotation_1', compact('form_type','role','product_titles','color_titles','model_titles','feature_sub_titles','sub_titles','date','client','user','request','quotation_invoice_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 160,'isRemoteEnabled' => true]);
            $file = public_path() . '/assets/newQuotations/' . $filename;
            $pdf->save($file);

            if (array_filter($suppliers)) {

                $invoice->processing = 1;
                $invoice->save();
                $quotation_id = $invoice->id;

                if($form_type == 1)
                {
                    $role = 'order';
                    CreateOrder::dispatch($quotation_id,$form_type,$role,$product_titles,$color_titles,$model_titles,$feature_sub_titles,$sub_titles,$date,$client,$user,$request->all(),$quotation_invoice_number,$suppliers,$order_numbers);
                }
                else
                {
                    $role = 'supplier2';
                    CreateOrder::dispatch($quotation_id,$form_type,$role,$product_titles,$color_titles,$model_titles,$feature_sub_titles,$sub_titles,$date,$client,$user,$request->all(),$quotation_invoice_number,$suppliers,$order_numbers);
                }

           }

        }
        else
        {
            $filename = $invoice_number . '.pdf';

            ini_set('max_execution_time', 180);

            $date = $invoice->created_at;
            $role = 'invoice1';

            if(!$request->negative_invoice)
            {
                $pdf = PDF::loadView('user.pdf_new_quotation_1', compact('form_type','role','product_titles','color_titles','model_titles','feature_sub_titles','sub_titles','date','client','user','request','invoice_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 160,'isRemoteEnabled' => true]);
                $file = public_path() . '/assets/newInvoices/' . $filename;
                $pdf->save($file);

                Session::flash('success','Invoice has been updated successfully.');
            }
            else
            {
                $pdf = PDF::loadView('user.pdf_new_quotation_1', compact('form_type','role','product_titles','color_titles','model_titles','feature_sub_titles','sub_titles','date','client','user','request','invoice_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 160,'isRemoteEnabled' => true]);
                $file = public_path() . '/assets/newNegativeInvoices/' . $filename;
                $pdf->save($file);

                if($request->negative_invoice_id)
                {
                    Session::flash('success','Negative Invoice has been updated successfully.');
                }
                else
                {
                    Session::flash('success','Negative Invoice has been created successfully.');
                }
            }
        }

        return redirect()->route('customer-quotations');
    }

    public function EmailTemplates()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $uer_role = $user->role_id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
            $user_id = $user->id;
        }

        if($uer_role != 2)
        {
            return redirect()->route('user-login');
        }

        $quotation_email_template = email_templates::where('user_id',$user_id)->where('type','quotation')->first();
        $order_email_template = email_templates::where('user_id',$user_id)->where('type','order')->first();
        $invoice_email_template = email_templates::where('user_id',$user_id)->where('type','invoice')->first();

        return view('user.email_templates',compact('quotation_email_template','order_email_template','invoice_email_template'));
    }

    public function SaveEmailTemplate(Request $request)
    {
        $type = $request->type == 1 ? 'quotation' : ($request->type == 2 ? 'order' : 'invoice');
        $template_id = $request->template_id;
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
            $user_id = $user->id;
        }

        if($template_id)
        {
            email_templates::where('user_id',$user_id)->where('type',$type)->update(['subject' => $request->mail_subject, 'body' => $request->mail_body]);

            Session::flash('success', 'Email template updated successfully!');
            return redirect()->back();
        }
        else
        {
            $post = new email_templates;
            $post->type = $type;
            $post->subject = $request->mail_subject;
            $post->body = $request->mail_body;
            $post->user_id = $user_id;
            $post->save();

            Session::flash('success', 'Email template saved successfully!');
            return redirect()->back();
        }
    }

    public function StoreQuotation(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
            $user_id = $user->id;
        }

        $user_name = $user->name;
        $counter = $user->counter;

        $name = \Route::currentRouteName();

        $services = $request->item;

        if ($name == 'store-quotation') {

            $quote = quotes::where('id', $request->quote_id)->first();
            $quote->status = 1;
            $quote->save();

            $requested_quote_number = $quote->quote_number;
            $quotation_invoice_number = $user->quotation_client_id ? date("Y") . "-" . sprintf('%04u', $user_id) . '-' . sprintf('%06u', $counter) : date("Y") . '-' . sprintf('%06u', $counter);

            $invoice = new quotation_invoices;
            $invoice->quote_id = $request->quote_id;
            $invoice->quotation_invoice_number = $quotation_invoice_number;
            $invoice->handyman_id = $user_id;
            $invoice->vat_percentage = $request->vat_percentage;
            $invoice->tax = str_replace(",",".",$request->tax_amount);
            $invoice->subtotal = str_replace(",",".",$request->sub_total);
            $invoice->grand_total = str_replace(",",".",$request->grand_total);
            $invoice->description = $request->other_info;
            $invoice->delivery_date = $quote->quote_delivery;
            $invoice->save();

            foreach ($services as $i => $key) {

                $invoice_items = new quotation_invoices_data;
                $invoice_items->quotation_id = $invoice->id;
                $invoice_items->s_i_id = (int)$key;
                $invoice_items->service = $request->service_title[$i];
                $invoice_items->product_title = $request->productInput[$i];

                if (strpos($services[$i], 'I') > -1) {

                    $invoice_items->b_i_id = 0;
                    $invoice_items->m_i_id = 0;
                    $invoice_items->item = 1;
                    $invoice_items->brand = '';
                    $invoice_items->model = '';

                }
                elseif (strpos($services[$i], 'S') > -1) {

                    $invoice_items->b_i_id = 0;
                    $invoice_items->m_i_id = 0;
                    $invoice_items->is_service = 1;
                    $invoice_items->brand = '';
                    $invoice_items->model = '';

                }
                else {

                    $invoice_items->b_i_id = (int)$request->brand[$i];
                    $invoice_items->m_i_id = (int)$request->model[$i];
                    $invoice_items->brand = $request->brand_title[$i];
                    $invoice_items->model = $request->model_title[$i];

                }

                $invoice_items->rate = str_replace(",",".",$request->cost[$i]);
                $invoice_items->qty = str_replace(",",".",$request->qty[$i]);
                $invoice_items->description = $request->description[$i];
                $invoice_items->estimated_date = $request->date;
                $invoice_items->amount = str_replace(",",".",$request->amount[$i]);
                $invoice_items->save();
            }


            $counter = $counter + 1;
            User::where('id',$user_id)->update(['counter' => $counter]);

            $filename = $quotation_invoice_number . '.pdf';

            $file = public_path() . '/assets/quotationsPDF/' . $filename;

            $type = 'new';

            $handyman_role = 1;

            if (!file_exists($file)) {

                ini_set('max_execution_time', 180);

                $pdf = PDF::loadView('user.pdf_quotation', compact('quote', 'type', 'request', 'quotation_invoice_number', 'requested_quote_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140,'isRemoteEnabled' => true]);

                $pdf->save(public_path() . '/assets/quotationsPDF/' . $filename);
            }

            $file1 = public_path() . '/assets/quotationsPDF/HandymanQuotations/' . $filename;

            if (!file_exists($file1)) {

                $pdf = PDF::loadView('user.pdf_quotation', compact('handyman_role','quote', 'type', 'request', 'quotation_invoice_number', 'requested_quote_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140,'isRemoteEnabled' => true]);

                $pdf->save(public_path() . '/assets/quotationsPDF/HandymanQuotations/' . $filename);
            }

            $admin_email = $this->sl->admin_email;

            \Mail::send('user.quotation_invoice_mail',
                array(
                    'username' => $user_name,
                    'quote_number' => $requested_quote_number,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'type' => $type
                ), function ($message) use ($file, $admin_email, $filename) {
                    $message->from('info@vloerofferte.nl');
                    $message->to($admin_email)->subject(__('text.Quotation Created!'));

                    $message->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);

                });


            Session::flash('success', __('text.Quotation has been created successfully!'));
            return redirect()->route('handyman-quotation-requests');

        } elseif ($name == 'update-quotation') {

            $quote = quotes::leftjoin('categories', 'categories.id', '=', 'quotes.quote_service')->where('quotes.id', $request->quote_id)->select('quotes.*', 'categories.cat_name')->first();

            $quotation = quotation_invoices::where('quote_id', $request->quote_id)->where('handyman_id', $user_id)->first();
            $quotation->ask_customization = 0;
            $quotation->vat_percentage = $request->vat_percentage;
            $quotation->subtotal = str_replace(",",".",$request->sub_total);
            $quotation->tax = str_replace(",",".",$request->tax_amount);
            $quotation->grand_total = str_replace(",",".",$request->grand_total);
            $quotation->description = $request->other_info;
            $quotation->save();

            quotation_invoices_data::where('quotation_id', $quotation->id)->delete();

            foreach ($services as $i => $key) {

                $item = new quotation_invoices_data;
                $item->quotation_id = $quotation->id;
                $item->s_i_id = (int)$key;
                $item->service = $request->service_title[$i];
                $item->product_title = $request->productInput[$i];

                if (strpos($services[$i], 'I') > -1) {

                    $item->b_i_id = 0;
                    $item->m_i_id = 0;
                    $item->item = 1;
                    $item->brand = '';
                    $item->model = '';

                }
                elseif (strpos($services[$i], 'S') > -1) {

                    $item->b_i_id = 0;
                    $item->m_i_id = 0;
                    $item->is_service = 1;
                    $item->brand = '';
                    $item->model = '';

                }
                else {

                    $item->b_i_id = (int)$request->brand[$i];
                    $item->m_i_id = (int)$request->model[$i];
                    $item->brand = $request->brand_title[$i];
                    $item->model = $request->model_title[$i];

                }

                $item->rate = str_replace(",",".",$request->cost[$i]);
                $item->qty = str_replace(",",".",$request->qty[$i]);
                $item->description = $request->description[$i];
                $item->estimated_date = $request->date;
                $item->amount = str_replace(",",".",$request->amount[$i]);
                $item->save();
            }

            $requested_quote_number = $quote->quote_number;

            $quotation_invoice_number = $quotation->quotation_invoice_number;

            $filename = $quotation_invoice_number . '.pdf';

            $file = public_path() . '/assets/quotationsPDF/' . $filename;

            $type = 'edit';

            $handyman_role = 1;

            ini_set('max_execution_time', 180);

            $pdf = PDF::loadView('user.pdf_quotation', compact('quote', 'type', 'request', 'quotation_invoice_number', 'requested_quote_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140,'isRemoteEnabled' => true]);

            $pdf->save(public_path() . '/assets/quotationsPDF/' . $filename);

            $file1 = public_path() . '/assets/quotationsPDF/HandymanQuotations/' . $filename;

            $pdf = PDF::loadView('user.pdf_quotation', compact('handyman_role','quote', 'type', 'request', 'quotation_invoice_number', 'requested_quote_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140,'isRemoteEnabled' => true]);

            $pdf->save(public_path() . '/assets/quotationsPDF/HandymanQuotations/' . $filename);

            $client_name = $quote->quote_name;
            $client_email = $quote->quote_email;

            $type = 'edit client';

            \Mail::send('user.quotation_invoice_mail',
                array(
                    'username' => $user_name,
                    'client' => $client_name,
                    'quote_number' => $requested_quote_number,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'type' => $type
                ), function ($message) use ($file, $client_email, $filename) {
                    $message->from('info@vloerofferte.nl');
                    $message->to($client_email)->subject(__('text.Quotation Edited!'));

                    $message->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);

                });

            $admin_email = $this->sl->admin_email;
            $type = 'edit';

            \Mail::send('user.quotation_invoice_mail',
                array(
                    'username' => $user_name,
                    'quote_number' => $requested_quote_number,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'type' => $type
                ), function ($message) use ($file, $admin_email, $filename) {
                    $message->from('info@vloerofferte.nl');
                    $message->to($admin_email)->subject(__('text.Quotation Edited!'));

                    $message->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);

                });


            Session::flash('success', __('text.Quotation has been edited and sent to client successfully!'));
            return redirect()->route('handyman-quotation-requests');

        } else {

            $quote = quotes::leftjoin('categories', 'categories.id', '=', 'quotes.quote_service')->where('quotes.id', $request->quote_id)->select('quotes.*', 'categories.cat_name')->first();

            $quote->status = 3;
            $quote->save();

            $quotation = quotation_invoices::where('quote_id', $request->quote_id)->where('handyman_id', $user_id)->first();
            $quotation->ask_customization = 0;
            $quotation->invoice = 1;
            $quotation->vat_percentage = $request->vat_percentage;
            $quotation->subtotal = str_replace(",",".",$request->sub_total);
            $quotation->tax = str_replace(",",".",$request->tax_amount);
            $quotation->grand_total = str_replace(",",".",$request->grand_total);
            $quotation->description = $request->other_info;
            $quotation->save();

            quotation_invoices_data::where('quotation_id', $quotation->id)->delete();

            foreach ($services as $i => $key) {

                if (strpos($services[$i], 'I') > -1) {
                    $x = 1;
                } else {
                    $x = 0;
                }

                $item = new quotation_invoices_data;
                $item->quotation_id = $quotation->id;
                $item->s_i_id = (int)$key;
                $item->item = $x;
                $item->service = $request->service_title[$i];
                $item->rate = str_replace(",",".",$request->cost[$i]);
                $item->qty = str_replace(",",".",$request->qty[$i]);
                $item->description = $request->description[$i];
                $item->estimated_date = $request->date;
                $item->amount = str_replace(",",".",$request->amount[$i]);
                $item->save();
            }

            $requested_quote_number = $quote->quote_number;

            $quotation_invoice_number = $quotation->quotation_invoice_number;

            $filename = $quotation_invoice_number . '.pdf';

            $file = public_path() . '/assets/quotationsPDF/' . $filename;

            $type = 'invoice';

            $handyman_role = 1;

            ini_set('max_execution_time', 180);

            $pdf = PDF::loadView('user.pdf_quotation', compact('quote', 'type', 'request', 'quotation_invoice_number', 'requested_quote_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140,'isRemoteEnabled' => true]);

            $pdf->save(public_path() . '/assets/quotationsPDF/' . $filename);

            $file1 = public_path() . '/assets/quotationsPDF/HandymanQuotations/' . $filename;

            $pdf = PDF::loadView('user.pdf_quotation', compact('handyman_role','quote', 'type', 'request', 'quotation_invoice_number', 'requested_quote_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140,'isRemoteEnabled' => true]);

            $pdf->save(public_path() . '/assets/quotationsPDF/HandymanQuotations/' . $filename);

            $client_name = $quote->quote_name;
            $client_email = $quote->quote_email;

            $type = 'invoice client';

            \Mail::send('user.quotation_invoice_mail',
                array(
                    'username' => $user_name,
                    'client' => $client_name,
                    'quote_number' => $requested_quote_number,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'type' => $type
                ), function ($message) use ($file, $client_email, $filename) {
                    $message->from('info@vloerofferte.nl');
                    $message->to($client_email)->subject('Invoice Generated!');

                    $message->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);

                });

            $admin_email = $this->sl->admin_email;
            $type = 'invoice';

            \Mail::send('user.quotation_invoice_mail',
                array(
                    'username' => $user_name,
                    'quote_number' => $requested_quote_number,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'type' => $type
                ), function ($message) use ($file, $admin_email, $filename) {
                    $message->from('info@vloerofferte.nl');
                    $message->to($admin_email)->subject(__('text.Invoice Generated!'));

                    $message->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);

                });


            Session::flash('success', 'Invoice has been generated successfully!');
            return redirect()->route('handyman-quotation-requests');
        }

    }

    public function SendCustomQuotation($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($user->can('send-custom-quotation'))
        {
            if($main_id)
            {
                $user = User::where('id',$main_id)->first();
                $user_id = $user->id;
            }

            $user_name = $user->name;
            $user_email = $user->email;
            $company_name = $user->company_name;
            $result = custom_quotations::leftjoin('users', 'users.id', '=', 'custom_quotations.user_id')->where('custom_quotations.id', $id)->select('users.company_name', 'users.id', 'users.name', 'users.family_name', 'users.email', 'custom_quotations.*')->first();
            $result->approved = 1;
            $result->status = 1;
            $result->save();

            $quotation_invoice_number = $result->quotation_invoice_number;

            $filename = $quotation_invoice_number . '.pdf';

            $file = public_path() . '/assets/customQuotations/' . $filename;

            $type = 'new';

            $client_email = $result->email;
            $client_name = $result->name;

            \Mail::send('user.custom_quotation_mail',
                array(
                    'username' => $user_name,
                    'client' => $client_name,
                    'company_name' => $company_name,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'type' => $type
                ), function ($message) use ($file, $client_email, $user_email, $user_name, $filename) {
                    $message->from('info@vloerofferte.nl');
                    $message->to($client_email)->subject(__('text.Quotation Created!'));

                    $message->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);

                });


            Session::flash('success', __('text.Quotation has been sent to customer'));
            return redirect()->route('customer-quotations');
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function SendNewQuotation(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
            $user_id = $user->id;
        }

        $check = new_quotations::where('id',$request->quotation_id)->where('creator_id',$user_id)->first();

        if($check)
        {
            $user_name = $user->name;
            $user_email = $user->email;
            $company_name = $user->company_name;
            $result = new_quotations::leftjoin('users', 'users.id', '=', 'new_quotations.user_id')->where('new_quotations.id', $request->quotation_id)->select('users.company_name', 'users.id', 'users.name', 'users.family_name', 'users.email', 'new_quotations.*')->first();
            $result->approved = 1;
            $result->status = 1;
            $result->save();

            $quotation_invoice_number = $result->quotation_invoice_number;

            $filename = $quotation_invoice_number . '.pdf';

            $file = public_path() . '/assets/newQuotations/' . $filename;

            $type = 'new';

            $client_email = $result->email;
            $client_name = $result->name;

            $mail_to = $request->mail_to;
            $subject = $request->mail_subject;
            $msg = $request->mail_body;


            \Mail::send('user.global_mail',
                array(
                    'msg' => $msg,
                ), function ($message) use ($request,$mail_to,$subject,$msg,$file,$filename) {
                    $message->to($mail_to)
                        ->from('info@pieppiep.com')
                        ->subject($subject)
                        ->attach($file, [
                            'as' => $filename,
                            'mime' => 'application/pdf',
                        ]);
                });

            new_quotations::where('id', $request->quotation_id)->update(['mail_to' => $request->mail_to]);

            /*\Mail::send('user.custom_quotation_mail',
                array(
                    'username' => $user_name,
                    'client' => $client_name,
                    'company_name' => $company_name,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'type' => $type
                ), function ($message) use ($file, $client_email, $user_email, $user_name, $filename) {
                    $message->from('info@vloerofferte.nl');
                    $message->to($client_email)->subject(__('text.Quotation Created!'));

                    $message->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);

                });*/


            Session::flash('success', __('text.Quotation has been sent to customer'));
            return redirect()->back();
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function SendOrder(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
            $user_id = $user->id;
        }

        $check = new_quotations::where('id',$request->quotation_id1)->where('creator_id',$user_id)->first();

        if($check)
        {
            $check->processing = 1;
            $check->save();

            SendOrder::dispatch($request->quotation_id1,$user,$request->mail_subject1,$request->mail_body1);

            Session::flash('success', 'Order will be sent to supplier(s) soon...');
            return redirect()->route('customer-quotations');
        }
        else
        {
            return redirect()->route('user-login');
        }

        /*event(new \App\Events\SendOrder($id));*/
    }

    public function ChangeDeliveryDates($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
            $user_id = $user->id;
        }

        $data = new_quotations::leftjoin('new_orders', 'new_orders.quotation_id', '=', 'new_quotations.id')->where('new_quotations.id',$id)->where('new_orders.supplier_id', $user_id)->where('new_orders.processing','!=',1)->where('new_orders.delivered','!=',1)->first();

        if($data)
        {
            $invoice = new_orders::leftjoin('new_quotations','new_quotations.id','=','new_orders.quotation_id')->leftjoin('products','products.id','=','new_orders.product_id')->leftjoin('product_models','product_models.id','=','new_orders.model_id')->leftjoin('colors','colors.id','=','new_orders.color')->where('new_quotations.id', $id)->where('new_orders.supplier_id', $user_id)->select('colors.title as color_title','product_models.model','new_quotations.*','new_quotations.id as invoice_id','new_orders.approved','new_orders.delivery_days','new_orders.delivery_date','new_orders.id','new_orders.supplier_id','new_orders.product_id','new_orders.color','new_orders.qty','products.title as product_title')->get();

            return view('user.change_delivery_date',compact('data','invoice'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function UpdateDeliveryDates(Request $request)
    {
        $rows = $request->data_id;
        $user = Auth::guard('user')->user();

        new_orders::whereIn('id',$rows)->update(['processing' => 1]);

        UpdateDates::dispatch($request->all(),$user);

        Session::flash('success', 'Processing...');
        return redirect()->route('customer-quotations');
    }

    public function SupplierOrderDelivered($id)
    {
        $user = Auth::guard('user')->user();
        $main_id = $user->main_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
        }

        $user_id = $user->id;
        $supplier_name = $user->name . ' ' . $user->family_name;

        $data = new_quotations::leftjoin('new_orders', 'new_orders.quotation_id', '=', 'new_quotations.id')->where('new_quotations.id',$id)->where('new_orders.supplier_id', $user_id)->where('new_orders.processing','!=',1)->where('new_orders.approved',1)->where('new_orders.delivered','!=',1)->select('new_quotations.*','new_orders.order_number')->first();

        if($data)
        {
            new_orders::leftjoin('new_quotations','new_quotations.id','=','new_orders.quotation_id')->where('new_quotations.id', $id)->where('new_orders.supplier_id', $user_id)->update(['new_orders.delivered' => 1]);

            $delivered = new_orders::where('quotation_id',$id)->get();
            $flag = 0;

            foreach ($delivered as $key)
            {
                if(!$key->delivered)
                {
                    $flag = 1;
                }
            }

            if($flag == 0)
            {
                new_quotations::where('id',$id)->update(['delivered' => 1]);
            }

            $retailer = User::where('id',$data->creator_id)->first();
            $retailer_company = $retailer->company_name;
            $retailer_email = $retailer->email;
            $order_number = $data->order_number;

            \Mail::send(array(), array(), function ($message) use ($retailer_email, $retailer_company, $supplier_name, $order_number) {
                $message->to($retailer_email)
                    ->from('info@pieppiep.com')
                    ->subject('Order marked as delivered by supplier!')
                    ->setBody("Recent activity: Hi ".$retailer_company.", order has been delivered by supplier <b>".$supplier_name."</b><br> Order No: <b>" . $order_number . "</b>.<br><br>Kind regards,<br><br>Klantenservice<br><br> Pieppiep", 'text/html');
            });

            Session::flash('success', 'Order marked as delivered.');
            return redirect()->back();
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function RetailerMarkDelivered($id)
    {
        $user = Auth::guard('user')->user();
        $main_id = $user->main_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
        }

        $user_id = $user->id;
        $retailer_company = $user->company_name;

        $data = new_quotations::where('id',$id)->where('creator_id', $user_id)->where('delivered',1)->first();

        if($data)
        {
            new_quotations::where('id', $id)->where('creator_id', $user_id)->update(['retailer_delivered' => 1]);

            if($data->quote_request_id)
            {
                $quote = quotes::where('id',$data->quote_request_id)->first();
                $client = new \stdClass();
                $client_name = $quote->quote_name . ' ' . $quote->quote_familyname;
                $client_email = $quote->quote_email;
            }
            else
            {
                $client = customers_details::leftjoin('users','users.id','=','customers_details.user_id')->where('customers_details.id', $data->customer_details)->select('customers_details.*','users.email')->first();
                $client_name = $client->name . ' ' . $client->family_name;
                $client_email = $client->email;
            }

            $quotation_invoice_number = $data->quotation_invoice_number;

            \Mail::send(array(), array(), function ($message) use ($client_email, $retailer_company, $client_name, $quotation_invoice_number) {
                $message->to($client_email)
                    ->from('info@pieppiep.com')
                    ->subject('Quotation marked as delivered by retailer!')
                    ->setBody("Recent activity: Hi ".$client_name.", quotation has been delivered by retailer <b>".$retailer_company."</b><br> Quotation No: <b>" . $quotation_invoice_number . "</b>.<br><br>Kind regards,<br><br>Klantenservice<br><br> Pieppiep", 'text/html');
            });

            Session::flash('success', 'Quotation marked as delivered.');
            return redirect()->back();
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function SendInvoice(Request $request)
    {
        $user = Auth::guard('user')->user();
        $main_id = $user->main_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
        }

        $user_id = $user->id;
        $check = new_invoices::where('quotation_id',$request->quotation_id2)->where('creator_id',$user_id)->where('invoice',1)->where('invoice_sent',0)->first();

        if (!$check) {
            return redirect()->back();
        }

        new_quotations::where('id', $request->quotation_id2)->where('creator_id',$user_id)->where('invoice',1)->where('invoice_sent',0)->update(['invoice_sent' => 1]);
        $check->invoice_sent = 1;
        $check->save();

        if($check->quote_request_id)
        {
            $quote = quotes::where('id', $check->quote_request_id)->first();
            $client = new \stdClass();
            $client_name = $quote->quote_name . ' ' . $quote->quote_familyname;
            $client_email = $quote->quote_email;
        }
        else
        {
            $client = customers_details::leftjoin('users','users.id','=','customers_details.user_id')->where('customers_details.id', $check->customer_details)->select('customers_details.*','users.email')->first();
            $client_name = $client->name . ' ' . $client->family_name;
            $client_email = $client->email;
        }
        
        $retailer_company = $user->company_name;
        $invoice_number = $check->invoice_number;
        $filename = $invoice_number . '.pdf';
        $file = public_path() . '/assets/newInvoices/' . $filename;

        $mail_to = $request->mail_to2;
        $subject = $request->mail_subject2;
        $msg = $request->mail_body2;

        \Mail::send('user.global_mail',
            array(
                'msg' => $msg,
            ), function ($message) use ($request,$mail_to,$subject,$msg,$file,$filename) {
                $message->to($mail_to)
                    ->from('info@pieppiep.com')
                    ->subject($subject)
                    ->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);
            });

        new_quotations::where('id', $request->quotation_id2)->update(['mail_invoice_to' => $request->mail_to2]);
        new_invoices::where('quotation_id', $request->quotation_id2)->update(['mail_invoice_to' => $request->mail_to2]);

        Session::flash('success', 'Invoice sent to customer successfully!');
        return redirect()->back();
    }

    public function SendNegativeInvoice(Request $request)
    {
        $user = Auth::guard('user')->user();
        $main_id = $user->main_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
        }

        $user_id = $user->id;
        $check = new_invoices::where('quotation_id',$request->quotation_id3)->where('creator_id',$user_id)->where('negative_invoice_sent',0)->first();

        if (!$check) {
            return redirect()->back();
        }

//        new_quotations::where('id', $request->quotation_id3)->where('creator_id',$user_id)->where('negative_invoice_sent',0)->update(['negative_invoice_sent' => 1]);
        $check->negative_invoice_sent = 1;
        $check->save();

        $client = customers_details::leftjoin('users','users.id','=','customers_details.user_id')->where('customers_details.id', $check->customer_details)->select('customers_details.*','users.email')->first();
        $client_name = $client->name . ' ' . $client->family_name;
        $client_email = $client->email;
        $retailer_company = $user->company_name;

        $invoice = new_negative_invoices::where('quotation_id',$request->quotation_id3)->where('creator_id',$user_id)->where('negative_invoice_sent',0)->first();
        $invoice_number = $invoice->invoice_number;
        $invoice->negative_invoice_sent = 1;
        $invoice->save();
        $filename = $invoice_number . '.pdf';
        $file = public_path() . '/assets/newNegativeInvoices/' . $filename;

        $mail_to = $request->mail_to3;
        $subject = $request->mail_subject3;
        $msg = $request->mail_body3;

        \Mail::send('user.global_mail',
            array(
                'msg' => $msg,
            ), function ($message) use ($request,$mail_to,$subject,$msg,$file,$filename) {
                $message->to($mail_to)
                    ->from('info@pieppiep.com')
                    ->subject($subject)
                    ->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);
            });

//        new_quotations::where('id', $request->quotation_id3)->update(['mail_negative_invoice_to' => $request->mail_to3]);
        new_invoices::where('quotation_id', $request->quotation_id3)->update(['mail_negative_invoice_to' => $request->mail_to3]);
        new_negative_invoices::where('quotation_id', $request->quotation_id3)->update(['mail_negative_invoice_to' => $request->mail_to3]);

        Session::flash('success', 'Negative Invoice sent to customer successfully!');
        return redirect()->back();
    }

    public function CreateNewInvoice($id)
    {
        $invoice_id = $id;
        $user = Auth::guard('user')->user();
        $main_id = $user->main_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
        }

        $user_id = $user->id;
        $counter_invoice = $user->counter_invoice;

        $data = new_quotations::where('id',$invoice_id)->where('creator_id', $user_id)->where('invoice','!=',1)->first();

        if($data)
        {
            $date = date("Y-m-d");
            $invoice_data = new_quotations::where('id',$data->id)->first();
            $invoice_number = $user->invoice_client_id ? date("Y") . "-" . sprintf('%04u', $user_id) . '-' . sprintf('%06u', $counter_invoice) : date("Y") . '-' . sprintf('%06u', $counter_invoice);
            $invoice_data->quotation_id = $data->id;
            $invoice_data->invoice_number = $invoice_number;
            $invoice_data->invoice_date = $date;
            $invoice_data->invoice = 1;
            $new_invoice = $invoice_data->replicate($except = ['quotation_invoice_number']); 
            $new_invoice->setTable('new_invoices');
            $new_invoice->save();

            if($data->quote_request_id)
            {
                $quote = quotes::where('id', $data->quote_request_id)->first();
                $client = new \stdClass();
                $client->address = $quote->quote_zipcode;
                $client->name = $quote->quote_name;
                $client->family_name = $quote->quote_familyname;
                $client->postcode = $quote->quote_postcode;
                $client->city = $quote->quote_city;
                $client->email = $quote->quote_email;
            }
            else
            {
                $client = customers_details::leftjoin('users','users.id','=','customers_details.user_id')->where('customers_details.id',$data->customer_details)->select('customers_details.*','users.email')->first();
            }

            $request = new_quotations::where('id',$invoice_id)->select('new_quotations.*','new_quotations.subtotal as total_amount')->first();
            $request->products = new_quotations_data::where('quotation_id',$invoice_id)->get();

            $product_titles = array();
            $color_titles = array();
            $sub_titles = array();
            $qty = array();
            $width = array();
            $width_unit = array();
            $height = array();
            $height_unit = array();
            $comments = array();
            $delivery = array();
            $feature_sub_titles = array();
            $labor_impact = array();
            $price_before_labor = array();
            $discount = array();
            $rate = array();
            $labor_discount = array();
            $total = array();
            $total_discount = array();

            foreach ($request->products as $x => $temp)
            {
                $temp->invoice_id = $new_invoice->id;
                $new_invoice_data = $temp->replicate($except = ['order_number','quotation_id']); 
                $new_invoice_data->setTable('new_invoices_data');
                $new_invoice_data->save();

                $calculations = new_quotations_data_calculations::where('quotation_data_id',$temp->id)->get();

                foreach($calculations as $cal)
                {
                    $cal->invoice_data_id = $new_invoice_data->id;
                    $new_invoice_data_calculation = $cal->replicate($except = ['quotation_data_id']); 
                    $new_invoice_data_calculation->setTable('new_invoices_data_calculations');
                    $new_invoice_data_calculation->save();
                }

                $feature_sub_titles[$x][] = array();

                if ($temp->item_id != 0) {
                    $product_titles[] = items::where('id',$temp->item_id)->pluck('cat_name')->first();
                    $color_titles[] = '';
                    $model_titles[] = '';
                }
                elseif ($temp->service_id != 0) {
                    $product_titles[] = Service::where('id',$temp->service_id)->pluck('title')->first();
                    $color_titles[] = '';
                    $model_titles[] = '';
                }
                else
                {
                    $product_titles[] = product::where('id',$temp->product_id)->pluck('title')->first();
                    $color_titles[] = colors::where('id',$temp->color)->pluck('title')->first();
                    $model_titles[] = product_models::where('id',$temp->model_id)->pluck('model')->first();
                }

                $qty[] = $temp->qty;
                $width[] = $temp->width;
                $width_unit[] = $temp->width_unit;
                $height[] = $temp->height;
                $height_unit[] = $temp->height_unit;
                $delivery[] = $temp->delivery_date;
                $labor_impact[] = $temp->labor_impact;
                $price_before_labor[] = $temp->price_before_labor;
                $discount[] = $temp->discount;
                $rate[] = $temp->rate;
                $labor_discount[] = $temp->labor_discount;
                $total[] = $temp->amount;
                $total_discount[] = $temp->total_discount;

                $features = new_quotations_features::where('quotation_data_id',$temp->id)->get();

                foreach ($features as $f => $feature)
                {
                    $feature->invoice_data_id = $new_invoice_data->id;
                    $new_invoice_feature = $feature->replicate($except = ['quotation_data_id']); 
                    $new_invoice_feature->setTable('new_invoices_features');
                    $new_invoice_feature->save();

                    if($feature->feature_id == 0)
                    {
                        if($feature->ladderband)
                        {
                            $sub_product = new_quotations_sub_products::where('feature_row_id',$feature->id)->get();

                            foreach ($sub_product as $sub)
                            {
                                $sub->feature_row_id = $new_invoice_feature->id;
                                $new_invoice_sub_product = $sub->replicate(); 
                                $new_invoice_sub_product->setTable('new_invoices_sub_products');
                                $new_invoice_sub_product->save();

                                if($sub->size1_value == 1 || $sub->size2_value == 1)
                                {
                                    $sub_titles[$x] = product_ladderbands::where('product_id',$temp->product_id)->where('id',$sub->sub_product_id)->first();

                                    if($sub->size1_value == 1)
                                    {
                                        $sub_titles[$x]->size = '38mm';
                                    }
                                    else
                                    {
                                        $sub_titles[$x]->size = '25mm';
                                    }
                                }
                            }
                        }
                    }

                    $feature_sub_titles[$x][] = product_features::leftjoin('features','features.id','=','product_features.heading_id')->where('product_features.product_id',$temp->product_id)->where('product_features.id',$feature->feature_sub_id)->select('product_features.*','features.title as main_title','features.order_no','features.id as f_id')->first();
                    $comments[$x][] = $feature->comment;
                }
            }

            $request->qty = $qty;
            $request->width = $width;
            $request->width_unit = $width_unit;
            $request->height = $height;
            $request->height_unit = $height_unit;
            $request->delivery_date = $delivery;
            $request->labor_impact = $labor_impact;
            $request->price_before_labor = $price_before_labor;
            $request->discount = $discount;
            $request->rate = $rate;
            $request->labor_discount = $labor_discount;
            $request->total = $total;
            $request->total_discount = $total_discount;

            $quotation_invoice_number = $request->quotation_invoice_number;
            $order_number = $invoice_number;
            $filename = $order_number . '.pdf';
            $file = public_path() . '/assets/newInvoices/' . $filename;

            ini_set('max_execution_time', 180);

            $role = 'invoice';
            $form_type = $request->form_type;

            $pdf = PDF::loadView('user.pdf_new_quotation_1', compact('form_type','role','comments','product_titles','color_titles','model_titles','feature_sub_titles','sub_titles','date','client','user','request','quotation_invoice_number','order_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 160,'isRemoteEnabled' => true]);
            $pdf->save($file);

            $counter_invoice = $counter_invoice + 1;
            $user->counter_invoice = $counter_invoice;
            $user->save();
            $data->invoice_number = $order_number;
            $data->invoice_date = $date;
            $data->invoice = 1;
            $data->save();

            Session::flash('success', 'Invoice created successfully!');
            return redirect()->back();
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function StoreCustomQuotation(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
            $user_id = $user->id;
        }

        $user_name = $user->name;
        $user_email = $user->email;
        $company_name = $user->company_name;
        $counter = $user->counter;

        $name = \Route::currentRouteName();

        $services = $request->item;

        $client = User::where('id', $request->customer)->first();

        if ($name == 'store-custom-quotation') {

            $quotation_invoice_number = $user->quotation_client_id ? date("Y") . "-" . sprintf('%04u', $user_id) . '-' . sprintf('%06u', $counter) : date("Y") . '-' . sprintf('%06u', $counter);

            $invoice = new custom_quotations;
            $invoice->quotation_invoice_number = $quotation_invoice_number;
            $invoice->handyman_id = $user_id;
            $invoice->user_id = $request->customer;
            $invoice->vat_percentage = $request->vat_percentage;
            $invoice->tax = str_replace(",",".",$request->tax_amount);
            $invoice->subtotal = str_replace(",",".",$request->sub_total);
            $invoice->grand_total = str_replace(",",".",$request->grand_total);
            $invoice->description = $request->other_info;
            $invoice->save();

            foreach ($services as $i => $key) {

                $invoice_items = new custom_quotations_data;
                $invoice_items->quotation_id = $invoice->id;
                $invoice_items->s_i_id = (int)$key;
                $invoice_items->service = $request->service_title[$i];
                $invoice_items->product_title = $request->productInput[$i];

                if (strpos($services[$i], 'I') > -1) {

                    $invoice_items->b_i_id = 0;
                    $invoice_items->m_i_id = 0;
                    $invoice_items->item = 1;
                    $invoice_items->brand = '';
                    $invoice_items->model = '';

                }
                elseif (strpos($services[$i], 'S') > -1) {

                    $invoice_items->b_i_id = 0;
                    $invoice_items->m_i_id = 0;
                    $invoice_items->is_service = 1;
                    $invoice_items->brand = '';
                    $invoice_items->model = '';

                }
                else {

                    $invoice_items->b_i_id = (int)$request->brand[$i];
                    $invoice_items->m_i_id = (int)$request->model[$i];
                    $invoice_items->brand = $request->brand_title[$i];
                    $invoice_items->model = $request->model_title[$i];

                }

                $invoice_items->rate = str_replace(",",".",$request->cost[$i]);
                $invoice_items->qty = str_replace(",",".",$request->qty[$i]);
                $invoice_items->description = $request->description[$i];
                $invoice_items->estimated_date = $request->date;
                $invoice_items->amount = str_replace(",",".",$request->amount[$i]);
                $invoice_items->save();

            }

            $counter = $counter + 1;

            User::where('id',$user_id)->update(['counter' => $counter]);

            $filename = $quotation_invoice_number . '.pdf';

            $file = public_path() . '/assets/customQuotations/' . $filename;

            $type = 'new';

            if (!file_exists($file)) {

                ini_set('max_execution_time', 180);

                $date = $invoice->created_at;

                $pdf = PDF::loadView('user.pdf_custom_quotation', compact('date','client', 'user', 'type', 'request', 'quotation_invoice_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140,'isRemoteEnabled' => true]);

                $pdf->save(public_path() . '/assets/customQuotations/' . $filename);
            }

            /*$admin_email = $this->sl->admin_email;

            \Mail::send('user.quotation_invoice_mail',
                array(
                    'username' => $user_name,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'type' => $type
                ), function ($message) use($file,$admin_email,$filename) {
                    $message->from('info@vloerofferte.nl');
                    $message->to($admin_email)->subject('Quotation Created!');

                    $message->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);

                });*/


            Session::flash('success', __('text.Quotation has been created successfully!'));
            return redirect()->route('customer-quotations');

        } elseif ($name == 'store-direct-invoice') {

            $quotation_invoice_number = $user->quotation_client_id ? date("Y") . "-" . sprintf('%04u', $user_id) . '-' . sprintf('%06u', $counter) : date("Y") . '-' . sprintf('%06u', $counter);

            $invoice = new custom_quotations;
            $invoice->quotation_invoice_number = $quotation_invoice_number;
            $invoice->status = 3;
            $invoice->approved = 1;
            $invoice->accepted = 1;
            $invoice->invoice = 1;
            $invoice->handyman_id = $user_id;
            $invoice->user_id = $request->customer;
            $invoice->vat_percentage = $request->vat_percentage;
            $invoice->tax = str_replace(",",".",$request->tax_amount);
            $invoice->subtotal = str_replace(",",".",$request->sub_total);
            $invoice->grand_total = str_replace(",",".",$request->grand_total);
            $invoice->description = $request->other_info;
            $invoice->save();

            foreach ($services as $i => $key) {

                $invoice_items = new custom_quotations_data;
                $invoice_items->quotation_id = $invoice->id;
                $invoice_items->s_i_id = (int)$key;
                $invoice_items->service = $request->service_title[$i];
                $invoice_items->product_title = $request->productInput[$i];

                if (strpos($services[$i], 'I') > -1) {

                    $invoice_items->b_i_id = 0;
                    $invoice_items->m_i_id = 0;
                    $invoice_items->item = 1;
                    $invoice_items->brand = '';
                    $invoice_items->model = '';

                }
                elseif (strpos($services[$i], 'S') > -1) {

                    $invoice_items->b_i_id = 0;
                    $invoice_items->m_i_id = 0;
                    $invoice_items->is_service = 1;
                    $invoice_items->brand = '';
                    $invoice_items->model = '';

                }
                else {

                    $invoice_items->b_i_id = (int)$request->brand[$i];
                    $invoice_items->m_i_id = (int)$request->model[$i];
                    $invoice_items->brand = $request->brand_title[$i];
                    $invoice_items->model = $request->model_title[$i];

                }

                $invoice_items->rate = str_replace(",",".",$request->cost[$i]);
                $invoice_items->qty = str_replace(",",".",$request->qty[$i]);
                $invoice_items->description = $request->description[$i];
                $invoice_items->estimated_date = $request->date;
                $invoice_items->amount = str_replace(",",".",$request->amount[$i]);
                $invoice_items->save();

            }

            $counter = $counter + 1;

            User::where('id',$user_id)->update(['counter' => $counter]);

            $filename = $quotation_invoice_number . '.pdf';

            $file = public_path() . '/assets/customQuotations/' . $filename;

            $type = 'direct-invoice';

            if (!file_exists($file)) {

                ini_set('max_execution_time', 180);

                $date = $invoice->created_at;

                $pdf = PDF::loadView('user.pdf_custom_quotation', compact('date','client', 'user', 'type', 'request', 'quotation_invoice_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140,'isRemoteEnabled' => true]);

                $pdf->save(public_path() . '/assets/customQuotations/' . $filename);
            }

            /*$admin_email = $this->sl->admin_email;

            \Mail::send('user.quotation_invoice_mail',
                array(
                    'username' => $user_name,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'type' => $type
                ), function ($message) use($file,$admin_email,$filename) {
                    $message->from('info@vloerofferte.nl');
                    $message->to($admin_email)->subject('Quotation Created!');

                    $message->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);

                });*/

            $client_name = $client->name;
            $client_email = $client->email;

            \Mail::send('user.custom_quotation_mail',
                array(
                    'username' => $user_name,
                    'client' => $client_name,
                    'company_name' => $company_name,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'type' => $type
                ), function ($message) use ($file, $client_email, $user_email, $user_name, $filename, $company_name) {
                    $message->from('info@vloerofferte.nl');
                    $message->to($client_email)->subject(__('text.Direct Invoice Created!').$company_name);

                    $message->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);

                });


            Session::flash('success', __('text.Direct invoice has been created successfully!'));
            return redirect()->route('customer-invoices');

        } elseif ($name == 'update-custom-quotation') {

            $quotation = custom_quotations::where('id', $request->quotation_id)->where('handyman_id', $user_id)->first();
            $quotation->ask_customization = 0;
            $quotation->vat_percentage = $request->vat_percentage;
            $quotation->subtotal = str_replace(",",".",$request->sub_total);
            $quotation->tax = str_replace(",",".",$request->tax_amount);
            $quotation->grand_total = str_replace(",",".",$request->grand_total);
            $quotation->description = $request->other_info;
            $quotation->save();

            $items = custom_quotations_data::where('quotation_id', $quotation->id)->delete();

            foreach ($services as $i => $key) {

                $item = new custom_quotations_data;
                $item->quotation_id = $quotation->id;
                $item->s_i_id = (int)$key;
                $item->service = $request->service_title[$i];
                $item->product_title = $request->productInput[$i];

                if (strpos($services[$i], 'I') > -1) {

                    $item->b_i_id = 0;
                    $item->m_i_id = 0;
                    $item->item = 1;
                    $item->brand = '';
                    $item->model = '';

                }
                elseif (strpos($services[$i], 'S') > -1) {

                    $item->b_i_id = 0;
                    $item->m_i_id = 0;
                    $item->is_service = 1;
                    $item->brand = '';
                    $item->model = '';

                }
                else {

                    $item->b_i_id = (int)$request->brand[$i];
                    $item->m_i_id = (int)$request->model[$i];
                    $item->brand = $request->brand_title[$i];
                    $item->model = $request->model_title[$i];

                }

                $item->rate = str_replace(",",".",$request->cost[$i]);
                $item->qty = str_replace(",",".",$request->qty[$i]);
                $item->description = $request->description[$i];
                $item->estimated_date = $request->date;
                $item->amount = str_replace(",",".",$request->amount[$i]);
                $item->save();

            }

            $quotation_invoice_number = $quotation->quotation_invoice_number;

            $filename = $quotation_invoice_number . '.pdf';

            $file = public_path() . '/assets/customQuotations/' . $filename;

            $type = 'edit';

            ini_set('max_execution_time', 180);

            $date = $quotation->created_at;

            $pdf = PDF::loadView('user.pdf_custom_quotation', compact('date','client', 'user', 'type', 'request', 'quotation_invoice_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140,'isRemoteEnabled' => true]);

            $pdf->save(public_path() . '/assets/customQuotations/' . $filename);

            $client_name = $client->name;
            $client_email = $client->email;

            $type = 'edit client';

            \Mail::send('user.custom_quotation_mail',
                array(
                    'username' => $user_name,
                    'client' => $client_name,
                    'company_name' => $company_name,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'type' => $type
                ), function ($message) use ($file, $client_email, $user_email, $user_name, $filename) {
                    $message->from('info@vloerofferte.nl');
                    $message->to($client_email)->subject(__('text.Quotation Edited!'));

                    $message->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);

                });

            /*$admin_email = $this->sl->admin_email;
            $type = 'edit';

            \Mail::send('user.quotation_invoice_mail',
                array(
                    'username' => $user_name,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'type' => $type
                ), function ($message) use($file,$admin_email,$filename) {
                    $message->from('info@vloerofferte.nl');
                    $message->to($admin_email)->subject('Quotation Edited!');

                    $message->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);

                });*/


            Session::flash('success', __('text.Quotation has been edited and sent to client successfully!'));
            return redirect()->route('customer-quotations');

        } else {
            $quotation = custom_quotations::where('id', $request->quotation_id)->where('handyman_id', $user_id)->first();
            $quotation->status = 3;
            $quotation->ask_customization = 0;
            $quotation->invoice = 1;
            $quotation->vat_percentage = $request->vat_percentage;
            $quotation->subtotal = str_replace(",",".",$request->sub_total);
            $quotation->tax = str_replace(",",".",$request->tax_amount);
            $quotation->grand_total = str_replace(",",".",$request->grand_total);
            $quotation->description = $request->other_info;
            $quotation->save();

            $items = custom_quotations_data::where('quotation_id', $quotation->id)->delete();

            foreach ($services as $i => $key) {

                if (strpos($services[$i], 'I') > -1) {

                    $x = 1;
                    $brand_id = 0;
                    $model_id = 0;

                    $brand_title = $request->brand_title;

                    $brand_title[$i] = $request->item_brand[$i];
                    $request->merge(['brand_title' => $brand_title]);

                    $model_title = $request->model_title;
                    $model_title[$i] = $request->item_model[$i];
                    $request->merge(['model_title' => $model_title]);

                } else {
                    $x = 0;
                    $brand_id = (int)$request->brand[$i];
                    $model_id = (int)$request->model[$i];
                }

                $item = new custom_quotations_data;
                $item->quotation_id = $quotation->id;
                $item->s_i_id = (int)$key;
                $item->b_i_id = $brand_id;
                $item->m_i_id = $model_id;
                $item->item = $x;
                $item->service = $request->service_title[$i];
                $item->brand = $request->brand_title[$i];
                $item->model = $request->model_title[$i];
                $item->rate = str_replace(",",".",$request->cost[$i]);
                $item->qty = str_replace(",",".",$request->qty[$i]);
                $item->description = $request->description[$i];
                $item->estimated_date = $request->date;
                $item->amount = str_replace(",",".",$request->amount[$i]);
                $item->save();
            }

            $quotation_invoice_number = $quotation->quotation_invoice_number;

            $filename = $quotation_invoice_number . '.pdf';

            $file = public_path() . '/assets/customQuotations/' . $filename;

            $type = 'invoice';

            ini_set('max_execution_time', 180);

            $date = $quotation->created_at;

            $pdf = PDF::loadView('user.pdf_custom_quotation', compact('date','client', 'user', 'type', 'request', 'quotation_invoice_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140,'isRemoteEnabled' => true]);

            $pdf->save(public_path() . '/assets/customQuotations/' . $filename);

            $client_name = $client->name;
            $client_email = $client->email;

            $type = 'invoice client';

            \Mail::send('user.custom_quotation_mail',
                array(
                    'username' => $user_name,
                    'client' => $client_name,
                    'company_name' => $company_name,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'type' => $type
                ), function ($message) use ($file, $client_email, $user_email, $user_name, $filename) {
                    $message->from('info@vloerofferte.nl');
                    $message->to($client_email)->subject(__('text.Invoice Generated!'));

                    $message->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);

                });

            /*$admin_email = $this->sl->admin_email;
            $type = 'invoice';

            \Mail::send('user.quotation_invoice_mail',
                array(
                    'username' => $user_name,
                    'quote_number' => $requested_quote_number,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'type' => $type
                ), function ($message) use($file,$admin_email,$filename) {
                    $message->from('info@vloerofferte.nl');
                    $message->to($admin_email)->subject('Invoice Generated!');

                    $message->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);

                });*/


            Session::flash('success', 'Invoice has been generated successfully!');
            return redirect()->route('customer-quotations');
        }

    }

    public function Invoice($id)
    {

        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;

        $invoice = invoices::leftjoin('bookings', 'bookings.invoice_id', '=', 'invoices.id')->leftjoin('categories', 'categories.id', '=', 'bookings.service_id')->leftjoin('service_types', 'service_types.id', '=', 'bookings.rate_id')->where('invoices.id', '=', $id)->Select('invoices.id', 'invoices.handyman_id', 'invoices.user_id', 'categories.cat_name', 'service_types.type', 'bookings.service_rate', 'bookings.rate', 'invoices.booking_date', 'bookings.total', 'invoices.is_booked', 'invoices.is_completed', 'invoices.pay_req', 'invoices.is_paid', 'invoices.is_partial', 'invoices.status', 'invoices.total as inv_total', 'invoices.created_at as inv_date', 'invoices.invoice_number', 'invoices.service_fee', 'invoices.vat_percentage', 'invoices.is_cancelled', 'invoices.cancel_req', 'invoices.amount_refund', 'invoices.commission_percentage')->get();

        $user = invoices::leftjoin('users', 'users.id', '=', 'invoices.user_id')->where('invoices.id', '=', $id)->first();

        $handyman = invoices::leftjoin('users', 'users.id', '=', 'invoices.handyman_id')->where('invoices.id', '=', $id)->first();

        if ($user_role == 2) {
            return view('user.invoice', compact('invoice', 'user', 'handyman'));
        } else {
            return view('user.client_invoice', compact('invoice', 'user', 'handyman'));
        }

    }


    public function CancelledInvoice($id)
    {

        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;


        $invoice = invoices::leftjoin('bookings', 'bookings.invoice_id', '=', 'invoices.id')->leftjoin('categories', 'categories.id', '=', 'bookings.service_id')->leftjoin('service_types', 'service_types.id', '=', 'bookings.rate_id')->where('invoices.id', '=', $id)->Select('invoices.id', 'invoices.handyman_id', 'invoices.user_id', 'categories.cat_name', 'service_types.type', 'bookings.service_rate', 'bookings.rate', 'invoices.booking_date', 'bookings.total', 'invoices.is_booked', 'invoices.is_completed', 'invoices.pay_req', 'invoices.is_paid', 'invoices.is_partial', 'invoices.status', 'invoices.total as inv_total', 'invoices.created_at as inv_date', 'invoices.invoice_number', 'invoices.service_fee', 'invoices.vat_percentage', 'invoices.is_cancelled', 'invoices.cancel_req', 'invoices.amount_refund', 'invoices.commission_percentage')->get();

        $invoice_number = cancelled_invoices::where('invoice_id', $id)->first();

        $invoice_number = $invoice_number->invoice_number;


        $user = invoices::leftjoin('users', 'users.id', '=', 'invoices.user_id')->where('invoices.id', '=', $id)->first();

        $handyman = invoices::leftjoin('users', 'users.id', '=', 'invoices.handyman_id')->where('invoices.id', '=', $id)->first();

        if ($user_role == 2) {

            return view('user.cancelled_invoice', compact('invoice', 'user', 'handyman', 'invoice_number'));
        } else {

            return view('user.client_cancelled_invoice', compact('invoice', 'user', 'handyman', 'invoice_number'));

        }


    }

    public function Images($id)
    {

        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $user_role = $user->role_id;


        $data = bookings::leftjoin('booking_images', 'booking_images.booking_id', '=', 'bookings.id')->leftjoin('categories', 'categories.id', '=', 'bookings.service_id')->where('bookings.invoice_id', '=', $id)->Select('categories.cat_name', 'booking_images.image', 'booking_images.description')->get();


        if ($user_role == 2) {

            return view('user.images', compact('data'));
        } else {

            return view('user.client_images', compact('data'));

        }

    }


    public function ClientIndex()
    {
        $user = Auth::guard('user')->user();

        if ($user->role_id == 2) {
            return redirect()->route('user-login');

        }


        return view('user.client_dashboard', compact('user'));
    }

    public function HandymanBookings()
    {

        $user = Auth::guard('user')->user();
        $user_id = $user->id;

        if ($user->role_id == 3) {
            return redirect()->route('user-login');
        }

        // $users_bookings = bookings::leftjoin('users','users.id','=','bookings.user_id')->leftjoin('categories','categories.id','=','bookings.service_id')->leftjoin('service_types','service_types.id','=','bookings.rate_id')->where('handyman_id','=',$user_id)->Select('bookings.id','bookings.handyman_id','users.name','users.email','users.photo','users.family_name','categories.cat_name','service_types.type','bookings.service_rate','bookings.rate','bookings.booking_date','bookings.total','bookings.is_booked','bookings.is_completed','bookings.pay_req','bookings.is_paid','bookings.status')->get();

        $users_bookings = invoices::leftjoin('users', 'users.id', '=', 'invoices.user_id')->where('invoices.handyman_id', '=', $user_id)->Select('invoices.id', 'invoices.user_id', 'invoices.handyman_id', 'invoices.invoice_number', 'invoices.total', 'users.name', 'users.email', 'users.photo', 'users.family_name', 'invoices.is_booked', 'invoices.is_completed', 'invoices.pay_req', 'invoices.is_paid', 'invoices.is_partial', 'invoices.is_cancelled', 'invoices.cancel_req', 'invoices.reply', 'invoices.status', 'invoices.created_at as inv_date', 'invoices.booking_date', 'invoices.service_fee', 'invoices.commission_percentage')->orderBy('id', 'desc')->get();


        // $bookings_dates =  array();

        // $i = 0;

        // foreach ($users_bookings as $key) {

        //     $bookings_dates = bookings::where('invoice_id','=',$key->id)->get();

        //     foreach ($bookings_dates as $temp) {

        //          $dates[$i] = array('id' => $temp->invoice_id,'date' => $temp->booking_date);

        //          $i++;
        //         # code...
        //     }


        // }


        return view('user.bookings', compact('users_bookings'));
    }

    public function PurchasedBookings()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;


        if ($user->role_id == 3) {
            return redirect()->route('user-login');
        }


        $users_bookings = invoices::leftjoin('users', 'users.id', '=', 'invoices.handyman_id')->where('invoices.user_id', '=', $user_id)->Select('invoices.id', 'invoices.user_id', 'invoices.handyman_id', 'invoices.invoice_number', 'invoices.total', 'users.name', 'users.email', 'users.photo', 'users.family_name', 'invoices.is_booked', 'invoices.is_completed', 'invoices.pay_req', 'invoices.is_paid', 'invoices.is_partial', 'invoices.is_cancelled', 'invoices.cancel_req', 'invoices.reply', 'invoices.status', 'invoices.created_at as inv_date', 'invoices.booking_date')->orderBy('id', 'desc')->get();

        return view('user.purchased_bookings', compact('users_bookings'));
    }

    public function ClientBookings()
    {

        $user = Auth::guard('user')->user();
        $user_id = $user->id;

        if ($user->role_id == 2) {
            return redirect()->route('user-login');
        }


        $users_bookings = invoices::leftjoin('users', 'users.id', '=', 'invoices.handyman_id')->where('invoices.user_id', '=', $user_id)->Select('invoices.id', 'invoices.user_id', 'invoices.handyman_id', 'invoices.invoice_number', 'invoices.total', 'users.name', 'users.email', 'users.photo', 'users.family_name', 'invoices.is_booked', 'invoices.is_completed', 'invoices.pay_req', 'invoices.is_paid', 'invoices.is_partial', 'invoices.is_cancelled', 'invoices.cancel_req', 'invoices.reply', 'invoices.status', 'invoices.created_at as inv_date', 'invoices.booking_date')->orderBy('id', 'desc')->get();


        return view('user.client_bookings', compact('users_bookings'));
    }

    public function HandymanStatusUpdate(Request $request)
    {

        $user = Auth::guard('user')->user();
        $user_id = $user->id;

        $client_email = $request->user_email;

        $client = User::where('email', '=', $client_email)->first();

        $client_name = $client->name . " " . $client->family_name;


        $user_name = $user->name;
        $user_familyname = $user->family_name;

        $name = $user_name . ' ' . $user_familyname;

        $handyman_dash = url('/') . '/aanbieder/dashboard';

        $client_dash = url('/') . '/aanbieder/quotation-requests';


        if ($request->statusSelect == 1) {

            $post = bookings::where('invoice_id', '=', $request->item_id)->update(['is_booked' => 1]);
            $post = invoices::where('id', '=', $request->item_id)->update(['is_booked' => 1]);

            if ($this->lang->lang == 'eng') // English Email Template
            {

                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $subject = "Booking status changed!";
                $msg = "Dear Mr/Mrs " . $client_name . ",<br><br>Your requested handyman Mr/Mrs " . $name . " recently changed the status regarding your booking. You can see your current booking status by visiting your profile through <a href='" . $client_dash . "'>here.</a><br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
                mail($client_email, $subject, $msg, $headers);

            } else // Dutch Email Template
            {

                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $subject = "Klus status gewijzigd!";
                $msg = "Beste " . $client_name . ",<br><br>Je stoffeerder " . $name . " heeft de status van je klus gewijzigd. Klik op account om de status van je klus te bekijken <a href='" . $client_dash . "'>account.</a><br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte";
                mail($client_email, $subject, $msg, $headers);

            }


            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $subject = "Booking status changed!";
            $msg = "Dear Nordin Adoui, Recent Activity: Status changed for handyman Mr/Mrs " . $name . ". Kindly visit your admin dashboard to view all bookings statuses.";
            mail($this->sl->admin_email, $subject, $msg, $headers);

        } elseif ($request->statusSelect == 3) {

            $post = bookings::where('invoice_id', '=', $request->item_id)->update(['is_booked' => 1, 'is_completed' => 1]);
            $post = invoices::where('id', '=', $request->item_id)->update(['is_booked' => 1, 'is_completed' => 1]);

            if ($this->lang->lang == 'eng') // English Email Template
            {

                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $subject = "Booking status changed!";
                $msg = "Dear Mr/Mrs " . $client_name . ",<br><br>Your handyman Mr/Mrs " . $name . " recently changed the status regarding your booking. Current status for the ongoing job is updated as completed by the handyman, If the job has been completed by this handyman than kindly change the status for this job so that we can transfer funds to handyman account. You can see your current booking status by visiting your profile through <a href='" . $client_dash . "'>here.</a><br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
                mail($client_email, $subject, $msg, $headers);

            } else // Dutch Email Template
            {

                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $subject = "Klus status gewijzigd!";
                $msg = "Beste " . $client_name . ",<br><br>Je stoffeerder " . $name . " heeft de status van je klus gewijzigd. De status is gewijzigd naar afgerond, als je akkoord bent graag ook de status wijzigen naar klus voldaan. Indien, je niet tevreden bent laat dit ons graag binnen 48 uur weten zodat wij contact op kunnen nemen met de stoffeerder. Om de status van je klus te bekijken klik op account <a href='" . $client_dash . "'>account.</a><br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte";
                mail($client_email, $subject, $msg, $headers);

            }


            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $subject = "Booking status changed!";
            $msg = "Dear Nordin Adoui, Recent activity: Status changed for handyman Mr/Mrs " . $name . ". Kindly visit your admin dashboard to view all bookings statuses.";
            mail($this->sl->admin_email, $subject, $msg, $headers);

        }


        Session::flash('success', $this->lang->hbsm);

        return redirect()->route('handyman-bookings');


    }


    public function ClientStatusUpdate(Request $request)
    {


        $user = Auth::guard('user')->user();
        $user_id = $user->id;


        $user_name = $user->name;
        $user_familyname = $user->family_name;

        $name = $user_name . ' ' . $user_familyname;

        $handyman_email = $request->user_email;

        $handyman = User::where('email', '=', $handyman_email)->first();

        $handyman_name = $handyman->name . " " . $handyman->family_name;

        $handyman_dash = url('/') . '/aanbieder/dashboard';

        $client_dash = url('/') . '/aanbieder/quotation-requests';


        if ($request->statusSelect == 1) {

            $post = bookings::where('invoice_id', '=', $request->item_id)->update(['is_booked' => 1, 'is_completed' => 1, 'pay_req' => 1]);

            $post = invoices::where('id', '=', $request->item_id)->update(['is_booked' => 1, 'is_completed' => 1, 'pay_req' => 1, 'rating' => $request->rate]);

            $rating = invoices::where('handyman_id', $request->handyman_id)->where('pay_req', 1)->get();
            $t_rating = 0;

            $i = 0;

            foreach ($rating as $key) {

                $t_rating = $t_rating + $key->rating;

                $i++;

            }

            $avg_rating = $t_rating / $i;
            $avg_rating = round($avg_rating);

            $user = User::where('id', $request->handyman_id)->update(['rating' => $avg_rating]);

            if ($this->lang->lang == 'eng') // English Email Template
            {

                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $subject = "Booking status changed!";
                $msg = "Dear Mr/Mrs " . $handyman_name . ",<br><br>Your client Mr/Mrs. " . $name . " has changed an ongoing job status to Finished. You will get your payment in your account after approval from backoffice in next 48 hours. You can visit your profile dashboard to view your booking status. You can see your current booking status by visiting your profile through <a href='" . $handyman_dash . "'>here.</a><br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
                mail($handyman_email, $subject, $msg, $headers);

            } else // Dutch Email Template
            {

                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $subject = "Klus status gewijzigd!";
                $msg = "Beste " . $handyman_name . ",<br><br>Je opdrachtgever " . $name . " heeft de status van je klus gewijzigd naar klus voldaan. Je factuur wordt binnen 5 werkdagen uitbetaald. Klik op account om de status van je reservering te bekijken <a href='" . $handyman_dash . "'>account.</a><br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte";
                mail($handyman_email, $subject, $msg, $headers);

            }


            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $subject = "Booking status changed!";
            $msg = "Dear Nordin Adoui, Recent activity: Status changed for handyman Mr/Mrs. " . $name . ". Kindly visit your admin dashboard to view all bookings statuses.";
            mail($this->sl->admin_email, $subject, $msg, $headers);

            Session::flash('success', $this->lang->cbsm);

            return redirect()->route('client-bookings');

        }

        if ($request->statusSelect == 3) {


            $post = invoices::where('id', '=', $request->item_id)->first();

            $user = User::where('id', '=', $post->handyman_id)->first();
            $user1 = User::where('id', '=', $post->user_id)->first();

            $handyman_email = $user->email;
            $user_email = $user1->email;

            $handyman_name = $user->name . ' ' . $user->family_name;
            $user_name = $user1->name . ' ' . $user1->family_name;

            $item_id = $request->item_id;

            $rem_amount = $post->total - ($post->total * 0.3);
            $rem_amount = number_format((float)$rem_amount, 2, '.', '');
            $inv_encrypt = Crypt::encrypt($item_id);
            $language = $this->lang->lang;

            $description = 'Remaining partial payment to admin for Invoice No. ' . $post->invoice_number;

            $api_key = Generalsetting::findOrFail(1);

            $mollie = new \Mollie\Api\MollieApiClient();
            $mollie->setApiKey($api_key->mollie);
            $payment = $mollie->payments->create([
                'amount' => [
                    'currency' => 'EUR',
                    'value' => $rem_amount, // You must send the correct number of decimals, thus we enforce the use of strings
                ],
                'description' => $description,
                'webhookUrl' => route('webhooks.last'),
                'redirectUrl' => url('/thankyou/' . $inv_encrypt),
                "metadata" => [
                    "invoice_id" => $item_id,
                    "user_email" => $user_email,
                    "handyman_email" => $handyman_email,
                    "client_name" => $user_name,
                    "handyman_name" => $handyman_name,
                    "language" => $language,


                ],
            ]);

            $payment_url = $payment->getCheckoutUrl();
            $invoice_update = invoices::where('id', '=', $item_id)->update(['partial_paymentLink' => $payment_url]);

            return Redirect::to($payment_url);
        }


        if ($request->statusSelect == -1) {


            $post = invoices::where('id', '=', $request->item_id)->update(['cancel_req' => 1, 'reason' => $request->reason]);


            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $subject = "Booking cancellation request!";
            $msg = "Dear Nordin Adoui, Recent activity: Job cancellation request has been posted for handyman Mr/Mrs. " . $name . " due to following reason: ' " . $request->reason . " '. Kindly visit your admin dashboard to take further actions.";
            mail($this->sl->admin_email, $subject, $msg, $headers);

            Session::flash('success', $this->lang->cbjcm);

            return redirect()->route('client-bookings');


        }

    }

    public function Services(Request $request)
    {
        $service = Category::leftjoin('service_types', 'service_types.id', '=', 'categories.service_type')->where('categories.id', '=', $request->id)->select('service_types.id', 'service_types.type', 'service_types.text', 'categories.vat_percentage')->first();

        return $service;

    }

    public function GetQuotationData(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;

        $id = $request->id;
        if (strpos($id, 'I')) {
            $id = str_replace("I", "", $id);
            $post = items::where('id', $request->id)->first();
        } else {
            if($request->type == "service")
            {
                $post = Category::where('id', $request->id)->first();
            }
            elseif($request->type == "brand")
            {
                $post = Brand::where('id', $request->id)->first();
            }
            else
            {
                $post = handyman_products::leftjoin('products','products.id','=','handyman_products.product_id')->leftjoin('models','models.id','=','products.model_id')->where('products.category_id',$request->cat)->where('products.brand_id',$request->brand)->where('products.model_id',$id)->where('handyman_products.handyman_id',$user_id)->select('handyman_products.sell_rate as rate','models.cat_name')->first();
            }
        }


        return $post;

    }

    public function SubServices(Request $request)
    {
        $post = handyman_products::leftjoin('categories', 'categories.id', '=', 'handyman_products.product_id')->leftjoin('service_types', 'service_types.id', '=', 'categories.service_type')->where('handyman_products.handyman_id', $request->handyman_id)->where('handyman_products.product_id', $request->id)->where('handyman_products.main_id', $request->main)->select('handyman_products.rate', 'handyman_products.description', 'service_types.type', 'service_types.text', 'service_types.id as rate_id')->first();

        return $post;

    }

    public function UserServices(Request $request)
    {
        $post = Category::query()->where('id', '=', $request->id)->first();
        $service = service_types::query()->where('id', '=', $post->service_type)->first();

        $service_rate = handyman_products::where('handyman_id', '=', $request->h_id)->where('service_id', '=', $request->id)->first();

        $data[] = array('service' => $service, 'service_rate' => $service_rate);


        return $data;

    }

    public function UserSubServices(Request $request)
    {

        $sub_services = handyman_products::leftjoin('categories', 'categories.id', '=', 'handyman_products.product_id')->leftjoin('service_types', 'service_types.id', '=', 'categories.service_type')->where('handyman_products.handyman_id', $request->handyman_id)->where('handyman_products.main_id', $request->service)->select('categories.cat_name', 'categories.cat_slug', 'categories.id')->get();

        return $sub_services;

    }

    public function DeleteServices(Request $request)
    {

        $service = handyman_products::query()->where('id', '=', $request->id)->delete();

        return 'Success!';

    }

    public function DeleteSubServices(Request $request)
    {

        $service = sub_services::query()->where('id', '=', $request->id)->delete();

        return 'Success!';

    }

    public function AddCart(Request $request)
    {

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } //whether ip is from proxy

        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } //whether ip is from remote address

        else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        $img_desc = $request->file('file');
        $size = 0;
        $no = 0;
        $uploadedFiles = array(); // return value

        if ($img_desc) {
            foreach ($img_desc as $img) {
                $no = $no + 1;
                if ($img->getSize() == '') // Size of single image from list is greater than 2mb
                {
                    $msg = $this->lang->tpe;
                    $type = 1;
                    $cart = carts::where('user_ip', '=', $ip_address)->get();
                    $cart_count = count($cart);
                    $data = array('msg' => $msg, 'type' => $type, 'count' => $cart_count);
                    return $data;
                }

                $size = $img->getSize() + $size;

                /* Location */

                $location = public_path() . '/assets/bookingImages/' . $img->getClientOriginalName();
                $uploadOk = 1;
                $imageFileType = pathinfo($location, PATHINFO_EXTENSION);

                /* Valid Extensions */
                $valid_extensions = array("jpg", "jpeg", "png", "pdf");
                /* Check file extension */

                if (!in_array(strtolower($imageFileType), $valid_extensions)) {

                    $msg = $this->lang->fte;
                    $type = 1;
                    $cart = carts::where('user_ip', '=', $ip_address)->get();
                    $cart_count = count($cart);

                    $data = array('msg' => $msg, 'type' => $type, 'count' => $cart_count);

                    return $data;

                }

            }

            if ($no > 5) {
                $msg = $this->lang->mie;
                $type = 1;
                $cart = carts::where('user_ip', '=', $ip_address)->get();
                $cart_count = count($cart);

                $data = array('msg' => $msg, 'type' => $type, 'count' => $cart_count);
                return $data;
            }

            if ($size > '2097152‬') {
                $msg = $this->lang->tpe;
                $type = 1;
                $cart = carts::where('user_ip', '=', $ip_address)->get();
                $cart_count = count($cart);
                $data = array('msg' => $msg, 'type' => $type, 'count' => $cart_count);
                return $data;
            }

            foreach ($img_desc as $img) {
                $fileName = date('YmdHis', time()) . mt_rand() . '.' . pathinfo($img->getClientOriginalName(), PATHINFO_EXTENSION);
                /* Upload file */
                $img->move(public_path() . '/assets/bookingImages/', $fileName);

                array_push($uploadedFiles, $fileName);
            }
        }

        if ($request->service_questions) {
            $purpose = $request->purpose;

            if ($purpose == 1) {
                if ($request->vat_percentage == 21) {
                    $vat_percentage = $request->vat_percentage;
                    $sell_rate = $request->sell_rate;
                } else {
                    $service_rate = $request->service_rate;
                    $vat_percentage = 21;
                    $sell_rate = $service_rate * ($vat_percentage / 100);
                    $sell_rate = $sell_rate + $service_rate;
                }
            } else {
                if ($request->purpose_type == 1) {
                    if ($request->vat_percentage == 21) {
                        $vat_percentage = $request->vat_percentage;
                        $sell_rate = $request->sell_rate;
                    } else {
                        $service_rate = $request->service_rate;
                        $vat_percentage = 21;
                        $sell_rate = $service_rate * ($vat_percentage / 100);
                        $sell_rate = $sell_rate + $service_rate;
                    }
                } else {
                    $service_rate = $request->service_rate;
                    $vat_percentage = 9;
                    $sell_rate = $service_rate * ($vat_percentage / 100);
                    $sell_rate = $sell_rate + $service_rate;
                }
            }
        } else {
            $vat_percentage = $request->vat_percentage;
            $sell_rate = $request->sell_rate;
        }

        $check = carts::where('user_ip', '=', $ip_address)->first();

        if ($check) {
            if ($check->handyman_id == $request->handyman_id) {
                $to_update = carts::where('user_ip', '=', $ip_address)->where('service_id', '=', $request->service)->where('handyman_id', '=', $request->handyman_id)->first();

                if ($to_update) {
                    $qty = $to_update->rate + $request->rate;
                    carts::where('user_ip', '=', $ip_address)->where('service_id', '=', $request->service)->where('handyman_id', '=', $request->handyman_id)->update(['rate' => $qty, 'vat_percentage' => $vat_percentage, 'sell_rate' => $sell_rate]);
                    $sub_service = $request->sub_service;

                    if ($sub_service) {
                        $date = new DateTime($request->date);
                        $date = $date->format('Y-m-d H:i');

                        foreach ($sub_service as $i => $key) {

                            $sub_service_id = $key;

                            $to_update_sub = carts::where('user_ip', '=', $ip_address)->where('service_id', '=', $sub_service_id)->where('main_id', '=', $request->service)->where('handyman_id', '=', $request->handyman_id)->first();

                            if ($to_update_sub) {
                                $qty_sub = $to_update_sub->rate + $request->sub_rate[$i];
                                carts::where('user_ip', '=', $ip_address)->where('service_id', '=', $sub_service_id)->where('main_id', '=', $request->service)->where('handyman_id', '=', $request->handyman_id)->update(['rate' => $qty_sub]);
                            } else {
                                $cart = new carts;
                                $cart->user_ip = $ip_address;
                                $cart->handyman_id = $request->handyman_id;
                                $cart->service_id = $sub_service_id;
                                $cart->main_id = $request->service;
                                $cart->rate_id = $request->sub_rate_id[$i];
                                $cart->rate = $request->sub_rate[$i];
                                $cart->service_rate = $request->sub_service_rate[$i];
                                $cart->booking_date = $date;
                                $cart->save();
                            }
                        }
                    }

                    if (!empty($_FILES ['file'])) {
                        $x = 0;

                        foreach ($img_desc as $img) {
                            $images = new booking_images;
                            $images->cart_id = $to_update->id;
                            $images->image = $uploadedFiles[$x];
                            $images->description = $request->description;
                            $images->save();
                            $x++;
                        }
                    } else {

                        if ($request->description) {
                            $images = new booking_images;
                            $images->cart_id = $to_update->id;
                            $images->description = $request->description;
                            $images->save();
                        }
                    }
                } else {
                    $date = new DateTime($request->date);
                    $date = $date->format('Y-m-d H:i');

                    $post = new carts();
                    $post->user_ip = $ip_address;
                    $post->handyman_id = $request->handyman_id;
                    $post->service_id = $request->service;
                    $post->rate_id = $request->rate_id;
                    $post->rate = $request->rate;
                    $post->service_rate = $request->service_rate;
                    $post->booking_date = $date;
                    $post->vat_percentage = $vat_percentage;
                    $post->sell_rate = $sell_rate;
                    $post->save();

                    $sub_service = $request->sub_service;

                    if ($sub_service) {
                        $i = 0;
                        $date = new DateTime($request->date);
                        $date = $date->format('Y-m-d H:i');

                        foreach ($sub_service as $key) {

                            $cart = new carts;
                            $cart->user_ip = $ip_address;
                            $cart->handyman_id = $request->handyman_id;
                            $cart->service_id = $key;
                            $cart->main_id = $request->service;
                            $cart->rate_id = $request->sub_rate_id[$i];
                            $cart->rate = $request->sub_rate[$i];
                            $cart->service_rate = $request->sub_service_rate[$i];
                            $cart->booking_date = $date;
                            $cart->save();
                            $i++;

                        }
                    }

                    if (!empty($_FILES ['file'])) {
                        $x = 0;

                        foreach ($img_desc as $img) {
                            $images = new booking_images;
                            $images->cart_id = $post->id;
                            $images->image = $uploadedFiles[$x];
                            $images->description = $request->description;
                            $images->save();
                            $x++;
                        }
                    } else {

                        if ($request->description) {
                            $images = new booking_images;
                            $images->cart_id = $post->id;
                            $images->description = $request->description;
                            $images->save();
                        }
                    }
                }

                $type = 0;

                // $msg = 'Service added to cart successfully!';
                $msg = $this->lang->acm;
            } else {
                // $msg = 'Sorry, You can only add multiple services of same handyman into your cart!';
                $msg = $this->lang->ace;
                $type = 1;
            }
        } else {
            $date = new DateTime($request->date);
            $date = $date->format('Y-m-d H:i');

            $post = new carts();
            $post->user_ip = $ip_address;
            $post->handyman_id = $request->handyman_id;
            $post->service_id = $request->service;
            $post->rate_id = $request->rate_id;
            $post->rate = $request->rate;
            $post->service_rate = $request->service_rate;
            $post->booking_date = $date;
            $post->vat_percentage = $vat_percentage;
            $post->sell_rate = $sell_rate;
            $post->save();

            $sub_service = $request->sub_service;

            if ($sub_service) {
                $i = 0;

                $date = new DateTime($request->date);
                $date = $date->format('Y-m-d H:i');

                foreach ($sub_service as $key) {

                    $cart = new carts;
                    $cart->user_ip = $ip_address;
                    $cart->handyman_id = $request->handyman_id;
                    $cart->service_id = $key;
                    $cart->main_id = $request->service;
                    $cart->rate_id = $request->sub_rate_id[$i];
                    $cart->rate = $request->sub_rate[$i];
                    $cart->service_rate = $request->sub_service_rate[$i];
                    $cart->booking_date = $date;
                    $cart->save();
                    $i++;
                }
            }

            if (!empty($_FILES ['file'])) {
                $x = 0;

                foreach ($img_desc as $img) {
                    $images = new booking_images;
                    $images->cart_id = $post->id;
                    $images->image = $uploadedFiles[$x];
                    $images->description = $request->description;
                    $images->save();
                    $x++;
                }
            } else {
                if ($request->description) {
                    $images = new booking_images;
                    $images->cart_id = $post->id;
                    $images->description = $request->description;
                    $images->save();
                }
            }

            $type = 0;

            // $msg = 'Service added to cart successfully!';
            $msg = $this->lang->acm;

        }

        $cart = carts::where('user_ip', '=', $ip_address)->get();
        $cart_count = count($cart);

        $data = array('msg' => $msg, 'type' => $type, 'count' => $cart_count);
        return $data;
    }

    public function BookHandyman(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = Auth::guard('user')->user()->id;

        if ($request->handyman_id == $user_id) {

            Session::flash('unsuccess', $this->lang->pdc);
            return redirect()->back();
        }


        $language = $this->lang->lang;

        $payment_option = $request->payment_option;

        $service_rate = $request->service_rate;
        $service_rate1 = $request->service_rate;
        $service_rate = json_encode($service_rate);


        $handyman_id = $request->handyman_id;
        $counter = Generalsetting::findOrFail(1);
        $min_amount = $counter->min_amount;

        $t_amount = $request->sub_total;


        if ($min_amount != '') {
            if ($min_amount > $t_amount) {

                Session::flash('unsuccess', $this->lang->ma . $min_amount . '!');
                return redirect()->back();

            }
        }
        
        $counter = $counter->counter;

        $invoice_no = sprintf('%04u', $counter);

        $description = 'Payment for Invoice No. ' . $invoice_no;


        $rate_id = $request->rate_id;
        $rate_id = json_encode($rate_id);

        $cart_id = $request->cart_id;
        $cart_id = json_encode($cart_id);

        $service_id = $request->service_id;
        $service_id = json_encode($service_id);

        $rate = $request->rate;
        $rate1 = $request->rate;
        $rate = json_encode($rate);


        $service_total = $request->service_total;

        for ($i = 0; $i < count($service_rate1); $i++) {
            $service_rate1[$i] = $service_rate1[$i];
            $rate1[$i] = $rate1[$i];
            $service_total1[$i] = $service_rate1[$i] * $rate1[$i];

        }

        $service_total = json_encode($service_total1);

        $service_fee = $request->service_fee;
        $vat_percentage = $request->vat_percentage;

        if ($payment_option == 2) {
            $total1 = $request->total_payment1;
            $total = $request->sub_total;
            $total_mollie = number_format((float)$total1, 2, '.', '');
        } else {
            $total = $request->sub_total;
            $total_mollie = number_format((float)$total, 2, '.', '');

        }

        $paid_amount = str_replace('.', ',', number_format($total_mollie, 2));

        $date = $request->date;
        $date = json_encode($date);

        $commission_percentage = $this->gs->commission_percentage;
        // $date = new DateTime($request->date);

        // $date = $date->format('Y-m-d H:m');

        $msg_encrypt = Crypt::encrypt($handyman_id);

        $api_key = Generalsetting::findOrFail(1);

        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey($api_key->mollie);
        $payment = $mollie->payments->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => $total_mollie, // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            'description' => $description,
            'webhookUrl' => route('webhooks.mollie'),
            'redirectUrl' => url('/thankyou-page/' . $msg_encrypt),
            "metadata" => [
                "user_id" => $user_id,
                "handyman_id" => $handyman_id,
                "service_id" => $service_id,
                "rate_id" => $rate_id,
                "rate" => $rate,
                "date" => $date,
                "service_rate" => $service_rate,
                "service_total" => $service_total,
                "total" => $total,
                "invoice_no" => $invoice_no,
                "ip" => $request->ip,
                "payment_option" => $payment_option,
                "language" => $language,
                "service_fee" => $service_fee,
                "vat_percentage" => $vat_percentage,
                "commission_percentage" => $commission_percentage,
                "cart_id" => $cart_id,
                "paid_amount" => $paid_amount,


            ],
        ]);

        return redirect($payment->getCheckoutUrl(), 303);


        // $date = new DateTime($request->date);


        // $post = new bookings;
        // $post->user_id = $user_id;
        // $post->handyman_id = $request->handyman_id;
        // $post->is_booked = 1;
        // $post->service_id = $request->service;
        // $post->rate_id = $request->rate_id;
        // $post->rate = $request->rate;
        // $post->booking_date = $date;
        // $post->service_rate = $service_rate;
        // $post->total = $total;
        // $post->save();

        // Session::flash('success', 'Handyman booked successfully!');
        // return redirect()->back();

    }

    public function profile()
    {
        $user = Auth::guard('user')->user();
        $user_id = Auth::guard('user')->user()->id;

        if ($user->role_id == 3) {
            return redirect()->route('user-login');
        }

        if($user->can('edit-profile'))
        {
            $cats = Category::all();
            $services_selected = handyman_products::query()->where('handyman_id', '=', $user_id)->get();

            $services = Category::leftjoin('handyman_products', 'handyman_products.product_id', '=', 'categories.id')->where('handyman_products.handyman_id', '=', $user_id)->get();


            return view('user.profile', compact('user', 'cats', 'services_selected', 'services'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function AvailabilityManager()
    {
        $user = Auth::guard('user')->user();
        $user_id = Auth::guard('user')->user()->id;

        if ($user->role_id == 3) {
            return redirect()->route('user-login');
        }

        $post = handyman_unavailability::where('handyman_id', '=', $user_id)->select('date')->get();


        $unavailable_dates = $post->pluck('date')->implode(',');


        $hours = handyman_unavailability_hours::where('handyman_id', '=', $user_id)->get();

        $services = Category::leftjoin('handyman_products', 'handyman_products.product_id', '=', 'categories.id')->where('handyman_products.handyman_id', '=', $user_id)->get();


        return view('user.availability_management', compact('user', 'services', 'unavailable_dates', 'hours'));
    }

    public function RadiusManagement()
    {
        $user = Auth::guard('user')->user();
        $user_id = Auth::guard('user')->user()->id;

        if ($user->role_id == 3) {
            return redirect()->route('user-login');
        }


        if($user->can('radius-management'))
        {
            $services = Category::leftjoin('handyman_products', 'handyman_products.product_id', '=', 'categories.id')->where('handyman_products.handyman_id', '=', $user_id)->get();
            $terminal = handyman_terminals::where('handyman_id', '=', $user_id)->first();


            return view('user.radius_management', compact('user', 'services', 'terminal'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function ClientProfile()
    {
        $user = Auth::guard('user')->user();
        $user_id = Auth::guard('user')->user()->id;

        if ($user->role_id == 2) {
            return redirect()->route('user-login');
        }

        $cats = Category::all();


        return view('user.client_profile', compact('user', 'cats'));
    }

    public function MyProducts()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $check = 0;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if(\Route::currentRouteName() == 'user-products')
        {
            if($user->can('user-products'))
            {
                $check = 1;
            }
        }


        if(\Route::currentRouteName() == 'product-create')
        {
            if($user->can('product-create'))
            {
                $check = 1;
            }
        }

        if($check)
        {
            $products_array = array();

            $products_selected = handyman_products::leftjoin('products', 'products.id', '=', 'handyman_products.product_id')->leftjoin('categories', 'categories.id', '=', 'products.category_id')->leftjoin('brands', 'brands.id', '=', 'products.brand_id')->leftjoin('models', 'models.id', '=', 'products.model_id')->where('handyman_products.handyman_id', '=', $user_id)->orderBy('products.id', 'desc')->select('products.*', 'categories.cat_name as category', 'brands.cat_name as brand', 'models.cat_name as model', 'handyman_products.rate', 'handyman_products.vat_percentage', 'handyman_products.sell_rate', 'handyman_products.id', 'handyman_products.product_id', 'handyman_products.size_rates', 'handyman_products.size_sell_rates')->get();

            foreach ($products_selected as $key)
            {
                $products_array[] = array($key->product_id);
            }

            $products = Products::leftjoin('categories', 'categories.id', '=', 'products.category_id')->leftjoin('brands', 'brands.id', '=', 'products.brand_id')->leftjoin('models', 'models.id', '=', 'products.model_id')->whereNotIn('products.id',$products_array)->orderBy('products.id', 'desc')->select('products.*', 'categories.cat_name as category', 'brands.cat_name as brand', 'models.cat_name as model')->get();

            return view('user.my_products', compact('user', 'products_selected','products'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function ProductCreate()
    {
        $user = Auth::guard('user')->user();
        $user_id = Auth::guard('user')->user()->id;

        if ($user->role_id == 3) {
            return redirect()->route('user-login');
        }

        $ids = array();

        $my_products = handyman_products::where('handyman_id',$user_id)->get();

        foreach($my_products as $key)
        {
            $ids[] = array('id' => $key->product_id);
        }

        $products = Products::whereNotIn('id',$ids)->get();

        return view('user.create_product',compact('products'));
    }

    public function ProductEdit($id)
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
            $my_product = handyman_products::leftjoin('products','products.id','=','handyman_products.product_id')->leftjoin('categories', 'categories.id', '=', 'products.category_id')->leftjoin('brands', 'brands.id', '=', 'products.brand_id')->leftjoin('models', 'models.id', '=', 'products.model_id')->where('handyman_products.id',$id)->select('products.*','handyman_products.*','categories.cat_name as category','brands.cat_name as brand','models.cat_name as model')->first();

            $ids = array();

            $my_products = handyman_products::where('handyman_id',$user_id)->where('id','!=',$id)->get();

            foreach($my_products as $key)
            {
                $ids[] = array('id' => $key->product_id);
            }

            $products = Products::whereNotIn('id',$ids)->get();

            return view('user.create_product',compact('products','my_product'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function ProductDetails(Request $request)
    {
        $details = Products::leftjoin('categories', 'categories.id', '=', 'products.category_id')->leftjoin('brands', 'brands.id', '=', 'products.brand_id')->leftjoin('models', 'models.id', '=', 'products.model_id')->where('products.id',$request->id)->select('products.*', 'categories.cat_name as category', 'brands.cat_name as brand', 'models.cat_name as model')->first();

        return $details;
    }

    public function ProductStore(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($request->handyman_product_id)
        {
            $sizes = explode(',', $request->size);

            $post = handyman_products::where('id',$request->handyman_product_id)->first();
            $post->handyman_id = $user_id;
            $post->product_id = $request->product_id;
            $post->rate = str_replace(",",".",$request->product_rate[0]);
            $post->sell_rate = str_replace(",",".",$request->product_sell_rate[0]);
            $post->vat_percentage = $request->product_vat;
            /*$post->model_number = $request->model_number;*/

            $new_rates = [];
            $new_sell_rates = [];

            foreach ($sizes as $y => $key1)
            {
                array_push($new_rates,str_replace(",",".",$request->product_rate[$y]));
                array_push($new_sell_rates,str_replace(",",".",$request->product_sell_rate[$y]));
            }

            $size_rates = implode(',',$new_rates);
            $size_sell_rates = implode(',',$new_sell_rates);

            $post->size_rates = $size_rates;
            $post->size_sell_rates = $size_sell_rates;

            $post->save();


            Session::flash('success', __('text.Product edited successfully.'));
        }
        else
        {
            foreach ($request->product_checkboxes as $x => $key)
            {
                $sizes = explode(',', $request->sizes[$x]);

                $new_rates = [];
                $new_sell_rates = [];

                foreach ($sizes as $y => $key1)
                {
                    array_push($new_rates,number_format((float)$request->product_rate[$key], 2, '.', ''));
                    array_push($new_sell_rates,number_format((float)$request->product_sell_rate[$key], 2, '.', ''));
                }

                $size_rates = implode(',',$new_rates);
                $size_sell_rates = implode(',',$new_sell_rates);

                $post = new handyman_products;
                $post->handyman_id = $user_id;
                $post->product_id = $request->product_id[$key];
                $post->rate = $request->product_rate[$key];
                $post->sell_rate = $request->product_sell_rate[$key];
                $post->size_rates = $size_rates;
                $post->size_sell_rates = $size_sell_rates;
                $post->vat_percentage = 21;
                /*$post->model_number = $request->model_number[$x];*/
                $post->save();
            }

            Session::flash('success', __('text.New Product(s) added successfully.'));
        }

        return redirect()->route('user-products');
    }

    public function ProductDelete($id)
    {
        $user = Auth::guard('user')->user();

        if($user->can('product-delete'))
        {
            $my_product = handyman_products::findOrFail($id);
            $my_product->delete();

            Session::flash('success', __('text.Product deleted successfully.'));
            return redirect()->back();
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function MyServices()
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $check = 0;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if(\Route::currentRouteName() == 'my-services')
        {
            if($user->can('my-services'))
            {
                $check = 1;
            }
        }

        if(\Route::currentRouteName() == 'service-create')
        {
            if($user->can('service-create'))
            {
                $check = 1;
            }
        }

        if($check)
        {
            $services_array = array();

            $services_selected = retailer_services::leftjoin('services', 'services.id', '=', 'retailer_services.service_id')->where('retailer_services.retailer_id', '=', $user_id)->orderBy('services.id', 'desc')->select('services.*','retailer_services.rate','retailer_services.sell_rate','retailer_services.id','retailer_services.service_id')->get();

            foreach ($services_selected as $key)
            {
                $services_array[] = array($key->service_id);
            }

            $services = Service::whereNotIn('id',$services_array)->orderBy('services.id', 'desc')->get();

            return view('user.my_services', compact('user', 'services_selected','services'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function ServiceStore(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($request->retailer_service_id)
        {
            $sub_categories = implode(',', $request->sub_category_id);

            $post = retailer_services::where('id',$request->retailer_service_id)->first();
            $post->retailer_id = $user_id;
            $post->service_id = $request->service_id;
            $post->rate = str_replace(",",".",$request->product_rate);
            $post->sell_rate = str_replace(",",".",$request->product_sell_rate);
            $post->measure = $request->measure;
            $post->category_id = $request->category_id;
            $post->sub_category_ids = $sub_categories ? $sub_categories : NULL;
            $post->save();

            Session::flash('success', 'Service edited successfully.');
        }
        else
        {
            foreach ($request->service_checkboxes as $x => $key)
            {
                $post = new retailer_services;
                $post->retailer_id = $user_id;
                $post->service_id = $request->service_id[$key];
                $post->rate = $request->product_rate[$key];
                $post->sell_rate = $request->product_sell_rate[$key];
                $post->measure = $request->measure[$key];
                $post->category_id = $request->category_id[$key];
                $post->sub_category_ids = $request->sub_category_id[$key];
                $post->save();
            }

            Session::flash('success', 'New Service(s) added successfully.');
        }

        return redirect()->route('my-services');
    }

    public function ServiceEdit($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('service-edit'))
        {
            $my_service = retailer_services::leftjoin('services','services.id','=','retailer_services.service_id')->where('retailer_services.id',$id)->select('services.*','retailer_services.*')->first();

            $ids = array();

            $my_services = retailer_services::where('retailer_id',$user_id)->where('id','!=',$id)->get();

            foreach($my_services as $key)
            {
                $ids[] = array('id' => $key->service_id);
            }

            $services = Service::whereNotIn('id',$ids)->get();
            $categories = Category::get();
            $sub_categories = sub_categories::where('parent_id',$my_service->category_id)->get();

            return view('user.create_service',compact('services','my_service','categories','sub_categories'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function ServiceDelete($id)
    {
        $user = Auth::guard('user')->user();

        if($user->can('service-delete'))
        {
            $my_service = retailer_services::findOrFail($id);

            $my_service->delete();
            Session::flash('success', 'Service deleted successfully.');
            return redirect()->back();
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function MyItems()
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
            $items = items::where('user_id', $user_id)->get();

            return view('user.my_items', compact('user_id', 'items'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function CreateItem()
    {
        $user = Auth::guard('user')->user();

        if($user->can('create-item'))
        {
            $categories = Category::get();
            return view('user.create_item',compact('categories'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function StoreItem(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($request->item_id)
        {
            $item = items::where('id',$request->item_id)->first();

            if ($item->photo != null) {
                \File::delete(public_path() .'/assets/item_images/'.$item->photo);
            }

            Session::flash('success', __('text.Item updated successfully.'));
        }
        else
        {
            $item = new items;
            Session::flash('success', __('text.Item added successfully.'));
        }

        $photo = '';

        if ($file = $request->file('photo')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('assets/item_images', $name);
            $photo = $name;
        }

        $sub_categories = implode(',', $request->sub_category_id);
        $products = implode(',', $request->products);

        $item->user_id = $user_id;
        $item->category_id = $request->category_id;
        $item->sub_category_ids = $sub_categories ? $sub_categories : NULL;
        $item->cat_name = $request->item;
        $item->photo = $photo;
        $item->description = $request->description;
        $item->rate = str_replace(",",".",$request->rate);
        $item->sell_rate = str_replace(",",".",$request->sell_rate);
        $item->products = $products ? $products : NULL;
        $item->save();

        return redirect()->route('user-items');
    }

    public function EditItem($id)
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
            $item = items::where('id', $id)->where('user_id', $user_id)->first();
            $categories = Category::get();
            $sub_categories = sub_categories::where('parent_id',$item->category_id)->get();
            return view('user.create_item', compact('item','categories','sub_categories'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function UpdateItem(Request $request, $id)
    {
        $item = items::findOrFail($id);
        $input = $request->all();

        if ($file = $request->file('photo')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('assets/item_images', $name);
            if ($item->photo != null) {
                \File::delete(public_path() .'/assets/item_images/'.$item->photo);
            }
            $input['photo'] = $name;
        } else {
            if ($item->photo != null) {
                \File::delete(public_path() .'/assets/item_images/'.$item->photo);
            }

            $input['photo'] = '';
        }

        $item = items::where('id', $id)->update(['cat_name' => $request->item, 'photo' => $input['photo'], 'description' => $request->description, 'rate' => str_replace(",",".",$request->rate)]);

        Session::flash('success', __('text.Item updated successfully.'));
        return redirect()->route('user-items');
    }

    public function DestroyItem($id)
    {
        $user = Auth::guard('user')->user();

        if($user->can('delete-item'))
        {
            $item = items::findOrFail($id);

            if ($item->photo == null) {
                $item->delete();
                Session::flash('success', 'Item deleted successfully.');
                return redirect()->route('user-items');
            }

            \File::delete(public_path() .'/assets/item_images/'.$item->photo);
            $item->delete();
            Session::flash('success', __('text.Item deleted successfully.'));
            return redirect()->route('user-items');
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function MySubServices()
    {
        $user = Auth::guard('user')->user();
        $user_id = Auth::guard('user')->user()->id;

        if ($user->role_id == 3) {
            return redirect()->route('user-login');
        }


        // $sub_cats = Category::leftjoin('handyman_products','handyman_products.product_id','=','categories.id')->leftjoin('sub_services','sub_services.sub_id','=','handyman_products.product_id')->where('handyman_products.handyman_id',$user_id)->where('categories.main_service',0)->select('categories.id','categories.cat_name','sub_services.cat_id','sub_services.sub_id','handyman_products.rate','handyman_products.description')->get();

        $main_cats_selected = Category::leftjoin('handyman_products', 'handyman_products.product_id', '=', 'categories.id')->where('handyman_products.handyman_id', $user_id)->select('categories.id', 'categories.cat_name', 'handyman_products.product_id')->get();

        foreach ($main_cats_selected as $key => $value) {

            $sub_cats[$value->id] = Category::leftjoin('sub_services', 'sub_services.sub_id', '=', 'categories.id')->where('sub_services.cat_id', $value->id)->select('categories.id', 'categories.cat_name', 'sub_services.cat_id', 'sub_services.sub_id')->get();

            $sub_selected[$value->id] = Category::leftjoin('handyman_products', 'handyman_products.product_id', '=', 'categories.id')->leftjoin('service_types', 'service_types.id', '=', 'categories.service_type')->where('handyman_products.handyman_id', $user_id)->where('handyman_products.main_id', $value->id)->select('categories.id', 'categories.cat_name', 'handyman_products.id as h_id', 'handyman_products.rate', 'handyman_products.description', 'handyman_products.main_id', 'service_types.type', 'handyman_products.vat_percentage', 'handyman_products.sell_rate')->get();

            # code...
        }


        return view('user.my_subservices', compact('user', 'sub_cats', 'main_cats_selected', 'sub_selected'));
    }

    public function GetID(Request $request)
    {


        $user = Auth::guard('user')->user();
        $user_id = Auth::guard('user')->user()->id;


        $sub_cats = Category::leftjoin('sub_services', 'sub_services.sub_id', '=', 'categories.id')->where('sub_services.cat_id', $request->id)->select('categories.id', 'categories.cat_name', 'sub_services.cat_id', 'sub_services.sub_id')->get();


        return $sub_cats;

    }

    public function CompleteProfile()
    {
        $user = Auth::guard('user')->user();
        $user_id = Auth::guard('user')->user()->id;

        if ($user->role_id == 3) {
            return redirect()->route('user-login');
        }


        if($user->can('user-complete-profile'))
        {
            $cats = Category::all();

            $services_selected = handyman_products::query()->where('handyman_id', '=', $user_id)->get();

            $services = Category::leftjoin('handyman_products', 'handyman_products.product_id', '=', 'categories.id')->where('handyman_products.handyman_id', '=', $user_id)->get();


            return view('user.complete_profile', compact('user', 'cats', 'services_selected', 'services'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function ExperienceYears()
    {
        $user = Auth::guard('user')->user();
        $user_id = Auth::guard('user')->user()->id;

        if ($user->role_id == 3) {
            return redirect()->route('user-login');
        }

        $cats = Category::all();

        $services_selected = handyman_products::query()->where('handyman_id', '=', $user_id)->get();

        $services = Category::leftjoin('handyman_products', 'handyman_products.product_id', '=', 'categories.id')->where('handyman_products.handyman_id', '=', $user_id)->get();


        return view('user.experience_years', compact('user', 'services_selected', 'services', 'cats'));
    }

    public function Insurance()
    {
        $user = Auth::guard('user')->user();
        $user_id = Auth::guard('user')->user()->id;

        if ($user->role_id == 3) {
            return redirect()->route('user-login');
        }

        $cats = Category::all();

        $services_selected = handyman_products::query()->where('handyman_id', '=', $user_id)->get();

        $services = Category::leftjoin('handyman_products', 'handyman_products.product_id', '=', 'categories.id')->where('handyman_products.handyman_id', '=', $user_id)->get();


        return view('user.insurance', compact('user', 'services_selected', 'services', 'cats'));
    }

    public function resetform()
    {
        $user = Auth::guard('user')->user();
        $user_role = Auth::guard('user')->user()->role_id;

        if ($user_role == 2) {

            $services = Category::leftjoin('handyman_products', 'handyman_products.product_id', '=', 'categories.id')->where('handyman_products.handyman_id', '=', $user->id)->get();

        } else {
            $services = "";
        }

        return view('user.reset', compact('user', 'services', 'user_role'));
    }

    public function reset(Request $request)
    {
        $input = $request->all();
        $user = Auth::guard('user')->user();
        if ($request->cpass) {
            if (Hash::check($request->cpass, $user->password)) {
                if ($request->newpass == $request->renewpass) {
                    $input['password'] = Hash::make($request->newpass);
                } else {
                    Session::flash('unsuccess', $this->lang->cpnm);
                    return redirect()->back();
                }
            } else {
                Session::flash('unsuccess', $this->lang->cpnm);
                return redirect()->back();
            }
        }
        $user->update($input);
        Session::flash('success', $this->lang->suyp);
        return redirect()->back();
    }

    public function compressImage($source, $destination, $quality) {

        $info = getimagesize($source);

        if (isset($info['mime']) && $info['mime'] == 'image/jpeg')
        {
            $source = imagecreatefromjpeg($source);
        }

        $img = Image::make($source);

        $img->resize(300, 300, function($constraint){
            $constraint->aspectRatio();
        })->save($destination);

        return;

    }

    public function compress_image()
    {
        $users = User::all();

        foreach($users as $user)
        {
            if($user->photo)
            {
                $path = public_path('assets/images/' . $user->photo);

                if (File::exists($path)) {
                    $tmpFilePath = 'assets/images/';
                    $hardPath =  time() . '.' .pathinfo($path, PATHINFO_EXTENSION);

                    $target_file = $tmpFilePath . $hardPath;

                    $this->compressImage($path,$target_file,20);
                    $user->compressed_photo = $hardPath;
                    $user->save();
                }
            }
        }
    }

    public function TemporaryProfileUpdate(Request $request)
    {
        $input = $request->all();
        $user = Auth::guard('user')->user();
        $user_id = $user->id;

        if($input['longitude'] && $input['latitude'])
        {
            $latitude = $input['latitude'];
            $longitude = $input['longitude'];
        }
        else
        {
            $terminal = handyman_terminals::where('handyman_id',$user_id)->first();

            if($terminal)
            {
                $latitude = $terminal->latitude;
                $longitude = $terminal->longitude;
            }
            else
            {
                $latitude = NULL;
                $longitude = NULL;
            }
        }

        $check = handyman_temporary::where('handyman_id', $user->id)->first();


        if (strpos($request->address, '&') === true) {
            $input['address'] = str_replace("&", "and", $request->address);
        }

        if (!empty($request->special)) {
            $input['special'] = implode(',', $request->special);
        }

        if (empty($request->special)) {
            $input['special'] = null;
        }


        if ($check) {

            if ($file = $request->file('photo')) {

                if ($check->photo) {
                    \File::delete(public_path() .'/assets/images/'.$check->photo);
                }

                if ($check->compressed_photo) {
                    \File::delete(public_path() .'/assets/images/'.$check->compressed_photo);
                }

                $image = $request->file('photo');

                $tmpFilePath = 'assets/images/';
                $hardPath =  time() . $image->getClientOriginalName();

                $target_file = $tmpFilePath . $hardPath;

                $this->compressImage($image,$target_file,20);

                $name = time() . $file->getClientOriginalName();
                $file->move('assets/images', $name);

                User::where('id',$user_id)->update(['photo' => $name, 'compressed_photo' => $hardPath]);

                $input['photo'] = $name;
                $input['compressed_photo'] = $hardPath;

            } else {

                $input['photo'] = $check->photo;
                $input['compressed_photo'] = null;

            }

            handyman_temporary::where('handyman_id', $user->id)->update(['handyman_id' => $user->id, 'email' => $user->email, 'name' => $input['name'], 'family_name' => $input['family_name'], 'photo' => $input['photo'], 'compressed_photo' => $input['compressed_photo'], 'description' => $input['description'], 'language' => $input['language'], 'education' => $input['education'], 'profession' => $input['profession'], 'city' => $input['city'], 'address' => $input['address'], 'phone' => $input['phone'], 'web' => $input['web'], 'special' => $input['special'], 'registration_number' => $input['registration_number'], 'company_name' => $input['company_name'], 'tax_number' => $input['tax_number'], 'bank_account' => $input['bank_account'], 'postcode' => $input['postcode'], 'longitude' => $longitude, 'latitude' => $latitude ]);

        } else {

            if ($file = $request->file('photo')) {

                $image = $request->file('photo');

                $tmpFilePath = 'assets/images/';
                $hardPath =  time() . $image->getClientOriginalName();

                $target_file = $tmpFilePath . $hardPath;

                $this->compressImage($image,$target_file,20);

                $name = time() . $file->getClientOriginalName();
                $file->move('assets/images', $name);

                User::where('id',$user_id)->update(['photo' => $name, 'compressed_photo' => $hardPath]);

                $input['photo'] = $name;
                $input['compressed_photo'] = $hardPath;

            } else {

                $input['photo'] = null;
                $input['compressed_photo'] = null;

            }

            $post = new handyman_temporary;
            $post->handyman_id = $user->id;
            $post->email = $user->email;
            $post->name = $input['name'];
            $post->family_name = $input['family_name'];
            $post->photo = $input['photo'];
            $post->compressed_photo = $input['compressed_photo'];
            $post->description = $input['description'];
            $post->language = $input['language'];
            $post->education = $input['education'];
            $post->profession = $input['profession'];
            $post->city = $input['city'];
            $post->address = $input['address'];
            $post->phone = $input['phone'];
            $post->web = $input['web'];
            $post->special = $input['special'];
            $post->registration_number = $input['registration_number'];
            $post->company_name = $input['company_name'];
            $post->tax_number = $input['tax_number'];
            $post->bank_account = $input['bank_account'];
            $post->postcode = $input['postcode'];
            $post->longitude = $longitude;
            $post->latitude = $latitude;

            $post->save();

        }

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Profile Update Requested!";
        $msg = "Dear Nordin Adoui, Recent activity: A handyman Mr/Mrs. " . $input['name'] . " " . $input['family_name'] . " requested for profile update, kindly visit your admin dashboard in order to take further actions.";
        mail($this->sl->admin_email, $subject, $msg, $headers);


        Session::flash('success', $this->lang->pusm);
        return redirect()->route('user-profile');
    }

    public function profileupdate(Request $request)
    {
        $input = $request->all();

        $user = Auth::guard('user')->user();


        if ($file = $request->file('photo')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('assets/images', $name);
            if ($user->photo != null) {
                \File::delete(public_path() .'/assets/images/'.$user->photo);
            }
            $input['photo'] = $name;
        }
        if (strpos($request->address, '&') === true) {
            $input['address'] = str_replace("&", "and", $request->address);
        }

        if (!empty($request->special)) {
            $input['special'] = implode(',', $request->special);
        }

        if (empty($request->special)) {
            $input['special'] = null;
        }

        $user->update($input);


        Session::flash('success', $this->lang->success);
        return redirect()->route('user-profile');
    }

    public function AvailabilityUpdate(Request $request)
    {
        $input = $request->all();


        $user = Auth::guard('user')->user();


        $handyman_unavailability = handyman_unavailability::where('handyman_id', '=', $user->id)->delete();


        if ($request->multiple_dates != '') {
            $myArray = explode(',', $request->multiple_dates);


            foreach ($myArray as $key) {


                $handyman_unavailability = new handyman_unavailability();
                $handyman_unavailability->handyman_id = $user->id;
                $handyman_unavailability->date = $key;
                $handyman_unavailability->save();


            }

        }

        $handyman_unavailability_hours = handyman_unavailability_hours::where('handyman_id', '=', $user->id)->delete();

        if ($request->hours != '') {


            foreach ($request->hours as $key) {


                $handyman_unavailability_hours = new handyman_unavailability_hours();
                $handyman_unavailability_hours->handyman_id = $user->id;
                $handyman_unavailability_hours->hour = $key;
                $handyman_unavailability_hours->save();


            }

        }


        Session::flash('success', $this->lang->success);
        return redirect()->route('user-availability');
    }

    public function RadiusUpdate(Request $request)
    {
        $input = $request->all();

        $user = Auth::guard('user')->user();

        $post = handyman_terminals::where('handyman_id', '=', $user->id)->first();

        if ($post == '') {

            $post = new handyman_terminals();
            $post->handyman_id = $user->id;
            $post->zipcode = $input['postal_code'];
            $post->longitude = $input['longitude'];
            $post->latitude = $input['latitude'];
            $post->radius = $input['radius'];
            $post->city = $input['terminal_city'];
            $post->save();

        } else {

            handyman_terminals::where('handyman_id', '=', $user->id)->update(['zipcode' => $input['postal_code'], 'longitude' => $input['longitude'], 'latitude' => $input['latitude'], 'radius' => $input['radius'], 'city' => $input['terminal_city']]);

        }

        /*User::where('id', '=', $user->id)->update(['postcode' => $input['postal_code']]);*/


        Session::flash('success', $this->lang->success);
        return redirect()->route('radius-management');
    }

    public function InsuranceUpload(Request $request)
    {
        $input = $request->all();

        $user = Auth::guard('user')->user();


        if ($file = $request->file('photo')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('assets/InsurancePod', $name);
            if ($user->photo != null) {
                unlink(public_path() . '/assets/InsurancePod/' . $user->photo);
            }
            $input['photo'] = $name;
        }

        $post = User::where('id', '=', $user->id)->update(['insurance_pod' => $input['photo']]);


        $user_name = $user->name;
        $user_familyname = $user->family_name;

        $name = $user_name . ' ' . $user_familyname;


        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Insurance POD Uploaded!";
        $msg = "Dear Nordin Adoui, Recent activity: A handyman Mr/Mrs. " . $name . " uploaded a pod for his/her insurance, kindly visit your admin dashboard in order to take further actions.";
        mail($this->sl->admin_email, $subject, $msg, $headers);


        Session::flash('success', $this->lang->success);
        return redirect()->route('insurance');
    }

    public function ClientProfileUpdate(Request $request)
    {
        $input = $request->all();

        $user = Auth::guard('user')->user();


        if ($file = $request->file('photo')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('assets/images', $name);
            if ($user->photo != null) {
                unlink(public_path() . '/assets/images/' . $user->photo);
            }
            $input['photo'] = $name;
        }
        if (strpos($request->address, '&') === true) {
            $input['address'] = str_replace("&", "and", $request->address);
        }

        if (!empty($request->special)) {
            $input['special'] = implode(',', $request->special);
        }

        if (empty($request->special)) {
            $input['special'] = null;
        }

        $user->update($input);


        Session::flash('success', $this->lang->success);
        return redirect()->route('client-profile');
    }

    public function MyServicesUpdate(Request $request)
    {
        $input = $request->all();

        $user_id = Auth::guard('user')->user()->id;

        $post = handyman_products::query()->where('handyman_id', '=', $user_id)->first();


        if ($post != "") {
            for ($i = 0; $i < sizeof($input['title']); $i++) {
                if ($input['hs_id'][$i] == 0) {
                    $post = new handyman_products();
                    $post->handyman_id = $user_id;
                    $post->service_id = $input['title'][$i];
                    $post->rate = $input['details'][$i];
                    $post->vat_percentage = $input['vat_percentages'][$i];
                    $post->sell_rate = $input['sell_rates'][$i];
                    $post->description = $input['description'][$i];

                    $post->save();
                } else {

                    $post = handyman_products::query()->where('id', '=', $input['hs_id'][$i])->update(['service_id' => $input['title'][$i], 'rate' => $input['details'][$i], 'vat_percentage' => $input['vat_percentages'][$i], 'sell_rate' => $input['sell_rates'][$i], 'description' => $input['description'][$i]]);

                }


            }

        } else {

            for ($i = 0; $i < sizeof($input['title']); $i++) {
                $post = new handyman_products();
                $post->handyman_id = $user_id;
                $post->service_id = $input['title'][$i];
                $post->rate = $input['details'][$i];
                $post->vat_percentage = $input['vat_percentages'][$i];
                $post->sell_rate = $input['sell_rates'][$i];
                $post->description = $input['description'][$i];

                $post->save();

            }


        }


        Session::flash('success', $this->lang->success);
        return redirect()->route('user-services');
    }


    public function MySubServicesUpdate(Request $request)
    {
        $input = $request->all();

        $user_id = Auth::guard('user')->user()->id;

        for ($i = 0; $i < sizeof($input['title']); $i++) {
            if ($input['hs_id'][$i] == 0) {
                $check = handyman_products::where('handyman_id', $user_id)->where('service_id', $input['title'][$i])->where('main_id', $input['main_id'][$i])->first();

                if ($check) {

                    $post = handyman_products::query()->where('id', '=', $check->id)->update(['service_id' => $input['title'][$i], 'rate' => $input['details'][$i], 'vat_percentage' => $input['vat_percentages'][$i], 'sell_rate' => $input['sell_rates'][$i], 'description' => $input['description'][$i]]);

                } else {
                    $post = new handyman_products();
                    $post->handyman_id = $user_id;
                    $post->service_id = $input['title'][$i];
                    $post->main_id = $input['main_id'][$i];
                    $post->rate = $input['details'][$i];
                    $post->vat_percentage = $input['vat_percentages'][$i];
                    $post->sell_rate = $input['sell_rates'][$i];
                    $post->description = $input['description'][$i];
                    $post->save();

                }

            } else {
                $post = handyman_products::query()->where('id', '=', $input['hs_id'][$i])->update(['service_id' => $input['title'][$i], 'rate' => $input['details'][$i], 'vat_percentage' => $input['vat_percentages'][$i], 'sell_rate' => $input['sell_rates'][$i], 'description' => $input['description'][$i]]);
            }


        }

        Session::flash('success', $this->lang->success);
        return redirect()->route('user-subservices');
    }

    public function PostExperienceYears(Request $request)
    {
        $input = $request->all();

        $user_id = Auth::guard('user')->user()->id;


        $post = User::query()->where('id', '=', $user_id)->update(['experience_years' => $request->years]);


        Session::flash('success', $this->lang->success);
        return redirect()->route('experience-years');
    }


    public function CompleteProfileUpdate(Request $request)
    {

        $input = $request->all();

        $registration_fee = $this->gs->registration_fee;

        if ($registration_fee == '' || $registration_fee == 0) {
            $registration_fee = "0.01";
        } else {

            $registration_fee = number_format((float)$registration_fee, 2, '.', '');

        }


        $consumerName = $input['full_name'];
        $current_date = date("Y-m-d");


        $user = Auth::guard('user')->user();
        $user_id = Auth::guard('user')->user()->id;
        $api_key = Generalsetting::findOrFail(1);
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey($api_key->mollie);

        $customer = $mollie->customers->create([
            "name" => $consumerName,
            "email" => $input['email'],
        ]);

//         $mandate = $mollie->customers->get($customer->id)->createMandate([
//    "method" => \Mollie\Api\Types\MandateMethod::DIRECTDEBIT,
//    "consumerName" => "John Doe",
//    "consumerAccount" => "NL55INGB0000000000",
// ]);


        $payment = $mollie->customers->get($customer->id)->createPayment([
            "amount" => [
                "currency" => "EUR",
                "value" => $registration_fee,
            ],
            "description" => "Registration Fee Payment",
            "redirectUrl" => route('user-complete-profile'),
            "webhookUrl" => route('webhooks.first'),
            "metadata" => [
                "customer_id" => $customer->id,
                "consumer_name" => $consumerName,
                "user_id" => $user_id,

            ],
        ]);

        return redirect($payment->getCheckoutUrl(), 303);

    }

    public function publish()
    {
        $user = Auth::guard('user')->user();
        $user->status = 1;
        $user->active = 1;
        $user->update();
        return redirect(route('user-dashboard'))->with('success', 'Successfully Published The Profile.');
    }

    public function feature()
    {
        $user = Auth::guard('user')->user();
        $user->is_featured = 1;
        $user->featured = 1;
        $user->update();
        return redirect(route('user-dashboard'))->with('success', 'Successfully Featured The Profile.');
    }

    public function Ratings()
    {

        $user = Auth::guard('user')->user();
        $user_id = $user->id;

        if ($user->role_id == 3) {
            return redirect()->route('user-login');
        }


        if($user->can('ratings'))
        {
            $ratings = invoices::leftjoin('users', 'users.id', '=', 'invoices.user_id')->where('invoices.handyman_id', '=', $user_id)->where('invoices.pay_req', 1)->Select('invoices.id', 'invoices.user_id', 'invoices.handyman_id', 'invoices.invoice_number', 'invoices.total', 'users.name', 'users.family_name', 'invoices.rating as client_rating', 'users.email', 'users.photo', 'users.family_name', 'invoices.is_booked', 'invoices.is_completed', 'invoices.pay_req', 'invoices.is_paid', 'invoices.is_partial', 'invoices.is_cancelled', 'invoices.cancel_req', 'invoices.reply', 'invoices.status', 'invoices.created_at as inv_date', 'invoices.booking_date')->get();


            return view('user.ratings', compact('ratings'));
        }
        else
        {
            return redirect()->route('user-login');
        }
    }

    public function MarkDelivered($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($user->can('mark-delivered'))
        {
            $now = date('d-m-Y H:i:s');
            $check = quotation_invoices::where('id',$id)->where('handyman_id', $user_id)->where('invoice',1)->update(['delivered' => 1,'delivered_date' => $now]);

            iF($check)
            {
                $client = quotation_invoices::leftjoin('quotes','quotes.id','=','quotation_invoices.quote_id')->leftjoin('users','users.id','=','quotes.user_id')->where('quotation_invoices.id',$id)->select('users.*','quotation_invoices.quotation_invoice_number')->first();

                $admin_email = $this->sl->admin_email;

                $link = url('/') . '/aanbieder/quotation-requests';

                if($this->lang->lang == 'du')
                {
                    $msg = "Beste $client->name,<br><br>De status van je bestelling met factuur INV# <b>" . $client->quotation_invoice_number . "</b> is zojuist gewijzigd naar afgeleverd. Je kan de status naar ontvangen wijzigen in je <a href='$link'>dashboard</a>. Doe dit alleen als je de goederen hebt ontvangen. Mocht, je de goederen op de bezorgdatum niet hebben ontvangen neem dan contact met ons op.<br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte";
                }
                else
                {
                    $msg = "Dear <b>Mr/Mrs " . $client->name . "</b>,<br><br>Goods for quotation INV# <b>" . $client->quotation_invoice_number . "</b> have been marked as delivered. You can change this quotation status to 'Received' if goods have been delivered to you. After 7 days from now on it will automatically be marked as 'Received'.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
                }

                \Mail::send(array(), array(), function ($message) use ($msg,$client) {
                    $message->to($client->email)
                        ->from('info@vloerofferte.nl')
                        ->subject(__('text.Invoice Status Changed'))
                        ->setBody($msg, 'text/html');
                });

                \Mail::send(array(), array(), function ($message) use ($admin_email, $client) {
                    $message->to($admin_email)
                        ->from('info@vloerofferte.nl')
                        ->subject('Invoice Status Changed')
                        ->setBody("Recent activity: Goods for quotation INV# <b>" . $client->quotation_invoice_number . "</b> have been marked as delivered.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
                });

                Session::flash('success', __('text.Status Updated Successfully!'));
            }

            return redirect()->back();
        }
        else
        {
            return redirect()->route('user-login');
        }
    }


    public function MarkReceived($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;

        $now = date('d-m-Y H:i:s');
        $check = quotation_invoices::leftjoin('quotes','quotes.id','=','quotation_invoices.quote_id')->where('quotation_invoices.id',$id)->where('quotes.user_id',$user_id)->where('quotation_invoices.invoice',1)->update(['quotation_invoices.received' => 1,'quotation_invoices.received_date' => $now]);

        iF($check)
        {
            $handyman = quotation_invoices::leftjoin('users','users.id','=','quotation_invoices.handyman_id')->where('quotation_invoices.id',$id)->select('users.*','quotation_invoices.quotation_invoice_number')->first();

            $admin_email = $this->sl->admin_email;

            if($this->lang->lang == 'du')
            {
                $msg = "Beste $handyman->name,<br><br>Je klant heeft de status voor factuur INV# <b>" . $handyman->quotation_invoice_number . "</b> gewijzigd naar goederen ontvangen.<br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte";
            }
            else
            {
                $msg = "Dear <b>Mr/Mrs " . $handyman->name . "</b>,<br><br>Goods for quotation INV# <b>" . $handyman->quotation_invoice_number . "</b> have been marked as received.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
            }

            \Mail::send(array(), array(), function ($message) use ($msg,$handyman) {
                $message->to($handyman->email)
                    ->from('info@vloerofferte.nl')
                    ->subject(__('text.Invoice Status Changed'))
                    ->setBody($msg, 'text/html');
            });

            \Mail::send(array(), array(), function ($message) use ($admin_email, $handyman) {
                $message->to($admin_email)
                    ->from('info@vloerofferte.nl')
                    ->subject('Invoice Status Changed')
                    ->setBody("Recent activity: Goods for quotation INV# <b>" . $handyman->quotation_invoice_number . "</b> have been marked as received.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
            });

            Session::flash('success', __('text.Status Updated Successfully!'));
        }

        return redirect()->back();
    }


    public function CustomMarkDelivered($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;

        if($user->can('custom-mark-delivered'))
        {
            $now = date('d-m-Y H:i:s');
            $check = custom_quotations::where('id',$id)->where('handyman_id',$user_id)->where('invoice',1)->update(['delivered' => 1,'delivered_date' => $now]);

            iF($check)
            {
                $client = custom_quotations::leftjoin('users','users.id','=','custom_quotations.user_id')->where('custom_quotations.id',$id)->select('users.*','custom_quotations.quotation_invoice_number')->first();

                $admin_email = $this->sl->admin_email;

                $link = url('/') . '/aanbieder/quotation-requests';

                if($this->lang->lang == 'du')
                {
                    $msg = "Beste $client->name,<br><br>De status van je bestelling met factuur INV# <b>" . $client->quotation_invoice_number . "</b> is zojuist gewijzigd naar afgeleverd. Je kan de status naar ontvangen wijzigen in je <a href='$link'>dashboard</a>. Doe dit alleen als je de goederen hebt ontvangen. Mocht, je de goederen op de bezorgdatum niet hebben ontvangen neem dan contact met ons op.<br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte";
                }
                else
                {
                    $msg = "Dear <b>Mr/Mrs " . $client->name . "</b>,<br><br>Goods for quotation INV# <b>" . $client->quotation_invoice_number . "</b> have been marked as delivered. You can change this quotation status to 'Received' if goods have been delivered to you. After 7 days from now on it will automatically be marked as 'Received'.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
                }

                \Mail::send(array(), array(), function ($message) use ($msg,$client) {
                    $message->to($client->email)
                        ->from('info@vloerofferte.nl')
                        ->subject(__('text.Invoice Status Changed'))
                        ->setBody($msg, 'text/html');
                });

                \Mail::send(array(), array(), function ($message) use ($admin_email, $client) {
                    $message->to($admin_email)
                        ->from('info@vloerofferte.nl')
                        ->subject('Invoice Status Changed')
                        ->setBody("Recent activity: Goods for quotation INV# <b>" . $client->quotation_invoice_number . "</b> have been marked as delivered.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
                });

                Session::flash('success', __('text.Status Updated Successfully!'));
            }

            return redirect()->back();
        }
        else
        {
            return redirect()->route('user-login');
        }
    }


    public function CustomMarkReceived($id)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;

        $now = date('d-m-Y H:i:s');
        $check = custom_quotations::where('id',$id)->where('user_id',$user_id)->where('invoice',1)->update(['received' => 1,'received_date' => $now]);

        iF($check)
        {
            $handyman = custom_quotations::leftjoin('users','users.id','=','custom_quotations.handyman_id')->where('custom_quotations.id',$id)->select('users.*','custom_quotations.quotation_invoice_number')->first();

            $admin_email = $this->sl->admin_email;

            if($this->lang->lang == 'du')
            {
                $msg = "Beste $handyman->name,<br><br>Je klant heeft de status voor factuur INV# <b>" . $handyman->quotation_invoice_number . "</b> gewijzigd naar goederen ontvangen.<br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte";
            }
            else
            {
                $msg = "Dear <b>Mr/Mrs " . $handyman->name . "</b>,<br><br>Goods for quotation INV# <b>" . $handyman->quotation_invoice_number . "</b> have been marked as received.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
            }

            \Mail::send(array(), array(), function ($message) use ($msg,$handyman) {
                $message->to($handyman->email)
                    ->from('info@vloerofferte.nl')
                    ->subject(__('text.Invoice Status Changed'))
                    ->setBody($msg, 'text/html');
            });

            \Mail::send(array(), array(), function ($message) use ($admin_email, $handyman) {
                $message->to($admin_email)
                    ->from('info@vloerofferte.nl')
                    ->subject('Invoice Status Changed')
                    ->setBody("Recent activity: Goods for quotation INV# <b>" . $handyman->quotation_invoice_number . "</b> have been marked as received.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
            });

            Session::flash('success', __('text.Status Updated Successfully!'));
        }

        return redirect()->back();
    }

}
