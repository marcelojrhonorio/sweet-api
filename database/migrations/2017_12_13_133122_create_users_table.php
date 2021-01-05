<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname', 60);
            $table->string('email', 40)->unique();
            $table->string('password', 50);
            $table->string('api_key', 80);
            $table->boolean('active');
            $table->integer('access_groups_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('access_groups_id')->references('id')->on('access_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
