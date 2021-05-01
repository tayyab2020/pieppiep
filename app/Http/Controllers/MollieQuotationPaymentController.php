<?php
namespace App\Http\Controllers;

use App\quotation_invoices;
use App\quotes;
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

        $api_key = Generalsetting::findOrFail(1);
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
            $handyman_dash = url('/').'/aanbieder/dashboard';
            $commission_percentage = $data->commission_percentage;
            $commission = $data->commission;
            $total_receive = $data->total_receive;
            $language = $data->language;

            quotation_invoices::where('id','=',$data->invoice_id)->update(['invoice' => 1, 'ask_customization' => 0, 'commission_percentage' => $commission_percentage, 'commission' => $commission, 'total_receive' => $total_receive, 'payment_date' => $now, 'payment_id' => $payment_id, 'commission_invoice_number' => $commission_invoice_number]);
            quotes::where('id','=',$data->quote_id)->update(['status' => 3]);

            $handyman = User::where('id','=',$data->handyman_id)->first();
            $name = $handyman->name;
            $email = $handyman->email;

            $quote = quotes::leftjoin('categories', 'categories.id', '=', 'quotes.quote_service')->leftjoin('users','users.id','=','quotes.user_id')->where('quotes.id', $data->quote_id)->select('quotes.*', 'categories.cat_name', 'users.postcode', 'users.city', 'users.address')->first();
            $invoice = quotation_invoices::leftjoin('quotation_invoices_data', 'quotation_invoices_data.quotation_id', '=', 'quotation_invoices.id')->leftjoin('users','users.id','=','quotation_invoices.handyman_id')->where('quotation_invoices.quote_id', $data->quote_id)->select('quotation_invoices_data.*', 'quotation_invoices.created_at', 'quotation_invoices.description as other_info', 'quotation_invoices.vat_percentage', 'quotation_invoices.tax', 'quotation_invoices.subtotal as sub_total', 'quotation_invoices.grand_total','users.company_name','users.address','users.postcode','users.city','users.tax_number','users.registration_number','users.email','users.phone')->get();

            $requested_quote_number = $quote->quote_number;

            $filename = $quotation_invoice_number . '.pdf';

            $file = public_path() . '/assets/quotationsPDF/' . $filename;

            $type = 'invoice';

            ini_set('max_execution_time', 180);

            $pdf = PDF::loadView('user.pdf_quotation', compact('quote', 'type', 'invoice', 'quotation_invoice_number', 'requested_quote_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140]);
            $pdf->save($file);


            $filename = $commission_invoice_number . '.pdf';

            $file = public_path() . '/assets/quotationsPDF/CommissionInvoices/' . $filename;

            $type = 'commission_invoice';

            $pdf = PDF::loadView('user.pdf_commission', compact('quote', 'type', 'invoice', 'commission_invoice_number', 'quotation_invoice_number', 'requested_quote_number', 'commission_percentage', 'commission', 'total_receive'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 140]);

            $pdf->save($file);


            if($language == 'du')
            {
                $msg = "Beste ". $name .",<br><br>De klant heeft de factuur betaald QUO# " . $quotation_invoice_number . ", Wij betalen het bedrag minus commissiekosten aan je uit, zodra de klant de goederen heeft ontvangen en de status van de levering heeft gewijzigd naar ontvangen. <a href='".$handyman_dash."'>Klik hier</a> om naar je dashboard te gaan.<br><br><b>Wat als?</b><br><br>Geen melding dat het pakket is ontvangen? Wees gerust, na zeven dagen gaan we hier vanuit. Als verkoper ontvang je uiterlijk de volgende werkdag om 18.00 uur het aankoopbedrag op je rekening.<br><br>Met vriendelijke groeten,<br><br>Vloerofferte";
            }
            else
            {
                $msg = "Dear Mr/Mrs ". $name .",<br><br>We have received a total amount of € " . $paid_amount ." for your quotation # " . $quotation_invoice_number . ". This amount will soon be transferred to your account. Below attached is your invoice along with our commission. For further details visit your panel through <a href='".$handyman_dash."'>here.</a><br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte";
            }


            \Mail::send(array(), array(), function ($message) use ($msg, $file, $filename, $email, $name, $handyman_dash, $paid_amount, $quotation_invoice_number) {
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
