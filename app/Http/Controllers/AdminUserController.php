<?php

namespace App\Http\Controllers;

use App\Brand;
use App\carts;
use App\Category;
use App\sub_categories;
use App\Generalsetting;
use App\handyman_quotes;
use App\handyman_terminals;
use App\handyman_unavailability;
use App\items;
use App\Model1;
use App\predefined_answers;
use App\predefined_services_answers;
use App\product;
use App\Products;
use App\question_services;
use App\question_services1;
use App\quotation_invoices;
use App\quotation_questions;
use App\quotation_services_questions;
use App\quotes;
use App\requests_q_a;
use App\Service;
use App\sub_services;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use Auth;
use App\bookings;
use App\handyman_products;
use App\users;
use App\service_types;
use App\invoices;
use App\handyman_temporary;
use File;
use PDF;
use Illuminate\Database\Eloquent\SoftDeletes;


class AdminUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function QuotationQuestions()
    {
        $data = quotation_questions::with('answers')->with(['services' => function($query){
        $query->leftjoin('categories','categories.id','=','question_services.service_id');
        }])->get();

        return view('admin.user.questions',compact('data'));
    }

    public function CreateQuestion()
    {
        $services = sub_categories::get();

        return view('admin.user.create_question',compact('services'));
    }

    public function EditQuestion($id)
    {
        $services = sub_categories::get();

        $data = quotation_questions::where('id',$id)->with('answers')->with('services')->first();

        return view('admin.user.create_question',compact('services','data'));
    }

    public function SubmitQuestion(Request $request)
    {

        $predefined = $request->predefined;

        if($predefined == 'on')
        {
            $predefined = 1;
        }
        else
        {
            $predefined = 0;
        }

        if(!$request->question_id)
        {
            $question = new quotation_questions;
            $question->title = $request->title;
            $question->predefined = $predefined;
            $question->order_no = $request->order_no;
            $question->placeholder = $request->placeholder;
            $question->save();

            foreach ($request->services as $i => $temp)
            {
                $post = new question_services;
                $post->question_id = $question->id;
                $post->service_id = $temp;
                $post->save();
            }

            if($predefined)
            {
                foreach ($request->predefined_answer as $key)
                {
                    $answer = new predefined_answers;
                    $answer->question_id = $question->id;
                    $answer->title = $key;
                    $answer->save();
                }
            }

            Session::flash('success', 'Flexible Question Created Successfully!');
        }
        else
        {
            $question = quotation_questions::where('id',$request->question_id)->update(['title' => $request->title, 'placeholder' => $request->placeholder, 'predefined' => $predefined, 'order_no' => $request->order_no]);

            question_services::where('question_id',$request->question_id)->delete();

                foreach ($request->services as $service)
                {
                    $services = new question_services;
                    $services->question_id = $request->question_id;
                    $services->service_id = $service;
                    $services->save();
                }

            predefined_answers::where('question_id',$request->question_id)->delete();

            if($predefined)
            {

                foreach ($request->predefined_answer as $key)
                {
                    $answer = new predefined_answers;
                    $answer->question_id = $request->question_id;
                    $answer->title = $key;
                    $answer->save();
                }
            }

            Session::flash('success', 'Flexible Question Updated Successfully!');
        }

        return redirect()->back();

    }

    public function DeleteQuestion($id)
    {

        $question = quotation_questions::where('id',$id)->delete();
        $sub = predefined_answers::where('question_id',$id)->delete();
        $services = question_services::where('question_id',$id)->delete();

        Session::flash('success', 'Question deleted successfully.');
        return redirect()->back();
    }

    public function ServicesQuotationQuestions()
    {

        $data = quotation_services_questions::with('answers')->with(['services' => function($query){
            $query->leftjoin('services','services.id','=','question_services1.service_id');
        }])->get();


        return view('admin.user.services_questions',compact('data'));
    }

    public function CreateServicesQuestion()
    {
        $services = Service::get();

        return view('admin.user.create_services_questions',compact('services'));
    }

    public function EditServicesQuestion($id)
    {
        $services = Service::get();

        $data = quotation_services_questions::where('id',$id)->with('answers')->with('services')->first();

        return view('admin.user.create_services_questions',compact('services','data'));
    }

    public function SubmitServicesQuestion(Request $request)
    {

        $predefined = $request->predefined;

        if($predefined == 'on')
        {
            $predefined = 1;
        }
        else
        {
            $predefined = 0;
        }

        if(!$request->question_id)
        {
            $question = new quotation_services_questions();
            $question->title = $request->title;
            $question->predefined = $predefined;
            $question->order_no = $request->order_no;
            $question->placeholder = $request->placeholder;
            $question->save();

            foreach ($request->services as $i => $temp)
            {
                $post = new question_services1;
                $post->question_id = $question->id;
                $post->service_id = $temp;
                $post->save();
            }

            if($predefined)
            {
                foreach ($request->predefined_answer as $key)
                {
                    $answer = new predefined_services_answers();
                    $answer->question_id = $question->id;
                    $answer->title = $key;
                    $answer->save();
                }
            }

            Session::flash('success', 'Flexible Question Created Successfully!');
        }
        else
        {
            $question = quotation_services_questions::where('id',$request->question_id)->update(['title' => $request->title, 'placeholder' => $request->placeholder, 'predefined' => $predefined, 'order_no' => $request->order_no]);

            question_services1::where('question_id',$request->question_id)->delete();

            foreach ($request->services as $service)
            {
                $services = new question_services1;
                $services->question_id = $request->question_id;
                $services->service_id = $service;
                $services->save();
            }

            predefined_services_answers::where('question_id',$request->question_id)->delete();

            if($predefined)
            {

                foreach ($request->predefined_answer as $key)
                {
                    $answer = new predefined_services_answers;
                    $answer->question_id = $request->question_id;
                    $answer->title = $key;
                    $answer->save();
                }
            }

            Session::flash('success', 'Flexible Question Updated Successfully!');
        }

        return redirect()->back();

    }

    public function DeleteServicesQuestion($id)
    {

        $question = quotation_services_questions::where('id',$id)->delete();
        $sub = predefined_services_answers::where('question_id',$id)->delete();
        $services = question_services1::where('question_id',$id)->delete();

        Session::flash('success', 'Question deleted successfully.');
        return redirect()->back();
    }

    public function index()
    {
        $users = User::where('role_id','=',2)->orderBy('created_at','desc')->get();

        return view('admin.user.index',compact('users'));
    }

    public function Suppliers()
    {
        $users = User::where('role_id','=',4)->orderBy('created_at','desc')->get();
        $products = array();

        foreach ($users as $key) {

            $products[] = Products::leftjoin('users','users.id','=','products.user_id')->where('products.user_id',$key->id)->select('products.title')->get();

        }

        return view('admin.user.index',compact('users','products'));
    }


    public function QuotationRequests()
    {
        $requests = quotes::leftjoin('categories','categories.id','=','quotes.quote_service')->leftjoin('services','services.id','=','quotes.quote_service1')->leftjoin('quotation_invoices','quotation_invoices.quote_id','=','quotes.id')->select('quotes.*','quotation_invoices.delivered','quotation_invoices.received','categories.cat_name','services.title')->orderBy('quotes.created_at','desc')->withCount('quotations')->get();


        return view('admin.user.quote_requests',compact('requests'));
    }

    public function HandymanQuotations($id = '')
    {
        if($id)
        {
            $invoices = quotation_invoices::leftjoin('quotes','quotes.id','=','quotation_invoices.quote_id')->leftjoin('users','users.id','=','quotation_invoices.handyman_id')->where('quotation_invoices.quote_id',$id)->where('quotes.status','<',3)->orderBy('quotation_invoices.id','desc')->select('quotes.*','quotation_invoices.review_text','quotation_invoices.id as invoice_id','quotation_invoices.invoice','quotation_invoices.approved','quotation_invoices.accepted','quotation_invoices.ask_customization','quotation_invoices.quotation_invoice_number','quotation_invoices.tax','quotation_invoices.subtotal','quotation_invoices.grand_total','quotation_invoices.created_at as invoice_date','users.name','users.family_name','users.company_name')->get();
        }
        else
        {
            $invoices = quotation_invoices::leftjoin('quotes','quotes.id','=','quotation_invoices.quote_id')->leftjoin('users','users.id','=','quotation_invoices.handyman_id')->where('quotes.status','<',3)->orderBy('quotation_invoices.id','desc')->select('quotes.*','quotation_invoices.review_text','quotation_invoices.id as invoice_id','quotation_invoices.invoice','quotation_invoices.approved','quotation_invoices.accepted','quotation_invoices.ask_customization','quotation_invoices.quotation_invoice_number','quotation_invoices.tax','quotation_invoices.subtotal','quotation_invoices.grand_total','quotation_invoices.created_at as invoice_date','users.name','users.family_name','users.company_name')->get();
        }

        return view('admin.user.quote_invoices',compact('invoices'));
    }

    public function HandymanQuotationsInvoices($id = '')
    {
        if($id)
        {
            $invoices = quotation_invoices::leftjoin('quotes','quotes.id','=','quotation_invoices.quote_id')->leftjoin('users','users.id','=','quotation_invoices.handyman_id')->where('quotes.status','=',3)->where('quotation_invoices.quote_id',$id)->where('quotes.status','<',3)->where('quotation_invoices.invoice',1)->orderBy('quotation_invoices.created_at','desc')->select('quotes.*','quotation_invoices.commission_percentage', 'quotation_invoices.commission', 'quotation_invoices.total_receive','quotation_invoices.id as invoice_id','quotation_invoices.approved','quotation_invoices.accepted','quotation_invoices.delivered','quotation_invoices.received','quotation_invoices.ask_customization','quotation_invoices.quotation_invoice_number','quotation_invoices.tax','quotation_invoices.subtotal','quotation_invoices.grand_total','quotation_invoices.created_at as invoice_date','users.name','users.family_name','users.company_name')->get();
        }
        else
        {
            $invoices = quotation_invoices::leftjoin('quotes','quotes.id','=','quotation_invoices.quote_id')->leftjoin('users','users.id','=','quotation_invoices.handyman_id')->where('quotes.status','=',3)->where('quotation_invoices.invoice',1)->orderBy('quotation_invoices.created_at','desc')->select('quotes.*','quotation_invoices.commission_percentage', 'quotation_invoices.commission', 'quotation_invoices.total_receive','quotation_invoices.id as invoice_id','quotation_invoices.approved','quotation_invoices.accepted','quotation_invoices.delivered','quotation_invoices.received','quotation_invoices.ask_customization','quotation_invoices.quotation_invoice_number','quotation_invoices.tax','quotation_invoices.subtotal','quotation_invoices.grand_total','quotation_invoices.created_at as invoice_date','users.name','users.family_name','users.company_name')->get();
        }

        return view('admin.user.quote_invoices',compact('invoices'));
    }

    public function QuoteRequest($id)
    {
        $request = quotes::where('id',$id)->withCount('quotations')->first();

        $q_a = requests_q_a::where('request_id',$id)->get();

        $categories = Category::get();
        $services = Service::all();
        $brands = Brand::all();
        $models = Model1::all();

        return view('admin.user.quote_request',compact('request','categories','brands','models','q_a','services'));
    }

    public function DownloadQuoteRequest($id)
    {
        $quote = quotes::leftjoin('categories','categories.id','=','quotes.quote_service')->leftjoin('brands','brands.id','=','quotes.quote_brand')->leftjoin('models','models.id','=','quotes.quote_model')->leftjoin('services','services.id','=','quotes.quote_service1')->where('quotes.id',$id)->select('quotes.*','categories.cat_name','brands.cat_name as brand_name','models.cat_name as model_name','services.title')->first();

        $q_a = requests_q_a::where('request_id',$id)->get();

        $quote_number = $quote->quote_number;

        $filename = $quote_number.'.pdf';

        $file = public_path().'/assets/adminQuotesPDF/'.$filename;

        if (!file_exists($file)){

            $role = 1;

            ini_set('max_execution_time', 180);

            $pdf = PDF::loadView('admin.user.pdf_quote',compact('quote','q_a','role'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140]);

            $pdf->save(public_path().'/assets/adminQuotesPDF/'.$filename);
        }

        return response()->download(public_path("assets/adminQuotesPDF/{$filename}"));
    }

    public function ViewQuotation($id)
    {
        $settings = Generalsetting::findOrFail(1);

        $vat_percentage = $settings->vat;

        $quotation = quotation_invoices::leftjoin('quotation_invoices_data','quotation_invoices_data.quotation_id','=','quotation_invoices.id')->leftjoin('quotes','quotes.id','=','quotation_invoices.quote_id')->where('quotation_invoices.id',$id)->select('quotation_invoices.*','quotes.id as quote_id','quotes.quote_number','quotes.created_at as quote_date','quotation_invoices_data.id as data_id','quotation_invoices_data.product_title','quotation_invoices_data.s_i_id','quotation_invoices_data.b_i_id','quotation_invoices_data.m_i_id','quotation_invoices_data.item','quotation_invoices_data.rate','quotation_invoices_data.qty','quotation_invoices_data.description as data_description','quotation_invoices_data.estimated_date','quotation_invoices_data.amount')->get();

        if(count($quotation) != 0)
        {
            return view('admin.user.quotation',compact('quotation','vat_percentage'));
        }
        else
        {
            return redirect('logstof/dashboard');
        }
    }

    public function DownloadQuoteInvoice($id)
    {
        $invoice = quotation_invoices::where('id',$id)->first();

        $quotation_invoice_number = $invoice->quotation_invoice_number;

        $filename = $quotation_invoice_number.'.pdf';

        return response()->download(public_path("assets/quotationsPDF/{$filename}"));
    }

    public function DownloadCommissionInvoice($id)
    {
        $invoice = quotation_invoices::where('id',$id)->first();

        $commission_invoice_number = $invoice->commission_invoice_number;

        $filename = $commission_invoice_number.'.pdf';

        return response()->download(public_path("assets/quotationsPDF/CommissionInvoices/{$filename}"));
    }

    public function SendQuoteRequest($id)
    {

        $request = quotes::leftjoin('categories','categories.id','=','quotes.quote_service')->leftjoin('brands','brands.id','=','quotes.quote_brand')->leftjoin('models','models.id','=','quotes.quote_model')->leftjoin('services','services.id','=','quotes.quote_service1')->where('quotes.id',$id)->select('quotes.*','categories.cat_name','services.title','brands.cat_name as brand_name','models.cat_name as model_name')->first();

        $search = $request->quote_zipcode;

        $url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBNRJukOohRJ1tW0tMG4tzpDXFz68OnonM&address=".urlencode($search).",+Netherlands&sensor=false";

        $result_string = file_get_contents($url);
        $result = json_decode($result_string, true);

        $history = handyman_quotes::leftjoin('users','users.id','=','handyman_quotes.handyman_id')->where('handyman_quotes.quote_id',$id)->select('users.*','handyman_quotes.created_at as quote_date')->get();

        if(($result['status']) != 'ZERO_RESULTS')
        {
            $user_latitude = $result['results'][0]['geometry']['location']['lat'];
            $user_longitude = $result['results'][0]['geometry']['location']['lng'];

            if($request->quote_service == 0 && $request->quote_brand == 0 && $request->quote_model == 0)
            {
                $handymen = Service::leftjoin('handyman_services','handyman_services.service_id','=','services.id')->leftjoin('users','users.id','=','handyman_services.handyman_id')->leftjoin('handyman_terminals','handyman_terminals.handyman_id','=','users.id')->where('users.active',1)->where('services.id','=', $request->quote_service1)->select('users.*','handyman_terminals.zipcode','handyman_terminals.longitude','handyman_terminals.latitude','handyman_terminals.radius')->get();
            }
            else
            {
                $handymen = Products::leftjoin('handyman_products','handyman_products.product_id','=','products.id')->leftjoin('users','users.id','=','handyman_products.handyman_id')->leftjoin('handyman_terminals','handyman_terminals.handyman_id','=','users.id')->where('users.active',1)->where('products.category_id','=', $request->quote_service)->where('products.brand_id','=', $request->quote_brand)->where('products.model_id','=', $request->quote_model)->select('users.*','handyman_terminals.zipcode','handyman_terminals.longitude','handyman_terminals.latitude','handyman_terminals.radius')->get();
            }

            foreach ($handymen as $key) {

                $lat = $key->latitude;
                $lng = $key->longitude;
                $radius = $key->radius;

                $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat.",".$lng."&destinations=".$user_latitude.",".$user_longitude."&mode=driving&key=AIzaSyBNRJukOohRJ1tW0tMG4tzpDXFz68OnonM";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $response = curl_exec($ch);
                curl_close($ch);
                $response_a = json_decode($response, true);

                if(($response_a['rows'][0]['elements'][0]['status']) != 'ZERO_RESULTS')
                {
                    $dist = $response_a['rows'][0]['elements'][0]['distance']['value'];
                    /*$time = $response_a['rows'][0]['elements'][0]['duration']['text'];*/

                    $distance = $dist/1000;

                    $key->distance = $distance;

                    if($distance <= $radius)
                    {
                        $key->preferred = 1;
                    }
                    else
                    {
                        $key->preferred = 0;
                    }
                }
                else
                {
                    $key->distance = 'N/A';
                    $key->preferred = 0;
                }

            }

            $handymen = $handymen->sortBy('distance');

        }

        else
        {
            Session::flash('unsuccess', 'Invalid Postal code given in quote request!');
            return redirect()->back();
        }

        return view('admin.user.send_quote',compact('request','handymen','history'));
    }


    public function ApproveHandymanQuotations(Request $request)
    {
        $handyman = $request->action;

        foreach ($handyman as $key)
        {
            $quotation = quotation_invoices::where('id',$key)->first();
            $quotation->approved = 1;
            $quotation->save();

            $user = quotes::leftjoin('quotation_invoices','quotation_invoices.quote_id','=','quotes.id')->leftjoin('users','users.id','=','quotes.user_id')->where('quotation_invoices.id',$key)->select('users.*','quotes.quote_number','quotes.created_at')->first();

            $client_name = $user->name;
            $client_email = $user->email;

            $requested_quote_number = $user->quote_number;

            $quotation_invoice_number = $quotation->quotation_invoice_number;

            $filename = $quotation_invoice_number.'.pdf';

            $file = public_path().'/assets/quotationsPDF/'.$filename;

            $user = User::where('id',$quotation->handyman_id)->first();
            $user_name = $user->name;
            $email = $user->email;

            $link = url('/').'/handyman/dashboard';

            \Mail::send('admin.user.quotation_approved_mail',
                array(
                    'username' => $user_name,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'requested_quote_number' => $requested_quote_number,
                    'link' => $link,
                ), function ($message) use($email){
                    $message->from('info@vloerofferte.nl');
                    $message->to($email)->subject("Offerte is bij de klant");

                });

            $client_link = url('/').'/aanbieder/quotation-requests';

            \Mail::send('admin.user.quotation_client_mail',
                array(
                    'handyman' => $user_name,
                    'client' => $client_name,
                    'quotation_invoice_number' => $quotation_invoice_number,
                    'requested_quote_number' => $requested_quote_number,
                    'client_link' => $client_link,
                ), function ($message) use($file,$client_email,$filename) {
                    $message->from('info@vloerofferte.nl');
                    $message->to($client_email)->subject("Je hebt een nieuwe offerte!");

                    $message->attach($file, [
                        'as' => $filename,
                        'mime' => 'application/pdf',
                    ]);

                });

        }

        Session::flash('success', 'Quotation approved successfully!');
        return redirect()->back();


    }

    public function SendQuoteRequestHandymen(Request $request)
    {
        $handyman = $request->action;

        $quote = quotes::leftjoin('categories','categories.id','=','quotes.quote_service')->leftjoin('brands','brands.id','=','quotes.quote_brand')->leftjoin('models','models.id','=','quotes.quote_model')->leftjoin('services','services.id','=','quotes.quote_service1')->where('quotes.id',$request->quote_id)->select('quotes.*','categories.cat_name','services.title','brands.cat_name as brand_name','models.cat_name as model_name')->first();

        $q_a = requests_q_a::where('request_id',$request->quote_id)->get();

        $quote_number = $quote->quote_number;

        $filename = $quote_number.'.pdf';

        $file = public_path().'/assets/quotesPDF/'.$filename;

        if (!file_exists($file)){

            $role = 2;

            ini_set('max_execution_time', 180);

            $pdf = PDF::loadView('admin.user.pdf_quote',compact('quote','q_a','role'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140]);

            $pdf->save(public_path().'/assets/quotesPDF/'.$filename);
        }


        foreach ($handyman as $key)
        {
            $user = User::where('id',$key)->first();
            $email = $user->email;

            $user_name = $user->name;

            $save = handyman_quotes::where('handyman_id',$key)->where('quote_id',$request->quote_id)->first();

            if(!$save)
            {
                $save = new handyman_quotes;
                $save->handyman_id = $key;
                $save->quote_id = $request->quote_id;
                $save->save();
            }
            else
            {
                handyman_quotes::where('handyman_id',$key)->where('quote_id',$request->quote_id)->update(['updated_at' => date('Y-m-d H:i:s', time())]);
            }

            $link = url('/').'/handyman/dashboard';

            \Mail::send('admin.user.quote_request_mail',
                array(
                    'username' => $user_name,
                    'link' => $link,
                ), function ($message) use($file,$email,$filename){
                $message->from('info@vloerofferte.nl');
                $message->to($email)->subject("Offerte aanvraag!");

                        $message->attach($file, [
                            'as' => $filename,
                            'mime' => 'application/pdf',
                        ]);

            });

        }

        Session::flash('success', 'Quotation request sent successfully!');
        return redirect()->back();
    }

    public function Clients()
    {
        $users = User::where('role_id','=',3)->orderBy('created_at','desc')->get();

        return view('admin.user.clients',compact('users'));
    }

    public function UserBookings()
    {
        $users_bookings = invoices::leftjoin('users','users.id','=','invoices.user_id')->Select('users.name','users.family_name','users.email','invoices.booking_date','invoices.total','invoices.status','invoices.id','invoices.handyman_id','invoices.is_booked','invoices.is_completed','invoices.pay_req','invoices.is_partial','invoices.is_cancelled','invoices.cancel_req','invoices.reason','invoices.reply','invoices.is_paid','invoices.created_at as inv_date','invoices.invoice_number','invoices.user_id')->orderBy('id', 'desc')->get();

        $handymans_booked = invoices::leftjoin('users','users.id','=','invoices.handyman_id')->orderBy('invoices.id', 'desc')->get();

        $data[] = array('users'=>$users_bookings,'handymans'=>$handymans_booked);

        return view('admin.user.bookings',compact('data'));
    }

    public function UserRequests()
    {
        $users_requests = handyman_temporary::leftjoin('users','users.id','=','handyman_temporary.handyman_id')->Select('users.name','users.family_name','users.email','handyman_temporary.created_at as Date','handyman_temporary.updated_at as UpdateDate','users.photo','handyman_temporary.handyman_id')->orderBy('handyman_temporary.id', 'desc')->get();

        return view('admin.user.requets',compact('users_requests'));
    }

    public function UserRequest($id)
    {
        $user = handyman_temporary::where('handyman_id','=',$id)->first();
        return view('admin.user.request',compact('user'));
    }

     public function RequestProfileUpdate(Request $request)
    {
        $input = $request->all();

        $user_id = $input['handyman_id'];

        $user = User::where('id',$user_id)->first();

        $input['photo'] = $user->photo;
        $input['compressed_photo'] = $user->compressed_photo;

        User::where('id',$user_id)->update(['name' => $input['name'], 'family_name' => $input['family_name'], 'photo' => $input['photo'], 'compressed_photo' => $input['compressed_photo'], 'description' => $input['description'], 'language' => $input['language'], 'education' => $input['education'], 'profession' => $input['profession'], 'city' => $input['city'], 'address' => $input['address'], 'phone' => $input['phone'],  'web' => $input['web'], 'special' => $input['special'], 'registration_number' => $input['registration_number'], 'company_name' => $input['company_name'], 'tax_number' => $input['tax_number'], 'bank_account' => $input['bank_account'], 'postcode' => $input['postcode'] ]);

        if($input['latitude'] && $input['longitude'])
        {
            handyman_terminals::where('handyman_id',$user_id)->update(['latitude' => $input['latitude'], 'longitude' => $input['longitude'], 'zipcode' => $input['postcode'], 'city' => $input['city']]);
        }

        handyman_temporary::where('handyman_id',$user_id)->delete();

        $user = User::findOrFail($user_id);

        $email = $user->email;

        $user_name = $user->name;

        $handyman_dash = url('/').'/handyman/dashboard';


        /*$headers =  'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Profile Information Updated Successfully!";
        $msg = "Dear Mr/Mrs ". $user_name .",<br><br>Your profile information update request has been approved. For further details visit your handyman panel through <a href='".$handyman_dash."'>here.</a><br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
        mail($email,$subject,$msg,$headers);*/


        $headers =  'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Profiel informatie is geupdate";
        $msg = "Beste ". $user_name .",<br><br>Je wijziging in je profiel is goedgekeurd.<br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte";
        mail($email,$subject,$msg,$headers);

        Session::flash('success', 'Profile Updated Successfully');

        return redirect()->route('admin-user-requests');
    }

  public function status($id1,$id2)
    {

        $user = User::findOrFail($id1);
        $user->active = $id2;
        $user->featured = $id2;
        $user->update();
        Session::flash('success', 'Status updated Successfully');

        return redirect()->route('admin-user-index');
    }

    public function create()
    {
        $cats = Category::all();
        return view('admin.user.create');
    }

    public function createSupplier()
    {
        return view('admin.user.create');
    }

    public function store(StoreValidationRequest $request)
    {

        $user = new User;
        $input = $request->all();
            if ($file = $request->file('photo'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
            $input['photo'] = $name;
            }

            if($request->featured == "")
            {
                $input['featured'] = 0;
            }

            if(in_array(null, $request->title) || in_array(null, $request->details))
            {
                $input['title'] = null;
                $input['details'] = null;
            }
            else
            {
                $input['title'] = implode(',', $request->title);
                $input['details'] = implode(',', $request->details);
            }
        if (!empty($request->special))
         {
            $input['special'] = implode(',', $request->special);
         }

        $input['category_id'] = 20;
        $input['password'] = bcrypt($request['password']);
        $user->fill($input)->save();

        if($input['role_id'] == 2)
        {
            Session::flash('success', 'New Retailer added successfully.');
            return redirect()->route('admin-user-index');
        }
        else
        {
            Session::flash('success', 'New Supplier added successfully.');
            return redirect()->route('admin-supplier-index');
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        if($user->title!=null && $user->details!=null)
        {
            $title = explode(',', $user->title);
            $details = explode(',', $user->details);
        }
        else
        {
            $title = '';
            $details = '';
        }

        if($user->special != null)
        {
            $specials = explode(',', $user->special);
        }
        else
        {
            $specials = '';
        }

        return view('admin.user.edit',compact('user','title','details','specials'));
    }

    public function editSupplier($id)
    {
        $user = User::findOrFail($id);

        if($user->title!=null && $user->details!=null)
        {
            $title = explode(',', $user->title);
            $details = explode(',', $user->details);
        }
        else
        {
            $title = '';
            $details = '';
        }

        if($user->special != null)
        {
            $specials = explode(',', $user->special);
        }
        else
        {
            $specials = '';
        }

        return view('admin.user.edit',compact('user','title','details','specials'));
    }

    public function update(UpdateValidationRequest $request,$id)
    {
        $input = $request->all();
        $user = User::findOrFail($id);
        if(!in_array(null, $request->title) && !in_array(null, $request->details))
        {
            $input['title'] = implode(',', $request->title);
            $input['details'] = implode(',', $request->details);
        }
        else
        {
            if(in_array(null, $request->title) || in_array(null, $request->details))
            {
                $input['title'] = null;
                $input['details'] = null;
            }
            else
            {
                $title = explode(',', $user->title);
                $details = explode(',', $user->details);
                $input['title'] = implode(',', $title);
                $input['details'] = implode(',', $details);
            }
        }
            if ($file = $request->file('photo'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
                if($user->photo != null)
                {
                    unlink(public_path().'/assets/images/'.$user->photo);
                }
            $input['photo'] = $name;
            }
        if (!empty($request->special))
         {
            $input['special'] = implode(',', $request->special);
         }
        if (empty($request->special))
         {
            $input['special'] = null;
         }
        if(!empty($input['password'])){
        $input['password'] = bcrypt($request['password']);

        }
        else{
         $input['password'] = $user->password;
        }
        if($request->featured == "")
        {
            $input['featured'] = 0;
        }
        $ck = strpos($request->address,'&');

            if($ck !== false)
            {
                $input['address'] = str_replace("&","and",$request->address);
            }

        $user->update($input);

        if($input['role_id'] == 2)
        {
            Session::flash('success', 'Successfully updated the Retailer');
            return redirect()->route('admin-user-index');
        }
        else
        {
            Session::flash('success', 'Successfully updated the Supplier');
            return redirect()->route('admin-supplier-index');
        }
    }

     public function InsuranceUpdate(Request $request)
    {

        $post = User::where('id','=',$request->handyman_id)->update(['insurance' => 1]);

        $user = User::findOrFail($request->handyman_id);
        $email = $user->email;
        $user_name = $user->name;
        $handyman_dash = url('/').'/handyman/dashboard';


        /*$headers =  'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Insurance POD Approved!";
        $msg = "Dear Mr/Mrs ". $user_name .",<br><br>Your insurance pod has been approved. For further details visit your handyman panel through <a href='".$handyman_dash."'>here.</a><br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
        mail($email,$subject,$msg,$headers);*/



        $headers =  'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Verzekering!";
        $msg = "Beste ". $user_name .",<br><br>Je verzekering status is goedgekeurd. Klik op account om de status van je wijziging te bekijken <a href='".$handyman_dash."'>account.</a><br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte";
        mail($email,$subject,$msg,$headers);

        Session::flash('success', 'Successfully updated the User');
        return redirect()->route('admin-user-index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if($user->photo == null){
         $user->delete();
        Session::flash('success', 'Successfully deleted your User');
        return redirect()->back();
        }

        \File::delete(public_path() .'/assets/images/'.$user->photo);
        $user->delete();
        Session::flash('success', 'Successfully deleted your User');
        return redirect()->back();
    }

    public function Insurance($id)
    {
        $user = User::findOrFail($id);
        $cats = Category::all();

        return view('admin.user.insurance',compact('user','cats'));
    }

    public function Details($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.details',compact('user'));
    }

    public function DetailsSupplier($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.details',compact('user'));
    }

    public function ClientDetails($id)
    {
        $user = User::findOrFail($id);


        return view('admin.user.client_details',compact('user'));
    }

    public function MarkDelivered($id)
    {
        $now = date('d-m-Y H:i:s');
        quotation_invoices::where('id',$id)->where('invoice',1)->update(['delivered' => 1,'delivered_date' => $now]);

        $handyman = quotation_invoices::leftjoin('users','users.id','=','quotation_invoices.handyman_id')->where('quotation_invoices.id',$id)->select('users.*','quotation_invoices.quotation_invoice_number')->first();
        $client = quotation_invoices::leftjoin('quotes','quotes.id','=','quotation_invoices.quote_id')->leftjoin('users','users.id','=','quotes.user_id')->where('quotation_invoices.id',$id)->select('users.*','quotation_invoices.quotation_invoice_number')->first();

        \Mail::send(array(), array(), function ($message) use ($handyman) {
            $message->to($handyman->email)
                ->from('info@vloerofferte.nl')
                ->subject('Invoice Status Changed')
                ->setBody("Dear <b>Mr/Mrs " . $handyman->name . "</b>,<br><br>Goods for your quotation INV# <b>" . $handyman->quotation_invoice_number . "</b> have been marked as delivered.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
        });

        \Mail::send(array(), array(), function ($message) use ($client) {
            $message->to($client->email)
                ->from('info@vloerofferte.nl')
                ->subject('Invoice Status Changed')
                ->setBody("Dear <b>Mr/Mrs " . $client->name . "</b>,<br><br>Goods for quotation INV# <b>" . $client->quotation_invoice_number . "</b> have been marked as delivered. You can change this quotation status to 'Received' if goods have been delivered to you. After 7 days from now on it will automatically be marked as 'Received'.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
        });

        Session::flash('success', 'Status Updated Successfully!');
        return redirect()->back();
    }

    public function MarkReceived($id)
    {
        $now = date('d-m-Y H:i:s');
        quotation_invoices::where('id',$id)->update(['received' => 1,'received_date' => $now]);

        $handyman = quotation_invoices::leftjoin('users','users.id','=','quotation_invoices.handyman_id')->where('quotation_invoices.id',$id)->select('users.*','quotation_invoices.quotation_invoice_number')->first();
        $client = quotation_invoices::leftjoin('quotes','quotes.id','=','quotation_invoices.quote_id')->leftjoin('users','users.id','=','quotes.user_id')->where('quotation_invoices.id',$id)->select('users.*','quotation_invoices.quotation_invoice_number')->first();

        \Mail::send(array(), array(), function ($message) use ($handyman) {
            $message->to($handyman->email)
                ->from('info@vloerofferte.nl')
                ->subject('Invoice Status Changed')
                ->setBody("Dear <b>Mr/Mrs " . $handyman->name . "</b>,<br><br>Goods for your quotation INV# <b>" . $handyman->quotation_invoice_number . "</b> has been marked as received.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
        });

        \Mail::send(array(), array(), function ($message) use ($client) {
            $message->to($client->email)
                ->from('info@vloerofferte.nl')
                ->subject('Invoice Status Changed')
                ->setBody("Dear <b>Mr/Mrs " . $client->name . "</b>,<br><br>Goods for quotation INV# <b>" . $client->quotation_invoice_number . "</b> has been marked as received.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');
        });

        Session::flash('success', 'Status Updated Successfully!');
        return redirect()->back();
    }
}


