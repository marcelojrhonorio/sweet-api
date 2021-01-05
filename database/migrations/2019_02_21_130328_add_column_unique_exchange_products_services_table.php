<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnUniqueExchangeProductsServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_services', function (Blueprint $table) {
            $table->boolean('unique_exchange')
                ->default(false)
                ->after('path_image');
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
            $table->dropColumn('unique_exchange');
        });
    }
}
