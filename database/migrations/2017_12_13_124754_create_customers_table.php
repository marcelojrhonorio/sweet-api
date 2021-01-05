<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname', 60);
            $table->string('email', 40)->unique();
            $table->enum('gender', ['M', 'F', ''])->default('');
            $table->date('birthdate');
            $table->time('birthtime');
            $table->string('city', 50);
            $table->string('cpf', 11);
            $table->string('token', 100)->nullable();
            $table->string('phone_number', 14);
            $table->string('source', 50);
            $table->string('medium', 50);
            $table->string('campaign', 50);
            $table->string('term', 50);
            $table->string('content', 50);
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
        Schema::dropIfExists('customers');
    }
}
