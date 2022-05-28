<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $fillable = ['category_id','sub_category_ids','title','slug','photo','description',/*'estimated_prices'*/'measure','show_vloerofferte'];
    public $timestamps = false;
    protected $dates = ['deleted_at'];


}
