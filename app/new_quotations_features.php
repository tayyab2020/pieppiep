<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class new_quotations_features extends Model
{
    protected $table = 'new_quotations_features';
    public $timestamps = false;

    public function data()
    {
        return $this->belongsTo(new_quotations_data::class);
    }

    /*public function sub_products()
    {
        return $this->hasMany(new_quotations_sub_products::class, 'feature_row_id','id');
    }*/
}
