<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableForeignKeyTypeStampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stamps', function($table) {
           
            $table->integer('type')
                  ->after('points')
                  ->unsigned()
                  ->nullable();

            $table->foreign('type')
                  ->references('id')
                  ->on('stamp_types');
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
            $table->dropForeign('stamps_type_foreign');
            $table->dropColumn('type');           
            
         });
    }
}
