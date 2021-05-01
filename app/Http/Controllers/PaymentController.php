<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Generalsetting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Config;
use Session;

class PaymentController extends Controller
{

 public function store(Request $request){
     $payment = new Payment;
     $settings = Generalsetting::findOrFail(1);
     $user = User::findOrFail($request->userid);

     $paymentold = Payment::where('user_id',$request->userid)
     ->where('payment_status',"Pending")
     ->where('featured',$request->featured);
     $paymentold->delete();
     $item_name = 'Premium Profile';
     $item_number = str_random(2).time();
     $item_amount = $settings->np;
     $feature_price = $settings->fp;
     if($user->status == '1'){
         $item_amount = 0.00;
     }
     if($request->featured == 'yes'){
         $item_amount = $item_amount + $feature_price;
     }
     $paypal_email = $settings->pb;
     $return_url = action('PaymentController@payreturn');
     $cancel_url = action('PaymentController@paycancle');
     $notify_url = action('PaymentController@notify');
     $querystring = '';
     // Firstly Append paypal account to querystring
     $querystring .= "?business=".urlencode($paypal_email)."&";
     // Append amount& currency (£) to quersytring so it cannot be edited in html

     //The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
     $querystring .= "item_name=".urlencode($item_name)."&";
     $querystring .= "amount=".urlencode($item_amount)."&";
     $querystring .= "item_number=".urlencode($item_number)."&";
     $querystring .= "cmd=".urlencode(stripslashes($request->cmd))."&";
     $querystring .= "bn=".urlencode(stripslashes($request->bn))."&";
     $querystring .= "lc=".urlencode(stripslashes($request->lc))."&";
     $querystring .= "currency_code=".urlencode(stripslashes($request->currency_code))."&";
     // Append paypal return addresses
     $querystring .= "return=".urlencode(stripslashes($return_url))."&";
     $querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
     $querystring .= "notify_url=".urlencode($notify_url)."&";
     $querystring .= "custom=".$request->featured;

     $payment['featured'] = $request->featured;
     $payment['user_id'] = $request->userid;
     $payment['paid_amount'] = $item_amount;
     $payment['method'] = "Paypal";
     $payment['payment_status'] = "Pending";
     $payment['payment_id'] = $item_number;
     $payment['process_time'] = date('Y-m-d H:i:s');
     $payment->save();
    // Redirect to paypal IPN
     header('location:https://www.paypal.com/cgi-bin/webscr'.$querystring);
     exit();
 }


 public function paycancle(){
     return redirect()->back()->with('unsuccess','Payment Cancelled.');
 }

public function payreturn(){
    return redirect(route('user-dashboard'))->with('success','Payment Completed Successfully.');
 }

public function notify(Request $request){

    $raw_post_data = file_get_contents('php://input');
    $raw_post_array = explode('&', $raw_post_data);
    $myPost = array();
    foreach ($raw_post_array as $keyval) {
        $keyval = explode ('=', $keyval);
        if (count($keyval) == 2)
            $myPost[$keyval[0]] = urldecode($keyval[1]);
    }

    // Read the post from PayPal system and add 'cmd'
    $req = 'cmd=_notify-validate';
    if(function_exists('get_magic_quotes_gpc')) {
        $get_magic_quotes_exists = true;
    }
    foreach ($myPost as $key => $value) {
        if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
            $value = urlencode(stripslashes($value));
        } else {
            $value = urlencode($value);
        }
        $req .= "&$key=$value";
    }

    /*
     * Post IPN data back to PayPal to validate the IPN data is genuine
     * Without this step anyone can fake IPN data
     */
    $paypalURL = "https://www.paypal.com/cgi-bin/webscr";
    $ch = curl_init($paypalURL);
    if ($ch == FALSE) {
        return FALSE;
    }
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSLVERSION, 6);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

// Set TCP timeout to 30 seconds
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: company-name'));
    $res = curl_exec($ch);

    /*
     * Inspect IPN validation result and act accordingly
     * Split response headers and payload, a better way for strcmp
     */
    $tokens = explode("\r\n\r\n", trim($res));
    $res = trim(end($tokens));
    if (strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0) {

        $payment = Payment::where('payment_id', $_POST['item_number'])->first();
            $data['txnid'] = $_POST['txn_id'];
            $data['payment_status'] = $_POST['payment_status'];
            $payment->update($data);

        $userid = Payment::where('payment_id', $_POST['item_number'])->first();

        $profileupdate = User::findOrFail($userid->user_id);
        $status['status'] = 1;
        $status['active'] = 1;
        $status['is_featured'] = 0;
        if ($_POST['custom'] == "yes"){
            $status['is_featured'] = 1;
            $status['featured'] = 1;
        }
        $profileupdate->update($status);

    }else{

        $payment = Payment::where('featured',$_POST['custom'])
            ->where('payment_id',$_POST['item_number']);
        $payment->delete();

    }

}

}
