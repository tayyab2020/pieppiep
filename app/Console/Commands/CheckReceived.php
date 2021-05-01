<?php

namespace App\Console\Commands;

use App\custom_quotations;
use App\quotation_invoices;
use Illuminate\Console\Command;
use DateTime;

class CheckReceived extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-received:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking delivered invoices and mark them received if more than 7 days.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $quotation_invoices = quotation_invoices::where('delivered',1)->where('received',0)->get();

        foreach ($quotation_invoices as $key)
        {
            $delivered_date = $key->delivered_date;
            $now = date('d-m-Y H:i:s');

            $datetime1 = new DateTime($delivered_date);
            $datetime2 = new DateTime($now);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');

            if($days >= 7)
            {
                $key->received = 1;
                $key->received_date = $now;
                $key->save();
            }
        }

        $custom_quotation_invoices = custom_quotations::where('delivered',1)->where('received',0)->get();

        foreach ($custom_quotation_invoices as $key)
        {
            $delivered_date = $key->delivered_date;
            $now = date('d-m-Y H:i:s');

            $datetime1 = new DateTime($delivered_date);
            $datetime2 = new DateTime($now);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');

            if($days >= 7)
            {
                $key->received = 1;
                $key->received_date = $now;
                $key->save();
            }
        }


        \Log::info("Cron Job is working fine!");
    }
}
