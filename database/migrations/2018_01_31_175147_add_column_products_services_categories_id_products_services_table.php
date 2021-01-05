<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnProductsServicesCategoriesIdProductsServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_services', function (Blueprint $table) {
            $table->addColumn('integer', 'category_id')->unsigned()->nullable()->after('status');
            $table->foreign('category_id')->references('id')->on('products_services_categories');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_services', function (Blueprint $table) {
            $table->dropForeign('category_id');
            $table->dropColumn('category_id');
        });
    }
}
