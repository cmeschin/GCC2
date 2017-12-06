<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Zic',
            'username' => 'zic',
            'email' => 'c.zic@free.fr',
            'password' => bcrypt('averdun'),
        ]);
        User::create([
            'name' => 'Cédric Meschin',
            'username' => 'cmeschin',
            'role' => 'admin',
            'email' => 'c.meschin@free.fr',
            'password' => bcrypt('averdun'),
        ]);
    }
}
