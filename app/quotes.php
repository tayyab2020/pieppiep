<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class quotes extends Model
{
    protected $table = 'quotes';

    public function quotations()
    {
        return $this->hasMany(quotation_invoices::class, 'quote_id');
    }
}
