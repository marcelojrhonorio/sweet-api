<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDateInsuranceCollumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::connection(env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql'))->table('customer_research_answers', function ($table) {
            $table->string('customer_research_answer_date_insurace_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::connection(env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql'))->table('customer_research_answers', function ($table) {
            $table->date('customer_research_answer_date_insurace_at')->nullable(false)->change();
        });
    }
}
