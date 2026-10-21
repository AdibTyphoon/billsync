<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akaun Admin Ujian
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@billsync.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Akaun Pengguna Biasa Ujian
        User::create([
            'name' => 'Adib Zobri',
            'email' => 'adib@billsync.test',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // Jalankan BillerSeeder
        $this->call([
            BillerSeeder::class,
        ]);
    }
}