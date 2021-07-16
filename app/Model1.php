<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model1 extends Model
{
    use SoftDeletes;
    protected $table = 'models';
    protected $fillable = ['user_id','brand_id','cat_name','cat_slug','photo','description'];
    public $timestamps = false;
    protected $dates = ['deleted_at'];


}
