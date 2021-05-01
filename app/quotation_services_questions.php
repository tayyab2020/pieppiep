<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class quotation_services_questions extends Model
{

    protected  $table = 'quotation_services_questions';


    public function answers(){
        return $this->hasMany('App\predefined_services_answers','question_id','id');
    }

    public function services(){
        return $this->hasMany('App\question_services1','question_id','id');
    }

}
