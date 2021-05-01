<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('bloodgroup_id');
            $table->string('photo');
            $table->text('description')->nullable();
            $table->string('language');
            $table->integer('age');
            $table->string('education');
            $table->string('residency');
            $table->string('profession');
            $table->string('city');
            $table->string('address');
            $table->string('phone')->unique();
            $table->string('fax');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donors');
    }
}
