<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $fillable = ['category_id','sub_category_id','title','slug','photo','description',/*'estimated_prices'*/'measure'];
    public $timestamps = false;
    protected $dates = ['deleted_at'];


}
