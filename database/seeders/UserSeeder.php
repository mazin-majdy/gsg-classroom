<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Query Builder
        // DB::table('users')->insert([
        //     'name' => 'Mazin',
        //     'email' => 'mazin@gmail.com',
        //     'password' => Hash::make('password') // algorithms => (sha, md5, Rsa)
        // ]);
        // DB::table('users')->insert([
        //     'name' => 'Hasan',
        //     'email' => 'hasan@gmail.com',
        //     'password' => 'password' // algorithms => (sha, md5, Rsa)
        // ]);
    }
}
