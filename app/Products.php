<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    protected $fillable = ['excel_id','title','slug','model_number','size','measure','estimated_price','additional_info','floor_type','floor_type2','supplier','color','category_id','brand_id','model_id','photo','description'];
    public $timestamps = false;
    protected $dates = ['deleted_at'];


}
