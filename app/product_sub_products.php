<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_sub_products extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function sub_heading()
    {
        return $this->belongsTo('App\sub_products');
    }
}
