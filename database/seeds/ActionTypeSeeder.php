<?php

use App\Models\ActionType;
use Illuminate\Database\Seeder;

class ActionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ActionType::create([
            'name' => 'Campanha',
            'name'=> 'Pesquisa',
        ]);
    }
}
