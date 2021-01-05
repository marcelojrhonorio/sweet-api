<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersEmailForwardingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_forwarding', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customers_id')->unsigned()->nullable();
            $table->integer('email_forwarding_id')->unsigned()->nullable();            
            $table->integer('won_points')->unsigned()->nullable();

            $table->foreign('email_forwarding_id')->references('id')->on('email_forwarding');            
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
        Schema::dropIfExists('customers_forwarding');
    }
}
