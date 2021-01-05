<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppAllowedCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_allowed_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customers_id')->unsigned()->unique();
            $table->dateTime('access_expired_at');
            $table->foreign('customers_id')
                ->references('id')->on('customers');
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
        Schema::dropIfExists('app_allowed_customers');
    }
}
