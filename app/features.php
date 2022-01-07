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

    public function feature_details()
    {
        return $this->hasMany('App\features_details','feature_id','id')->where('features_details.sub_feature',0);
    }

    public function sub_features()
    {
        return $this->hasMany('App\features_details','feature_id','id')->where('features_details.sub_feature',1);
    }
}
