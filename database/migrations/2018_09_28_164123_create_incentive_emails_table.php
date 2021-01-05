<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncentiveEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incentive_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 30);
            $table->string('description', 60)->nullable();
            $table->integer('points')->unsigned();
            $table->string('redirect_link', 60);
            
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
        Schema::dropIfExists('incentive_emails');
    }
}
