@extends('layouts.app')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .stok-interface-wrapper {
        font-family: 'Montserrat', sans-serif !important;
        padding: 40px 30px;
    }

    /* Papan Putih Besar Tunggal Sesuai Mockup UI */
    .papan-stok-putih {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.06);
        padding: 35px 40px;
        border: 1px solid #ebedf0;
    }

    /* Montserrat 20px Bold Hitam untuk Judul */
    .judul-stok-asli {
        font-family: 'Montserrat', sans-serif;
        font-size: 20px !important;
        font-weight: 700 !important;
        color: #000000 !important;
        letter-spacing: -0.2px;
    }

    /* Montserrat 14px Bold Hitam untuk Parameter */
    .th-parameter-stok {
        font-family: 'Montserrat', sans-serif;
        font-size: 14px !important;
        font-weight: 700 !important;
        color: #000000 !important;
        border-bottom: 2px solid #dee2e6 !important;
    }

    /* Montserrat 14px Grey untuk Isi Data */
    .td-isi-stok {
        font-family: 'Montserrat', sans-serif;
        font-size: 14px !important;
        font-weight: 400 !important;
        color: #6c757d !important;
    }

    /* Tombol Aksi Kanan Atas Sesuai Tampilan Baru */
    .btn-custom-radius {
        border-radius: 4px !important;
        font-size: 0.85rem;
        padding: 6px 16px;
    }

    /* Frame Foto Produk Tepat di Samping Kiri Nama */
    .frame-foto-mini {
        width: 44px;
        height: 44px;
        object-fit: cover;
        border-radius: 8px; /* Potongan kotak melengkung halus */
    }

    /* Tombol Teks Ubah & Hapus Samping Ikon */
    .btn-link-ubah {
        font-family: 'Montserrat', sans-serif;
        font-size: 14px !important;
        font-weight: 700 !important;
        color: #0d6efd !important;
        background: none;
        border: none;
        padding: 0;
        text-decoration: none;
    }

    .btn-link-hapus {
        font-family: 'Montserrat', sans-serif;
        font-size: 14px !important;
        font-weight: 700 !important;
        color: #dc3545 !important;
        background: none;
        border: none;
        padding: 0;
        text-decoration: none;
    }

    /* Pagination Footer Desain */
    .kotak-halaman-biru {
        width: 30px;
        height: 30px;
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
    
    <div class="papan-stok-putih">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="judul-stok-asli m-0">Daftar Stok</h4>
            <div class="d-flex gap-2">
                <button class="btn btn-primary btn-custom-radius fw-semibold text-white border-0" style="background-color: #0d6efd;" data-bs-toggle="modal" data-bs-target="#modalTambahStokBaru">
                    Tambah Stok
                </button>
                <button class="btn btn-light btn-custom-radius border bg-white text-muted d-flex align-items-center gap-2" style="font-weight: 500;" onclick="fungsiSortirNamaLive()">
                    <span style="font-size: 0.9rem; color: #6c757d; font-weight: bold; line-height: 1;">⇅</span> Sort
                </button>
                <button class="btn btn-light btn-custom-radius border bg-white text-muted" style="font-weight: 500;" onclick="eksporDataStokCSV()">
                    Download
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table id="tabelStokData" class="table align-middle table-borderless mb-0">
                <thead>
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <th class="py-3 th-parameter-stok" width="90">Foto</th>
                        <th class="py-3 th-parameter-stok">Nama Produk</th>
                        <th class="py-3 th-parameter-stok">SKU Produk</th>
                        <th class="py-3 th-parameter-stok">Harga</th>
                        <th class="py-3 th-parameter-stok">Jumlah Stok</th>
                        <th class="py-3 th-parameter-stok" width="160">Aksi</th>
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
                                <td class="py-2">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" class="frame-foto-mini" alt="Varian">
                                    @else
                                        <img src="{{ asset('images/produk/' . Str::slug($item->nama_produk) . '.jpg') }}" 
                                             class="frame-foto-mini" 
                                             onerror="this.src='{{ asset('images/default-es.jpg') }}'" alt="Varian Es">
                                    @endif
                                </td>
                                <td class="py-3 td-isi-stok" style="color: #000000 !important; font-weight: 500;">{{ $item->nama_produk }}</td>
                                
                                <td class="py-3 td-isi-stok">{{ $item->sku }}</td>
                                
                                <td class="py-3 td-isi-stok">Rp {{ number_format($item->harga, 0, ',', '.') }},00</td>
                                
                                <td class="py-3 td-isi-stok">{{ $item->stok }}</td>
                                
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <button class="btn-custom-radius btn-link-ubah d-flex align-items-center gap-1" onclick="pemicuModalEdit({{ $item->id }})">
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

    <div class="d-flex justify-content-between align-items-center mt-4 px-2">
        <div>
            @if($produk->onFirstPage())
                <button class="btn btn-light btn-custom-radius border text-muted bg-white fw-normal" disabled>Sebelumnya</button>
            @else
                <a href="{{ $produk->previousPageUrl() }}" class="btn btn-light btn-custom-radius border text-muted bg-white fw-normal">Sebelumnya</a>
            @endif
        </div>

        <div class="d-flex flex-column align-items-center">
            <div class="kotak-halaman-biru">
                {{ $produk->currentPage() }}
            </div>
            <span class="text-muted mt-1 td-isi-stok" style="font-size: 12px !important;">
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

<form id="formActionDeleteHidden" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function pemicuHapusData(id, nama) {
        if(confirm('Apakah kamu benar-benar ingin menghapus varian "' + nama + '" dari data inventaris toko Brasil?')) {
            const form = document.getElementById('formActionDeleteHidden');
            form.action = "/stok/" + id + "/delete";
            form.submit();
        }
    }
    
    let urutanSortAscending = true;
    function fungsiSortirNamaLive() {
        const table = document.getElementById("tabelStokData");
        const rows = Array.from(table.rows).slice(1);
        
        rows.sort((a, b) => {
            const teksA = a.cells[1].innerText.toLowerCase().trim();
            const teksB = b.cells[1].innerText.toLowerCase().trim();
            return urutanSortAscending ? teksA.localeCompare(teksB) : teksB.localeCompare(teksA);
        });
        
        urutanSortAscending = !urutanSortAscending;
        const tbody = table.querySelector('tbody');
        rows.forEach(row => tbody.appendChild(row));
    }
</script>
@endsection