<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id','title','slug','photo','description','estimated_prices','measure'];
    public $timestamps = false;
    protected $dates = ['deleted_at'];


}
