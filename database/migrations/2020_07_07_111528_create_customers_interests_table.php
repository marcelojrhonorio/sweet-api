<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_interests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('interest_types_id')->unsigned()->nullable(); 
            $table->integer('customers_id')->unsigned()->nullable();           
            $table->string('interest')->nullable();

            $table->foreign('interest_types_id')->references('id')->on('interest_types');
            $table->foreign('customers_id')->references('id')->on('customers');

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
        Schema::dropIfExists('customers_interests');
    }
}
