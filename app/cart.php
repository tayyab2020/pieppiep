<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
   protected $primaryKey = 'id';
	public $incrementing = false;
	public $timestamps = false;
}
