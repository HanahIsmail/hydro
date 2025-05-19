<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Ika',
            'email' => 'ika@hidroponik.com',
            'password' => Hash::make('ika123'),
            'roles' => 'Pemilik',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Dafa',
            'email' => 'dafa@hidroponik.com',
            'password' => Hash::make('dafa123'),
            'roles' => 'Pengelola',
        ]);

        $this->call([
            TDSDataSeeder::class,
        ]);
    }
}
