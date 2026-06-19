@extends('layouts.app') {{-- Sesuaikan dengan nama master layout utama kamu --}}

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid px-4 py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    
    <div class="card border-0 shadow-sm p-4 mb-4 bg-white" style="border-radius: 12px;">
        
        <div class="d-flex gap-2 mb-3">
            <button class="btn btn-sm text-white px-3 fw-bold" style="background-color: #1b6d7a; border-radius: 4px; font-size: 0.85rem;" onclick="toggleDataset(0)">
                <input type="checkbox" id="check-outlet" checked class="form-check-input me-1"> Outlet
            </button>
            <button class="btn btn-sm text-white px-3 fw-bold" style="background-color: #e0b034; border-radius: 4px; font-size: 0.85rem;" onclick="toggleDataset(1)">
                <input type="checkbox" id="check-reseller" checked class="form-check-input me-1"> Reseller
            </button>
            <button class="btn btn-sm text-white px-3 fw-bold" style="background-color: #3b7a9e; border-radius: 4px; font-size: 0.85rem;" onclick="toggleDataset(2)">
                <input type="checkbox" id="check-agen" checked class="form-check-input me-1"> Agen
            </button>
        </div>

        <div style="position: relative; height:320px; width:100%">
            <canvas id="chartStatistik"></canvas>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
        <h4 class="fw-bold text-dark" style="font-family: sans-serif; font-size: 1.4rem;">Distribusi Produk</h4>
        
        <button class="btn btn-outline-secondary btn-sm px-3 bg-white text-muted" style="border-radius: 6px;" onclick="downloadTableAsCSV()">Download</button>
    </div>

    <div class="card border-0 shadow-sm bg-white" style="border-radius: 12px; overflow: hidden;">
        <div class="table-responsive">
            <table id="tabelDistribusi" class="table align-middle mb-0" style="font-size: 0.9rem; font-family: sans-serif;">
                <thead class="table-light text-secondary fw-bold" style="border-bottom: 2px solid #eeecec;">
                    <tr>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3">Jenis Toko</th>
                        <th class="py-3">Tanggal Pesan</th>
                        <th class="py-3">Alamat</th>
                        <th class="py-3">Total Produk</th>
                        <th class="py-3 px-4">ID Pemesanan</th>
                    </tr>
                </thead>
                <tbody class="text-dark">
                    @if($distribusiProduk->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada data distribusi produk.</td>
                        </tr>
                    @else
                        @foreach($distribusiProduk as $item)
                            <tr style="border-bottom: 1px solid #f4f4f4;">
                                <td class="py-3 px-4 text-secondary fw-semibold">{{ $item->nama }}</td>
                                <td class="text-muted">{{ ucfirst($item->jenis_toko) }}</td>
                                <td class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal_pesan)->format('d/m/Y') }}</td>
                                <td class="text-muted">{{ $item->alamat }}</td>
                                <td class="text-muted fw-bold">{{ $item->total_produk }}</td>
                                <td class="py-3 px-4 text-muted">1000{{ $item->id_pemesanan }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    const ctx = document.getElementById('chartStatistik').getContext('2d');
    
    // Instance grafik disimpan ke variabel 'myChart' agar bisa dikontrol fungsi toggle
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'November', 'Desember'],
            datasets: [
                {
                    label: 'Outlet',
                    data: [500, 750, 450, 900, 550, 600, 850, 1100, 800, 950, 600],
                    borderColor: '#1b6d7a',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    tension: 0.3,
                    pointRadius: 0
                },
                {
                    label: 'Reseller',
                    data: [600, 500, 800, 400, 1100, 700, 900, 1000, 1250, 900, 850],
                    borderColor: '#e0b034',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    tension: 0.3,
                    pointRadius: 0
                },
                {
                    label: 'Agen',
                    data: [450, 850, 550, 650, 400, 1150, 950, 900, 1100, 750, 800],
                    borderColor: '#3b7a9e',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    tension: 0.3,
                    pointRadius: 0
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    min: 0,
                    max: 1500,
                    ticks: { stepSize: 300 }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // FUNGSI UNTUK FILTER GRAFIK & TABEL SEKALIGUS
    function toggleDataset(datasetIndex) {
    const checkboxIds = ['check-outlet', 'check-reseller', 'check-agen'];
    const labelToko = ['outlet', 'reseller', 'agen']; // Menyesuaikan dengan data role/jenis toko di database
    
    const checkbox = document.getElementById(checkboxIds[datasetIndex]);
    const isVisible = myChart.isDatasetVisible(datasetIndex);
    
    // 1. Logika untuk Grafik (Chart.js)
    if (isVisible) {
        myChart.hide(datasetIndex);
        checkbox.checked = false;
    } else {
        myChart.show(datasetIndex);
        checkbox.checked = true;
    }

    // 2. LOGIKA UNTUK MENYARING BARIS TABEL
    // Ambil semua status check saat ini (true atau false)
    const outletChecked = document.getElementById('check-outlet').checked;
    const resellerChecked = document.getElementById('check-reseller').checked;
    const agenChecked = document.getElementById('check-agen').checked;

    // Ambil semua baris data di dalam tabel (kecuali bagian paling atas/header)
    const tableRows = document.querySelectorAll("#tabelDistribusi tbody tr");

    tableRows.forEach(row => {
        // Ambil teks dari kolom kedua (Jenis Toko) dan ubah ke huruf kecil semua
        const jenisTokoKolom = row.cells[1].innerText.toLowerCase().trim();

        // Logika kecocokan filter
        if (jenisTokoKolom === 'outlet' && !outletChecked) {
            row.style.display = 'none'; // Sembunyikan jika checkbox outlet mati
        } else if (jenisTokoKolom === 'reseller' && !resellerChecked) {
            row.style.display = 'none'; // Sembunyikan jika checkbox reseller mati
        } else if (jenisTokoKolom === 'agen' && !agenChecked) {
            row.style.display = 'none'; // Sembunyikan jika checkbox agen mati
        } else {
            row.style.display = ''; // Tampilkan kembali jika checkbox menyala
        }
    });
}

    // FUNGSI UNTUK EKSPOR DATA TABEL MENJADI EXCEL/CSV
    function downloadTableAsCSV() {
        const table = document.getElementById("tabelDistribusi");
        let csv = [];
        const rows = table.querySelectorAll("tr");
        
        for (let i = 0; i < rows.length; i++) {
            const row = [];
            const cols = rows[i].querySelectorAll("td, th");
            
            for (let j = 0; j < cols.length; j++) {
                let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, "").replace(/(\s\s+)/gm, " ");
                data = data.replace(/"/g, '""');
                row.push('"' + data + '"');
            }
            csv.push(row.join(","));
        }
        
        const csvString = csv.join("\n");
        const filename = "Laporan_Distribusi_Produk_" + new Date().toISOString().slice(0,10) + ".csv";
        const link = document.createElement("a");
        link.style.display = "none";
        link.setAttribute("href", "data:text/csv;charset=utf-8,\uFEFF" + encodeURIComponent(csvString));
        link.setAttribute("download", filename);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection