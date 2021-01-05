<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerExchangedPointsSmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_exchanged_points_sm', function (Blueprint $table) {
            $table->increments('id');
            $table->string('social_media');
            $table->string('subject');
            $table->string('profile_picture');
            $table->string('profile_link');
            $table->string('status');
            $table->integer('points');

            $table->integer('product_services_id')->unsigned()->nullable();
            $table->integer('customers_id')->unsigned()->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('customers_id')
                ->references('id')->on('customers');
            $table->foreign('product_services_id')
                ->references('id')->on('products_services');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_exchanged_points_sm');
    }
}
