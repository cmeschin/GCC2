<?php

use Illuminate\Database\Seeder;
use App\Models\TypeDemande;

class TypeDemandesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeDemande::create([
                'type' => 'Démarrage',
                'alias' => 'DEM',
        ]);
        TypeDemande::create([
                'type' => 'Mise à jour',
                'alias' => 'MAJ',
        ]);
        TypeDemande::create([
                'type' => 'Arrêt',
                'alias' => 'STOP',
        ]);
    }
}
