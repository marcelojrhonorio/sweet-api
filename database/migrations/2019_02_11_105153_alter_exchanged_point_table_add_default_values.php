<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterExchangedPointTableAddDefaultValues extends Migration
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
        Schema::table('customer_exchanged_points', function (Blueprint $table) {
            $table->string('address')->default('default')->change();
            $table->string('reference_point')->default('default')->change();
            $table->string('neighborhood')->default('default')->change();
            $table->string('city')->default('default')->change();
            $table->string('cep')->default('default')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_exchanged_points', function (Blueprint $table) {
            $table->string('address')->default(null)->change();
            $table->string('reference_point')->default(null)->change();
            $table->string('neighborhood')->default(null)->change();
            $table->string('city')->default(null)->change();
            $table->string('cep')->default(null)->change();        
        });
    }
}
