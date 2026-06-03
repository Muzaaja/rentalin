
@extends('layouts.app')

@section('content')

<div class="profile-page">

    <div class="profile-container">

        {{-- SIDEBAR --}}
        <aside class="profile-sidebar">

            <div class="profile-avatar-section">

                <img
                    src="{{ $user->avatar
                        ? asset('storage/' . $user->avatar)
                        : asset('assets/img/profile/user-photo-profile.png') }}"
                    alt="Profile"
                    class="profile-avatar"
                >

                <h3>{{ $user->name }}</h3>

                <p>{{ $user->email }}</p>

            </div>

            <div class="profile-menu">

                <a href="{{ route('profile.edit') }}"
                   class="profile-menu-item active">

                    Profil

                </a>

                <a href="{{ route('transactions.tenant') }}"
                   class="profile-menu-item">

                    Riwayat

                </a>

                <a href="{{ route('profile.edit') }}"
                   class="profile-menu-item">

                    Pengaturan

                </a>

            </div>

        </aside>

        {{-- CONTENT --}}
        <div class="profile-content">

            {{-- PENGATURAN AKUN --}}
            <div class="profile-card">

                <div class="card-header">

                    <h2>
                        Pengaturan Akun
                    </h2>

                </div>

                <form
                    method="POST"
                    action="{{ route('profile.update') }}"
                >

                    @csrf
                    @method('PATCH')

                    <div class="form-grid">

                        <div class="form-group">

                            <label>
                                Nama
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                            >

                        </div>

                        <div class="form-group">

                            <label>
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                            >

                        </div>

                        <div class="form-group">

                            <label>
                                Nomor HP
                            </label>

                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone', $user->phone) }}"
                            >

                        </div>

                        <div class="form-group full-width">

                            <label>
                                Alamat
                            </label>

                            <textarea
                                name="address"
                                rows="4"
                            >{{ old('address', $user->address) }}</textarea>

                        </div>

                    </div>

                    <div class="form-actions">

                        <button
                            type="submit"
                            class="save-btn"
                        >

                            Edit Details

                        </button>

                    </div>

                </form>

            </div>

            {{-- VERIFIKASI IDENTITAS --}}
            <div class="profile-card">

                <div class="card-header">

                    <h2>
                        Verifikasi Identitas
                    </h2>

                </div>

                <div class="verification-box">

                    <div class="verification-status">

                        <span class="status-badge pending">
                            Belum Terverifikasi
                        </span>

                    </div>

                    <p>
                        Lengkapi verifikasi identitas untuk
                        meningkatkan keamanan akun dan
                        membuka seluruh fitur Rentalin.
                    </p>

                    <a
                        href="{{ route('kyc.step1') }}"
                        class="verify-btn"
                    >

                        Lengkapi Verifikasi

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

