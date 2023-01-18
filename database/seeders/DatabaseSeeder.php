<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('users')->insert([
            'name' => 'Owner',
            'email' => 'enricko.putra028@gmail.com',
            'password' => Hash::make('123qweasd'),
            'level' => 'owner',
        ]);
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'enricko.putra@gmail.com',
            'password' => Hash::make('123qweasd'),
            'level' => 'admin',
        ]);
    }
}
