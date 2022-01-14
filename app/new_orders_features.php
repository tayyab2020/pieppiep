<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class new_orders_features extends Model
{
    protected $table = 'new_orders_features';
    public $timestamps = false;

    public function data()
    {
        return $this->belongsTo(new_orders::class);
    }
}
