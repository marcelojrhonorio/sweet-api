<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTypeActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->unsignedInteger('action_type_id')->after('action_category_id')->default(0);

            $table->foreign('action_type_id')
                ->references('id')
                ->on('action_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // if (Schema::hasColumn('actions', 'action_type_id')) {
        //     Schema::table('actions', function (Blueprint $table) {
        //         $table->dropColumn('action_type');
        //     });
        // }
    }
}
