<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Generalsetting extends Model
{
    protected $fillable = ['logo', 'backend', 'favicon', 'title', 'site', 'bgimg', 'about', 'street', 'phone', 'fax', 'email', 'footer','footer_bg','footer_tx','menu_tx','menu_mobile_tx','btn_bg','btn_col','btn_brd','form_bg','form_col','form_ic','as_bg', 'bg_link','bg_title','bg_text','np','fp','pb','sk','ss','colors','map_key','bimg','loader','mollie','service_fee','registration_fee','commission_percentage','min_amount','vat','h_dashbg','c_dashbg','h_sidebg','c_sidebg'];

    public $timestamps = false;
}
