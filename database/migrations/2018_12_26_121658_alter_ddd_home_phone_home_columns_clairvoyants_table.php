<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDddHomePhoneHomeColumnsClairvoyantsTable extends Migration
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
        Schema::table('clairvoyants', function (Blueprint $table) {
            $table->string('ddd_home')->nullable()->change();
            $table->string('phone_home')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clairvoyants', function (Blueprint $table) {
            $table->string('ddd_home')->nullable(false)->change();
            $table->string('phone_home')->nullable(false)->change();
        });
    }
}
