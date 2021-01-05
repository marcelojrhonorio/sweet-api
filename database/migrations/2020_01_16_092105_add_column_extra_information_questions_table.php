<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnExtraInformationQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_RESEARCHES', 'researches_mysql'))->table('questions', function (Blueprint $table) {
            $table->string('extra_information')->after('one_answer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('DB_CONNECTION_RESEARCHES', 'researches_mysql'))->table('questions', function (Blueprint $table) {
            $table->dropColumn('extra_information');
        });
    }
}
