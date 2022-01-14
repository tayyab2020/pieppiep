<?php

namespace App\Jobs;

use App\colors;
use App\customers_details;
use App\new_quotations;
use App\new_quotations_data;
use App\new_quotations_features;
use App\new_quotations_sub_products;
use App\product;
use App\product_features;
use App\product_ladderbands;
use App\product_models;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Barryvdh\DomPDF\Facade as PDF;

class SendOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $id = null;
    private $user = null;
    private $mail_to = null;
    private $mail_subject = null;
    private $mail_body = null;
    public $timeout = 0;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id,$user,$mail_subject,$mail_body)
    {
        $this->id = $id;
        $this->user = $user;
        $this->mail_subject = $mail_subject;
        $this->mail_body = $mail_body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $id = $this->id;
        $user = $this->user;
        $user_id = $user->id;
        $main_id = $user->main_id;
        $mail_subject = $this->mail_subject;
        $mail_body = $this->mail_body;
        $sup_mail = array();

        if($main_id)
        {
            $user = User::where('id',$main_id)->first();
            $user_id = $user->id;
        }

        $retailer_name = $user->name . ' ' . $user->family_name;
        $retailer_company = $user->company_name;

        $check = new_quotations::where('id',$id)->where('creator_id',$user_id)->first();

        $client = customers_details::leftjoin('users','users.id','=','customers_details.user_id')->where('customers_details.id', $check->customer_details)->select('customers_details.*','users.email')->first();
        $suppliers = new_quotations_data::leftjoin('new_quotations','new_quotations.id','=','new_quotations_data.quotation_id')->where('new_quotations.id',$id)->where('new_quotations.creator_id',$user_id)->pluck('new_quotations_data.supplier_id');
        $suppliers = $suppliers->unique();

        foreach ($suppliers as $i => $key)
        {
            $supplier_data = User::where('id',$key)->first();
            $supplier_name = $supplier_data->name . ' ' . $supplier_data->family_name;
            $supplier_email = $supplier_data->email;
            $order_number = new_orders::where('quotation_id',$id)->where('supplier_id',$key)->first();
            $order_number = $order_number->order_number;
            $filename = $order_number . '.pdf';
            $file = public_path() . '/assets/supplierQuotations/' . $filename;

            new_quotations_data::where('quotation_id',$id)->where('supplier_id',$key)->update(['order_date' => date('Y-m-d')]);
            new_orders::where('quotation_id',$id)->where('supplier_id',$key)->update(['order_sent' => 1]);

            /*if($this->attempts() == 1)
            {
                $supplier_data->counter_order = $counter + 1;
                $supplier_data->save();
            }*/

            $sup_mail[] = array('email' => $supplier_email,'name' => $supplier_name,'file' => $file,'file_name' => $filename,'order_number' => $order_number);
        }

        foreach ($sup_mail as $sup)
        {
            $mail_subject = str_replace('{order_nummer}',$sup['order_number'],$mail_subject);
            $mail_body = str_replace('{aan_voornaam}',$sup['name'],$mail_body);
            $mail_body = str_replace('{order_nummer}',$sup['order_number'],$mail_body);
            $mail_body = str_replace('{van_voornaam}',$retailer_name,$mail_body);
            $mail_body = str_replace('{van_bedrijfsnaam}',$retailer_company,$mail_body);

            \Mail::send('user.global_mail',
                array(
                    'msg' => $mail_body,
                ), function ($message) use ($sup,$mail_subject) {
                    $message->to($sup['email'])
                        ->from('info@pieppiep.com')
                        ->subject($mail_subject)
                        ->attach($sup['file'], [
                            'as' => $sup['file_name'],
                            'mime' => 'application/pdf',
                        ]);
                });

            /*\Mail::send('user.custom_quotation_mail',
                array(
                    'supplier' => $sup['name'],
                    'retailer' => $retailer_name,
                    'company_name' => $retailer_company,
                    'order_number' => $sup['order_number'],
                    'type' => 'new-quotation'
                ), function ($message) use ($sup) {
                    $message->from('info@pieppiep.com');
                    $message->to($sup['email'])->subject('New order received!');

                    $message->attach($sup['file'], [
                        'as' => $sup['file_name'],
                        'mime' => 'application/pdf',
                    ]);

                });*/
        }

        new_quotations::where('id',$id)->update(['processing' => 0, 'finished' => 1]);
    }

    public function failed()
    {
        $id = $this->id;
        new_quotations::where('id',$id)->update(['processing' => 0, 'failed' => 1]);

        $msg = 'Job failed for sending order to supplier(s) <br> Quotation ID: ' . $id;

        \Mail::send(array(), array(), function ($message) use ($msg) {
            $message->to('tayyabkhurram62@gmail.com')
                ->from('info@pieppiep.com')
                ->subject('Job Failed')
                ->setBody($msg, 'text/html');
        });
    }
}
