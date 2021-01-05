<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCustomersIdColumnResearcheAnswersTable extends Migration
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
        Schema::connection(env('DB_CONNECTION_RESEARCHES', 'researches_mysql'))->table('researche_answers', function (Blueprint $table) {
            $table->string('customers_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('DB_CONNECTION_RESEARCHES', 'researches_mysql'))->table('researche_answers', function (Blueprint $table) {
            $table->integer('customers_id')->change();
        });
    }
}
