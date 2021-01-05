<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsiProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ssi_projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('contactMethodId');
            $table->integer('projectId')->unique();
            $table->string('startUrlHead');
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
        Schema::dropIfExists('ssi_projects');
    }
}
