<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class vats extends Model
{

    use SoftDeletes;
    public $timestamps = false;
    protected $dates = ['deleted_at'];


}
