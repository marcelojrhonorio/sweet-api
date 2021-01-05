<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterFinalSocialClassTable extends Migration
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
        Schema::connection(env('DB_CONNECTION_SOCIAL_CLASS', 'social_class_mysql'))->table('final_social_class', function (Blueprint $table) {
            $table->integer('final_points')->nullable(true)->change();
            $table->string('final_class_by_income')->nullable(true)->change();
            $table->string('final_class_by_questions')->nullable(true)->change();
            $table->unique('customers_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('DB_CONNECTION_SOCIAL_CLASS', 'social_class_mysql'))->table('final_social_class', function (Blueprint $table) {
            $table->integer('final_points')->nullable(false)->change();
            $table->string('final_class_by_income')->nullable(false)->change();
            $table->string('final_class_by_questions')->nullable(false)->change();
            // $table->dropUnique('customers_id');
        });
    }
}
