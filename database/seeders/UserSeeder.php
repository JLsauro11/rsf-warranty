<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'Admin',
            'email' => 'saurojhonlewis@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'remember_token' => \Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'username' => 'CSR_RS8',
            'email' => 'csr_rs8@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role' => 'csr_rs8',
            'remember_token' => \Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'username' => 'CSR_SRF',
            'email' => 'csr_srf@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'role' => 'csr_srf',
            'remember_token' => \Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
