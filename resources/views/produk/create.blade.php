@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Tambah Produk Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama Produk -->
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label fw-bold">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text"
                                   id="nama_produk"
                                   name="nama_produk"
                                   class="form-control @error('nama_produk') is-invalid @enderror"
                                   value="{{ old('nama_produk') }}"
                                   required
                                   autofocus>
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- SKU -->
                        <div class="mb-3">
                            <label for="sku" class="form-label fw-bold">SKU <span class="text-danger">*</span></label>
                            <input type="text"
                                   id="sku"
                                   name="sku"
                                   class="form-control @error('sku') is-invalid @enderror"
                                   value="{{ old('sku') }}"
                                   required>
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div class="mb-3">
                            <label for="harga" class="form-label fw-bold">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number"
                                   id="harga"
                                   name="harga"
                                   class="form-control @error('harga') is-invalid @enderror"
                                   value="{{ old('harga', $produk->harga ?? '') }}"
                                   min="0"
                                   step="100"
                                   required>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Masukkan angka tanpa titik atau koma, contoh: 5000 untuk Rp 5.000</small>
                        </div>

                        <!-- Stok -->
                        <div class="mb-3">
                            <label for="stok" class="form-label fw-bold">Jumlah Stok <span class="text-danger">*</span></label>
                            <input type="number"
                                   id="stok"
                                   name="stok"
                                   class="form-control @error('stok') is-invalid @enderror"
                                   value="{{ old('stok') ?? 0 }}"
                                   min="0"
                                   required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Foto Produk -->
                        <div class="mb-3">
                            <label for="foto" class="form-label fw-bold">Foto Produk</label>
                            <input type="file"
                                   id="foto"
                                   name="foto"
                                   class="form-control @error('foto') is-invalid @enderror"
                                   accept="image/jpeg,image/png,image/jpg,image/gif">
                            <small class="text-muted">Format: JPG, PNG, GIF. Maks 2MB.</small>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                            <textarea id="deskripsi"
                                      name="deskripsi"
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      rows="4"
                                      placeholder="Opsional: jelaskan tentang produk ini...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-grid d-md-flex justify-content-md-end gap-2">
                            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Simpan Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection