<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoice_item extends Model
{
   protected $primaryKey = 'id';
	public $incrementing = false;
	public $timestamps = false;
}
