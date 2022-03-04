<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class new_invoices_data_calculations extends Model
{
    protected $table = 'new_invoices_data_calculations';
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(new_invoices_data::class);
    }

}
