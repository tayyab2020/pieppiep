<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Mollie\Laravel\Facades\Mollie;
use App\orders;
use App\Generalsetting;
use App\users;
use App\Sociallink;


class MollieFirstPayment extends Controller {

    public function handle(Request $request) {

        if (! $request->has('id')) {
            return;
        }

        $api_key = Generalsetting::findOrFail(1);
        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey($api_key->mollie);
        $sl = Sociallink::findOrFail(1);


        $payment = $mollie->payments->get($request->id);
        $customerId = $payment->metadata->customer_id;

        $consumerName = $payment->metadata->consumer_name;
        $user_id = $payment->metadata->user_id;
        $status = $payment->status;
        $role = $payment->metadata->role_id == 2 ? 'Retailer' : 'Supplier';


        if ($payment->isPaid()) {

            $user = User::where('id','=',$user_id)->update(['mollie_customer_id' => $customerId, 'payment_id' => $request->id, 'payment_status' => $status, 'featured' => 1]);

            $headers =  'MIME-Version: 1.0' . "\r\n";
            $headers .= 'From: Pieppiep <info@pieppiep.com>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        	$subject = "Remaining Payment Received!";
            $msg = "Dear Nordin Adoui, Recent Activity: Registration Fee has been received from a new ". $role ." Mr/Mrs. ". $consumerName .". Kindly visit your admin panel to view further details.";
            mail($sl->admin_email,$subject,$msg,$headers);

        }
    }
}
