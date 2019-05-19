<?php

use App\Models\Action;
use Illuminate\Database\Seeder;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Action::create([
            'action' => 'Create',
            'alias' => 'CRE',
        ]);
        Action::create([
            'action' => 'Modify',
            'alias' => 'MOD',
        ]);
        Action::create([
            'action' => 'Disable',
            'alias' => 'DIS',
        ]);
        Action::create([
            'action' => 'Delete',
            'alias' => 'DEL',
        ]);
    }
}
