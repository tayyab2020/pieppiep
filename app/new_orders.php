<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class new_orders extends Model
{
    protected $table = 'new_orders';

    public function features()
    {
        return $this->hasMany(new_orders_features::class, 'order_data_id','id')->where('new_orders_features.sub_feature',0);
    }

    public function sub_features()
    {
        return $this->hasMany(new_orders_features::class, 'order_data_id','id')->where('new_orders_features.sub_feature',1);
    }

}
