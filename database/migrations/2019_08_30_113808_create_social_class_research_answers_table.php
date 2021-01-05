<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialClassResearchAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_SOCIAL_CLASS', 'social_class_mysql'))->create('research_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customers_id')->unsigned();
            $table->bigInteger('question_id')->unsigned();
            $table->bigInteger('option_id')->unsigned();

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
        Schema::connection(env('DB_CONNECTION_SOCIAL_CLASS', 'social_class_mysql'))->drop('research_answers');
    }
}
