<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppValidatedIndicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_validated_indications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customers_id')->unsigned()->nullable();    
            $table->integer('indicated_id')->unsigned()->nullable();    
            $table->integer('points')->nullable();

            $table->foreign('customers_id')->references('id')->on('customers');
            $table->foreign('indicated_id')->references('id')->on('customers');
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
        Schema::dropIfExists('app_validated_indications');
    }
}
