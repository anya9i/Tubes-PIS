@extends('layouts.app')

@section('content')
<!-- Import Font Montserrat & Bootstrap Icons -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* Pembungkus utama halaman berlatar belakang transparan agar foto ruko di belakang tetap terlihat */
    .stok-interface-wrapper {
        font-family: 'Montserrat', sans-serif !important;
        padding: 40px 30px;
        min-height: calc(100vh - 90px);
        display: flex;
        flex-direction: column;
        justify-content: space-between; /* Mendorong papan pagination tetap berada di bawah halaman */
    }

    /* Papan Putih Atas untuk Tabel (Sesuai gambar mockup) */
    .papan-stok-putih {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        padding: 35px 40px;
        border: 1px solid #ebedf0;
        margin-bottom: 30px;
    }

    /* Papan Putih Bawah Khusus Kontrol Halaman / Pagination */
    .papan-pagination-bawah {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        padding: 20px 40px;
        border: 1px solid #ebedf0;
    }

    /* Judul Utama (Montserrat 20px, Warna #383E49) */
    .judul-stok-asli {
        font-family: 'Montserrat', sans-serif !important;
        font-size: 20px !important;
        font-weight: 700 !important;
        color: #383E49 !important;
        letter-spacing: -0.2px;
    }

    /* Header Parameter Tabel */
    .th-parameter-stok {
        font-family: 'Montserrat', sans-serif !important;
        font-size: 14px !important;
        font-weight: 700 !important;
        color: #383E49 !important;
        border-bottom: 1px solid #dee2e6 !important;
    }

    /* Teks Isi Data Kolom */
    .td-isi-stok {
        font-family: 'Montserrat', sans-serif !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        color: #6c757d !important;
    }

    /* Jari-jari Sudut Tombol Standar */
    .btn-custom-radius {
        border-radius: 4px !important;
        font-size: 0.85rem;
        padding: 6px 18px;
    }

    /* Gaya Tombol Teks Ubah */
    .btn-link-ubah {
        font-family: 'Montserrat', sans-serif !important;
        font-size: 14px !important;
        font-weight: 700 !important;
        color: #0d6efd !important;
        background: none;
        border: none;
        padding: 0;
        text-decoration: none;
    }

    /* Gaya Tombol Teks Hapus */
    .btn-link-hapus {
        font-family: 'Montserrat', sans-serif !important;
        font-size: 14px !important;
        font-weight: 700 !important;
        color: #dc3545 !important;
        background: none;
        border: none;
        padding: 0;
        text-decoration: none;
    }

    /* Kotak Indikator Halaman Aktif */
    .kotak-halaman-biru {
        width: 32px;
        height: 32px;
        background-color: #e6f0fa !important;
        border: 1px solid #0d6efd !important;
        color: #0d6efd !important;
        font-weight: 700;
        font-size: 14px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="container-fluid bg-transparent stok-interface-wrapper">
    
    <div>
        <!-- Bagian Notifikasi Akses Sukses -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-radius: 6px;">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <div class="papan-stok-putih">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="judul-stok-asli m-0">Daftar Stok</h4>
                
                {{-- BARIKADE ROLE: Bungkus tombol pemicu modal yang asli di sini --}}
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'super admin')
                    <div>
                        <button class="btn btn-primary btn-custom-radius fw-semibold text-white border-0" style="background-color: #0d6efd;" data-bs-toggle="modal" data-bs-target="#modalTambahStokBaru">
                            Tambah Stok
                        </button>
                    </div>
                @endif
                
            </div>
        </div>

            <div class="table-responsive">
                <table id="tabelStokData" class="table align-middle table-borderless mb-0">
                    <thead>
                        <tr style="border-bottom: 1px solid #dee2e6;">
                            <th class="py-3 th-parameter-stok text-center" width="90">No</th>
                            <th class="py-3 th-parameter-stok text-center">Nama Produk</th>
                            <th class="py-3 th-parameter-stok text-center">SKU Produk</th>
                            <th class="py-3 th-parameter-stok text-center">Harga</th>
                            <th class="py-3 th-parameter-stok text-center">Jumlah Stok</th>
                            <th class="py-3 th-parameter-stok text-center" width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($produk->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center py-5 td-isi-stok">Data ketersediaan stok es sedang kosong.</td>
                            </tr>
                        @else
                            @foreach($produk as $item)
                                <tr style="border-bottom: 1px solid #f1f3f5;">
                                    <td class="py-3 td-isi-stok text-center">
                                        {{ ($produk->currentPage() - 1) * $produk->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="py-3 td-isi-stok text-center" style="color: #383E49 !important; font-weight: 500;">
                                        {{ $item->nama_produk }}
                                    </td>
                                    <td class="py-3 td-isi-stok text-center">{{ $item->sku }}</td>
                                    <td class="py-3 td-isi-stok text-center">Rp {{ number_format($item->harga, 0, ',', '.') }},00</td>
                                    <td class="py-3 td-isi-stok text-center" style="color: #383E49 !important;">
                                        {{ $item->stok }}
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center justify-content-center gap-3">
                                            <button class="btn-link-ubah d-flex align-items-center gap-1" onclick="pemicuModalEdit({{ $item->id }}, '{{ $item->nama_produk }}', {{ $item->stok }})">
                                                <i class="bi bi-pencil-fill" style="font-size: 0.82rem;"></i> Ubah
                                            </button>
                                            <button class="btn-link-hapus d-flex align-items-center gap-1" onclick="pemicuHapusData({{ $item->id }}, '{{ $item->nama_produk }}')">
                                                <i class="bi bi-trash-fill" style="font-size: 0.82rem;"></i> Hapus
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
    </div>

    <!-- PAPAN PUTIH BAWAH (PAGINATION TERPISAH SESUAI MOCKUP) -->
    <div class="papan-pagination-bawah d-flex justify-content-between align-items-center">
        <div>
            @if($produk->onFirstPage())
                <button class="btn btn-light btn-custom-radius border text-muted bg-white fw-normal" disabled>Sebelumnya</button>
            @else
                <a href="{{ $produk->previousPageUrl() }}" class="btn btn-light btn-custom-radius border text-muted bg-white fw-normal">Sebelumnya</a>
            @endif
        </div>

        <div class="d-flex flex-column align-items-center">
            <div class="kotak-halaman-biru mb-1">
                {{ $produk->currentPage() }}
            </div>
            <span class="text-muted small" style="font-family: 'Montserrat', sans-serif; font-size: 12px;">
                Halaman {{ $produk->currentPage() }} dari {{ $produk->lastPage() }}
            </span>
        </div>

        <div>
            @if($produk->hasMorePages())
                <a href="{{ $produk->nextPageUrl() }}" class="btn btn-light btn-custom-radius border text-muted bg-white fw-normal">Selanjutnya</a>
            @else
                <button class="btn btn-light btn-custom-radius border text-muted bg-white fw-normal" disabled>Selanjutnya</button>
            @endif
        </div>
    </div>

</div>

<!-- Form Request Penghapusan Data Tersembunyi -->
<form id="formActionDeleteHidden" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Modal Pop-Up TAMBAH STOK BARU -->
<div class="modal fade" id="modalTambahStokBaru" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 8px;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" style="font-size: 1.1rem; color: #383E49;">Tambah Item Stok Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/stok/store" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" placeholder="Contoh: Es Puter Cup" required style="border-radius: 4px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">SKU Produk</label>
                        <input type="text" name="sku" class="form-control" placeholder="Contoh: EKB-009" required style="border-radius: 4px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Harga Varian (Rp)</label>
                        <input type="number" name="harga" class="form-control" placeholder="5000" min="0" required style="border-radius: 4px;">
                    </div>
                    <div>
                        <label class="form-label small fw-semibold text-dark">Jumlah Stok Awal</label>
                        <input type="number" name="stok" class="form-control" placeholder="100" min="0" required style="border-radius: 4px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light btn-custom-radius border text-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-custom-radius px-4" style="background-color: #0d6efd;">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Pop-Up UBAH CEPAT JUMLAH STOK -->
<div class="modal fade" id="modalUbahStokCepat" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 8px;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" style="font-size: 1.1rem; color: #383E49;">Ubah Kuantitas Stok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('stok.update_cepat') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <input type="hidden" name="produk_id" id="input_edit_id">
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold">Nama Item Produk</label>
                        <input type="text" id="input_edit_nama" class="form-control bg-light border-0" readonly style="font-weight: 500;">
                    </div>
                    <div>
                        <label class="form-label text-dark small fw-bold">Jumlah Ketersediaan Baru</label>
                        <input type="number" name="jumlah_stok" id="input_edit_stok" class="form-control border-secondary-subtle" min="0" required style="border-radius: 4px;">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pb-4 px-4">
                    <button type="button" class="btn btn-light btn-custom-radius border text-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-custom-radius px-4" style="background-color: #0d6efd;">Perbarui Stok</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function pemicuHapusData(id, nama) {
        if(confirm('Apakah kamu benar-benar ingin menghapus varian "' + nama + '" dari data inventaris toko Brasil?')) {
            const form = document.getElementById('formActionDeleteHidden');
            form.action = "/stok/" + id + "/delete";
            form.submit();
        }
    }

    function pemicuModalEdit(id, nama, stok) {
        document.getElementById('input_edit_id').value = id;
        document.getElementById('input_edit_nama').value = nama;
        document.getElementById('input_edit_stok').value = stok;
        
        const instansiModal = new bootstrap.Modal(document.getElementById('modalUbahStokCepat'));
        instansiModal.show();
    }
</script>
@endsection