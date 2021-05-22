<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_features extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function heading()
    {
        return $this->belongsTo('App\features');
    }
}
