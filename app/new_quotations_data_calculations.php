<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class new_quotations_data_calculations extends Model
{
    protected $table = 'new_quotations_data_calculations';
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(new_quotations_data::class);
    }

}
