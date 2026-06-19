@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/stok.css') }}">

<div class="content d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="card shadow-lg" style="max-width: 600px; width: 100%; border: none; border-radius: 25px;">
        <div class="text-center py-5 bg-white border-0">
            <h2 class="fw-bold mb-0" style="color: #000; font-size: 2rem;">PERBARUI STOK</h2>
        </div>

        <div class="card-body p-5">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('stok.update') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-bold" style="color: #000;">Pilih Produk</label>
                    <select name="produk_id" class="form-select form-select-lg border-2 border-danger" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($produks as $p)
                            <option value="{{ $p->id }}">
                                {{ $p->nama_produk }} (Stok saat ini: {{ $p->stok }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-5">
                    <label class="form-label fw-bold" style="color: #000;">Jumlah Stok Baru</label>
                    <input type="number" name="jumlah_stok" class="form-control form-control-lg border-2 border-danger"
                           placeholder="Masukkan jumlah stok baru" min="0" required>
                </div>

                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('stok.index') }}" class="btn btn-outline-danger btn-lg px-5">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-success btn-lg px-5">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection