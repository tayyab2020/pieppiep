<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class terms_conditions extends Model {

    protected $table = 'terms_conditions';

     protected $fillable = ['role', 'file'];
    
}