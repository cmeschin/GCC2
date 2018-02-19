<?php

use Illuminate\Database\Seeder;
use App\Models\Preference;

class PreferencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Preference::create([
                'user_id' => '1',
                'type' => 'emails',
                'cle' => 'liste1',
                'valeur' => 'c.zic@free.fr;c.zic@free.fr',
        ]);
        Preference::create([
                'user_id' => '1',
                'type' => 'emails',
                'cle' => 'liste2',
                'valeur' => 'c.zic@free.fr;c.zic@free.fr;c.zic@free.fr',
        ]);
        Preference::create([
                'user_id' => '2',
                'type' => 'emails',
                'cle' => 'liste1',
                'valeur' => 'c.meschin@free.fr;c.meschin@free.fr',
        ]);
        Preference::create([
                'user_id' => '2',
                'type' => 'emails',
                'cle' => 'liste2',
                'valeur' => 'c.meschin@free.fr;c.meschin@free.fr;c.meschin@free.fr',
        ]);
    }
}
