<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat Admin
        User::create([
            'username'     => 'admin_brasil',
            'password'     => Hash::make('admin'), // Hash di dalam
            'nama_lengkap' => 'Admin Manajemen',
            'email'        => 'admin@gmail.com',
            'role'         => 'admin',
            'status'       => 'aktif',
        ]);

        // 2. Buat Owner
        User::create([
            'username'     => 'maria_owner',
            'password'     => Hash::make('owner123'), // Hash di dalam
            'nama_lengkap' => 'Owner',
            'email'        => 'owner@gmail.com',
            'role'         => 'super admin',
            'status'       => 'aktif',
        ]);

        // 3. Daftar Data Reseller (Data profil masuk ke tabel users)
        $dataLengkap = [
            ['nama' => 'Duta Agam', 'jenis' => 'Agen', 'alamat' => 'Jl. D.I. Panjaitan', 'telepon' => '08156882036'],
            ['nama' => 'Sukma kusuma', 'jenis' => 'Reseller', 'alamat' => 'Jl. Bobosan', 'telepon' => '082212134312'],
            ['nama' => 'Cantika Bunga', 'jenis' => 'Reseller', 'alamat' => 'Jl. Ahmad Jaelani', 'telepon' => '082212134312'],
            ['nama' => 'Akbar Wicaksana', 'jenis' => 'Reseller', 'alamat' => 'Jl. Pramuka', 'telepon' => '082212134312'],
            ['nama' => 'Maria Siregar', 'jenis' => 'Agen', 'alamat' => 'Jl. Ahmad Yani', 'telepon' => '082212134312'],
            ['nama' => 'Joko Prabowo', 'jenis' => 'Agen', 'alamat' => 'Jl. Daan Mogot', 'telepon' => '082212134312'],
        ];

        foreach ($dataLengkap as $item) {
            User::create([ // Ganti updateOrCreate jadi create
            'username'     => Str::slug($item['nama'], '_'),
            'password'     => Hash::make('reseller123'),
            'nama_lengkap' => $item['nama'],
            'email'        => Str::slug($item['nama'], '') . '@gmail.com',
            'role'         => 'reseller',
            'status'       => 'aktif',
            'jenis_toko'   => $item['jenis'],
            'wilayah'      => 'Purwokerto',
            'alamat'       => $item['alamat'],
            'no_telepon'   => $item['telepon'],
        ]);
}

    }
}

        /*
        // Data Customer
        // Buat 5 Customer (Reseller) Dummy
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'username' => 'reseller_'.$i,
                'nama_lengkap' => 'Reseller Cabang '.$i,
                'email' => 'reseller'.$i.'@gmail.com',
                'password' => Hash::make('reseller'),
                'role' => 'customer',
                'status' => 'active'
            ]); */



