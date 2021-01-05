<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (env('APP_ENV') === 'production') {
            exit('Não permitido em ambiente de producao.');
        }

        $this->call([
            AccessGroupsSeeder::class,
            MenusSeeder::class,
            MenusAccessGroupsSeeder::class,
            UsersAdminSeeder::class,
            CustomersSeeder::class,
            CompaniesSeeder::class,
            ClustersSeeder::class,
            CampaignTypesSeeder::class,
            DomainsSeeder::class,
            ProductsServicesCategoriesSeeder::class,
            ActionCategorySeeder::class,
            ActionTypeSeeder::class,
            ActionSeeder::class,
        ]);
    }
}
