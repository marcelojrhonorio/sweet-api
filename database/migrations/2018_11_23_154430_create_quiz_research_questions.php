<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizResearchQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_QUIZ', 'quiz_mysql'))->create('research_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('description');
            $table->boolean('one_answer');
            $table->string('extra_information')->nullable();
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
        Schema::connection(env('DB_CONNECTION_QUIZ', 'quiz_mysql'))->drop('research_questions');
    }
}
