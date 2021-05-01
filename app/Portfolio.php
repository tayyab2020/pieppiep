<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = ['review','client','designation','photo'];
    public $timestamps = false;
}
