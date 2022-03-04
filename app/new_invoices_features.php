<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class new_invoices_features extends Model
{
    protected $table = 'new_invoices_features';
    public $timestamps = false;

    public function data()
    {
        return $this->belongsTo(new_invoices_data::class);
    }
}
