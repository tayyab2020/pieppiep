<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    protected $table = 'brands';
    protected $fillable = ['cat_name','cat_slug','photo','description'];
    public $timestamps = false;
    protected $dates = ['deleted_at'];


}
