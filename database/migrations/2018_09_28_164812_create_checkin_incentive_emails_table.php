<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckinIncentiveEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkin_incentive_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('incentive_emails_id')->unsigned();
            $table->integer('customers_id')->unsigned();
            $table->integer('points')->unsigned();

            $table->index(['customers_id', 'incentive_emails_id']);

            $table->foreign('incentive_emails_id')
                ->references('id')
                ->on('incentive_emails')
                ->onDelete('cascade');

            $table->foreign('customers_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');

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
        Schema::dropIfExists('checkin_incentive_emails');
    }
}
