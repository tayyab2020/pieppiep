<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class colors extends Model
{
    protected $primaryKey = 'id';

    public function product()
    {
        return $this->belongsTo('App\Products');
    }
}
