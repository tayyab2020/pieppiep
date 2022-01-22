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

    public function images()
    {
        return $this->hasMany(color_images::class, 'color_id','id');
    }
}
