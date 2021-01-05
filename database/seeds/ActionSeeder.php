<?php

use App\Models\Action;
use Illuminate\Database\Seeder;

class ActionSeeder extends Seeder
{
    /**
     * Run the Action seeds.
     */
    public function run()
    {
        Action::create([
            'action_category_id' => 1,
            'action_type_id'     => 1,
            'title'              => 'Perfil',
            'description'        => 'Dados pessoais',
            'path_image'         => 'bonus/actions/images/2018/3/default.jpg',
            'grant_points'       => 100,
        ]);

        Action::create([
            'action_category_id' => 2,
            'action_type_id'     => 1,
            'title'              => 'Compartilhar',
            'description'        => 'Facebook',
            'path_image'         => 'bonus/actions/images/2018/3/default.jpg',
            'grant_points'       => 50,
        ]);

        Action::create([
            'action_category_id' => 3,
            'action_type_id'     => 1,
            'title'              => 'Quiz',
            'description'        => 'Sweet Bonus',
            'path_image'         => 'bonus/actions/images/2018/3/default.jpg',
            'grant_points'       => 70,
        ]);

        Action::create([
            'action_category_id' => 4,
            'action_type_id'     => 1,
            'title'              => 'Pesquisa',
            'description'        => 'Estilo de vida',
            'path_image'         => 'bonus/actions/images/2018/3/default.jpg',
            'grant_points'       => 60,
        ]);

        Action::create([
            'action_category_id' => 5,
            'action_type_id'     => 1,
            'title'              => 'Outros',
            'description'        => 'Recarga créditos',
            'path_image'         => 'bonus/actions/images/2018/3/default.jpg',
            'grant_points'       => 80,
        ]);
    }
}
