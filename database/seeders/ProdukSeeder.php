<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_produk' => 'Es Puter Cup',
                'sku'         => '120930192391',
                'harga'       => 5000.00,
                'stok'        => 100,
                'foto'        => null, // Dikosongkan sesuai permintaan
                'deskripsi'   => 'Es puter legendaris rasa kelapa muda dalam kemasan cup.',
            ],
            [
                'nama_produk' => 'Es Krim Cone',
                'sku'         => '120930192392',
                'harga'       => 10000.00,
                'stok'        => 125,
                'foto'        => null,
                'deskripsi'   => 'Es krim lembut dengan cone renyah.',
            ],
            [
                'nama_produk' => 'Es Lilin',
                'sku'         => '120930192393',
                'harga'       => 15000.00,
                'stok'        => 116,
                'foto'        => null,
                'deskripsi'   => 'Es lilin aneka rasa buah segar.',
            ],
            [
                'nama_produk' => 'Es Kotak',
                'sku'         => '120930192394',
                'harga'       => 3500.00,
                'stok'        => 119,
                'foto'        => null,
                'deskripsi'   => 'Es krim bentuk kotak praktis dan ekonomis.',
            ],
            [
                'nama_produk' => 'Es Rujak',
                'sku'         => '120930192395',
                'harga'       => 5000.00,
                'stok'        => 116,
                'foto'        => null,
                'deskripsi'   => 'Perpaduan unik rasa es krim dan bumbu rujak pedas manis.',
            ],
            [
                'nama_produk' => 'Es Kecil',
                'sku'         => '120930192396',
                'harga'       => 1500.00,
                'stok'        => 116,
                'foto'        => null,
                'deskripsi'   => 'Es krim ukuran mini untuk camilan ringan.',
            ],
        ];

        foreach ($data as $item) {
            Produk::create($item);
        }
    }
}