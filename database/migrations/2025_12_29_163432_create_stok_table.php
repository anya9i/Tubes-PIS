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
        Schema::create('stok', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('id_produk')
                  ->constrained('produk')
                  ->cascadeOnDelete();
        
            $table->integer('jumlah_baru');
            $table->string('keterangan', 255)->nullable();
            $table->timestamp('tanggal_update')->useCurrent();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('update_stok');
    }
};
