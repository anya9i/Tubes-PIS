<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pesanan;
use App\Models\User; // Atau App\Models\Reseller tergantung tabelmu

class PesananSeeder extends Seeder
{
    public function run()
{
    $dataReseller = [
        ['nama' => 'Duta Agam', 'alamat' => 'Jl. D.I. Panjaitan', 'telepon' => '08156882036'],
        ['nama' => 'Sukma kusuma', 'alamat' => 'Jl. Bobosan', 'telepon' => '082212134312'],
        ['nama' => 'Cantika Bunga', 'alamat' => 'Jl. Ahmad Jaelani', 'telepon' => '082212134312'],
        ['nama' => 'Akbar Wicaksana', 'alamat' => 'Jl. Pramuka', 'telepon' => '082212134312'],
        ['nama' => 'Maria Siregar', 'alamat' => 'Jl. Ahmad Yani', 'telepon' => '082212134312'],
        ['nama' => 'Joko Prabowo', 'alamat' => 'Jl. Daan Mogot', 'telepon' => '082212134312'],
    ];

    foreach ($dataReseller as $index => $item) {
        // Cari ID berdasarkan 'nama_lengkap' karena kolom 'name' TIDAK ADA
        $reseller = User::where('nama_lengkap', $item['nama'])->first();

        // Gunakan ID dari database jika ketemu, jika tidak gunakan ID 1
        $resellerId = $reseller ? $reseller->id : 1;

        Pesanan::create([
            'user_id'                => $resellerId, // GANTI DARI 'reseller' MENJADI 'user_id'
            'id_transaksi' => 'BSR-2026-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
            'tanggal_pesan'          => now()->format('Y-m-d'),
            'total_produk'           => rand(50, 200),
            'total_harga'            => rand(500000, 2000000),
            'alamat_pengiriman'      => $item['alamat'],
            'no_telepon_pengiriman'  => $item['telepon'],
            'status'                 => 'Dikemas',
            'payment_status'         => 'MENUNGGU',
            'payment_url'            => 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' . uniqid(),
        ]);
    }
}
}