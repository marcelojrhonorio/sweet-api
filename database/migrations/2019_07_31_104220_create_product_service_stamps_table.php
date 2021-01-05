<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductServiceStampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_service_stamps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stamps_id')->unsigned();
            $table->integer('product_id')->unsigned();

            $table->foreign('stamps_id')->references('id')->on('stamps');
            $table->foreign('product_id')->references('id')->on('products_services');

            $table->unique(['stamps_id', 'product_id']);
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
        Schema::dropIfExists('product_service_stamps');
    }
}
