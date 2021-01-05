<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizResearchOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_QUIZ', 'quiz_mysql'))->create('research_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('question_id')->unsigned();
            $table->string('description');
            $table->string('redirect_link')->nullable();
            $table->string('redirect_message')->nullable();
            $table->string('redirect_image')->nullable();
            $table->foreign('question_id')
                ->references('id')->on('research_questions');
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
        Schema::connection(env('DB_CONNECTION_QUIZ', 'quiz_mysql'))->drop('research_options');
    }
}
