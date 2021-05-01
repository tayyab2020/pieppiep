<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class colors extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
}
