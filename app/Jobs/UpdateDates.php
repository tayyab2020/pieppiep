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
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateDates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $request = null;
    private $user = null;
    public $timeout = 0;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request,$user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $request = $this->request;
        $supplier = $this->user;
        $rows = $request['data_id'];
        $delivery_dates = $request['delivery_dates'];

        $is_approved = new_quotations_data::where('id',$rows[0])->pluck('approved')->first();

        $invoice_id = $request['invoice_id'];
        $main_id = $supplier->main_id;

        if($main_id)
        {
            $supplier = User::where('id',$main_id)->first();
        }

        $supplier_id = $supplier->id;
        $supplier_name = $supplier->name . ' ' . $supplier->family_name;
        $user = User::where('id',$request['creator_id'])->first();
        $user_id = $user->id;
        $retailer_email = $user->email;
        $retailer_company = $user->company_name;

        $check = new_quotations::where('id',$invoice_id)->where('creator_id',$user_id)->first();

        $client = customers_details::leftjoin('users','users.id','=','customers_details.user_id')->where('customers_details.id', $check->customer_details)->select('customers_details.*','users.email')->first();

        $request = new_quotations::where('id',$invoice_id)->first();
        $request->products = new_quotations_data::where('quotation_id',$invoice_id)->where('supplier_id',$supplier_id)->get();
        $order_number = $request->products[0]->order_number;

        \Mail::send(array(), array(), function ($message) use ($order_number) {
            $message->to('tayyabkhurram62@gmail.com')
                ->from('info@pieppiep.com')
                ->subject('Testing')
                ->setBody($order_number, 'text/html');
        });

        $product_titles = array();
        $color_titles = array();
        $sub_titles = array();
        $qty = array();
        $width = array();
        $width_unit = array();
        $height = array();
        $height_unit = array();
        $comments = array();
        $delivery = array();
        $feature_sub_titles = array();

        foreach ($request->products as $x => $temp)
        {
            $feature_sub_titles[$x][] = 'empty';
            $product_titles[] = product::where('id',$temp->product_id)->pluck('title')->first();
            $color_titles[] = colors::where('id',$temp->color)->pluck('title')->first();
            $qty[] = $temp->qty;
            $width[] = $temp->width;
            $width_unit[] = $temp->width_unit;
            $height[] = $temp->height;
            $height_unit[] = $temp->height_unit;
            $delivery[] = $temp->delivery_date;

            $features = new_quotations_features::where('quotation_data_id',$temp->id)->get();

            foreach ($features as $f => $feature)
            {
                if($feature->feature_id == 0)
                {
                    if($feature->ladderband)
                    {
                        $sub_product = new_quotations_sub_products::where('feature_row_id',$feature->id)->get();

                        foreach ($sub_product as $sub)
                        {
                            if($sub->size1_value == 1 || $sub->size2_value == 1)
                            {
                                $sub_titles[$x] = product_ladderbands::where('product_id',$temp->product_id)->where('id',$sub->sub_product_id)->first();

                                if($sub->size1_value == 1)
                                {
                                    $sub_titles[$x]->size = '38mm';
                                }
                                else
                                {
                                    $sub_titles[$x]->size = '25mm';
                                }
                            }
                        }
                    }
                }

                $feature_sub_titles[$x][] = product_features::leftjoin('features','features.id','=','product_features.heading_id')->where('product_features.product_id',$temp->product_id)->where('product_features.heading_id',$feature->feature_id)->select('product_features.*','features.title as main_title','features.order_no','features.id as f_id')->first();
                $comments[$x][] = $feature->comment;
            }
        }

        $request->qty = $qty;
        $request->width = $width;
        $request->width_unit = $width_unit;
        $request->height = $height;
        $request->height_unit = $height_unit;
        $request->delivery_date = $delivery;

        $quotation_invoice_number = $request->quotation_invoice_number;
        $filename = $order_number . '.pdf';
        $file = public_path() . '/assets/supplierApproved/' . $filename;

        ini_set('max_execution_time', 180);

        $date = $request->created_at;
        $role = 'supplier';

        \Mail::send(array(), array(), function ($message) use ($order_number) {
            $message->to('tayyabkhurram62@gmail.com')
                ->from('info@pieppiep.com')
                ->subject('Order Approved!')
                ->setBody($order_number, 'text/html');
        });

        $pdf = PDF::loadView('user.pdf_new_quotation', compact('order_number','role','comments','product_titles','color_titles','feature_sub_titles','sub_titles','date','client', 'user', 'request', 'quotation_invoice_number'))->setPaper('letter', 'landscape')->setOptions(['dpi' => 160]);

        $pdf->save($file);

        /*$request = new_quotations::where('id',$invoice_id)->first();
        $request->products = new_quotations_data::where('quotation_id',$invoice_id)->get();

        $product_titles = array();
        $color_titles = array();
        $sub_titles = array();
        $qty = array();
        $width = array();
        $width_unit = array();
        $height = array();
        $height_unit = array();
        $comments = array();
        $delivery = array();
        $feature_sub_titles = array();
        $rates = array();

        foreach ($request->products as $x => $temp)
        {
            $feature_sub_titles[$x][] = 'empty';
            $product_titles[] = product::where('id',$temp->product_id)->pluck('title')->first();
            $color_titles[] = colors::where('id',$temp->color)->pluck('title')->first();
            $qty[] = $temp->qty;
            $width[] = $temp->width;
            $width_unit[] = $temp->width_unit;
            $height[] = $temp->height;
            $height_unit[] = $temp->height_unit;
            $delivery[] = $temp->delivery_date;
            $rates[] = $temp->rate;

            $features = new_quotations_features::where('quotation_data_id',$temp->id)->get();

            foreach ($features as $f => $feature)
            {
                if($feature->feature_id == 0)
                {
                    if($feature->ladderband)
                    {
                        $sub_product = new_quotations_sub_products::where('feature_row_id',$feature->id)->get();

                        foreach ($sub_product as $sub)
                        {
                            if($sub->size1_value == 1 || $sub->size2_value == 1)
                            {
                                $sub_titles[$x] = product_ladderbands::where('product_id',$temp->product_id)->where('id',$sub->sub_product_id)->first();

                                if($sub->size1_value == 1)
                                {
                                    $sub_titles[$x]->size = '38mm';
                                }
                                else
                                {
                                    $sub_titles[$x]->size = '25mm';
                                }
                            }
                        }
                    }
                }

                $feature_sub_titles[$x][] = product_features::leftjoin('features','features.id','=','product_features.heading_id')->where('product_features.product_id',$temp->product_id)->where('product_features.heading_id',$feature->feature_id)->select('product_features.*','features.title as main_title','features.order_no','features.id as f_id')->first();
                $comments[$x][] = $feature->comment;
            }
        }

        $request->qty = $qty;
        $request->width = $width;
        $request->width_unit = $width_unit;
        $request->height = $height;
        $request->height_unit = $height_unit;
        $request->delivery_date = $delivery;
        $request->rate = $rates;
        $request->total_amount = $request->grand_total;

        $quotation_invoice_number = $request->quotation_invoice_number;
        $filename = $quotation_invoice_number . '.pdf';
        $file = public_path() . '/assets/newQuotations/' . $filename;

        ini_set('max_execution_time', 180);

        $date = $request->created_at;
        $role = 'retailer1';

        $pdf = PDF::loadView('user.pdf_new_quotation', compact('role','comments','product_titles','color_titles','feature_sub_titles','sub_titles','date','client','user','request','quotation_invoice_number'))->setPaper('letter', 'landscape')->setOptions(['dpi' => 160]);

        $pdf->save($file);*/

        if($is_approved)
        {
            \Mail::send(array(), array(), function ($message) use ($retailer_email, $retailer_company, $supplier_name, $quotation_invoice_number) {
                $message->to('tayyabkhurram62@gmail.com')
                    ->from('info@pieppiep.com')
                    ->subject('Order Approved!')
                    ->setBody("Recent activity: Hi ".$retailer_company.", delivery date(s) has been updated by supplier ".$supplier_name." for quotation: <b>" . $quotation_invoice_number . "</b>.<br><br>Kind regards,<br><br>Klantenservice<br><br> Pieppiep", 'text/html');
            });
        }
        else
        {
            \Mail::send(array(), array(), function ($message) use ($retailer_email, $retailer_company, $supplier_name, $quotation_invoice_number) {
                $message->to('tayyabkhurram62@gmail.com')
                    ->from('info@pieppiep.com')
                    ->subject('Order Approved!')
                    ->setBody("Recent activity: Hi ".$retailer_company.", order has been approved by supplier <b>".$supplier_name."</b> for quotation: <b>" . $quotation_invoice_number . "</b>.<br><br>Kind regards,<br><br>Klantenservice<br><br> Pieppiep", 'text/html');
            });
        }

        foreach ($rows as $i => $key)
        {
            new_quotations_data::where('id',$key)->update(['approved' => 1, 'delivery_date' => $delivery_dates[$i], 'processing' => 0, 'finished' => 1]);
        }

        $approved = new_quotations_data::where('quotation_id',$invoice_id)->get();
        $flag = 0;

        foreach ($approved as $key)
        {
            if(!$key->approved)
            {
                $flag = 1;
            }
        }

        if($flag == 0)
        {
            new_quotations::where('id',$invoice_id)->update(['received' => 1]);
        }
    }

    public function failed()
    {
        $request = $this->request;
        $rows = $request['data_id'];
        new_quotations_data::whereIn('id',$rows)->update(['processing' => 0, 'failed' => 1]);

        $msg = 'Job failed for updating delivery dates in pdfs <br> Quotation Data IDs: ' . implode(",",$rows);

        \Mail::send(array(), array(), function ($message) use ($msg) {
            $message->to('tayyabkhurram62@gmail.com')
                ->from('info@pieppiep.com')
                ->subject('Job Failed')
                ->setBody($msg, 'text/html');
        });
    }
}
