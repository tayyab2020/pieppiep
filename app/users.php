<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class users extends Model
{



    protected $fillable = ['name', 'family_name','category_id','role_id', 'photo', 'description', 'language', 'age', 'education', 'residency', 'profession', 'city', 'address', 'phone', 'fax', 'email','f_url','g_url','t_url','l_url','password','is_featured','status','active','featured','web','special','postcode','business_name','company_name','registration_number','tax_number','bank_account','mollie_customer_id','mollie_method'];

}
