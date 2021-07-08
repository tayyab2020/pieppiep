<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class new_quotations_data extends Model
{
    protected $table = 'new_quotations_data';
    public $timestamps = false;

    public function features()
    {
        return $this->hasMany(new_quotations_features::class, 'quotation_data_id','id');
    }

}
