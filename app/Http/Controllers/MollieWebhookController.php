<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Mollie\Laravel\Facades\Mollie;
use App\Generalsetting;
use App\bookings;
use App\invoices;
use DateTime;
use App\carts;
use App\users;
use App\booking_images;
use Crypt;
use App\Sociallink;
use App\user_languages;


class MollieWebhookController extends Controller {

    public function handle(Request $request) {

        if (! $request->has('id')) {
            return;
        }


        $api_key = Generalsetting::findOrFail(1);
        $sl = Sociallink::findOrFail(1);

        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey($api_key->mollie);

        $payment = $mollie->payments->get($request->id);

        if ($payment->isPaid()) {

            $data = $payment->metadata;

            $check = invoices::where('invoice_number','=',$data->invoice_no)->first();

            if($check == "")
            {

                $service_rate = json_decode($data->service_rate);
                $service_id = json_decode($data->service_id);
                $rate_id = json_decode($data->rate_id);
                $rate = json_decode($data->rate);
                $book_date = json_decode($data->date);
                $service_total = json_decode($data->service_total);
                $cart_id = json_decode($data->cart_id);

                $b_date = new DateTime($book_date[0]);
                $b_date = $b_date->format('Y-m-d H:m');

                $due_date = date('d-m-Y', strtotime('-5 days', strtotime($b_date)));

                if($data->payment_option == 1)
                {
                    $payment_option = 0;
                }
                else
                    {
                        $payment_option = 1;
                    }

                $inv = new invoices;
                $inv->user_id = $data->user_id;
                $inv->handyman_id = $data->handyman_id;
                $inv->total = $data->total;
                $inv->invoice_number = $data->invoice_no;
                $inv->payment_id = $request->id;
                $inv->status = $payment->status;
                $inv->booking_date = $b_date;
                $inv->is_partial = $payment_option;
                $inv->service_fee = $data->service_fee;
                $inv->vat_percentage = $data->vat_percentage;
                $inv->commission_percentage = $data->commission_percentage;
                $inv->ip = $data->language;
                $inv->save();

                $inv_id = $inv->id;

                $i = 0;

                foreach ($service_rate as $key) {

                    $post = new bookings;
                    $post->user_id = $data->user_id;
                    $post->handyman_id = $data->handyman_id;
                    $post->invoice_id = $inv_id;
                    $post->cart_id = $cart_id[$i];
                    $post->service_id = $service_id[$i];
                    $post->rate_id = $rate_id[$i];
                    $post->rate = $rate[$i];

                    $date = new DateTime($book_date[$i]);
                    $date = $date->format('Y-m-d H:m');
                    $post->booking_date = $date;
                    $post->service_rate = $service_rate[$i];
                    $post->total = $service_total[$i];
                    $post->payment_id = $request->id;
                    $post->status = $payment->status;
                    $post->is_partial = $payment_option;
                    $post->save();

                    $update = booking_images::where('cart_id','=',$cart_id[$i])->update(['booking_id'=>$post->id]);
                    $i++;
                }

                $counter = Generalsetting::findOrFail(1);
                $counter = $counter->counter;
                $counter = $counter + 1;

                $settings = Generalsetting::where('id',1)->update(['counter' => $counter]);

                $post = User::where('id','=',$data->handyman_id)->first();
                $post1 = User::where('id','=',$data->user_id)->first();

                $handyman_email = $post->email;
                $user_email = $post1->email;

                $handyman_name = $post->name. ' ' .$post->family_name;
                $client_name = $post1->name. ' ' .$post1->family_name;
                $handyman_dash = url('/').'/aanbieder/dashboard';
                $client_dash = url('/').'/aanbieder/quotation-requests';
                $paid_amount = $data->paid_amount;


                if($payment_option != 0) // 30% payment
                    {

                        // $rem_amount = $data->total - ($data->total * 0.3);
// $rem_amount = number_format((float)$rem_amount, 2, '.', '');
// $inv_encrypt = Crypt::encrypt($inv_id);

// $api_key = Generalsetting::findOrFail(1);

//         $mollie = new \Mollie\Api\MollieApiClient();
//         $mollie->setApiKey($api_key->mollie);
//         $payment = $mollie->payments->create([
//             'amount' => [
//                 'currency' => 'EUR',
//                 'value' => $rem_amount, // You must send the correct number of decimals, thus we enforce the use of strings
//             ],
//             'description' => 'Remaining partial payment to admin',
//             'webhookUrl' => route('webhooks.last'),
//             'redirectUrl' => url('/thankyou/'. $inv_encrypt),
//             "metadata" => [
//             "invoice_id" => $inv_id,
//             "user_email" => $user_email,
//             "handyman_email" => $handyman_email,


//       ],
//         ]);

//         $payment_url = $payment->getCheckoutUrl();
//         $invoice_update = invoices::where('id','=',$inv_id)->update(['partial_paymentLink' => $payment_url]);

                    if($data->language == 'eng') // English Email Template
                        {
                            $headers =  'MIME-Version: 1.0' . "\r\n";
                            $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
                            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                            $subject = "New Booking!";
                            $msg = "Dear Mr/Mrs ". $client_name .",<br><br>Your partial payment has been received against your order. Kindly pay remaining payment before " . $due_date . ". We have received a total amount of € " . $paid_amount .". Kindly visit your bookings in your client panel to complete your remaining transaction. You can see your current booking status by visiting your profile through <a href='".$client_dash."'>here.</a><br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
                            mail($user_email,$subject,$msg,$headers);
                        }
                    else // Dutch Email Template
                    {
                        $headers =  'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $subject = "Bevestiging aanbetaling!";
                        $msg = "Beste ". $client_name .",<br><br> Je aanbetaling op je reservering is ontvangen. Het restant dient 7 dagen voor aanvang van de klus voldaan te worden " . $due_date . ". We hebben een totaalbedrag ontvangen van € " . $paid_amount .". Het restant kan voldaan worden door naar reserveringen te gaan en te klikken op restant betalen. Klik op account om de status van je reservering te bekijken <a href='".$client_dash."'>account.</a><br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte";
                        mail($user_email,$subject,$msg,$headers);

                    }

                    }
                else // 100% payment
                {

                    if($data->language == 'eng') // English Email Template
                        {
                            $headers =  'MIME-Version: 1.0' . "\r\n";
                            $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
                            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                            $subject = "New Booking!";
                            $msg = "Dear Mr/Mrs ". $client_name .",<br><br>Your booking has been made. We have received a total amount of € " . $paid_amount .". For further details visit your client panel through <a href='".$client_dash."'>here.</a><br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
                            mail($user_email,$subject,$msg,$headers);
                        }
                    else //Dutch Email Template
                    {
                        $headers =  'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $subject = "Nieuwe reservering!";
                        $msg = "Beste ". $client_name .",<br><br>Je reservering is geslaagd. Wij hebben een totaalbedrag van € " . $paid_amount ." ontvangen. Om je reservering te bekijken, klik op account <a href='".$client_dash."'>account.</a><br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte";
                        mail($user_email,$subject,$msg,$headers);
                    }

                }


                if($data->language == 'eng') //English Email Template
                    {
                        $headers =  'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $subject = "New Booking!";
                        $msg = "Dear Mr/Mrs ". $handyman_name .",<br><br>You have a new booking waiting for your response. Kindly review your bookings before it get expired. We have received a total amount of € " . $paid_amount .". You can visit your profile dashboard through <a href='".$handyman_dash."'>here.</a><br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
                        mail($handyman_email,$subject,$msg,$headers);
                    }
                else //Dutch Email Template
                {
                    $headers =  'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $subject = "Nieuwe reservering!";
                    $msg = "Beste ". $handyman_name .",<br><br>Je hebt een nieuwe reservering. Graag de opdracht binnen 48 uur accepteren. We hebben een totaalbedrag ontvangen van € " . $paid_amount .". Voor meer informatie over de boeking, klik op de link <a href='".$handyman_dash."'>account.</a><br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> Vloerofferte";
                    mail($handyman_email,$subject,$msg,$headers);
                }

                $headers =  'MIME-Version: 1.0' . "\r\n";
                $headers .= 'From: Vloerofferte <info@vloerofferte.nl>' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $subject = "New Booking!";
                $msg = "Dear Nordin Adoui, A new booking is made on your website. Paid amount is € " . $paid_amount .". You can visit your admin panel to view all bookings.";
                mail($sl->admin_email,$subject,$msg,$headers);

                $check = carts::where('user_ip','=',$data->ip)->delete();
            }

        }

    }
}
