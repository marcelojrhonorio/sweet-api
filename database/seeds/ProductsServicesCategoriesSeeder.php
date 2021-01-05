<?php

use Illuminate\Database\Seeder;
use App\Models\ProductsServicesCategories;

class ProductsServicesCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductsServicesCategories::create([
            'name' => 'Produtos de limpeza',
        ]);

        ProductsServicesCategories::create([
            'name' => 'Cosméticos',
        ]);

        ProductsServicesCategories::create([
            'name' => 'Alimentos',
        ]);

        ProductsServicesCategories::create([
            'name' => 'Eletrônicos',
        ]);

        ProductsServicesCategories::create([
            'name' => 'Outros',
        ]);
    }
}
