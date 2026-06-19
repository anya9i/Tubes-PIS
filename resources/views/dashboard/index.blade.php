@extends('layouts.app')

@section('content')
<div class="content">

    <div class="card mb-10 border-0 shadow-sm p-4 bg-white/90">
    {{-- Hapus 'items-center' agar konten sejajar dari atas, bukan di tengah --}}
    <div class="flex gap-10 items-start"> 
        <img src="{{ asset('images/lokasi.png') }}"
             class="w-64 h-60 object-cover border border-gray-100">
             
        <div class="pt-2"> {{-- Tambah sedikit padding top agar sejajar dengan bagian atas gambar --}}
            {{-- Tambah 'mb-4' untuk memberi jarak ke bawah --}}
            <h5 class="font-bold text-2xl mb-4 text-gray-900 tracking-tight uppercase">ES KOPI & BRASIL</h5>
            
            <p class="text-gray-500 text-sm leading-relaxed">
                Jl. Jenderal Suprapto No.25, Kauman Lama, Purwokerto Lor, Kec. Purwokerto Timur,
                Kabupaten Banyumas, Jawa Tengah 53114
            </p>
            
            <div class="mt-3 flex items-center gap-2 text-green-700 font-bold text-xs uppercase tracking-widest">
                <a href="https://www.bing.com/maps/directions?name=Pabrik+Brasil+Es+Dan+Kopi&trfc=&FORM=MPSRPL&style=r&rtp=%7Epos.-7.451775550842285_109.28075408935547_Sokaraja%2520JT-22_Pabrik%2520Brasil%2520Es%2520Dan%2520Kopi_ypid%3AYNFFC4AA84529FFC97&cp=-7.451776%7E109.280754&lvl=16" 
                target="_blank" 
                class="btn-google-maps">
                    <i class="fa-solid fa-location-dot me-2"></i> Google Maps
                </a>
            </div>
    </div>
</div>

    <div class="card border-0 shadow-sm bg-white/90 py-10 px-0"> {{-- px-0 agar galeri bisa menyentuh pinggir --}}
        <h2 class="text-2xl font-black text-center mb-10 tracking-[0.2em] uppercase">PROFIL PERUSAHAAN</h2>
        
        <div class="w-full overflow-hidden mb-12">
            <div class="flex gap-0 overflow-x-auto px-10 pb-4">
                @foreach (['image.png', 'image1.png', 'image2.png', 'image3.png'] as $img)
                    <div class="flex-shrink-0 w-50 h-56 border border-gray-200">
                        <img src="{{ asset('images/dashboard/' . $img) }}"
                            alt="Foto Brasil"
                            class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-500">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="px-14 md:px-16">
            <p class="leading-[1,5] text-gray-800 text-lg text-justify font-small" style="font-family: 'Montserrat', sans-serif;">
                Berdiri sejak tahun 1968, <span class="font-bold text-red-600">Ruko Es & Kopi Brasil</span> telah berkembang menjadi lokasi pusat penjualan produk-produk
                unggulan Brasil, oleh-oleh khas Purwokerto, dan tempat makan prasmanan tradisional. Nama “Brasil” dalam merk ini 
                bukan merujuk ke negara, melainkan singkatan dari kata “berhasil”, sebagai doa dan harapan dari pendiri agar usaha 
                ini sukses dan terus dikenal luas. 
                <br><br>
                Selama 56 tahun, Es Brasil terus menjadi usaha keluarga yang turun - temurun 
                mempertahankan cita rasa khas tradisional es puter & es krim untuk dinikmati bersama. Selain es puter tradisional, 
                juga menyediakan varian es krim dengan rasa yang modern seperti <span class="italic">Oreo, Green Tea, Blackforest, Almond, Mocca</span> dan 
                masih banyak lagi. 
                <br><br>
                Kini, Es Brasil telah berkembang menjadi salah satu merek es tradisional yang sangat dikenal 
                oleh masyarakat, tidak hanya di Purwokerto tetapi juga di daerah lainnya, seperti Jakarta. Dengan konsistensi 
                rasa yang tetap terjaga dan inovasi produk yang terus berkembang, perusahaan ini tetap relevan dari masa ke masa 
                dan menjadi salah satu ikon kuliner daerah yang tak lekang oleh waktu.
            </p>
        </div>
    </div>

</div>

<style>
    /* Styling Scrollbar khusus untuk galeri agar tetap rectangle merah */
    .custom-scrollbar::-webkit-scrollbar {
        height: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #ff0000;
        border-radius: 0 !important;
    }
</style>
@endsection