<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // GANTI MULAI DARI SINI
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
        
            // Menghubungkan pesanan ke tabel users (untuk role Reseller/Customer)
            $table->foreignId('user_id')
                  ->constrained('users') 
                  ->cascadeOnDelete();
        
            $table->date('tanggal_pesan')->useCurrent();
            $table->integer('total_produk');
            $table->decimal('total_harga', 15, 2)->default(0);
        
            $table->text('alamat_pengiriman')->nullable();
            $table->string('no_telepon_pengiriman', 20)->nullable();
        
            // Status yang kaku sesuai UI Figma
            $table->enum('status', ['Dikemas', 'Dikirim', 'Diterima'])
                  ->default('Dikemas');

            // Kolom tambahan untuk integrasi Midtrans nanti
            $table->string('payment_url')->nullable(); 
            $table->enum('payment_status', ['MENUNGGU', 'BERHASIL', 'GAGAL'])
                  ->default('MENUNGGU');
        
            $table->text('keterangan')->nullable();
            $table->timestamps(); 
        });        
        // SAMPAI DI SINI
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};