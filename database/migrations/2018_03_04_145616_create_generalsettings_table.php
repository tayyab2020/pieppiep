<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralsettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generalsettings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logo')->nullable();
            $table->string('title');
            $table->string('bg_title');
            $table->string('bg_link');
            $table->string('bgimg')->nullable();
            $table->string('bg_text');
            $table->text('about');
            $table->text('street');
            $table->text('phone');
            $table->text('fax');
            $table->text('email');
            $table->text('footer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generalsettings');
    }
}
