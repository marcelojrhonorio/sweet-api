<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClairvoyantSignaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clairvoyants', function(Blueprint $table){
            $table->increments('id');
            $table->string('first_name');
            $table->string('email_address');
            $table->string('ddd_home');
            $table->string('phone_home');
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
        Schema::dropIfExists('clairvoyants');
    }
}
