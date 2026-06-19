@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Edit Produk: <strong>{{ $produk->nama_produk }}</strong></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama Produk -->
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label fw-bold">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text"
                                   id="nama_produk"
                                   name="nama_produk"
                                   class="form-control @error('nama_produk') is-invalid @enderror"
                                   value="{{ old('nama_produk', $produk->nama_produk) }}"
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
                                   value="{{ old('sku', $produk->sku) }}"
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
                                   value="{{ old('stok', $produk->stok) }}"
                                   min="0"
                                   required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Foto Produk -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Saat Ini</label>
                            <div class="mb-2">
                                @if($produk->foto)
                                    <img src="{{ asset('storage/' . $produk->foto) }}"
                                         alt="{{ $produk->nama_produk }}"
                                         class="img-thumbnail rounded"
                                         style="max-height: 200px; object-fit: cover;">
                                    <p class="text-muted small mt-1">Biarkan kosong jika tidak ingin mengganti foto.</p>
                                @else
                                    <p class="text-muted">Tidak ada foto saat ini.</p>
                                @endif
                            </div>

                            <label for="foto" class="form-label">Ganti Foto Produk</label>
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
                                      placeholder="Opsional: jelaskan tentang produk ini...">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="d-grid d-md-flex justify-content-md-end gap-2">
                            <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-success">
                                Update Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection