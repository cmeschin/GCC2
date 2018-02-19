<?php

use Illuminate\Database\Seeder;
use App\Models\EtatDemande;

class EtatDemandesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EtatDemande::create([
                'etat' => 'draft',
                'action' => 'draft',
        ]);
        EtatDemande::create([
                'etat' => 'todo',
                'action' => 'todo',
        ]);
        EtatDemande::create([
                'etat' => 'inprogress',
                'action' => 'inprogress',
        ]);
        EtatDemande::create([
                'etat' => 'validation',
                'action' => 'validate',
        ]);
        EtatDemande::create([
                'etat' => 'treaty',
                'action' => 'treat',
        ]);
        EtatDemande::create([
                'etat' => 'canceled',
                'action' => 'cancel',
        ]);
        EtatDemande::create([
                'etat' => 'deleted',
                'action' => 'delete',
        ]);
        
    }
}
