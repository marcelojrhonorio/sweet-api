<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearcheQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_RESEARCHES', 'researches_mysql'))->create('researche_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('researches_id')->unsigned(); 
            $table->integer('questions_id')->unsigned(); 
            $table->integer('ordering')->unsigned()->nullable();  

            $table->foreign('researches_id')
                ->references('id')->on('researches');                      
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
        Schema::connection(env('DB_CONNECTION_RESEARCHES', 'researches_mysql'))->drop('researche_questions');
    }
}
