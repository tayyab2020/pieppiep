<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class new_quotations_sub_products extends Model
{
    protected $table = 'new_quotations_sub_products';
    public $timestamps = false;

    /*public function feature_row()
    {
        return $this->belongsTo(new_quotations_features::class);
    }*/
}
