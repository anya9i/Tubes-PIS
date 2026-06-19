@extends('layouts.app')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    .montserrat-main {
        font-family: 'Montserrat', sans-serif;
    }
    
    .judul-statistik {
        font-family: 'Montserrat', sans-serif;
        font-size: 20px !important;
        font-weight: 400 !important;
        color: #444444 !important;
        letter-spacing: -0.3px;
    }
    
    .parameter-text {
        font-family: 'Montserrat', sans-serif;
        font-size: 14px !important;
        font-weight: 700 !important;
        color: #000000 !important;
    }
    
    .isi-text {
        font-family: 'Montserrat', sans-serif;
        font-size: 14px !important;
        font-weight: 400 !important;
        color: #6c757d !important;
    }

    .btn-custom-radius {
        border-radius: 4px !important;
        font-size: 0.85rem;
        padding: 6px 16px;
    }

    .status-badge-radius {
        border-radius: 10px !important;
        font-size: 12px !important;
        font-weight: 600;
        min-width: 95px;
        display: inline-block;
        text-transform: uppercase; /* Membuat teks jadi kapital seperti NON-AKTIF / AKTIF di gambar */
    }
    
    /* Variasi Checkbox agar lebih rapi */
    .form-check-input-custom {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }
</style>

<div class="container-fluid px-4 py-4 bg-light montserrat-main" style="min-height: 100vh;">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="judul-statistik m-0">Daftar Reseller</h4>
        <div class="d-flex gap-2">
            <button class="btn btn-primary btn-custom-radius fw-semibold text-white border-0" style="background-color: #0d6efd;" data-bs-toggle="modal" data-bs-target="#modalTambahReseller">
                Tambah Reseller
            </button>
            <button class="btn btn-danger btn-custom-radius fw-semibold text-white border-0" style="background-color: #dc3545;" onclick="eksekusiHapusMassal()">
                Hapus Reseller
            </button>
            <button class="btn btn-light btn-custom-radius border bg-white text-muted d-flex align-items-center gap-1" onclick="sortNamaTabel()">
                <span style="font-size: 0.75rem; color: #b5b5b5;">⇅</span> Sort
            </button>
            <button class="btn btn-light btn-custom-radius border bg-white text-muted" onclick="eksporDataReseller()">
                Download
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm py-2 px-3 mb-3 small isi-text" style="border-radius: 6px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm bg-white mb-4" style="border-radius: 8px; overflow: hidden;">
        <div class="table-responsive">
            <table id="mainTableReseller" class="table align-middle mb-0" style="min-width: 950px;">
                <thead class="table-light" style="border-bottom: 2px solid #eeecec; background-color: #fdfdfd;">
                    <tr>
                        <th class="py-3 px-4" width="40">
                            <input type="checkbox" id="selectAllCheckbox" class="form-check-input form-check-input-custom" onclick="toggleSemuaCheckbox(this)">
                        </th>
                        <th class="py-3 parameter-text">Nama</th>
                        <th class="py-3 parameter-text">Jenis Toko</th>
                        <th class="py-3 parameter-text">Wilayah</th>
                        <th class="py-3 parameter-text">Alamat</th>
                        <th class="py-3 parameter-text">No Telepon</th>
                        <th class="py-3 text-center parameter-text" width="140">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if($resellers->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center py-5 isi-text">Tidak ada data reseller yang terdata.</td>
                        </tr>
                    @else
                        @foreach($resellers as $reseller)
                            <tr style="border-bottom: 1px solid #f7f7f7;">
                                <td class="py-3 px-4">
                                    <input type="checkbox" class="form-check-input form-check-input-custom cb-reseller" value="{{ $reseller->id }}">
                                </td>
                                <td class="py-3 isi-text" style="font-weight: 500; color: #333 !important;">{{ $reseller->nama_lengkap }}</td>
                                <td class="py-3 isi-text">{{ ucfirst($reseller->role) }}</td>
                                <td class="py-3 isi-text">{{ $reseller->wilayah ?? 'Purwokerto' }}</td>
                                <td class="py-3 isi-text">{{ $reseller->alamat }}</td>
                                <td class="py-3 isi-text">{{ $reseller->no_telepon }}</td>
                                <td class="text-center py-3">
                                    <span class="badge status-badge-radius py-2 text-white" 
                                          style="background-color: {{ strtolower($reseller->status) == 'aktif' ? '#3ACC6C' : '#e63946' }}; cursor: pointer;"
                                          onclick="ubahStatusInteraktif({{ $reseller->id }}, '{{ $reseller->status }}')">
                                        {{ $reseller->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-top mt-4 px-1">
        <div>
            @if($resellers->onFirstPage())
                <button class="btn btn-light btn-custom-radius border text-muted bg-white fw-normal" disabled>Sebelumnya</button>
            @else
                <a href="{{ $resellers->previousPageUrl() }}" class="btn btn-light btn-custom-radius border text-muted bg-white fw-normal">Sebelumnya</a>
            @endif
        </div>

        <div class="d-flex flex-column align-items-center">
            <div class="d-flex justify-content-center align-items-center border border-primary text-primary fw-bold mb-1" 
                 style="width: 28px; height: 28px; background-color: #e6f0fa !important; border-color: #0d6efd !important; border-radius: 4px; font-size: 0.85rem;">
                {{ $resellers->currentPage() }}
            </div>
            <span class="text-muted mt-1 isi-text" style="font-size: 0.8rem !important;">
                Halaman {{ $resellers->currentPage() }} dari {{ $resellers->lastPage() }}
            </span>
        </div>

        <div>
            @if($resellers->hasMorePages())
                <a href="{{ $resellers->nextPageUrl() }}" class="btn btn-light btn-custom-radius border text-muted bg-white fw-normal">Selanjutnya</a>
            @else
                <button class="btn btn-light btn-custom-radius border text-muted bg-white fw-normal" disabled>Selanjutnya</button>
            @endif
        </div>
    </div>

</div>

<form id="hiddenDeleteMassalForm" action="{{ route('reseller.destroyMassal') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="ids" id="inputHapusIds">
</form>

<form id="hiddenStatusForm" action="" method="POST" style="display: none;">@csrf</form>

<div class="modal fade montserrat-main" id="modalTambahReseller" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('reseller.store') }}" method="POST" class="modal-content border-0 shadow-lg" style="border-radius: 6px;">
            @csrf
            <div class="modal-header border-0 bg-light">
                <h6 class="parameter-text m-0">Tambah Mitra Reseller</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 py-3">
                <div class="mb-3">
                    <label class="form-label parameter-text" style="font-size: 12px !important;">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control isi-text" style="border-radius: 4px;" required>
                </div>
                <div class="mb-3">
                    <label class="form-label parameter-text" style="font-size: 12px !important;">Jenis Kemitraan (Toko)</label>
                    <select name="role" class="form-select isi-text" style="border-radius: 4px;" required>
                        <option value="reseller">Reseller</option>
                        <option value="agen">Agen</option>
                        <option value="outlet">Outlet</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label parameter-text" style="font-size: 12px !important;">Wilayah Operasional</label>
                    <input type="text" name="wilayah" class="form-control isi-text" value="Purwokerto" style="border-radius: 4px;" required>
                </div>
                <div class="mb-3">
                    <label class="form-label parameter-text" style="font-size: 12px !important;">Alamat Rumah/Toko</label>
                    <textarea name="alamat" class="form-control isi-text" rows="2" style="border-radius: 4px;" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label parameter-text" style="font-size: 12px !important;">Nomor WhatsApp/Telepon</label>
                    <input type="text" name="no_telepon" class="form-control isi-text" style="border-radius: 4px;" required>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light py-2">
                <button type="button" class="btn btn-secondary btn-custom-radius" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary btn-custom-radius">Simpan Mitra</button>
            </div>
        </form>
    </div>
</div>

<script>
    // 1. Fungsi Klik Checkbox Utama untuk Select All / Unselect All
    function toggleSemuaCheckbox(master) {
        const checkboxes = document.querySelectorAll('.cb-reseller');
        checkboxes.forEach(cb => cb.checked = master.checked);
    }

    // 2. Fungsi Ambil Data Centang & Kirim Form Hapus Ke Controller
    function eksekusiHapusMassal() {
        const terpilih = [];
        document.querySelectorAll('.cb-reseller:checked').forEach(cb => terpilih.push(cb.value));
        
        if (terpilih.length === 0) {
            alert('Silakan centang kotak di samping nama reseller yang ingin kamu hapus terlebih dahulu.');
            return;
        }
        
        if (confirm('Apakah kamu yakin ingin menghapus data ' + terpilih.length + ' reseller yang dicentang?')) {
            document.getElementById('inputHapusIds').value = JSON.stringify(terpilih);
            document.getElementById('hiddenDeleteMassalForm').submit();
        }
    }

    function ubahStatusInteraktif(id, statusSekarang) {
        const statusBaru = (statusSekarang.trim().toLowerCase() === 'aktif') ? 'Tidak aktif' : 'Aktif';
        if(confirm('Ubah status operasional mitra menjadi: ' + statusBaru + '?')) {
            const formStatus = document.getElementById('hiddenStatusForm');
            formStatus.action = "/reseller/" + id + "/update-status?status=" + encodeURIComponent(statusBaru);
            formStatus.submit();
        }
    }

    let urutanAscending = true;
    function sortNamaTabel() {
        const table = document.getElementById("mainTableReseller");
        const rows = Array.from(table.rows).slice(1);
        rows.sort((a, b) => {
            const namaA = a.cells[1].innerText.toLowerCase(); // Indeks kolom nama berubah jadi 1 karena ada checkbox di 0
            const namaB = b.cells[1].innerText.toLowerCase();
            return urutanAscending ? namaA.localeCompare(namaB) : namaB.localeCompare(namaA);
        });
        urutanAscending = !urutanAscending;
        const tbody = table.querySelector('tbody');
        rows.forEach(row => tbody.appendChild(row));
    }

    function eksporDataReseller() {
        const table = document.getElementById("mainTableReseller");
        let csvContent = [];
        const rows = table.querySelectorAll("tr");
        for (let i = 0; i < rows.length; i++) {
            const rowData = [];
            const cols = rows[i].querySelectorAll("td, th");
            // Skip kolom checkbox ke-0 saat diekspor agar file CSV bersih
            for (let j = 1; j < cols.length; j++) {
                let text = cols[j].innerText;
                let cleanData = text.replace(/(\r\n|\n|\r)/gm, "").replace(/(\s\s+)/gm, " ");
                rowData.push('="' + cleanData.replace(/"/g, '""') + '"');
            }
            csvContent.push(rowData.join(","));
        }
        const blob = new Blob(["\uFEFF" + csvContent.join("\n")], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.setAttribute("download", "Laporan_Reseller_Brasil_" + new Date().toISOString().slice(0,10) + ".csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection