<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerResearchAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql'))->create('customer_research_answers', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->nullable(false);
            $table->boolean('customer_research_answer_has_insurance')->unsigned();
            $table->integer('customer_research_answer_status_sicronized')->default(0);
            $table->bigInteger('customer_research_id')->unsigned();
            $table->integer('insurance_company_id')->nullable()->unsigned();
            $table->date('customer_research_answer_date_insurace_at');
            $table->bigInteger('model_year_id')->unsigned();
            $table->foreign('model_year_id')
                ->references('id')->on('model_years');
            $table->foreign('insurance_company_id')
                ->references('id')->on('insurance_companys');
            $table->foreign('customer_research_id')
                ->references('id')->on('customer_researches');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('DB_CONNECTION_SEGURO', 'seguro_auto_mysql'))->drop('customer_research_answers');
    }
}
