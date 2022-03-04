<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class new_invoices extends Model
{
    protected $table = 'new_invoices';

    public function data()
    {
        return $this->hasMany(new_invoices_data::class,'invoice_id','id');
    }

}
