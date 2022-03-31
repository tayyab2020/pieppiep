<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    protected $table = 'brands';
    protected $fillable = ['user_id','other_suppliers','cat_name','cat_slug','photo','description','trademark'];
    public $timestamps = false;
    protected $dates = ['deleted_at'];
}
