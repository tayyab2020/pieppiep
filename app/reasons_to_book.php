<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reasons_to_book extends Model
{
	protected $table = 'reasons_to_book';
    protected $fillable = ['heading1','heading2', 'heading3', 'desc1', 'desc2', 'desc3', 'dh1', 'dh2', 'dh3', 'dd1', 'dd2', 'dd3'];
   
}