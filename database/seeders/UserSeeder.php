<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \App\Models\User::factory(14)->create();

        \App\Models\User::factory()->create([
            'name' => 'Arya Admin',
            'email' => 'aryaa@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '085385275505',
            'roles' => 'ADMIN',
        ]);
    }
}
