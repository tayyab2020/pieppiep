<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class features extends Model
{
    protected $primaryKey = 'id';

    public function features()
    {
        return $this->hasMany('App\product_features','heading_id','id');
    }
}
