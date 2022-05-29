<?php

namespace App\Jobs;

use App\colors;
use App\customers_details;
use App\new_quotations;
use App\new_quotations_data;
use App\new_orders;
use App\new_orders_features;
use App\new_orders_sub_products;
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

class CreateOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $quotation_id = null;
    private $form_type = null;
    private $role = null;
    private $product_titles = null;
    private $color_titles = null;
    private $model_titles = null;
    private $feature_sub_titles = null;
    private $sub_titles = null;
    private $date = null;
    private $client = null;
    private $user = null;
    private $request = null;
    private $quotation_invoice_number = null;
    private $suppliers = null;
    private $order_numbers = null;
    public $timeout = 0;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($quotation_id,$form_type,$role,$product_titles,$color_titles,$model_titles,$feature_sub_titles,$sub_titles,$date,$client,$user,$request,$quotation_invoice_number,$suppliers,$order_numbers)
    {
        $this->quotation_id = $quotation_id;
        $this->form_type = $form_type;
        $this->role = $role;
        $this->product_titles = $product_titles;
        $this->color_titles = $color_titles;
        $this->model_titles = $model_titles;
        $this->feature_sub_titles = $feature_sub_titles;
        $this->sub_titles = $sub_titles;
        $this->date = $date;
        $this->client = $client;
        $this->user = $user;
        $this->request = $request;
        $this->quotation_invoice_number = $quotation_invoice_number;
        $this->suppliers = $suppliers;
        $this->order_numbers = $order_numbers;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $quotation_id = $this->quotation_id;
        $form_type = $this->form_type;
        $role = $this->role;
        $product_titles = $this->product_titles;
        $color_titles = $this->color_titles;
        $model_titles = $this->model_titles;
        $color_titles = $this->color_titles;
        $feature_sub_titles = $this->feature_sub_titles;
        $sub_titles = $this->sub_titles;
        $date = $this->date;
        $client = $this->client;
        $client = customers_details::leftjoin('users','users.id','=','customers_details.user_id')->where('customers_details.id', $client->id)->select('customers_details.*','users.email')->first(); // refetching because of email issue
        $user = $this->user;
        $request = $this->request;
        $request = (object) $request;
        $quotation_invoice_number = $this->quotation_invoice_number;
        $suppliers = $this->suppliers;
        $order_numbers = $this->order_numbers;
        
        $filename = $quotation_invoice_number . '.pdf';

        ini_set('max_execution_time', 180);

        if($form_type == 1)
        {
            $pdf = PDF::loadView('user.pdf_new_quotation_1', compact('form_type','suppliers','order_numbers','role','product_titles','color_titles','model_titles','feature_sub_titles','sub_titles','date','client','user','request','quotation_invoice_number'))->setPaper('letter', 'portrait')->setOptions(['dpi' => 160,'isRemoteEnabled' => true]);
        }
        else
        {
            $pdf = PDF::loadView('user.pdf_new_quotation', compact('form_type','suppliers','order_numbers','role','product_titles','color_titles','model_titles','feature_sub_titles','sub_titles','date','client','user','request','quotation_invoice_number'))->setPaper('letter', 'landscape')->setOptions(['dpi' => 160,'isRemoteEnabled' => true]);
        }
        
        $file = public_path() . '/assets/Orders/' . $filename;
        $pdf->save($file);

        new_quotations::where('id',$quotation_id)->update(['processing' => 0]);
    }

    public function failed()
    {
        $quotation_id = $this->quotation_id;
        new_quotations::where('id',$quotation_id)->update(['processing' => 0, 'failed' => 1]);

        $msg = 'Job failed for creating order pdf Quotation ID: ' . $quotation_id;

        \Mail::send(array(), array(), function ($message) use ($msg) {
            $message->to('tayyabkhurram62@gmail.com')
                ->from('info@pieppiep.com')
                ->subject('Job Failed')
                ->setBody($msg, 'text/html');
        });
    }
}
