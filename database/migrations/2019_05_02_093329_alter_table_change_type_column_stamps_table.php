<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableChangeTypeColumnStampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stamps', function($table) {
            $table->dropColumn('type');            
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
            
            $table->enum('type', [
                'email', 
                'incentive_email',
                'action',
                'member_get_member'
                
            ])->nullable()
              ->after('points');
         });
    }
}
