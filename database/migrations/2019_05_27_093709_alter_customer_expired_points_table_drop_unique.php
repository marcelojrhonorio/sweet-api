<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCustomerExpiredPointsTableDropUnique extends Migration
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
        Schema::table('customer_expired_points', function (Blueprint $table) {
            $table->dropForeign('customer_expired_points_customers_id_foreign');
            $table->dropUnique('customer_expired_points_customers_id_unique');
            
            $table
                ->foreign('customers_id')
                ->references('id')
                ->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_expired_points', function (Blueprint $table) {
            $table->unique('customers_id');
        });
    }
}
