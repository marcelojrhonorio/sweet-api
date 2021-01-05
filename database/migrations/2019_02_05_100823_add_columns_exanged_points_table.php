<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsExangedPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_exchanged_points', function (Blueprint $table) {
            $table->string('tracking_code')->nullable()->after('status_id');
            $table->date('delivery_forecast')->nullable()->after('tracking_code');
            $table->string('address')->nullable()->after('delivery_forecast');
            $table->integer('number')->nullable()->after('address');
            $table->string('reference_point')->nullable()->after('number');
            $table->string('neighborhood')->nullable()->after('reference_point');
            $table->string('city')->nullable()->after('neighborhood');
            $table->string('cep')->nullable()->after('city');
            $table->longText('additional_information')->nullable()->after('cep');
            $table->string('complement')->nullable()->after('additional_information');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_exchanged_points', function (Blueprint $table) {
            $table->dropColumn([
                'tracking_code',
                'delivery_forecast', 
                'address',
                'number',
                'reference_point',
                'neighborhood',
                'city',
                'cep',
                'additional_information',
                'complement',
            ]);
        });
    }
}
