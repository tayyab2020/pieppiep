<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_models extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function features()
    {
        return $this->hasMany('App\model_features','model_id','id');
    }
}
