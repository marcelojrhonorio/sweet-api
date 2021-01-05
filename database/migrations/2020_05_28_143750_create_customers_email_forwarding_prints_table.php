<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersEmailForwardingPrintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_forwarding_prints', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customers_forwarding_id')->unsigned()->nullable();            
            $table->string('image')->nullable();

            $table->foreign('customers_forwarding_id')->references('id')->on('customers_forwarding');            
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
        Schema::dropIfExists('customers_forwarding_prints');
    }
}
