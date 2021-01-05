<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnGenderClairvoyantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clairvoyants', function (Blueprint $table) {
            $table->string('gender', 1)->nullable()->after('email_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clairvoyants', function (Blueprint $table) {
            $table->dropColumn('gender');
        });        
    }
}
