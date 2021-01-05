<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelatioshipRuleCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relationship_rule_customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('customer_id')->unsigned();
            $table->bigInteger('relationship_rule_id')->unsigned();
            $table->timestamps();
            $table->foreign('customer_id')
                ->references('id')->on('customers');
            $table->foreign('relationship_rule_id')
                ->references('id')->on('relationship_rules');
            $table->unique(['customer_id','relationship_rule_id'],'idx_unique_customer_rule');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relationship_rule_customers');
    }
}
