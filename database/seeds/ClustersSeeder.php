<?php

use Illuminate\Database\Seeder;

class ClustersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clusters = [
            'Cursos de Inglês',
            'Doações e ONGs',
            'Empréstimos',
            'Ecommerce',
            'Consórcios',
            'Cursos Superiores',
            'Gambling',
            'Imóveis',
            'Planos de Saúde',
            'Planos de Telefonia',
            'Planos de Tv a Cabo',
            'Seguro Auto',
            'Seguro de Vida',
            'Sorteios e Promoções',
            'Renda Extra',
            'Test Drive',
            'Vidências',
            'Infoproduto',
        ];

        asort($clusters);

        foreach ($clusters as $cluster) {
            App\Models\Clusters::create([
                'cluster' => $cluster,
            ]);
        }
    }
}
