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
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('id_pesanan')
                  ->constrained('pesanan')
                  ->cascadeOnDelete();
        
            $table->foreignId('id_produk')
                  ->constrained('produk')
                  ->restrictOnDelete();
        
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 15, 2);
        
            $table->decimal('subtotal', 15, 2)
                  ->storedAs('jumlah * harga_satuan');
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
