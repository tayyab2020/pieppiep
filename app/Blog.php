<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = ['title', 'details', 'photo', 'source', 'views', 'created_at', 'updated_at', 'status'];
}
