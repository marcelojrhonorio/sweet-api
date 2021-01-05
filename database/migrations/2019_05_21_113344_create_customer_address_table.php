<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_address', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customers_id')->unique();
            $table->string('cep')->nullable();
            $table->string('street')->nullable();
            $table->string('neighborhood')->nullable();
            $table->integer('number')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('reference_point')->nullable();
            $table->timestamps();

            $table
                ->foreign('customers_id')
                ->references('id')
                ->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_address');
    }
}
