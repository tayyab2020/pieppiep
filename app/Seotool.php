<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seotool extends Model
{
    protected $fillable = ['google_analytics','meta_keys'];
    public $timestamps = false;
}
