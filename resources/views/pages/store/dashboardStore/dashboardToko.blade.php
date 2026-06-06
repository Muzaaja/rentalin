<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Saya - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        body { background: #F5F7FA; font-family: 'Inter', sans-serif; }

        .page-wrap { width: 100%; max-width: 1289px; margin: 0 auto; padding: 28px 40px 60px; box-sizing: border-box; }

        .page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
        .btn-back { display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .btn-back img { width: 36px; height: 36px; display: block; }
        .page-title { font-size: 20px; font-weight: 700; color: #1E1E1E; margin: 0; }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
            align-items: stretch;
        }

        .card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.07);
            padding: 24px;
        }

        .notif-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            box-sizing: border-box;
        }

        .store-profile { display: flex; align-items: center; gap: 16px; margin-bottom: 0; }
        .store-profile img { width: 56px; height: 56px; border-radius: 50%; object-fit: cover; }
        .store-profile-info h2 { font-size: 18px; font-weight: 700; color: #1E1E1E; margin: 0 0 4px; }
        .store-profile-info span { font-size: 13px; color: #6B7280; }

        .stats-row {
            display: grid;
            grid-template-columns: 1fr auto 1fr auto 1fr auto 1fr;
            align-items: center;
            text-align: center;
            padding: 20px 0;
            border-top: 1px solid #F3F4F6;
            border-bottom: 1px solid #F3F4F6;
            margin: 20px 0;
        }
        .stat-item { display: flex; flex-direction: column; align-items: center; gap: 4px; }
        .stat-number { font-size: 22px; font-weight: 700; color: #34699A; }
        .stat-number.black { color: #1E1E1E; }
        .stat-label { font-size: 12px; color: #6B7280; }
        .stat-divider { width: 1px; background: #E5E7EB; align-self: stretch; }

        .menu-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
        .menu-item { display: flex; flex-direction: column; align-items: center; gap: 10px; cursor: pointer; text-decoration: none; }
        .menu-icon-wrap { width: 60px; height: 60px; border-radius: 14px; background: #34699A; display: flex; align-items: center; justify-content: center; }
        .menu-icon-wrap svg { width: 28px; height: 28px; }
        .menu-label { font-size: 13px; font-weight: 500; color: #374151; text-align: center; }

        .section-title { font-size: 16px; font-weight: 700; color: #1E1E1E; margin: 0 0 16px; }

        .product-table { width: 100%; border-collapse: collapse; }
        .product-table th {
            text-align: left;
            font-size: 13px;
            font-weight: 600;
            color: #6B7280;
            padding: 10px 12px;
            background: #F9FAFB;
        }
        .product-table th:first-child { border-radius: 8px 0 0 8px; }
        .product-table th:last-child { border-radius: 0 8px 8px 0; }
        .product-table td {
            padding: 14px 12px;
            font-size: 14px;
            color: #374151;
            border-bottom: 1px solid #F3F4F6;
            vertical-align: middle;
        }
        .product-table tr:last-child td { border-bottom: none; }

        .badge-aktif {
            display: inline-block;
            background: #D1FAE5;
            color: #065F46;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
        }

        .notif-title { font-size: 16px; font-weight: 700; color: #1E1E1E; margin: 0 0 16px; }
        .notif-list { display: flex; flex-direction: column; gap: 0; }
        .notif-item { display: flex; align-items: flex-start; gap: 12px; padding: 14px 0; border-bottom: 1px solid #F3F4F6; }
        .notif-item:last-child { border-bottom: none; }
        .notif-icon-wrap { width: 38px; height: 38px; border-radius: 10px; background: #EFF6FF; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .notif-icon-wrap.star { background: #FFFBEB; }
        .notif-icon-wrap.alert { background: #FEF2F2; }
        .notif-icon-wrap svg { width: 18px; height: 18px; }
        .notif-body { flex: 1; }
        .notif-body strong { font-size: 13px; font-weight: 600; color: #1E1E1E; display: block; margin-bottom: 2px; }
        .notif-body p { font-size: 12px; color: #6B7280; margin: 0 0 2px; }
        .notif-body .notif-time { font-size: 11px; color: #9CA3AF; }

        .left-col { display: flex; flex-direction: column; gap: 24px; }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    <main class="page-wrap">

        {{-- Header --}}
        <div class="page-header">
            <a href="{{ route('home') }}" class="btn-back">
                <img src="{{ asset('assets/icons/arrow-left-circle.png') }}" alt="Kembali"
                     onerror="this.onerror=null;this.outerHTML='<div style=\'width:36px;height:36px;border-radius:50%;border:1.5px solid #D1D5DB;display:flex;align-items:center;justify-content:center;\'><svg width=\'16\' height=\'16\' viewBox=\'0 0 16 16\' fill=\'none\'><path d=\'M10 13L5 8L10 3\' stroke=\'#374151\' stroke-width=\'1.8\' stroke-linecap=\'round\' stroke-linejoin=\'round\'/></svg></div>'">
            </a>
            <h1 class="page-title">Toko Saya</h1>
        </div>

        <div class="dashboard-grid">

            {{-- Kolom Kiri --}}
            <div class="left-col">

                {{-- Card Profil + Stats + Menu --}}
                <div class="card">

                    {{-- Profil --}}
                    <div class="store-profile">
                        <img src="{{ asset('assets/img/profile/user-photo-profile.png') }}" alt="Foto Toko">
                        <div class="store-profile-info">
                            <h2>Nugi_store</h2>
                            <span>rentalin.com/nugi_store</span>
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="stats-row">
                        <div class="stat-item">
                            <span class="stat-number">1</span>
                            <span class="stat-label">Perlu Dikirim</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-number black">0</span>
                            <span class="stat-label">Pembatalan</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-number black">0</span>
                            <span class="stat-label">Pengembalian</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-number">1</span>
                            <span class="stat-label">Penilaian</span>
                        </div>
                    </div>

                    {{-- Menu Grid --}}
                    <div class="menu-grid">

                        <a href="{{ route('items.index') }}" class="menu-item">
                            <div class="menu-icon-wrap">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M20 7H4C2.9 7 2 7.9 2 9V19C2 20.1 2.9 21 4 21H20C21.1 21 22 20.1 22 19V9C22 7.9 21.1 7 20 7Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M16 7V5C16 3.9 15.1 3 14 3H10C8.9 3 8 3.9 8 5V7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <line x1="12" y1="12" x2="12" y2="16" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="10" y1="14" x2="14" y2="14" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <span class="menu-label">Produk</span>
                        </a>

                        <a href="{{ route('transactions.owner') }}" class="menu-item">
                            <div class="menu-icon-wrap">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M9 5H7C5.9 5 5 5.9 5 7V19C5 20.1 5.9 21 7 21H17C18.1 21 19 20.1 19 19V7C19 5.9 18.1 5 17 5H15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <rect x="9" y="3" width="6" height="4" rx="1" stroke="white" stroke-width="2"/>
                                    <line x1="9" y1="12" x2="15" y2="12" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="9" y1="16" x2="13" y2="16" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <span class="menu-label">Pesanan</span>
                        </a>

                        <a href="{{ route('store.keuangan') }}" class="menu-item">
                            <div class="menu-icon-wrap">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="5" width="20" height="14" rx="3" stroke="white" stroke-width="2"/>
                                    <line x1="2" y1="10" x2="22" y2="10" stroke="white" stroke-width="2"/>
                                    <line x1="6" y1="15" x2="9" y2="15" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="12" y1="15" x2="15" y2="15" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <span class="menu-label">Keuangan</span>
                        </a>

                        <a href="{{ route('store.pengaturan') }}" class="menu-item">
                            <div class="menu-icon-wrap">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <circle cx="12" cy="12" r="3" stroke="white" stroke-width="2"/>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" stroke="white" stroke-width="2"/>
                                </svg>
                            </div>
                            <span class="menu-label">Pengaturan</span>
                        </a>

                    </div>
                </div>

                {{-- Card Produk Aktif --}}
                <div class="card">
                    <h2 class="section-title">Produk Aktif</h2>
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Stok</th>
                                <th>Tersewa</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <img src="{{ asset('assets/img/produk/Rectangle-193@2x.png') }}" alt="iPad"
                                             style="width:36px;height:36px;min-width:36px;border-radius:6px;object-fit:cover;display:block;flex-shrink:0;">
                                        <span style="font-size:14px;color:#374151;white-space:nowrap;">Ipad gen 100 blue</span>
                                    </div>
                                </td>
                                <td>1</td>
                                <td>3</td>
                                <td><span class="badge-aktif">Aktif</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <img src="{{ asset('assets/img/produk/Rectangle-19@2x.png') }}" alt="iPhone"
                                             style="width:36px;height:36px;min-width:36px;border-radius:6px;object-fit:cover;display:block;flex-shrink:0;">
                                        <span style="font-size:14px;color:#374151;white-space:nowrap;">Iphone 16 Promax 1TB</span>
                                    </div>
                                </td>
                                <td>1</td>
                                <td>3</td>
                                <td><span class="badge-aktif">Aktif</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            {{-- Kolom Kanan - Notifikasi --}}
            <div class="card notif-card">
                <h2 class="notif-title">Notifikasi</h2>
                <div class="notif-list">

                    <div class="notif-item">
                        <div class="notif-icon-wrap">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M20 7H4C2.9 7 2 7.9 2 9V19C2 20.1 2.9 21 4 21H20C21.1 21 22 20.1 22 19V9C22 7.9 21.1 7 20 7Z" stroke="#34699A" stroke-width="2"/>
                                <path d="M16 7V5C16 3.9 15.1 3 14 3H10C8.9 3 8 3.9 8 5V7" stroke="#34699A" stroke-width="2"/>
                            </svg>
                        </div>
                        <div class="notif-body">
                            <strong>Pesanan Baru Diterima</strong>
                            <p>Sony WH-1000XM4 telah disewa oleh user_99</p>
                            <span class="notif-time">2 menit yang lalu</span>
                        </div>
                    </div>

                    <div class="notif-item">
                        <div class="notif-icon-wrap star">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="#D97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="notif-body">
                            <strong>Penilaian Baru</strong>
                            <p>Anda mendapatkan bintang 5 dari Ari Setiawan</p>
                            <span class="notif-time">1 jam yang lalu</span>
                        </div>
                    </div>

                    <div class="notif-item">
                        <div class="notif-icon-wrap alert">
                            <svg viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="#DC2626" stroke-width="2"/>
                                <line x1="12" y1="8" x2="12" y2="12" stroke="#DC2626" stroke-width="2" stroke-linecap="round"/>
                                <circle cx="12" cy="16" r="1" fill="#DC2626"/>
                            </svg>
                        </div>
                        <div class="notif-body">
                            <strong>Informasi Sistem</strong>
                            <p>Maintenance sistem dijadwalkan pada jam 00:00 WIB</p>
                            <span class="notif-time">5 jam yang lalu</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </main>

    @include('layouts.partials.footer')

</body>
</html>