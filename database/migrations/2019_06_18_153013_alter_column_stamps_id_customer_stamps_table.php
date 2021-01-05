<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnStampsIdCustomerStampsTable extends Migration
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
        Schema::table('customer_stamps', function (Blueprint $table) {
            
            $table->unique(['stamps_id', 'customers_id'])->change();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_stamps', function ($table) {

            $table->dropForeign('customer_stamps_stamps_id_foreign');
            $table->dropForeign('customer_stamps_customers_id_foreign');            
            $table->dropUnique('customer_stamps_stamps_id_customers_id_unique');
            
            $table->foreign('stamps_id')
                  ->references('id')
                  ->on('stamps');

            $table->foreign('customers_id')
                  ->references('id')
                  ->on('customers');
        });
    }
}
