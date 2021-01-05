<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmbevCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambev_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('email');
            $table->string('language');
            $table->string('region');
            $table->string('template');
            $table->boolean('fired_email')->default(false);
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
        Schema::dropIfExists('ambev_customers');
    }
}
