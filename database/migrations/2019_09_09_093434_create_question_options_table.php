<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_RESEARCHES', 'researches_mysql'))->create('question_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('questions_id')->unsigned(); 
            $table->integer('options_id')->unsigned(); 
                                 
            $table->foreign('questions_id')
                ->references('id')->on('questions');
            $table->foreign('options_id')
                ->references('id')->on('options'); 

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
        Schema::connection(env('DB_CONNECTION_RESEARCHES', 'researches_mysql'))->drop('question_options');
    }
}
