<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnsubscribedCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unsubscribed_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customers_id')->unique();
            $table->string('reasons')->nullable();
            $table->string('another_reason_description')->nullable();
            $table->string('suggestion')->nullable();
            $table->enum('final_option', ['delete_account', 'unsubscribe_emails']);

            $table
                ->foreign('customers_id')
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
        Schema::dropIfExists('unsubscribed_customers');
    }
}
