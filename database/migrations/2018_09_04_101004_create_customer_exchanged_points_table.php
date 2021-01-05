<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerExchangedPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_exchanged_points', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customers_id');
            $table->unsignedInteger('product_services_id');
            $table->unsignedInteger('points');
            $table->timestamps();
            $table->foreign('customers_id')->references('id')->on('customers');
            $table->foreign('product_services_id')->references('id')->on('products_services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_exchanged_points');
    }
}
