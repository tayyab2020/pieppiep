<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class attributes_options extends Model
{
    public $timestamps = false;

    public function attributes()
    {
    	return $this->hasMany('App\attributes');

    }


}