<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $fillable = ['order_id', 'status'];
    public $timestamps = false;

  
}