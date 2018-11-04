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
        // Memanggil Class User dari file UserTableSeeder
        $this->call(UserTableSeeder::class);
        // Memanggil Class Spl dari file SplTableSeeder
        $this->call(SplTableSeeder::class);
    }

}
