<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOrderAndEnableOnRelationshipRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('relationship_rules', function (Blueprint $table) {
            $table->integer('order')->nullable()->after('html_message');
            $table->boolean('enabled')->default(true)->after('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relationship_rules', function (Blueprint $table) {
            $table->dropColumn(['order', 'enabled']);
        });
    }
}
