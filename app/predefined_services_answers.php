<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class predefined_services_answers extends Model
{

    protected  $table = 'predefined_services_answers';
    public $timestamps = false;

    public function question(){
        return $this->belongsTo('App\quotation_services_questions');
    }

}
