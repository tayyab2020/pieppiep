<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sub_categories extends Model
{
	use SoftDeletes;
    public $timestamps = false;
    protected $dates = ['deleted_at'];
    protected $table = 'categories';

    public function newQuery($excludeDeleted = true) {
        return parent::newQuery($excludeDeleted)
            ->where('parent_id','!=', 0);
    }

    public function main_category()
    {
        return $this->belongsTo('App\Category','parent_id','id');
    }

}
