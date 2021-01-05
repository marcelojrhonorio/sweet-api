<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerRegisterDivergences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_register_divergences', function (Blueprint $table) {
            $table->integer('customers_id')->unsigned();
            $table->boolean('invalid_cep')->default(false);
            //$table->boolean('invalid_ddd')->default(false);
            $table->foreign('customers_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('customer_register_divergences');
    }
}
