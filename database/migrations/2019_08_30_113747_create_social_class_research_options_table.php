<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialClassResearchOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_SOCIAL_CLASS', 'social_class_mysql'))->create('research_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('question_id')->unsigned();
            $table->string('description');
            $table->integer('points')->unsigned();
            
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
        Schema::connection(env('DB_CONNECTION_SOCIAL_CLASS', 'social_class_mysql'))->drop('research_options');
    }
}
