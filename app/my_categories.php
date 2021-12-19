<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class my_categories extends Model
{
	use SoftDeletes;
    protected $fillable = ['user_id','cat_name','cat_slug','photo','description'];
    public $timestamps = false;
    protected $dates = ['deleted_at'];

    public function users()
    {
    	return $this->hasMany('App\User');

    }


}
