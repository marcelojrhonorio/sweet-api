<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersLoginPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_login_points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customers_id')->unsigned()->nullable();    
            $table->integer('total_logins')->nullable();
            $table->timestamp('last_customer_login_points_at')->nullable();

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
        Schema::dropIfExists('customers_login_points');
    }
}
