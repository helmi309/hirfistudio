<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate record
        DB::table('users')->truncate();

        $user = [
            ['id' => str_random(36), 'username' => 'Hasan Basri', 'email' => 'mantemanku27@gmail.com', 'password' => bcrypt('mantemanku27'), 'level' => '0','pin' => 272727,  'created_at' => \Carbon\Carbon::now()],
            ['id' => str_random(36), 'username' => 'Bunda Maharani', 'email' => 'bundahirfi@gmail.com', 'password' => bcrypt('bunda46'), 'level' => '1','pin' => 397613,  'created_at' => \Carbon\Carbon::now()],
        ];

        // Insert Batch
        DB::table('users')->insert($user);
    }

}
