<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSociallinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sociallinks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('facebook'); 
            $table->string('gplus'); 
            $table->string('twitter');
            $table->string('linkedin');
            $table->tinyInteger('f_status')->default(1);
            $table->tinyInteger('g_status')->default(1);
            $table->tinyInteger('t_status')->default(1);
            $table->tinyInteger('l_status')->default(1);      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sociallinks');
    }
}
