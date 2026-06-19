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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('username')->unique();
        $table->string('password');
        $table->string('nama_lengkap');
        $table->string('email')->unique();
        $table->enum('role', ['admin', 'super admin', 'reseller'])->default('reseller');
        $table->string('status')->default('aktif');

        // TAMBAHKAN KOLOM INI DI SINI:
        $table->string('jenis_toko')->nullable(); 
        $table->string('wilayah')->nullable();
        $table->text('alamat')->nullable();
        $table->string('no_telepon')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }

    
};