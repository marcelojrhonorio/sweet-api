<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableDropColumnDeletedAtResearchAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {       
        Schema::connection(env('DB_CONNECTION_RESEARCHES', 'researches_mysql'))->table('researche_answers', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(env('DB_CONNECTION_RESEARCHES', 'researches_mysql'))->table('researche_answers', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
}
