<?php

use Illuminate\Database\Seeder;

class MenusAccessGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            //empresas
            [
                'menus_id' => 1,
                'access_groups_id' => 1,
            ],
            //campanhas
            [
                'menus_id' => 2,
                'access_groups_id' => 1,
            ],
            [
                'menus_id' => 2,
                'access_groups_id' => 3,
            ],
            //dominios
            [
                'menus_id' => 3,
                'access_groups_id' => 1,
            ],
            //produtos/serviços
            [
                'menus_id' => 4,
                'access_groups_id' => 1,
            ],
            //usuarios
            [
                'menus_id' => 5,
                'access_groups_id' => 1,
            ],
        ];


        foreach ($menus as $menu) {
            App\Models\MenusAccessGroups::create([
                'menus_id' => $menu['menus_id'],
                'access_groups_id' => $menu['access_groups_id'],
            ]);
        }
    }
}
