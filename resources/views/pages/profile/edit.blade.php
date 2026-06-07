@extends('layouts.app')

@section('content')

<div class="profile-page">

<div class="container profile-layout">

    {{-- ================= SIDEBAR ================= --}}

    <aside class="profile-sidebar">

        <div class="sidebar-profile">

            <img
                src="{{ $user->avatar
                    ? asset('storage/'.$user->avatar)
                    : asset('assets/img/profile/user-photo-profile.png') }}"
                class="avatar-lg"
                alt="Avatar">

            <h3>

                {{ trim(($user->first_name ?? '').' '.($user->last_name ?? ''))
                    ?: $user->name }}

            </h3>

            <small>

                {{ $user->email }}

            </small>

        </div>

        <div class="sidebar-menu">

            <a
                href="{{ route('profile.edit') }}"
                class="menu-btn active">

                👤 Profil

            </a>

            <a
                href="{{ route('riwayat.transaksi.penyewa') }}"
                class="menu-btn">

                📜 Riwayat

            </a>

            <a
                href="{{ route('profile.edit') }}"
                class="menu-btn">

                ⚙ Pengaturan

            </a>

            <a
                href="#"
                class="menu-btn">

                💳 Cicilan

            </a>

            <form
                action="{{ route('logout') }}"
                method="POST">

                @csrf

                <button
                    type="submit"
                    class="menu-btn logout-btn">

                    🚪 Keluar

                </button>

            </form>

        </div>

    </aside>

    {{-- ================= CONTENT ================= --}}

    <section class="profile-content">

        <div class="profile-card">

            <div class="card-header-flex">

                <div>

                    <h2>

                        Pengaturan Akun

                    </h2>

                    <small>

                        Kelola informasi pribadi akun Rentalin Anda

                    </small>

                </div>

                <button
                    type="button"
                    id="editProfileBtn"
                    class="menu-btn filled">

                    ✏ Edit Details

                </button>

            </div>

            @if(session('status')==='profile-updated')

                <div class="alert alert-success">

                    Profil berhasil diperbarui.

                </div>

            @endif

            <form
                method="POST"
                action="{{ route('profile.update') }}">

                @csrf
                @method('PATCH')

                <div class="form-grid">

                    {{-- Nama Depan --}}
                    <div class="form-group">

                        <label>Nama Depan</label>

                        <input
                            type="text"
                            class="editable"
                            readonly
                            name="first_name"
                            value="{{ old('first_name',$user->first_name) }}">

                    </div>

                    {{-- Nama Belakang --}}
                    <div class="form-group">

                        <label>Nama Belakang</label>

                        <input
                            type="text"
                            class="editable"
                            readonly
                            name="last_name"
                            value="{{ old('last_name',$user->last_name) }}">

                    </div>

                    {{-- Email --}}
                    <div class="form-group full">

                        <label>Alamat Email</label>

                        <input
                            type="email"
                            class="editable"
                            readonly
                            name="email"
                            value="{{ old('email',$user->email) }}">

                    </div>

                    {{-- Alamat --}}
                    <div class="form-group full">

                        <label>Alamat Lengkap</label>

                        <textarea
                            class="editable"
                            readonly
                            name="address"
                            rows="3">{{ old('address',$user->address) }}</textarea>

                    </div>

                    {{-- Kota --}}
                    <div class="form-group">

                        <label>Kota</label>

                        <input
                            type="text"
                            class="editable"
                            readonly
                            name="city"
                            value="{{ old('city',$user->city) }}">

                    </div>

                    {{-- Provinsi --}}
                    <div class="form-group">

                        <label>Provinsi</label>

                        <input
                            type="text"
                            class="editable"
                            readonly
                            name="province"
                            value="{{ old('province',$user->province) }}">

                    </div>

                    {{-- Kode Pos --}}
                    <div class="form-group">

                        <label>Kode Pos</label>

                        <input
                            type="text"
                            class="editable"
                            readonly
                            name="postal_code"
                            value="{{ old('postal_code',$user->postal_code) }}">

                    </div>

                    {{-- Nomor HP --}}
                    <div class="form-group">

                        <label>Nomor HP</label>

                        <input
                            type="text"
                            class="editable"
                            readonly
                            name="phone"
                            value="{{ old('phone',$user->phone) }}">

                    </div>

                </div>

                <div
                    id="saveContainer"
                    style="display:none;margin-top:25px;">

                    <button
                        type="submit"
                        class="menu-btn filled">

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

        {{-- ================= VERIFIKASI IDENTITAS ================= --}}

        <div class="profile-card">

            <div class="card-header-flex">

                <h2>

                    Verifikasi Identitas

                </h2>

                @if($user->kyc)

                    @if($user->kyc->status=='verified')

                        <span class="status-badge">

                            ✔ Terverifikasi

                        </span>

                    @elseif($user->kyc->status=='pending')

                        <span class="status-badge">

                            ⏳ Pending

                        </span>

                    @else

                        <span class="status-badge">

                            ✖ Ditolak

                        </span>

                    @endif

                @else

                    <span class="status-badge">

                        Belum Verifikasi

                    </span>

                @endif

            </div>

            <div class="verifikasi-grid">

                {{-- ================= FOTO KTP ================= --}}

                <div class="upload-box">

                    <h4>Kartu Identitas</h4>

                    @if($user->kyc && $user->kyc->identity_photo)

                        <img
                            src="{{ asset('storage/'.$user->kyc->identity_photo) }}"
                            class="preview-image"
                            alt="KTP">

                    @else

                        <label
                            for="identity_photo"
                            class="upload-placeholder">

                            <div class="upload-icon">

                                ☁️

                            </div>

                            <strong>

                                Unggah Foto KTP

                            </strong>

                            <small>

                                PNG, JPG atau JPEG

                            </small>

                        </label>

                    @endif

                </div>

                {{-- ================= SELFIE ================= --}}

                <div class="upload-box">

                    <h4>Verifikasi Wajah</h4>

                    @if($user->kyc && $user->kyc->selfie_photo)

                        <img
                            src="{{ asset('storage/'.$user->kyc->selfie_photo) }}"
                            class="preview-image"
                            alt="Selfie">

                    @else

                        <div class="selfie-guide">

                            <ul>

                                <li>✔ Wajah terlihat jelas</li>

                                <li>✔ Tidak memakai masker</li>

                                <li>✔ Tidak memakai topi</li>

                                <li>✔ Cahaya cukup terang</li>

                                <li>✔ Sesuai dengan KTP</li>

                            </ul>

                        </div>

                    @endif

                </div>

            </div>

            {{-- ================= PESAN PRIVASI ================= --}}

            <div class="info-box">

                <strong>

                    Pesan Privasi

                </strong>

                <p>

                    Rentalin menjaga seluruh data identitas
                    pengguna dengan sistem keamanan terenkripsi.
                    Dokumen identitas tidak akan dibagikan
                    kepada pengguna lain dan hanya digunakan
                    untuk proses verifikasi.

                </p>

            </div>

            @if(!$user->kyc)

                <div class="verify-action">

                    <a
                        href="{{ route('kyc.step1') }}"
                        class="menu-btn filled">

                        Lengkapi Verifikasi

                    </a>

                </div>

            @elseif($user->kyc->status=='rejected')

                <div class="verify-action">

                    <a
                        href="{{ route('kyc.step1') }}"
                        class="menu-btn filled">

                        Upload Ulang

                    </a>

                </div>

            @endif

        </div>

    </section>

</div>

</div>

{{-- ================= JAVASCRIPT ================= --}}

<script>

document.addEventListener("DOMContentLoaded",function(){

    const editBtn=document.getElementById("editProfileBtn");

    const saveContainer=document.getElementById("saveContainer");

    const inputs=document.querySelectorAll(".editable");

    if(editBtn){

        editBtn.addEventListener("click",function(){

            inputs.forEach(function(input){

                input.removeAttribute("readonly");

                input.removeAttribute("disabled");

            });

            saveContainer.style.display="block";

            editBtn.style.display="none";

        });

    }

});

</script>

@endsection

