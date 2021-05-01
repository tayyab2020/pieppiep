<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['user_id', 'txnid', 'paid_amount', 'payment_status', 'method', 'charge_id',  'payment_id', 'featured', 'process_time'];
    public $timestamps = false;
}
