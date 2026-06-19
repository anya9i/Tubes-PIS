@extends('layouts.app')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* RESET UTAMA: Semua elemen bersudut kotak tegas (Rectangle) */
    .interface-container * {
        border-radius: 0 !important;
        box-shadow: none !important;
    }

    .interface-container {
        font-family: 'Montserrat', sans-serif !important;
        padding: 0px 10px;
        margin-top: -10px;
    }

    /* Papan Putih Besar Utama */
    .papan-putih-produk {
        background-color: #ffffff;
        padding: 35px 40px;
        border: 1px solid #ebedf0;
    }

    .judul-produk {
        font-family: 'Montserrat', sans-serif;
        font-size: 20px !important;
        font-weight: 700 !important;
        color: #383E49 !important;
    }

    /* Parameter Judul Kolom Atas */
    .th-produk {
        font-family: 'Montserrat', sans-serif;
        font-size: 13px !important;
        font-weight: 700 !important;
        color: #383E49 !important;
        border-bottom: 2px solid #dee2e6 !important;
        padding-top: 12px !important;
        padding-bottom: 12px !important;
        text-align: left;
        vertical-align: middle;
    }

    /* Teks Isi Data Tabel */
    .td-produk-data {
        font-family: 'Montserrat', sans-serif;
        font-size: 13px !important;
        padding-top: 15px !important;
        padding-bottom: 15px !important;
        text-align: left;
        vertical-align: middle;
    }

    /* Kotak Foto Produk Rectangle */
    .foto-produk-thumbnail {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border: 1px solid #dee2e6;
        background-color: #f8f9fa;
    }

    /* Gaya Tombol Aksi Kanan Atas */
    .btn-brasil-blue {
        background-color: #0d6efd !important;
        color: #ffffff !important;
        font-weight: 600;
        font-size: 13px;
        padding: 8px 18px;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-brasil-blue:hover {
        background-color: #0b5ed7 !important;
    }

    .btn-brasil-outline {
        background-color: #ffffff !important;
        color: #495057 !important;
        border: 1px solid #dee2e6 !important;
        font-weight: 500;
        font-size: 13px;
        padding: 8px 18px;
    }

    .btn-brasil-outline:hover {
        background-color: #f8f9fa !important;
    }

    /* Dropdown Styling */
    .dropdown-menu-brasil {
        border: 1px solid #dee2e6 !important;
        font-size: 13px;
        min-width: 220px;
    }
    .dropdown-menu-brasil .dropdown-header {
        font-weight: 700;
        color: #212529;
        padding: 8px 16px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .dropdown-menu-brasil .dropdown-item {
        padding: 8px 16px;
        font-weight: 500;
        color: #495057;
    }
    .dropdown-menu-brasil .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
    }

    .link-aksi-ubah {
        font-weight: 700 !important;
        color: #0d6efd !important;
        background: none;
        border: none;
        font-size: 13px;
        text-decoration: none;
    }

    .link-aksi-hapus {
        font-weight: 700 !important;
        color: #dc3545 !important;
        background: none;
        border: none;
        font-size: 13px;
        text-decoration: none;
    }

    .halaman-aktif-box {
        width: 28px;
        height: 28px;
        background-color: #e6f0fa !important;
        border: 1px solid #0d6efd !important;
        color: #0d6efd !important;
        font-weight: 700;
        font-size: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="container-fluid bg-transparent interface-container">

    <!-- Ringkasan Filter Aktif -->
    @if(request('filter_value'))
        <div class="alert alert-light border-0 d-flex justify-content-between align-items-center py-2 px-3 mb-3 bg-white" style="font-size: 13px; border-left: 4px solid #0d6efd !important;">
            <div>
                <i class="bi bi-info-circle-fill text-primary me-2"></i>
                Menampilkan hasil saringan untuk {{ request('filter_type') == 'nama_produk' ? 'Nama' : 'SKU' }}: <strong>"{{ request('filter_value') }}"</strong>
            </div>
            <a href="{{ route('produk.index') }}" class="text-decoration-none fw-bold text-danger"><i class="bi bi-x-circle-fill me-1"></i> Bersihkan Saringan</a>
        </div>
    @endif

    <div class="papan-putih-produk">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="judul-produk m-0">Daftar Produk</h4>
            <div class="d-flex gap-2">
                <!-- TAMBAH PRODUK -->
                <a href="{{ route('produk.create') }}" class="btn btn-brasil-blue">
                    Tambah Produk
                </a>
                <!-- DOWNLOAD CSV -->
                <a href="{{ route('produk.download') }}" class="btn btn-brasil-outline text-decoration-none">
                    <i class="bi bi-download me-1.5"></i> Download CSV
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tabelDataProdukUtama" class="table align-middle table-borderless mb-0">
                <thead>
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <th class="th-produk">No.</th>
                        <th class="th-produk">Foto Produk</th> <!-- GANTI DISINI: Judul Kolom Baru -->
                        <th class="th-produk">Nama Produk</th>
                        <th class="th-produk">SKU Produk</th>
                        <th class="th-produk">Harga Produk</th>
                        <th class="th-produk" width="160" style="text-align: right; padding-right: 25px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($produk->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted td-produk-data">Tidak ada data produk yang cocok dengan kriteria saringan.</td>
                        </tr>
                    @else
                        @foreach($produk as $index => $item)
                            <tr style="border-bottom: 1px solid #f1f3f5;">
                                <td class="td-produk-data fw-bold text-dark" style="color: #000000 !important; font-weight: 800;">
                                    {{ ($produk->currentPage() - 1) * $produk->perPage() + $index + 1 }}.
                                </td>
                                
                                <!-- GANTI DISINI: Menampilkan thumbnail Foto dari Storage Link Laravel -->
                                <td class="td-produk-data">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_produk }}" class="foto-produk-thumbnail">
                                    @else
                                        <!-- Placeholder jika produk tidak memiliki foto upload-an -->
                                        <div class="foto-produk-thumbnail d-flex align-items-center justify-content-center text-muted" style="font-size: 11px;">
                                            No Image
                                        </div>
                                    @endif
                                </td>

                                <td class="td-produk-data text-dark fw-medium" style="color: #000000 !important;">{{ $item->nama_produk }}</td>
                                <td class="td-produk-data text-muted">{{ $item->sku }}</td>
                                <td class="td-produk-data text-muted">Rp {{ number_format($item->harga, 0, ',', '.') }},00</td>
                                <td class="td-produk-data" style="text-align: right; padding-right: 20px;">
                                    <div class="d-inline-flex align-items-center gap-3">
                                        <a href="{{ route('produk.edit', $item->id) }}" class="link-aksi-ubah p-0">
                                            <i class="bi bi-pencil-fill small me-1"></i> Ubah
                                        </a>
                                        <button class="link-aksi-hapus p-0" onclick="eksekusiHapusProduk({{ $item->id }}, '{{ $item->nama_produk }}')">
                                            <i class="bi bi-trash-fill small me-1"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

    </div>

    <!-- PAGINATION -->
    <div class="d-flex justify-content-between align-items-center mt-3 px-1">
        <div>
            @if($produk->onFirstPage())
                <button class="btn btn-light btn-brasil-outline text-muted bg-white fw-normal" style="padding: 5px 15px;" disabled>Sebelumnya</button>
            @else
                <a href="{{ $produk->previousPageUrl() }}" class="btn btn-light btn-brasil-outline text-muted bg-white fw-normal text-decoration-none" style="padding: 5px 15px;">Sebelumnya</a>
            @endif
        </div>

        <div class="d-flex flex-column align-items-center">
            <div class="halaman-aktif-box">
                {{ $produk->currentPage() }}
            </div>
            <span class="text-muted mt-1" style="font-size: 11px !important;">
                Halaman {{ $produk->currentPage() }} dari {{ $produk->lastPage() }}
            </span>
        </div>

        <div>
            @if($produk->hasMorePages())
                <a href="{{ $produk->nextPageUrl() }}" class="btn btn-light btn-brasil-outline text-muted bg-white fw-normal text-decoration-none" style="padding: 5px 15px;">Selanjutnya</a>
            @else
                <button class="btn btn-light btn-brasil-outline text-muted bg-white fw-normal" style="padding: 5px 15px;" disabled>Selanjutnya</button>
            @endif
        </div>
    </div>

</div>

<!-- FORM REDIRECT JALUR FILTER HIDDEN -->
<form id="formSaringanProdukHidden" action="{{ route('produk.index') }}" method="GET" style="display: none;">
    <input type="hidden" id="inputFilterType" name="filter_type">
    <input type="hidden" id="inputFilterValue" name="filter_value">
</form>

<!-- FORM DELETE -->
<form id="formHapusProdukHidden" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function pemicuSaringanMurni(tipe, kataKunci) {
        document.getElementById('inputFilterType').value = tipe;
        document.getElementById('inputFilterValue').value = kataKunci;
        document.getElementById('formSaringanProdukHidden').submit();
    }

    // FUNGSI DELETE
    function eksekusiHapusProduk(id, nama) {
        if(confirm('Apakah kamu yakin ingin menghapus varian "' + nama + '" dari daftar produk?')) {
            const form = document.getElementById('formHapusProdukHidden');
            form.action = "/produk/" + id;
            form.submit();
        }
    }
</script>
@endsection