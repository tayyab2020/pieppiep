<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class default_features extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id';
}
