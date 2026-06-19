<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,     // Admin & Owner
            // ResellerSeeder::class, // Daftar Reseller dari Figma
            ProdukSeeder::class,   // Daftar Es Krim Brasil
            PesananSeeder::class,  // Data transaksi
        ]);
    }
}

