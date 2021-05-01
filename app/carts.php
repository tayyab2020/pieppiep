<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class carts extends Model
{



    protected $fillable = ['user_id','handyman_id','service_id','rate_id','rate','booking_date'];
    public $timestamps = false;


}
