<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagesettings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contact_success'); 
            $table->string('contact_email'); 
            $table->string('contact_title');
            $table->text('contact_text');
            $table->string('about');
            $table->string('faq');
            $table->tinyInteger('c_status')->default(1);
            $table->tinyInteger('a_status')->default(1);
            $table->tinyInteger('f_status')->default(1);         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagesettings');
    }
}
