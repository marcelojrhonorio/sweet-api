<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnBirthdateClairvoyantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clairvoyants', function (Blueprint $table) {
            $table->date('birthdate')->nullable()->after('gender');
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
            $table->dropColumn('birthdate');
        });  
    }
}
