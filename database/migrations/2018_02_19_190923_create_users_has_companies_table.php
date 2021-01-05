<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersHasCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_has_companies', function (Blueprint $table) {

            $table->integer('users_id')->unsigned()->nullable();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('companies_id')->unsigned()->nullable();
            $table->foreign('companies_id')->references('id')->on('companies')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_has_companies');
    }
}
