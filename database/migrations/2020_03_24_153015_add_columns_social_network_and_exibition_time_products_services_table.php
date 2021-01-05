<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsSocialNetworkAndExibitionTimeProductsServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_services', function (Blueprint $table) {
            $table->integer('exibition_time')->after('path_image')->nullable()->unsigned();
            $table->string('social_network')->after('exibition_time')->nullable();
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
            $table->dropColumn(['social_network', 'exibition_time']);
        });
    }
}
