<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bookings extends Model
{



    protected $fillable = ['user_id','handyman_id', 'is_booked','is_paid','service_id','rate_id','rate','booking_date'];
    public $timestamps = false;


}
