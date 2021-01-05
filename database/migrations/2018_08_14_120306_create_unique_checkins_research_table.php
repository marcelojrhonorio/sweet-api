<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniqueCheckinsResearchTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::table('checkin_researches', function ($table) {
            $table->unique(['customers_id', 'researches_id']);
        });
    }
    
    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::table('checkin_researches', function ($table) {
            $table->dropUnique('checkin_researches_customers_id_researches_id_unique');
        });
        
    }
}
