<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Category;

class default_predefined_models extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';

    public function getCategoriesAttribute()
    {
        $ids = $this->getOriginal('category_ids');
        return Category::whereIn('id', explode(',', $ids))->get();
    }
}
