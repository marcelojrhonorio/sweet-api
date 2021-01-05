<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDescriptionColumnActionsTable extends Migration
{
    public function __construct()
    {
        /**
         * Fix to Doctrine `ENUM` support.
         * @see https://stackoverflow.com/a/42107554
         */
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->text('description')->change(); 
        });         
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->string('description')->change(); 
        });   
    }
}
