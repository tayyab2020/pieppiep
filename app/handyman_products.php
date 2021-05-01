<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class handyman_products extends Model
{
    protected $fillable = ['handyman_id','service_id','rate','model_number'];
    public $timestamps = false;


}
