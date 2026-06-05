@extends('layouts.app')

@section('content')

<div class="profile-page">

<div class="container profile-layout">

    {{-- SIDEBAR --}}
    <aside class="profile-sidebar">

        <img
            src="{{ $user->avatar
                ? asset('storage/' . $user->avatar)
                : asset('assets/img/profile/user-photo-profile.png') }}"
            alt="Profile"
            class="avatar-lg"
        >

        <h3>
            {{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: $user->name }}
        </h3>

        <div class="sidebar-menu">

            <a href="{{ route('profile.edit') }}"
               class="menu-btn active">
                👤 Profil
            </a>

            <a href="{{ route('riwayat.transaksi.penyewa') }}"
               class="menu-btn filled">
                ↺ Riwayat
            </a>

            <a href="{{ route('profile.edit') }}"
               class="menu-btn filled">
                ⚙ Pengaturan
            </a>

        </div>

    </aside>

    {{-- CONTENT --}}
    <div class="profile-content">

        {{-- PENGATURAN AKUN --}}
        <div class="profile-card">

            <div class="card-header-flex">

                <h2>Pengaturan Akun</h2>

                <span class="status-badge">
                    Edit Details
                </span>

            </div>

            @if(session('status') === 'profile-updated')
                <div class="alert alert-success mb-3">
                    Profil berhasil diperbarui.
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('profile.update') }}"
            >
                @csrf
                @method('PATCH')

                <div class="form-grid">

                    <div class="form-group">
                        <label>Nama Depan</label>
                        <input
                            type="text"
                            name="first_name"
                            value="{{ old('first_name', $user->first_name) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label>Nama Belakang</label>
                        <input
                            type="text"
                            name="last_name"
                            value="{{ old('last_name', $user->last_name) }}"
                        >
                    </div>

                    <div class="form-group full">
                        <label>Alamat Email</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                        >
                    </div>

                    <div class="form-group full">
                        <label>Alamat Lengkap</label>
                        <input
                            name="address"
                            rows="4"
                        >{{ old('address', $user->address) }}</input>
                    </div>

                    <div class="form-group">
                        <label>Kota</label>
                        <input
                            type="text"
                            name="city"
                            value="{{ old('city', $user->city) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label>Provinsi</label>
                        <input
                            type="text"
                            name="province"
                            value="{{ old('province', $user->province) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label>Kode Pos</label>
                        <input
                            type="text"
                            name="postal_code"
                            value="{{ old('postal_code', $user->postal_code) }}"
                        >
                    </div>

                    <div class="form-group">
                        <label>Nomor HP</label>
                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone', $user->phone) }}"
                        >
                    </div>

                </div>

                <div style="margin-top:25px">
                    <button
                        type="submit"
                        class="menu-btn filled"
                        style="border:none; cursor:pointer;"
                    >
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>

        {{-- VERIFIKASI IDENTITAS --}}
        <div class="profile-card">

            <div class="card-header-flex">

                <h2>Verifikasi Identitas</h2>

                @if(optional($user->kyc)->status === 'verified')
                    <span class="status-badge">
                        Terverifikasi
                    </span>
                @else
                    <span class="status-badge">
                        Belum Verifikasi
                    </span>
                @endif

            </div>

            <div class="verifikasi-grid">

                <div class="upload-box">

                    <div style="font-size:40px;">
                        📄
                    </div>

                    <p>
                        Unggah Foto Identitas Diri
                    </p>

                    <span>
                        Klik untuk mengganti dokumen
                    </span>

                </div>

                <div class="upload-box">

                    <div style="text-align:left; width:100%;">

                        <p style="margin-bottom:15px;">
                            ✔ Pencahayaan bagus, tidak ada bayangan wajah
                        </p>

                        <p style="margin-bottom:15px;">
                            ✔ Wajah harus terlihat jelas
                        </p>

                        <p>
                            ✔ Wajah harus sesuai dengan identitas
                        </p>

                    </div>

                </div>

            </div>

            <div class="info-box">

                <strong>Pesan Privasi</strong>
                <br><br>

                Data sensitif Anda terenkripsi dan hanya digunakan
                untuk kebutuhan verifikasi. Rentalin tidak akan
                membagikan kartu identitas kepada pengguna lain.

            </div>

            <div style="margin-top:20px;">

                <a
                    href="{{ route('kyc.step1') }}"
                    class="menu-btn filled"
                    style="display:inline-flex;"
                >
                    Lengkapi Verifikasi
                </a>

            </div>

        </div>

    </div>

</div>

</div>

@endsection
