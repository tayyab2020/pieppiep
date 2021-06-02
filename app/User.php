<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{

    use HasRoles;
    use SoftDeletes;
    protected $guard_name = 'user';

    protected $fillable = ['name', 'family_name','category_id','role_id', 'photo', 'description','experience_years','insurance','insurance_pod', 'language', 'age', 'education', 'residency', 'profession', 'city', 'address', 'phone', 'fax', 'email','f_url','g_url','t_url','l_url','password','is_featured','status','active','featured','web','special','postcode','business_name','company_name','registration_number','tax_number','bank_account','mollie_customer_id','mollie_method'];

    protected $hidden = [
        'password'
    ];

    protected $remember_token = false;


    public function category()
    {
    	return $this->belongsTo('App\Category');
    }
}
