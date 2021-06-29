<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sub_products extends Model
{
    protected $primaryKey = 'id';

    public function sub_products()
    {
        return $this->hasMany('App\product_sub_products','heading_id','id');
    }
}
