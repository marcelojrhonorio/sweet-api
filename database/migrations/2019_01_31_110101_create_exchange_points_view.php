<?php

use Illuminate\Database\Migrations\Migration;

class CreateExchangePointsView extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::connection(env('DB_CONNECTION', 'mysql'))
            ->statement("CREATE VIEW v_exchanged_points as
                        select
                            cep.id,
                            c.id as 'customer_id',
                            c.fullname as 'fullname',
                            c.email as 'email',
                            ps.title as 'product',
                            ps.points as 'points',
                            cep.status_id as 'status',
                            cep.created_at as 'created_at',
                            cep.updated_at as 'updated_at'
                        from
                            customers c
                        inner join customer_exchanged_points cep ON
                            c.id = cep.customers_id
                        inner join products_services ps ON
                            cep.product_services_id = ps.id");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::connection(env('DB_CONNECTION', 'mysql'))->statement('DROP VIEW v_exchanged_points');
    }
}
