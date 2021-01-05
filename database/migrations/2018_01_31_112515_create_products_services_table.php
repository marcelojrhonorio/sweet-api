<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 150);
            $table->string('description',255);
            $table->string('path_image', 255)->nullable();
            $table->integer('points');
            $table->boolean('status')->default(1);
            $table->integer('user_id_created');
            $table->integer('user_id_updated');
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
        Schema::dropIfExists('products_services');
    }
}
