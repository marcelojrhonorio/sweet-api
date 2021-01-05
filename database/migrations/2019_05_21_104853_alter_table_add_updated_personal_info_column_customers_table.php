<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAddUpdatedPersonalInfoColumnCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            
            $table->timestamp('updated_personal_info_at')
                  ->nullable()
                  ->default(null)
                  ->after('secondary_password');  

            $table->timestamp('confirmed_at')
                  ->nullable()
                  ->default(null)
                  ->after('confirmed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'updated_personal_info_at', 
                'confirmed_at'
            ]);
        });
    }
}
