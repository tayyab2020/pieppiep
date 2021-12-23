<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class features extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';

    public function features()
    {
        return $this->hasMany('App\product_features','heading_id','id');
    }
}
