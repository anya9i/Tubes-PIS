@extends('layouts.app')

@section('content')
<div class="profile-page">

    <h2 class="page-title">Profil User</h2>

    <div class="profile-card">

        {{-- HEADER --}}
        <div class="profile-header">
            <div class="profile-left">
                <img src="{{ asset('images/avatar.jpeg') }}" class="profile-avatar">
                <div>
                    <h4>Adalah Pokoknya</h4>
                    <small>Owner</small>
                </div>
            </div>

            <button id="editBtn" class="btn-edit">EDIT</button>
        </div>

        {{-- FORM --}}
        <form id="profileForm">

            <div class="form-grid">

                <div class="form-group">
                    <label>Nama Depan</label>
                    <input type="text" value="Fakhri" readonly>
                </div>

                <div class="form-group">
                    <label>Nama Belakang</label>
                    <input type="text" value="Pangeran Beji" readonly>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" value="owner@gmail.com" readonly>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" value="Purwokerto, Banyumas" readonly>
                </div>

                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="text" value="+62 838 7777 8000" readonly>
                </div>

                <div class="form-group">
                    <label>Wilayah</label>
                    <input type="text" value="Jawa Tengah" readonly>
                </div>

            </div>

            <button type="submit" id="saveBtn" class="btn-save hidden">
                SIMPAN
            </button>

        </form>
    </div>

</div>
@endsection
