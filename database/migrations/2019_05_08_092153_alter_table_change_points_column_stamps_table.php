<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableChangePointsColumnStampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stamps', function($table) {
            $table->dropColumn('points');            
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stamps', function($table) {

            $table->integer('points')
                  ->nullable()
                  ->after('icon');
         });
    }
}
