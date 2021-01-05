<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerExpiredPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_expired_points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customers_id')->unsigned()->unique();
            $table->integer('expired_points')->default(0);
            $table->integer('previous_balance')->default(0);
            $table->integer('balance_after')->default(0);
            $table->integer('expired_points_divergence')->default(0);
            $table->integer('points_balance_divergence')->default(0);

            $table->foreign('customers_id')
                ->references('id')
                ->on('customers');

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
        Schema::dropIfExists('customer_expired_points');
    }
}
