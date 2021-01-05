<?php

use Illuminate\Database\Seeder;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'name'  => 'Empresas',
                'icon'  => 'fa-bank',
                'order' => 1,
                'route' => 'index.companies',
            ], [
                'name'  => 'Campanhas',
                'icon'  => 'fa-briefcase',
                'order' => 2,
                'route' => 'index.campaigns',
            ], [
                'name'  => 'Domínios',
                'icon'  => 'fa-link',
                'order' => 3,
                'route' => 'index.domains',
            ], [
                'name'  => 'Ações',
                'icon'  => 'fa-plus',
                'order' => 4,
                'route' => 'index.actions',
            ], [
                'name'  => 'Produtos/Serviços',
                'icon'  => 'fa-tags',
                'order' => 5,
                'route' => 'index.products.services',
            ], [
                'name'  => 'Usuários',
                'icon'  => 'fa-users',
                'order' => 6,
                'route' => 'index.customers',
            ], [
                'name'  => 'E-mails Incentivados',
                'icon'  => 'fa-email',
                'order' => 7,
                'route' => 'index.incentive.emails'
            ],
        ];


        foreach ($menus as $menu) {
            App\Models\Menus::create([
                'name'  => $menu['name'],
                'icon'  => $menu['icon'],
                'order' => $menu['order'],
                'route' => $menu['route'],
            ]);
        }
    }
}
