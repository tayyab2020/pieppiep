<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sociallink extends Model
{
    protected $fillable = ['admin_email','facebook', 'twitter', 'gplus', 'linkedin', 'f_status', 't_status', 'g_status', 'l_status','ins','rat','pr','ey'];
    public $timestamps = false;
}
