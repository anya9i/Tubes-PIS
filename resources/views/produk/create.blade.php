@extends('layouts.app')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container mt-4 halaman-create-produk-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm papan-putih-create">
                <div class="card-header bg-primary text-white p-3">
                    <h4 class="mb-0 judul-create-produk">Tambah Varian Produk Baru</h4>
                </div>
                <div class="card-body p-4">
                    
                    {{-- FORM UTAMA --}}
                    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3 form-group-brasil">
                            <label for="nama_produk" class="form-label-brasil">Nama Varian Produk <span class="text-danger">*</span></label>
                            <input type="text"
                                   id="nama_produk"
                                   name="nama_produk"
                                   class="form-control-brasil @error('nama_produk') is-invalid-brasil @enderror"
                                   value="{{ old('nama_produk') }}"
                                   placeholder="Contoh: Es Kopi Brasil Susu"
                                   required
                                   autofocus>
                            @error('nama_produk')
                                <div class="pesan-error-brasil">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-group-brasil">
                            <label for="sku" class="form-label-brasil">SKU / Kode Produk <span class="text-danger">*</span></label>
                            <input type="text"
                                   id="sku"
                                   name="sku"
                                   class="form-control-brasil @error('sku') is-invalid-brasil @enderror"
                                   value="{{ old('sku') }}"
                                   placeholder="Contoh: BRSL-001"
                                   required>
                            @error('sku')
                                <div class="pesan-error-brasil">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-group-brasil">
                            <label for="harga" class="form-label-brasil">Harga Jual (Rp) <span class="text-danger">*</span></label>
                            <input type="number"
                                   id="harga"
                                   name="harga"
                                   class="form-control-brasil @error('harga') is-invalid-brasil @enderror"
                                   value="{{ old('harga') }}"
                                   min="0"
                                   placeholder="Contoh: 5000"
                                   required>
                            @error('harga')
                                <div class="pesan-error-brasil">{{ $message }}</div>
                            @enderror
                            <small class="text-muted small-helper-brasil">Masukkan nilai nominal angka bulat tanpa tanda titik/koma.</small>
                        </div>

                        <div class="mb-3 form-group-brasil">
                            <label for="stok" class="form-label-brasil">Jumlah Awal Stok <span class="text-danger">*</span></label>
                            <input type="number"
                                   id="stok"
                                   name="stok"
                                   class="form-control-brasil @error('stok') is-invalid-brasil @enderror"
                                   value="{{ old('stok', 0) }}"
                                   min="0"
                                   placeholder="Contoh: 100"
                                   required>
                            @error('stok')
                                <div class="pesan-error-brasil">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-group-brasil">
                            <label for="foto" class="form-label-brasil">Unggah Foto Produk</label>
                            <input type="file"
                                   id="foto"
                                   name="foto"
                                   class="form-control-brasil @error('foto') is-invalid-brasil @enderror"
                                   accept="image/*">
                            <small class="text-muted small-helper-brasil">Format berkas yang didukung: JPG, JPEG, PNG, GIF (Maks. 2MB).</small>
                            @error('foto')
                                <div class="pesan-error-brasil">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4 form-group-brasil">
                            <label for="deskripsi" class="form-label-brasil">Informasi Deskripsi Tambahan</label>
                            <textarea id="deskripsi"
                                      name="deskripsi"
                                      class="form-control-brasil @error('deskripsi') is-invalid-brasil @enderror"
                                      rows="4"
                                      placeholder="Opsional: Tuliskan rincian varian rasa es atau detail porsi takaran di sini...">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="pesan-error-brasil">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-2">
                            <a href="{{ route('produk.index') }}" class="btn btn-brasil-batal">Batal</a>
                            <button type="submit" class="btn btn-brasil-simpan">
                                <i class="bi bi-save me-1"></i> Simpan Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= STYLING ENGINE: NO-ROUNDED RECTANGLE STYLE ================= --}}
<style>
    .halaman-create-produk-wrapper {
        font-family: 'Montserrat', sans-serif !important;
    }

    /* Memaksa Struktur Sudut Siku-Siku Tegas Secara Keseluruhan */
    .papan-putih-create,
    .papan-putih-create .card-header,
    .form-control-brasil,
    .btn-brasil-batal,
    .btn-brasil-simpan {
        border-radius: 0px !important;
        box-shadow: none !important;
    }

    .papan-putih-create {
        background-color: #ffffff;
        border: 1px solid #ebedf0 !important;
    }

    .papan-putih-create .card-header {
        background-color: #111111 !important;
        border-bottom: none;
    }

    .judul-create-produk {
        font-size: 16px !important;
        font-weight: 700 !important;
        letter-spacing: -0.1px;
    }

    .form-group-brasil {
        display: flex;
        flex-direction: column;
    }

    .form-label-brasil {
        font-size: 13px;
        font-weight: 700;
        color: #383E49;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .form-control-brasil {
        background-color: #ffffff;
        border: 1px solid #dee2e6;
        padding: 10px 14px;
        font-size: 14px;
        color: #212529;
        font-weight: 500;
        outline: none;
        width: 100%;
        box-sizing: border-box;
    }

    .form-control-brasil:focus {
        border-color: #0d6efd;
    }

    .form-control-brasil.is-invalid-brasil {
        border-color: #dc3545 !important;
        background-color: #fff8f8;
    }

    .pesan-error-brasil {
        font-size: 12px;
        font-weight: 700;
        color: #dc3545;
        margin-top: 5px;
    }

    .small-helper-brasil {
        font-size: 11px !important;
        color: #7c838f !important;
        margin-top: 5px;
    }

    /* Tombol Aksi */
    .btn-brasil-batal {
        background-color: #ffffff !important;
        color: #495057 !important;
        border: 1px solid #dee2e6 !important;
        font-weight: 600;
        font-size: 13px;
        padding: 10px 24px;
        text-decoration: none;
        text-align: center;
    }
    .btn-brasil-batal:hover {
        background-color: #f8f9fa !important;
        color: #212529 !important;
    }

    .btn-brasil-simpan {
        background-color: #0d6efd !important;
        color: #ffffff !important;
        border: none;
        font-weight: 600;
        font-size: 13px;
        padding: 10px 24px;
    }
    .btn-brasil-simpan:hover {
        background-color: #0b5ed7 !important;
    }
</style>
@endsection