<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class new_quotations extends Model
{
    protected $table = 'new_quotations';

    public function data()
    {
        return $this->hasMany(new_quotations_data::class, 'quotation_id','id');
    }

}
