<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsiProjectRespondentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ssi_project_respondents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('startUrlId');
            $table->integer('respondentId')->unsigned();
            $table->bigInteger('ssi_project_id')->unsigned();
            $table->integer('status');
            $table->integer('point');
            $table->timestamps();
            $table->foreign('ssi_project_id')
                ->references('id')->on('ssi_projects');
            $table->foreign('respondentId')
                ->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ssi_project_respondent');
    }
}
