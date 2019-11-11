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
        User::create([
            'name' => 'Jonathan Lassalle',
            'username' => 'jlassalle',
            'email' => 'jonathan.lassalle@tessi.fr',
            'password' => bcrypt('averdun'),
        ]);
        User::create([
            'name' => 'Vincent Dupeyron-Villata',
            'username' => 'vdupeyronvillata',
            'email' => 'vincent.dupeyronvillata@tessi.fr',
            'password' => bcrypt('averdun'),
        ]);
        User::create([
            'name' => 'Jason Pinaud',
            'username' => 'jpinaud',
            'email' => 'jason.pinaud@tessi.fr',
            'password' => bcrypt('averdun'),
        ]);
        User::create([
            'name' => 'Savas Meze',
            'username' => 'smeze',
            'email' => 'savas.meze@tessi.fr',
            'password' => bcrypt('averdun'),
        ]);
    }
}
