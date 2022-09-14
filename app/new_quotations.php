<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class new_quotations extends Model
{
    protected $table = 'new_quotations';

    public function data()
    {
        return $this->hasMany(new_quotations_data::class, 'quotation_id','id');
    }

    public function orders()
    {
        return $this->hasMany(new_orders::class, 'quotation_id','id')->leftjoin("users","users.id","=","new_orders.supplier_id")->select("new_orders.*","users.company_name");
    }

    public function invoices()
    {
        return $this->hasMany(new_invoices::class, 'quotation_id','id');
    }

    public function unseen_messages()
    {
        return $this->hasMany(client_quotation_msgs::class, 'quotation_id','id')->where("seen",0);
    }

}
