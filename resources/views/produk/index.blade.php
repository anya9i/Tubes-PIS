@extends('layouts.app')

@section('content')

<div class="card border-0 shadow-sm p-4" style="border-radius: 0; background: rgba(255,255,255,0.95);">
    
    {{-- Header Daftar Produk & Tombol Aksi --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark m-0" style="font-family: 'Montserrat', sans-serif;">Daftar Produk</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('produk.create') }}" class="btn btn-primary-brasil">
                Tambah Produk
            </a>
            <button class="btn btn-action-outline">
                <i class="fa-solid fa-arrows-up-down me-2"></i> Sort
            </button>
            <button class="btn btn-action-outline">
                Download all
            </button>
        </div>
    </div>

    {{-- Tabel Produk --}}
    <div class="table-responsive">
        <table class="table align-middle" style="border-radius: 0;">
            <thead>
                <tr class="text-dark small fw-bold border-bottom">
                    <th class="pb-3 px-3">No.</th>
                    <th class="pb-3">Nama Produk</th>
                    <th class="pb-3">SKU Produk</th>
                    <th class="pb-3">Harga Produk</th>
                    <th class="pb-3">Jumlah Stok</th>
                    <th class="pb-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produks as $index => $produk)
                <tr class="border-bottom">
                    <td class="py-3 px-3 fw-bold">{{ $index + 1 }}.</td>
                    <td class="py-3 text-secondary">{{ $produk->nama_produk }}</td>
                    <td class="py-3 text-secondary">{{ $produk->sku }}</td>
                    <td class="py-3 text-secondary">Rp {{ number_format($produk->harga, 0, ',', '.') }},00</td>
                    <td class="py-3 text-secondary text-center">{{ $produk->stok }}</td>
                    <td class="py-3 text-center">
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('produk.edit', $produk->id) }}" class="btn-edit-text">
                                <i class="fa-solid fa-pen me-1"></i> Ubah
                            </a>
                            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete-text" onclick="return confirm('Hapus produk ini?')">
                                    <i class="fa-solid fa-trash-can me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">Belum ada data produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Sesuai Gambar --}}
    <div class="mt-5">
        <div class="d-flex justify-content-center mb-2">
            <span class="active-page-box">1</span>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-pagination-brasil">Sebelumnya</button>
            <div class="small text-secondary">Halaman 1 dari 1</div>
            <button class="btn btn-pagination-brasil">Selanjutnya</button>
        </div>
    </div>
</div>

<style>
    /* Global Rectangle */
    .card, .btn, .form-control { border-radius: 0 !important; }

    /* Tombol Biru Tambah Produk */
    .btn-primary-brasil {
        background-color: #0061f2;
        color: white !important;
        border: none;
        padding: 8px 20px;
        font-weight: 600;
        font-size: 14px;
    }

    /* Tombol Outline (Sort/Download) */
    .btn-action-outline {
        background: white;
        border: 1px solid #ddd;
        color: #888;
        font-size: 13px;
        padding: 8px 15px;
    }

    /* Tombol Pagination */
    .btn-pagination-brasil {
        border: 1px solid #ddd;
        background: white;
        color: #444;
        font-size: 13px;
        padding: 8px 25px;
    }

    .active-page-box {
        background: #e0ebff;
        color: #0061f2;
        padding: 5px 15px;
        font-weight: bold;
        border: 1px solid #c2d6ff;
    }

    /* Aksi Text Style */
    .btn-edit-text {
        color: #0061f2 !important;
        text-decoration: none;
        font-weight: bold;
        font-size: 14px;
    }
    .btn-delete-text {
        color: #dc3545 !important;
        background: none;
        border: none;
        font-weight: bold;
        font-size: 14px;
    }

    .table thead th {
        color: #666;
        font-size: 13px;
    }
    
    .hover-red:hover { color: #ff0000 !important; }
</style>

@endsection