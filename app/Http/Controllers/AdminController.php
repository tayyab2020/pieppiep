<?php

namespace App\Http\Controllers;

use App\Admin;
use App\instruction_manual;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreValidationRequest;
use App\Http\Requests\UpdateValidationRequest;
use App\User;
use App\Category;
use App\Advertise;
use App\Counter;
use App\terminals;
use App\bookings;
use App\Generalsetting;
use App\invoices;
use Illuminate\Validation\Rule;
use PDF;
use App\how_it_works;
use App\reasons_to_book;
use App\cancelled_invoices;
use App\terms_conditions;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function Permissions()
    {
        $permissions = Permission::all();

        return view('admin.permissions',compact('permissions'));
    }

    public function PermissionsCreate()
    {
        return view('admin.permission_create');
    }

    public function PermissionsStore(Request $request)
    {

        if($request->id)
        {
            $this->validate($request, [
                'name' => [
                    Rule::unique('permissions')->where(function($query) use($request) {
                        $query->where('id', '!=', $request->id);
                    })
                ],
            ],
                [
                    'name.unique' => 'Name should be unique',
                ]);

            Permission::where('id',$request->id)->update(['name' => $request->name]);

            Session::flash('success', 'Successfully updated permission');
        }
        else
        {
            $this->validate($request, [
                'name' => 'unique:permissions',
            ],
                [
                    'name.unique' => 'Name should be unique',
                ]);

            Permission::create(['guard_name' => 'user', 'name' => $request->name]);

            Session::flash('success', 'Successfully created permission');
        }

        return redirect()->route('admin-permissions-index');
    }

    public function PermissionEdit($id)
    {
        $permission = Permission::where('id',$id)->first();

        return view('admin.permission_create',compact('permission'));
    }

    public function AssignPermissions()
    {
        $users = User::with('permissions')->whereIn('role_id',[2,4])->get();

        return view('admin.assign_permissions',compact('users'));
    }

    public function AssignPermissionEdit($id)
    {
        $permissions = Permission::all();
        $user = User::with('permissions')->find($id);

        return view('admin.assign_permission',compact('permissions','user'));
    }

    public function AssignPermissionsStore(Request $request)
    {
        $user = User::find($request->user_id);

        $user->syncPermissions($request->permissions);

        Session::flash('success', 'Permission(s) assigned successfully');
        return redirect()->route('admin-assign-permissions');
    }

    public function index()
    {
        $users = User::all();
        $cats = Category::all();
        $ads = Advertise::all();
        $referrals = Counter::where('type','referral')->orderBy('total_count','desc')->take(5)->get();
        $browsers = Counter::where('type','browser')->orderBy('total_count','desc')->take(5)->get();
        return view('admin.index',compact('users','cats','ads','referrals','browsers'));
    }

    public function HowItWorks()
    {
        $data = how_it_works::findOrFail(1);

        return view('admin.how_it_works',compact('data'));
    }

    public function InstructionManual()
    {
        $data = instruction_manual::first();

        return view('admin.instruction_manual',compact('data'));
    }

    public function InstructionManualPost(Request $request)
    {

        $this->validate($request, [
            'file' => 'mimes:pdf',
        ],
            [
                'file.mimes' => __('text.File type should be pdf'),
            ]);


        $data = instruction_manual::first();
        $file = $request->file('file');

        if($data)
        {
            $name = time().$file->getClientOriginalName();
            $file->move(public_path().'/assets/InstructionManual',$name);

            if($data->file != null)
            {
                \File::delete(public_path().'/assets/InstructionManual/'.$data->file);
            }

            instruction_manual::first()->update(['file' => $name]);
        }
        else
        {
            $name = time().$file->getClientOriginalName();
            $file->move(public_path().'/assets/InstructionManual',$name);

            $instruction_manual = new instruction_manual;
            $instruction_manual->file = $name;
            $instruction_manual->save();
        }

        Session::flash('success','Successfully updated the instruction manual file');
        return redirect()->back();
    }

     public function HandymanTerms()
    {
        $data = terms_conditions::where("role",1)->first();

        return view('admin.handyman_terms_conditions',compact('data'));
    }

    public function HandymanTermsPost(StoreValidationRequest $request)
    {

        $input = $request->all();
        $terms = terms_conditions::where("role",1)->first();

        if($terms)
        {

            if ($file = $request->file('file'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets',$name);

                if($terms->file != null)
                {
                    \File::delete(public_path().'/assets/'.$terms->file);
                }
                $input['file'] = $name;
            }

            $terms->update($input);
        }

        else
        {

            if ($file = $request->file('file'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets',$name);
                $input['file'] = $name;
            }


            $terms = new terms_conditions;
            $terms->role = 1;
            $terms->file = $name;
            $terms->save();


        }

        Session::flash('success', 'Successfully updated the terms and conditions file for handyman');
        return redirect()->route('admin-handyman-terms');
    }


     public function ClientTerms()
    {
        $data = terms_conditions::where("role",2)->first();

        return view('admin.client_terms_conditions',compact('data'));
    }


    public function ClientTermsPost(StoreValidationRequest $request)
    {

        $input = $request->all();
        $terms = terms_conditions::where("role",2)->first();

        if($terms)
        {
            if ($file = $request->file('file'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets',$name);

                if($terms->file != null)
                {
                    \File::delete(public_path().'/assets/'.$terms->file);
                }
                $input['file'] = $name;
            }

            $terms->update($input);
        }

        else
        {

            if ($file = $request->file('file'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets',$name);
                $input['file'] = $name;
            }


            $terms = new terms_conditions;
            $terms->role = 2;
            $terms->file = $name;
            $terms->save();

        }

        Session::flash('success', 'Successfully updated the terms and conditions file for client');
        return redirect()->route('admin-client-terms');
    }

    public function ReasonsToBook()
    {


        $data = reasons_to_book::findOrFail(1);

        return view('admin.reasons_to_book',compact('data'));
    }

    public function HowItWorksUpdate(Request $request)
    {

        $data = how_it_works::findOrFail(1);
        $input = $request->all();


        $data->update($input);
        Session::flash('success', 'How It Works text updated successfully!');
        return redirect()->route('admin-how-it-works');
    }

    public function ReasonsToBookUpdate(Request $request)
    {

        $data = reasons_to_book::findOrFail(1);
        $input = $request->all();


        $data->update($input);
        Session::flash('success', 'Reasons To Book text updated successfully!');
        return redirect()->route('admin-reasons-to-book');
    }

    public function Invoice($id)
    {



        $invoice = invoices::leftjoin('bookings','bookings.invoice_id','=','invoices.id')->leftjoin('categories','categories.id','=','bookings.service_id')->leftjoin('service_types','service_types.id','=','bookings.rate_id')->where('invoices.id','=',$id)->Select('invoices.id','invoices.handyman_id','invoices.user_id','categories.cat_name','service_types.type','bookings.service_rate','bookings.rate','bookings.booking_date','bookings.total','invoices.is_booked','invoices.is_completed','invoices.pay_req','invoices.is_paid','invoices.is_partial','invoices.status','invoices.total as inv_total','invoices.created_at as inv_date','invoices.invoice_number','invoices.service_fee','invoices.vat_percentage','invoices.is_cancelled','invoices.cancel_req','invoices.amount_refund','invoices.commission_percentage')->get();


        $user = invoices::leftjoin('users','users.id','=','invoices.user_id')->where('invoices.id','=',$id)->first();

        $handyman = invoices::leftjoin('users','users.id','=','invoices.handyman_id')->where('invoices.id','=',$id)->first();

        return view('admin.user.invoice',compact('invoice','user','handyman'));

    }

    public function ClientInvoice($id)
    {

        $invoice = invoices::leftjoin('bookings','bookings.invoice_id','=','invoices.id')->leftjoin('categories','categories.id','=','bookings.service_id')->leftjoin('service_types','service_types.id','=','bookings.rate_id')->where('invoices.id','=',$id)->Select('invoices.id','invoices.handyman_id','invoices.user_id','categories.cat_name','service_types.type','bookings.service_rate','bookings.rate','bookings.booking_date','bookings.total','invoices.is_booked','invoices.is_completed','invoices.pay_req','invoices.is_paid','invoices.is_partial','invoices.status','invoices.total as inv_total','invoices.created_at as inv_date','invoices.invoice_number','invoices.service_fee','invoices.vat_percentage','invoices.is_cancelled','invoices.cancel_req','invoices.amount_refund','invoices.commission_percentage')->get();

        $user = invoices::leftjoin('users','users.id','=','invoices.user_id')->where('invoices.id','=',$id)->first();

        $handyman = invoices::leftjoin('users','users.id','=','invoices.handyman_id')->where('invoices.id','=',$id)->first();

        return view('admin.user.client_invoice',compact('invoice','user','handyman'));

    }

    public function CancelledInvoice($id)
    {



        $invoice = invoices::leftjoin('bookings','bookings.invoice_id','=','invoices.id')->leftjoin('categories','categories.id','=','bookings.service_id')->leftjoin('service_types','service_types.id','=','bookings.rate_id')->where('invoices.id','=',$id)->Select('invoices.id','invoices.handyman_id','invoices.user_id','categories.cat_name','service_types.type','bookings.service_rate','bookings.rate','bookings.booking_date','bookings.total','invoices.is_booked','invoices.is_completed','invoices.pay_req','invoices.is_paid','invoices.is_partial','invoices.status','invoices.total as inv_total','invoices.created_at as inv_date','invoices.invoice_number','invoices.service_fee','invoices.vat_percentage','invoices.is_cancelled','invoices.cancel_req','invoices.amount_refund','invoices.commission_percentage')->get();

         $invoice_number = cancelled_invoices::where('invoice_id',$id)->first();

        $invoice_number = $invoice_number->invoice_number;


        $user = invoices::leftjoin('users','users.id','=','invoices.user_id')->where('invoices.id','=',$id)->first();

        $handyman = invoices::leftjoin('users','users.id','=','invoices.handyman_id')->where('invoices.id','=',$id)->first();

        return view('admin.user.cancelled_invoice',compact('invoice','user','handyman','invoice_number'));

    }

    public function ClientCancelledInvoice($id)
    {



        $invoice = invoices::leftjoin('bookings','bookings.invoice_id','=','invoices.id')->leftjoin('categories','categories.id','=','bookings.service_id')->leftjoin('service_types','service_types.id','=','bookings.rate_id')->where('invoices.id','=',$id)->Select('invoices.id','invoices.handyman_id','invoices.user_id','categories.cat_name','service_types.type','bookings.service_rate','bookings.rate','bookings.booking_date','bookings.total','invoices.is_booked','invoices.is_completed','invoices.pay_req','invoices.is_paid','invoices.is_partial','invoices.status','invoices.total as inv_total','invoices.created_at as inv_date','invoices.invoice_number','invoices.service_fee','invoices.vat_percentage','invoices.is_cancelled','invoices.cancel_req','invoices.amount_refund','invoices.commission_percentage')->get();

        $invoice_number = cancelled_invoices::where('invoice_id',$id)->first();

        $invoice_number = $invoice_number->invoice_number;


        $user = invoices::leftjoin('users','users.id','=','invoices.user_id')->where('invoices.id','=',$id)->first();

        $handyman = invoices::leftjoin('users','users.id','=','invoices.handyman_id')->where('invoices.id','=',$id)->first();

        return view('admin.user.client_cancelled_invoice',compact('invoice','user','handyman','invoice_number'));

    }

    public function Images($id)
    {
        $data = bookings::leftjoin('booking_images','booking_images.booking_id','=','bookings.id')->leftjoin('categories','categories.id','=','bookings.service_id')->where('bookings.invoice_id','=',$id)->Select('categories.cat_name','booking_images.image','booking_images.description')->get();
        return view('admin.user.images',compact('data'));
    }


    public function DownloadInvoice($id)
    {

        $invoice = invoices::leftjoin('bookings','bookings.invoice_id','=','invoices.id')->leftjoin('categories','categories.id','=','bookings.service_id')->leftjoin('service_types','service_types.id','=','bookings.rate_id')->where('invoices.id','=',$id)->Select('invoices.id','invoices.handyman_id','invoices.user_id','categories.cat_name','service_types.type','bookings.service_rate','bookings.rate','bookings.booking_date','bookings.total','invoices.is_booked','invoices.is_completed','invoices.pay_req','invoices.is_paid','invoices.is_partial','invoices.status','invoices.total as inv_total','invoices.created_at as inv_date','invoices.invoice_number','invoices.service_fee','invoices.vat_percentage','invoices.is_cancelled','invoices.cancel_req','invoices.amount_refund','commission_percentage')->get();

        $user = invoices::leftjoin('users','users.id','=','invoices.user_id')->where('invoices.id','=',$id)->first();

        $handyman = invoices::leftjoin('users','users.id','=','invoices.handyman_id')->where('invoices.id','=',$id)->first();

        $pdf = PDF::loadView('admin.user.pdfinvoice',compact('invoice','user','handyman'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140]);

        $invoice_number = $invoice[0]->invoice_number;

        ini_set('max_execution_time', 180);

        return $pdf->download($invoice_number.'.pdf');
    }



    public function ClientDownloadInvoice($id)
    {



        $invoice = invoices::leftjoin('bookings','bookings.invoice_id','=','invoices.id')->leftjoin('categories','categories.id','=','bookings.service_id')->leftjoin('service_types','service_types.id','=','bookings.rate_id')->where('invoices.id','=',$id)->Select('invoices.id','invoices.handyman_id','invoices.user_id','categories.cat_name','service_types.type','bookings.service_rate','bookings.rate','bookings.booking_date','bookings.total','invoices.is_booked','invoices.is_completed','invoices.pay_req','invoices.is_paid','invoices.is_partial','invoices.status','invoices.total as inv_total','invoices.created_at as inv_date','invoices.invoice_number','invoices.service_fee','invoices.vat_percentage','invoices.is_cancelled','invoices.cancel_req','invoices.amount_refund','commission_percentage')->get();


        $user = invoices::leftjoin('users','users.id','=','invoices.user_id')->where('invoices.id','=',$id)->first();

        $handyman = invoices::leftjoin('users','users.id','=','invoices.handyman_id')->where('invoices.id','=',$id)->first();

        $pdf = PDF::loadView('admin.user.clientpdfinvoice',compact('invoice','user','handyman'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140]);

        $invoice_number = $invoice[0]->invoice_number;

        ini_set('max_execution_time', 180);



        return $pdf->download($invoice_number.'.pdf');



    }

    public function DownloadCancelledInvoice($id)
    {



        $invoice = invoices::leftjoin('bookings','bookings.invoice_id','=','invoices.id')->leftjoin('categories','categories.id','=','bookings.service_id')->leftjoin('service_types','service_types.id','=','bookings.rate_id')->where('invoices.id','=',$id)->Select('invoices.id','invoices.handyman_id','invoices.user_id','categories.cat_name','service_types.type','bookings.service_rate','bookings.rate','bookings.booking_date','bookings.total','invoices.is_booked','invoices.is_completed','invoices.pay_req','invoices.is_paid','invoices.is_partial','invoices.status','invoices.total as inv_total','invoices.created_at as inv_date','invoices.invoice_number','invoices.service_fee','invoices.vat_percentage','invoices.is_cancelled','invoices.cancel_req','invoices.amount_refund','invoices.commission_percentage')->get();


        $user = invoices::leftjoin('users','users.id','=','invoices.user_id')->where('invoices.id','=',$id)->first();

        $handyman = invoices::leftjoin('users','users.id','=','invoices.handyman_id')->where('invoices.id','=',$id)->first();


        $invoice_number = cancelled_invoices::where('invoice_id',$id)->first();

        $invoice_number = $invoice_number->invoice_number;

        $pdf = PDF::loadView('admin.user.cancelled_pdfinvoice',compact('invoice','user','handyman','invoice_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140]);



       ini_set('max_execution_time', 180);



        return $pdf->download($invoice_number.'.pdf');



    }

    public function ClientDownloadCancelledInvoice($id)
    {



        $invoice = invoices::leftjoin('bookings','bookings.invoice_id','=','invoices.id')->leftjoin('categories','categories.id','=','bookings.service_id')->leftjoin('service_types','service_types.id','=','bookings.rate_id')->where('invoices.id','=',$id)->Select('invoices.id','invoices.handyman_id','invoices.user_id','categories.cat_name','service_types.type','bookings.service_rate','bookings.rate','bookings.booking_date','bookings.total','invoices.is_booked','invoices.is_completed','invoices.pay_req','invoices.is_paid','invoices.is_partial','invoices.status','invoices.total as inv_total','invoices.created_at as inv_date','invoices.invoice_number','invoices.service_fee','invoices.vat_percentage','invoices.is_cancelled','invoices.cancel_req','invoices.amount_refund')->get();


        $user = invoices::leftjoin('users','users.id','=','invoices.user_id')->where('invoices.id','=',$id)->first();

        $handyman = invoices::leftjoin('users','users.id','=','invoices.handyman_id')->where('invoices.id','=',$id)->first();


        $invoice_number = cancelled_invoices::where('invoice_id',$id)->first();

        $invoice_number = $invoice_number->invoice_number;

        $pdf = PDF::loadView('admin.user.client_cancelled_pdfinvoice',compact('invoice','user','handyman','invoice_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140]);



        ini_set('max_execution_time', 180);



        return $pdf->download($invoice_number.'.pdf');



    }


       public function AdminStatusUpdate(Request $request)
    {



$user_email = $request->user_email;
$handyman_email = $request->handyman_email;

$user = User::where('email','=',$user_email)->first();
$handyman = User::where('email','=',$handyman_email)->first();
$amount = invoices::where('id','=',$request->item_id)->first();

$amount = $amount->total;

$handyman_dash = url('/').'/aanbieder/dashboard';

$client_dash = url('/').'/aanbieder/quotation-requests';


if( $handyman->featured == 0)
{

    Session::flash('success', 'Handyman profile is not completed, profile cannot be verified!');

        return redirect()->route('admin-user-bookings');


}
else
{



    if($request->statusSelect == 1)
    {

        $amount = number_format((float)$amount, 2, '.', '');

     /*     $api_key = Generalsetting::findOrFail(1);

      $mollie = new \Mollie\Api\MollieApiClient();

$mollie->setApiKey($api_key->mollie);




$payment = $mollie->customers->get($handyman->mollie_customer_id)->createPayment([
    "amount" => [
       "currency" => "EUR",
       "value" => $amount,
    ],
    "description" => "Payment",
    "sequenceType" => "recurring",

]);*/

 $post = bookings::where('invoice_id','=',$request->item_id)->update(['is_booked' => 1,'is_completed' => 1,'pay_req' => 1,'is_paid' => 1]);

            $post = invoices::where('id','=',$request->item_id)->update(['is_booked' => 1,'is_completed' => 1,'pay_req' => 1,'is_paid' => 1]);



        $headers =  'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Booking Payment!";
            $msg = "Dear Mr/Mrs ".$user->name. " ".$user->family_name.",<br><br>We have transferred your payment into Mr/Mrs. ".$handyman->name. " ".$handyman->family_name."'s account. You can visit your profile dashboard through <a href='".$client_dash."'>here.</a><br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
            mail($user_email,$subject,$msg,$headers);


            $headers =  'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Betaling!";
            $msg = "Beste ".$user->name.",<br><br>we hebben de stoffeerder uitbetaald Mr/Mrs. ".$handyman->name. " ".$handyman->family_name."'s account. Klik op account om de status van je klus te bekijken <a href='".$client_dash."'>account.</a><br><br>Met vriendeijke groet,<br><br>Klantenservice<br><br> Vloerofferte";
            mail($user_email,$subject,$msg,$headers);



            $headers =  'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Booking Payment!";
            $msg = "Dear Mr/Mrs ".$handyman->name. " ".$handyman->family_name.",<br><br>We have transferred payment from your client Mr/Mrs. ".$user->name. " ".$user->family_name." into your account. You can visit your profile dashboard through <a href='".$handyman_dash."'>here.</a><br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
            mail($handyman_email,$subject,$msg,$headers);


            $headers =  'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Uitbetaling";
            $msg = "Beste ".$handyman->name. " ".$handyman->family_name.",<br><br>we hebben je factuur van klus Mr/Mrs. ".$user->name . " ".$user->family_name." uitbetaald. Klik op account om de status van je klus te bekijken <a href='".$handyman_dash."'>account.</a><br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte";
            mail($handyman_email,$subject,$msg,$headers);

            Session::flash('success', 'Status has been updated successfully, your client has been notified through mail.');

        return redirect()->route('admin-user-bookings');


    }
    else
    {

        $invoice = invoices::where('id','=',$request->item_id)->first();

        if($invoice->payment_id1 != NULL) // payment refund partially
        {

            $thirty_amount = $amount * 0.3;
            $thirty_amount = number_format((float)$thirty_amount, 2, '.', '');

            $api_key = Generalsetting::findOrFail(1);

      /*$mollie = new \Mollie\Api\MollieApiClient();

$mollie->setApiKey($api_key->mollie);


$payment = $mollie->payments->get($invoice->payment_id);
$refund = $payment->refund([
"amount" => [
   "currency" => "EUR",
   "value" => $thirty_amount, // 30% payment refund
]
]);*/



$seventy_amount = $amount * 0.7;
            $seventy_amount = number_format((float)$seventy_amount, 2, '.', '');

            $api_key = Generalsetting::findOrFail(1);

      $mollie = new \Mollie\Api\MollieApiClient();

/*$mollie->setApiKey($api_key->mollie);


$payment = $mollie->payments->get($invoice->payment_id1);
$refund = $payment->refund([
"amount" => [
   "currency" => "EUR",
   "value" => $seventy_amount, // 70% payment
]
]);*/


$amount_refund = $thirty_amount + $seventy_amount;

        }

        else // payment refund either partially or in full
        {

            if($invoice->is_partial != 1) // Not partial payment
            {

                $amount = number_format((float)$amount, 2, '.', '');

            $api_key = Generalsetting::findOrFail(1);

      /*$mollie = new \Mollie\Api\MollieApiClient();

$mollie->setApiKey($api_key->mollie);


$payment = $mollie->payments->get($invoice->payment_id);
$refund = $payment->refund([
"amount" => [
   "currency" => "EUR",
   "value" => $amount, // You must send the correct number of decimals, thus we enforce the use of strings
]
]);*/

$amount_refund = $amount;

            }

            else // Partial payment so refund only 30% payment
            {

                $thirty_amount = $amount * 0.3;
            $thirty_amount = number_format((float)$thirty_amount, 2, '.', '');

            $api_key = Generalsetting::findOrFail(1);

      /*$mollie = new \Mollie\Api\MollieApiClient();

$mollie->setApiKey($api_key->mollie);


$payment = $mollie->payments->get($invoice->payment_id);
$refund = $payment->refund([
"amount" => [
   "currency" => "EUR",
   "value" => $thirty_amount, // You must send the correct number of decimals, thus we enforce the use of strings
]
]);*/

$amount_refund = $thirty_amount;

            }





        }




    $post = invoices::where('id','=',$request->item_id)->update(['status' => 'refund','is_cancelled' => 1,'cancel_req' => 0,'is_booked' => 0,'is_completed' => 0,'pay_req' => 0,'is_paid' => 0,'is_partial' => 0,'reply' => $request->reply,'amount_refund' => $amount_refund]);

    $counter = Generalsetting::findOrFail(1);

    $counter = $counter->counter;


    $cancelled_invoice_number = sprintf('%04u', $counter);

    $cancelled_invoice = new cancelled_invoices;
    $cancelled_invoice->invoice_id = $request->item_id;
    $cancelled_invoice->invoice_number =  $cancelled_invoice_number;
    $cancelled_invoice->save();

    $counter = $counter + 1;

    $settings = Generalsetting::where('id',1)->update(['counter'=>$counter]);





        $headers =  'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Booking Cancelled!";
            $msg = $request->reply;
            mail($user_email,$subject,$msg,$headers);



            $headers =  'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Booking Cancelled!";
            $msg = "Dear Mr/Mrs ".$handyman->name. " ".$handyman->family_name.",<br><br>Your booking has been cancelled from your client Mr/Mrs. ".$user->name. ' '.$user->family_name.". You can visit your profile dashboard through <a href='".$handyman_dash."'>here.</a><br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
            mail($handyman_email,$subject,$msg,$headers);



            $headers =  'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Klus geannuleerd!";
            $msg = "Beste ".$handyman->name. " ".$handyman->family_name.",<br><br>de klant heeft de reservering geannuleerd Mr/Mrs. ".$user->name. ' '.$user->family_name.". Klik op account om de status van je klus te bekijken <a href='".$handyman_dash."'>account.</a><br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte";
            mail($handyman_email,$subject,$msg,$headers);

            Session::flash('success', 'Booking has been cancelled successfully, Amount has been refunded into customer account.');

        return redirect()->route('admin-user-bookings');


    }




}




    }

    public function AddTerminals()
    {
        $counter = 0;

        ini_set('max_execution_time', '30000');

        if (($handle = fopen ( public_path () . '/terminals.csv', 'r' )) !== FALSE) {
        while ( ($data = fgetcsv ( $handle, 1000, ';' )) !== FALSE ) {

            if($counter != 0)
            {

                $csv_data = new terminals();
            $csv_data->postcode = $data [0];
            $csv_data->city = $data [1];
            $csv_data->GEMEENTE = $data [2];
            $csv_data->state = $data [3];
            $csv_data->latitude = $data [4];
            $csv_data->longitude = $data [5];
            $csv_data->save ();

            }

            else
            {
                $counter = $counter + 1;
            }

        }
        fclose ( $handle );
    }

    }



    public function profile()
    {
        return view('admin.profile');
    }


    public function profileupdate(UpdateValidationRequest $request)
    {

        $input = $request->all();
        $admin = Auth::guard('admin')->user();
            if ($file = $request->file('photo'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images',$name);
                if($admin->photo != null)
                {
                    unlink(public_path().'/assets/images/'.$admin->photo);
                }
            $input['photo'] = $name;
            }

        $admin->update($input);
        Session::flash('success', 'Successfully updated your profile');
        return redirect()->back();
    }


    public function passwordreset()
    {
        return view('admin.reset-password');
    }

    public function changepass(Request $request)
    {

        $admin = Auth::guard('admin')->user();
        if ($request->cpass){
            if (Hash::check($request->cpass, $admin->password)){
                if ($request->newpass == $request->renewpass){
                    $input['password'] = Hash::make($request->newpass);
                }else{
                    Session::flash('unsuccess', 'Confirm password does not match.');
                    return redirect()->back();
                }
            }else{
                Session::flash('unsuccess', 'Current password Does not match.');
                return redirect()->back();
            }
        }
        $admin->update($input);
        Session::flash('success', 'Successfully updated your password');
        return redirect()->back();
    }

}
