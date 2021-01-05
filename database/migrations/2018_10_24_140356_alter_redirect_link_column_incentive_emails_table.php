<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRedirectLinkColumnIncentiveEmailsTable extends Migration
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
        Schema::table('incentive_emails', function (Blueprint $table) {
            $table->string('redirect_link', 255)->change();
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incentive_emails', function (Blueprint $table) {
            $table->string('redirect_link', 60)->change();
        });         
    }
}
