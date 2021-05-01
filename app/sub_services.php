<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sub_services extends Model
{
    protected $fillable = ['cat_id','sub_id'];
    public $timestamps = false;


}