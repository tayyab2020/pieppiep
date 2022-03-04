<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class new_invoices_data extends Model
{
    protected $table = 'new_invoices_data';
    public $timestamps = false;

    public function features()
    {
        return $this->hasMany(new_invoices_features::class, 'invoice_data_id','id')->where('new_invoices_features.sub_feature',0);
    }

    public function sub_features()
    {
        return $this->hasMany(new_invoices_features::class, 'invoice_data_id','id')->where('new_invoices_features.sub_feature',1);
    }

    public function calculations()
    {
        return $this->hasMany(new_invoices_data_calculations::class, 'invoice_data_id','id');
    }

    public function invoice()
    {
        return $this->belongsTo(new_invoices::class);
    }

}
