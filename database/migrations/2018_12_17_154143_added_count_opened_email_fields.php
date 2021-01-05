<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedCountOpenedEmailFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('ssi_project_respondents',function(Blueprint $table){
            $table->integer('count_opened_email')->nullable()->after('point')->default(0);
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
        Schema::table('ssi_project_respondents',function(Blueprint $table){
            $table->dropColumn(['count_opened_email']);
        });
    }
}
