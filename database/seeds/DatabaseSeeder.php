<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'Admin',
            'email' => 'admin@omahbarokah.com',
            'password' => Hash::make('omahbarokah'),
            'role' => 'admin',
        ]);
    }
}
