<?php
namespace App\Http\Controllers;

use App\colors;
use App\items;
use App\new_quotations;
use App\product;
use App\product_models;
use App\quotation_invoices;
use App\quotes;
use App\Service;
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
use File;
use PDF;


class MollieQuotationPaymentController extends Controller {

    public function handle(Request $request) {

        if (! $request->has('id')) {
            return;
        }

        $api_key = Generalsetting::where('backend',0)->first();
        $sl = Sociallink::findOrFail(1);

        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey($api_key->mollie);

        $payment = $mollie->payments->get($request->id);

        if ($payment->isPaid()) {

            $payment_id = $request->id;

            $data = $payment->metadata;
            $now = date('d-m-Y H:i:s');
            $paid_amount = $data->paid_amount;
            $quotation_invoice_number = $data->quotation_invoice_number;
            $commission_invoice_number = $data->commission_invoice_number;
            $retailer_dash = url('/').'/aanbieder/dashboard';
            $commission_percentage = $data->commission_percentage;
            $commission = $data->commission;
            $total_receive = $data->total_receive;
            $language = $data->language;

            new_quotations::where('id','=',$data->invoice_id)->update(['paid' => 1, 'ask_customization' => 0, 'commission_percentage' => $commission_percentage, 'commission' => $commission, 'total_receive' => $total_receive, 'payment_date' => $now, 'payment_id' => $payment_id, 'commission_invoice_number' => $commission_invoice_number]);
            quotes::where('id','=',$data->quote_id)->update(['status' => 3]);

            $retailer = User::where('id','=',$data->retailer_id)->first();
            $name = $retailer->name;
            $email = $retailer->email;

            $quote = quotes::leftjoin('categories','categories.id','=','quotes.quote_service')->leftjoin('brands','brands.id','=','quotes.quote_brand')->leftjoin('product_models','product_models.id','=','quotes.quote_model')->leftjoin('models','models.id','=','quotes.quote_type')->leftjoin('colors','colors.id','=','quotes.quote_color')->leftjoin('services','services.id','=','quotes.quote_service1')->leftjoin('users','users.id','=','quotes.user_id')->where('quotes.id', $data->quote_id)->select('quotes.*','categories.cat_name','services.title','brands.cat_name as brand_name','product_models.model as model_name','models.cat_name as type_title','colors.title as color', 'users.postcode', 'users.city', 'users.address')->first();

            $requested_quote_number = $quote->quote_number;

            $filename = $quotation_invoice_number . '.pdf';

            $request = new_quotations::leftjoin('users','users.id','=','new_quotations.creator_id')->where('new_quotations.id', $data->invoice_id)->where('new_quotations.quote_request_id', $data->quote_id)->with('data')->select('new_quotations.*','new_quotations.tax_amount as tax','new_quotations.description as other_info','users.compressed_photo', 'users.quotation_prefix', 'users.company_name','users.address','users.postcode','users.city','users.tax_number','users.registration_number','users.email','users.phone')->first();
            $user = $request;

            $client = new \stdClass();
            $client->address = $quote->quote_zipcode;
            $client->name = $quote->quote_name;
            $client->family_name = $quote->quote_familyname;
            $client->postcode = $quote->quote_postcode;
            $client->postcode = $quote->quote_city;
            $client->email = $quote->quote_email;

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

            $date = $request->created_at;
            $role = 'retailer';
            $form_type = 1;
            $re_edit = 1;

            $pdf = PDF::loadView('user.pdf_new_quotation_1', compact('re_edit','form_type','role','product_titles','color_titles','model_titles','date','client','user','request','quotation_invoice_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 160,'isRemoteEnabled' => true]);
            $file = public_path() . '/assets/newQuotations/' . $filename;
            $pdf->save($file);

            $filename = $commission_invoice_number . '.pdf';

            $file = public_path() . '/assets/quotationsPDF/CommissionInvoices/' . $filename;

            $type = 'commission_invoice';

            $pdf = PDF::loadView('user.pdf_commission', compact('date','request', 'product_titles', 'color_titles', 'model_titles', 'quote', 'type', 'commission_invoice_number', 'quotation_invoice_number', 'requested_quote_number', 'commission_percentage', 'commission', 'total_receive'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140]);

            $pdf->save($file);

            if($language == 'du')
            {
                $msg = "Beste ". $name .",<br><br>De klant heeft de factuur betaald QUO# " . $quotation_invoice_number . ", Wij betalen het bedrag minus commissiekosten aan je uit, zodra de klant de goederen heeft ontvangen en de status van de levering heeft gewijzigd naar ontvangen. <a href='".$retailer_dash."'>Klik hier</a> om naar je dashboard te gaan.<br><br><b>Wat als?</b><br><br>Geen melding dat het pakket is ontvangen? Wees gerust, na zeven dagen gaan we hier vanuit. Als verkoper ontvang je uiterlijk de volgende werkdag om 18.00 uur het aankoopbedrag op je rekening.<br><br>Met vriendelijke groeten,<br><br>Vloerofferte";
            }
            else
            {
                $msg = "Dear Mr/Mrs ". $name .",<br><br>We have received a total amount of € " . $paid_amount ." for your quotation # " . $quotation_invoice_number . ". This amount will soon be transferred to your account. Below attached is your invoice along with our commission. For further details visit your panel through <a href='".$retailer_dash."'>here.</a><br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
            }


            \Mail::send(array(), array(), function ($message) use ($msg, $file, $filename, $email, $name, $retailer_dash, $paid_amount, $quotation_invoice_number) {
                $message->to($email)
                    ->from('info@vloerofferte.nl')
                    ->subject(__('text.Payment Received!'))
                    ->setBody($msg, 'text/html');

                $message->attach($file, [
                    'as' => $filename,
                    'mime' => 'application/pdf',
                ]);
            });


            $admin_email = $sl->admin_email;

            \Mail::send(array(), array(), function ($message) use ($file, $filename, $admin_email, $quotation_invoice_number, $paid_amount) {
                $message->to($admin_email)
                    ->from('info@vloerofferte.nl')
                    ->subject('Payment Received!')
                    ->setBody("Payment received for quotation # " . $quotation_invoice_number . "<br>Total amount : €" . $paid_amount . "<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte", 'text/html');

                $message->attach($file, [
                    'as' => $filename,
                    'mime' => 'application/pdf',
                ]);
            });

        }

    }
}
