<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Toko - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        body { background: #F5F7FA; font-family: 'Inter', sans-serif; }

        .page-wrap { width: 100%; max-width: 1289px; margin: 0 auto; padding: 28px 40px 60px; box-sizing: border-box; }

        /* ── Header ── */
        .page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
        .btn-back { display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .btn-back img { width: 36px; height: 36px; display: block; }
        .page-title { font-size: 20px; font-weight: 700; color: #1E1E1E; margin: 0; }

        /* ── Layout ── */
        .pengaturan-layout {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 24px;
            align-items: start;
        }

        /* ── Sidebar ── */
        .sidebar {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.07);
            overflow: hidden;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.2s;
        }
        .sidebar-item:hover { background: #F9FAFB; color: #34699A; }
        .sidebar-item.active {
            background: #EFF6FF;
            color: #34699A;
            font-weight: 600;
            border-left-color: #34699A;
        }
        .sidebar-item svg { width: 18px; height: 18px; flex-shrink: 0; }

        /* ── Main content ── */
        .content-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.07);
            padding: 32px;
        }
        .content-title { font-size: 18px; font-weight: 700; color: #1E1E1E; margin: 0 0 4px; }
        .content-subtitle { font-size: 13px; color: #6B7280; margin: 0 0 28px; }

        /* ── Info rows ── */
        .info-row {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 18px 0;
            border-bottom: 1px solid #F3F4F6;
        }
        .info-row:first-of-type { border-top: 1px solid #F3F4F6; }
        .info-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #F3F4F6;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .info-icon svg { width: 20px; height: 20px; }
        .info-body { flex: 1; }
        .info-label { font-size: 12px; color: #9CA3AF; margin-bottom: 2px; }
        .info-value { font-size: 14px; font-weight: 500; color: #1E1E1E; }
        .info-value a { color: #34699A; text-decoration: none; }

        .btn-ubah {
            background: #fff;
            color: #374151;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 500;
            padding: 8px 20px;
            border-radius: 8px;
            border: 1px solid #D1D5DB;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-ubah:hover { border-color: #34699A; color: #34699A; }

        .badge-verified {
            display: inline-block;
            background: #34699A;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            margin-left: 8px;
            vertical-align: middle;
        }
        .lock-icon { color: #D1D5DB; }

        /* ── Bantuan box ── */
        .bantuan-box {
            margin-top: 24px;
            background: #EFF6FF;
            border-radius: 12px;
            padding: 20px 24px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .bantuan-box svg { width: 20px; height: 20px; color: #34699A; flex-shrink: 0; margin-top: 2px; }
        .bantuan-box h4 { font-size: 14px; font-weight: 700; color: #34699A; margin: 0 0 4px; }
        .bantuan-box p { font-size: 13px; color: #34699A; margin: 0; }
        .bantuan-box a { color: #34699A; font-weight: 600; }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    <main class="page-wrap">

        {{-- Header --}}
        <div class="page-header">
            <a href="{{ route('store.dashboardToko') }}" class="btn-back">
                <img src="{{ asset('assets/icons/arrow-left-circle.png') }}" alt="Kembali">
            </a>
            <h1 class="page-title">Pengaturan Toko</h1>
        </div>

        <div class="pengaturan-layout">

            {{-- Sidebar --}}
            <nav class="sidebar">
                <a href="{{ route('store.pengaturan') }}" class="sidebar-item active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    Informasi Toko
                </a>
                <a href="{{ route('store.pengaturan.ulasan') }}" class="sidebar-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    Ulasan & Rating
                </a>
                <a href="{{ route('store.pengaturan.pembayaran') }}" class="sidebar-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="5" width="20" height="14" rx="3"/><line x1="2" y1="10" x2="22" y2="10"/>
                    </svg>
                    Metode Pembayaran
                </a>
                <a href="{{ route('store.pengaturan.edukasi') }}" class="sidebar-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5-10-5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                    Pusat Edukasi
                </a>
            </nav>

            {{-- Konten Informasi Toko --}}
            <div class="content-card">
                <h2 class="content-title">Informasi Toko</h2>
                <p class="content-subtitle">Kelola informasi profil dan detail toko Anda</p>

                {{-- Foto Toko --}}
                <div class="info-row">
                    <img src="{{ asset('assets/img/profile/user-photo-profile.png') }}" alt="Foto Toko"
                         style="width:48px; height:48px; border-radius:50%; object-fit:cover; flex-shrink:0;"
                         onerror="this.src='https://placehold.co/48x48/34699A/white?text=T'">
                    <div class="info-body">
                        <div class="info-label">Foto Toko</div>
                        <div class="info-value">Tampilkan foto yang mewakili toko Anda.</div>
                    </div>
                    <button class="btn-ubah">Ubah</button>
                </div>

                {{-- Nama Toko --}}
                <div class="info-row">
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                            <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                        </svg>
                    </div>
                    <div class="info-body">
                        <div class="info-label">Nama Toko</div>
                        <div class="info-value">Nugi_store</div>
                    </div>
                    <button class="btn-ubah">Ubah</button>
                </div>

                {{-- Deskripsi Toko --}}
                <div class="info-row">
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                        </svg>
                    </div>
                    <div class="info-body">
                        <div class="info-label">Deskripsi Toko</div>
                        <div class="info-value">Toko yang menyediakan berbagai produk berkualitas dengan harga terjangkau yang bisa anda sewa.</div>
                    </div>
                    <button class="btn-ubah">Ubah</button>
                </div>

                {{-- Link Toko --}}
                <div class="info-row">
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                        </svg>
                    </div>
                    <div class="info-body">
                        <div class="info-label">Link Toko</div>
                        <div class="info-value"><a href="#">rentalin.com/Nugi_store ↗</a></div>
                    </div>
                    <button class="btn-ubah">Ubah</button>
                </div>

                {{-- Status Verifikasi --}}
                <div class="info-row" style="border-bottom: none;">
                    <div class="info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                    </div>
                    <div class="info-body">
                        <div class="info-label">Status Verifikasi</div>
                        <div class="info-value">
                            Identitas toko Anda telah divalidasi oleh sistem keamanan.
                            <span class="badge-verified">TERVERIFIKASI</span>
                        </div>
                    </div>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB" stroke-width="2" class="lock-icon">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </div>

                {{-- Bantuan --}}
                <div class="bantuan-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#34699A" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/>
                        <circle cx="12" cy="16" r="1" fill="#34699A" stroke="none"/>
                    </svg>
                    <div>
                        <h4>Butuh bantuan?</h4>
                        <p>Gunakan <a href="{{ route('store.pengaturan.edukasi') }}">Pusat Edukasi</a> untuk mempelajari cara mengoptimalkan profil toko Anda agar lebih menarik bagi pembeli.</p>
                    </div>
                </div>

            </div>

        </div>

    </main>

    @include('layouts.partials.footer')

</body>
</html>