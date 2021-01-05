<?php

use App\Models\ActionCategory;
use Illuminate\Database\Seeder;

class ActionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ActionCategory::create([
            'name' => 'Completar seu perfil'
        ]);

        ActionCategory::create([
            'name' => 'Compartilhar',
        ]);

        ActionCategory::create([
            'name' => 'Participar de Quiz',
        ]);

        ActionCategory::create([
            'name' => 'Responder a pesquisas',
        ]);

        ActionCategory::create([
            'name' => 'Outros',
        ]);
    }
}
