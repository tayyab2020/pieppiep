<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagesetting extends Model
{
    protected $fillable = ['contact_success', 'contact_email', 'contact_title', 'contact_text', 'about', 'faq', 'c_status', 'a_status', 'f_status'];

    public $timestamps = false;
}
