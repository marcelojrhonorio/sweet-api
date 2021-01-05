<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearchesMiddlePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_RESEARCHES', 'researches_mysql'))->create('researches_middle_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('researches_id')->unsigned();            
            $table->foreign('researches_id')
                ->references('id')->on('researches');
            $table->integer('middle_pages_id')->unsigned();            
            $table->foreign('middle_pages_id')
                ->references('id')->on('middle_pages');
            $table->integer('options_id')->unsigned();            
            $table->foreign('options_id')
                ->references('id')->on('options');
                $table->integer('questions_id')->unsigned();            
            $table->foreign('questions_id')
                ->references('id')->on('questions');
            $table->softDeletes();
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
        Schema::connection(env('DB_CONNECTION_RESEARCHES', 'researches_mysql'))->drop('researches_middle_pages');
    }
}
