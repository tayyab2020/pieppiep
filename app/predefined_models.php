<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Category;

class predefined_models extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';
}
