<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertise extends Model
{
    protected $fillable = ['type','script','photo','url','size','clicks','status'];
    public $timestamps = false;
}
