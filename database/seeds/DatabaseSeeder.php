<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(EtatDemandesTableSeeder::class);
        $this->call(TypeDemandesTableSeeder::class);
        $this->call(ActionsTableSeeder::class);
//        $this->call(PreferencesTableSeeder::class);
    }
}
