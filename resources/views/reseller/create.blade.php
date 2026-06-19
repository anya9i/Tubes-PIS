@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/reseller.css') }}">

<div class="content">
    <div class="form-card">

        <h2 class="form-title">TAMBAH RESELLER</h2>

        <form action="{{ route('reseller.store') }}" method="POST">
            @csrf

            {{-- NAMA --}}
            {{-- Ubah di file create.blade.php --}}
            <div class="form-group full">
                <label>Nama Reseller</label>
                <input type="text" name="nama_lengkap" placeholder="Isi Nama Lengkap" required>
            </div>

            {{-- GRID 2 KOLOM --}}
            <div class="form-grid">
                <div class="form-group">
                    <label>Jenis Toko</label>
                    <select name="jenis_toko">
                        <option value="">Pilih Jenis Toko</option>
                        <option value="Agen">Agen</option>
                        <option value="Reseller">Reseller</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Wilayah</label>
                    <input type="text" name="wilayah" placeholder="Dimana Wilayah Anda?">
                </div>
            </div>

            {{-- ALAMAT --}}
            <div class="form-group full">
                <label>Alamat</label>
                <input type="text" name="alamat" placeholder="Alamat Lengkap Toko">
            </div>

            {{-- TELEPON --}}
            <div class="form-group">
                <label>No. Telepon</label>
                <input 
                    type="text"
                    name="no_telepon"
                    class="form-control"
                    placeholder="Nomor Telepon Aktif"
                    inputmode="numeric"
                    pattern="[0-9]*"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    required
                >
            </div>


            {{-- BUTTON --}}
            <div class="form-actions">
                <a href="/reseller" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">Submit</button>
            </div>
        </form>
    </div>
</div>

@foreach($reseller as $item)
<tr>
    <td>{{ $item->nama_lengkap }}</td> 
    <td>{{ $item->jenis_toko }}</td>
    <td>{{ $item->wilayah }}</td>
    <td>{{ $item->no_telepon }}</td>
    <td>{{ $item->status }}</td>
</tr>
@endforeach
@endsection
