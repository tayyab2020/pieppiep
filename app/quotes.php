<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class quotes extends Model
{
    protected $table = 'quotes';

    public function quotations()
    {
        return $this->hasMany(new_quotations::class, 'quote_request_id');
    }

    public function dimensions()
    {
        return $this->hasMany(quote_dimensions::class, 'quote_id','id');
    }
}
