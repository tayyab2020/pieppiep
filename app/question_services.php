<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class question_services extends Model
{

    protected  $table = 'question_services';
    public $timestamps = false;

    public function question(){
        return $this->belongsTo('App\quotation_questions');
    }
}
