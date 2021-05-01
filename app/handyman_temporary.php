<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class handyman_temporary extends Model
{

  protected $table = 'handyman_temporary';

    protected $fillable = ['handyman_id','email','name', 'family_name', 'photo', 'description', 'language', 'education',  'profession', 'city', 'address', 'phone', 'web','special','company_name','registration_number','tax_number','bank_account','postcode'];




}
