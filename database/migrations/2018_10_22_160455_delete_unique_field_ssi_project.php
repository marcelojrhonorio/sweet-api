<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteUniqueFieldSsiProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('ssi_projects', function ($table) {
            $table->dropUnique('ssi_projects_projectid_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('ssi_projects', function ($table) {
            $table->unique(['projectId']);
        });
    }
}
