<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfoprodutoResearchAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_INFOPRODUTO', 'infoproduto_mysql'))->create('research_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('research_id');
            $table->bigInteger('question_id')->unsigned();
            $table->bigInteger('option_id')->unsigned();
            $table->string('answer_string')->nullable();

            $table->foreign('question_id')
                ->references('id')->on('research_questions');
            $table->foreign('option_id')
                ->references('id')->on('research_options');
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
        Schema::connection(env('DB_CONNECTION_INFOPRODUTO', 'infoproduto_mysql'))->drop('research_answers');
    }
}
