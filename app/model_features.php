<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class model_features extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function model()
    {
        return $this->belongsTo('App\product_models');
    }

}
