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
            grid-template-columns: 1fr 350px;
            gap: 24px;
            align-items: start;
        }

        .card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.07);
            padding: 24px;
        }

        .notif-card { display: flex; flex-direction: column; height: auto; box-sizing: border-box; }
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
        .stat-item { display: flex; flex-direction: column; align-items: center; gap: 4px; text-decoration: none; cursor: pointer; }
        .stat-number { font-size: 22px; font-weight: 700; color: #34699A; }
        .stat-number.black { color: #1E1E1E; }
        .stat-number.red { color: #DC2626; }
        .stat-label { font-size: 12px; color: #6B7280; }
        .stat-divider { width: 1px; background: #E5E7EB; align-self: stretch; }

        .product-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .product-table th {
            text-align: left;
            font-size: 13px;
            font-weight: 600;
            color: #6B7280;
            padding: 10px 12px;
            background: #F9FAFB;
        }
        .product-table th:first-child { width: 65%; border-radius: 8px 0 0 8px; }
        .product-table th:last-child { border-radius: 0 8px 8px 0; }
        .product-table td { padding: 14px 12px; font-size: 14px; color: #374151; border-bottom: 1px solid #F3F4F6; vertical-align: middle; }
        .product-table tr:last-child td { border-bottom: none; }

        .product-name { font-size: 14px; color: #374151; white-space: normal !important; word-break: break-word; line-height: 1.4; }
        .badge-aktif { display: inline-block; background: #D1FAE5; color: #065F46; font-size: 12px; font-weight: 600; padding: 4px 10px; border-radius: 20px; }
        
        .empty-state { text-align: center; padding: 40px 20px; color: #9CA3AF; font-size: 14px; }
        .empty-state svg { width: 48px; height: 48px; margin-bottom: 12px; stroke: #9CA3AF; }

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
        .notif-body p { font-size: 12px; color: #6B7280; margin: 0 0 2px; line-height: 1.4; }
        .notif-body .notif-time { font-size: 11px; color: #9CA3AF; }

        .left-col { display: flex; flex-direction: column; gap: 24px; min-width: 0; }
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

                    {{-- Profil Toko --}}
                    <div class="store-profile">
                        <img src="{{ asset('assets/img/profile/user-photo-profile.png') }}" alt="Foto Toko">
                        <div class="store-profile-info">
                            <h2>{{ Auth::user()->name ?? 'Nugi_store' }}</h2>
                            <span>rentalin.com/{{ Str::slug(Auth::user()->name ?? 'nugi_store') }}</span>
                        </div>
                    </div>

                    {{-- REVISI: Stats Row Terhubung ke Page Riwayat Transaksi Pemilik secara Dinamis --}}
                    <div class="stats-row">
                        <a href="{{ route('transactions.owner', ['status' => 'perlu_dikirim']) }}" class="stat-item">
                            <span class="stat-number">{{ $countPerluDikirim ?? 0 }}</span>
                            <span class="stat-label">Perlu Dikirim</span>
                        </a>
                        <div class="stat-divider"></div>
                        <a href="{{ route('transactions.owner', ['status' => 'bermasalah']) }}" class="stat-item">
                            <span class="stat-number red">{{ $countBermasalah ?? 0 }}</span>
                            <span class="stat-label">Bermasalah</span>
                        </a>
                        <div class="stat-divider"></div>
                        <a href="{{ route('transactions.owner', ['status' => 'pengembalian']) }}" class="stat-item">
                            <span class="stat-number black">{{ $countPengembalian ?? 0 }}</span>
                            <span class="stat-label">Pengembalian</span>
                        </a>
                        <div class="stat-divider"></div>
                        {{-- REVISI FIXED: Rating & Penilaian Dinamis --}}
                        <a href="{{ route('store.pengaturan.ulasan') }}" class="stat-item" style="text-decoration: none; color: inherit;">
                            <span class="stat-number">
                                {{ $countPenilaian ?? 0 }}
                                @if(($averageRating ?? 0) > 0)
                                <span style="font-size: 14px; color: #F59E0B; font-weight: 600; margin-left: 2px;">
                                    ★{{ $averageRating }}
                                </span>
                                @endif
                            </span>
                            <span class="stat-label">Penilaian</span>
                        </a>
                    </div>

                    {{-- REVISI FIX TAMPILAN: Menu Grid Menggunakan Inline CSS untuk Mengunci Jarak Teks --}}
                    <div class="menu-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-top: 25px; margin-bottom: 10px;">

                        <a href="{{ route('items.index') }}" class="menu-item" style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none; min-height: 110px;">
                            <div class="menu-icon-wrap" style="width: 60px; height: 60px; border-radius: 14px; background: #34699A; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-bottom: 10px;">
                                <svg viewBox="0 0 24 24" fill="none" style="width: 28px; height: 28px;">
                                    <path d="M20 7H4C2.9 7 2 7.9 2 9V19C2 20.1 2.9 21 4 21H20C21.1 21 22 20.1 22 19V9C22 7.9 21.1 7 20 7Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M16 7V5C16 3.9 15.1 3 14 3H10C8.9 3 8 3.9 8 5V7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <line x1="12" y1="12" x2="12" y2="16" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="10" y1="14" x2="14" y2="14" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <span class="menu-label" style="font-size: 13px; font-weight: 600; color: #374151; text-align: center; display: block; width: 100%; line-height: 1.2;">Produk</span>
                        </a>

                        <a href="{{ route('transactions.owner') }}" class="menu-item" style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none; min-height: 110px;">
                            <div class="menu-icon-wrap" style="width: 60px; height: 60px; border-radius: 14px; background: #34699A; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-bottom: 10px;">
                                <svg viewBox="0 0 24 24" fill="none" style="width: 28px; height: 28px;">
                                    <path d="M9 5H7C5.9 5 5 5.9 5 7V19C5 20.1 5.9 21 7 21H17C18.1 21 19 20.1 19 19V7C19 5.9 18.1 5 17 5H15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <rect x="9" y="3" width="6" height="4" rx="1" stroke="white" stroke-width="2"/>
                                    <line x1="9" y1="12" x2="15" y2="12" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="9" y1="16" x2="13" y2="16" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <span class="menu-label" style="font-size: 13px; font-weight: 600; color: #374151; text-align: center; display: block; width: 100%; line-height: 1.2;">Pesanan</span>
                        </a>

                        <a href="{{ route('store.keuangan') }}" class="menu-item" style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none; min-height: 110px;">
                            <div class="menu-icon-wrap" style="width: 60px; height: 60px; border-radius: 14px; background: #34699A; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-bottom: 10px;">
                                <svg viewBox="0 0 24 24" fill="none" style="width: 28px; height: 28px;">
                                    <rect x="2" y="5" width="20" height="14" rx="3" stroke="white" stroke-width="2"/>
                                    <line x1="2" y1="10" x2="22" y2="10" stroke="white" stroke-width="2"/>
                                    <line x1="6" y1="15" x2="9" y2="15" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="12" y1="15" x2="15" y2="15" stroke="white" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <span class="menu-label" style="font-size: 13px; font-weight: 600; color: #374151; text-align: center; display: block; width: 100%; line-height: 1.2;">Keuangan</span>
                        </a>

                        <a href="{{ route('store.pengaturan') }}" class="menu-item" style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-decoration: none; min-height: 110px;">
                            <div class="menu-icon-wrap" style="width: 60px; height: 60px; border-radius: 14px; background: #34699A; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-bottom: 10px;">
                                <svg viewBox="0 0 24 24" fill="none" style="width: 28px; height: 28px;">
                                    <circle cx="12" cy="12" r="3" stroke="white" stroke-width="2"/>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" stroke="white" stroke-width="2"/>
                                </svg>
                            </div>
                            <span class="menu-label" style="font-size: 13px; font-weight: 600; color: #374151; text-align: center; display: block; width: 100%; line-height: 1.2;">Pengaturan</span>
                        </a>

                    </div>
                </div>

{{-- Card Produk Aktif DINAMIS --}}
<div class="card">
    <h2 class="section-title">Produk Aktif</h2>
    
    {{-- Cek apakah ada produk yang terdaftar --}}
    @if(isset($products) && !$products->isEmpty())
        <table class="product-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Stok</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                {{-- Menampilkan gambar produk dinamis, sesuaikan field gambar di databasemu --}}
                                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_barang }}"
                                     style="width:36px;height:36px;min-width:36px;border-radius:6px;object-fit:cover;display:block;flex-shrink:0;"
                                     onerror="this.onerror=null;this.src='{{ asset('assets/img/produk/default.png') }}';">
                                <span style="font-size:14px;color:#374151;">{{ $product->nama_barang }}</span>
                            </div>
                        </td>
                        {{-- Sesuai request: Stok dibuat selalu bernilai 1 karena sistem sewa --}}
                        <td>1</td>
                        <td><span class="badge-aktif">Aktif</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        {{-- Tampilan kalau toko belum menambahkan produk atau semua produk sedang disewa --}}
        <div class="empty-state" style="text-align: center; padding: 40px 20px; color: #9CA3AF; font-size: 14px;">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 48px; height: 48px; margin-bottom: 12px; stroke: #9CA3AF;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
            </svg>
            <p>Belum ada produk aktif. Silakan tambahkan produk baru di menu Produk.</p>
        </div>
    @endif
</div>
            </div>

           
            <div class="card notif-card">
                <h2 class="notif-title">Notifikasi</h2>
                
                @if(isset($notifications) && !$notifications->isEmpty())
                    <div class="notif-list">
                        @foreach($notifications as $notif)
                            <div class="notif-item">
                                <div class="notif-icon-wrap {{ $notif->type }}">
                                    @if($notif->type == 'star')
                                        <svg viewBox="0 0 24 24" fill="none"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="#D97706" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    @elseif($notif->type == 'alert')
                                        <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="#DC2626" stroke-width="2"/><line x1="12" y1="8" x2="12" y2="12" stroke="#DC2626" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="16" r="1" fill="#DC2626"/></svg>
                                    @else
                                        <svg viewBox="0 0 24 24" fill="none"><path d="M20 7H4C2.9 7 2 7.9 2 9V19C2 20.1 2.9 21 4 21H20C21.1 21 22 20.1 22 19V9C22 7.9 21.1 7 20 7Z" stroke="#34699A" stroke-width="2"/><path d="M16 7V5C16 3.9 15.1 3 14 3H10C8.9 3 8 3.9 8 5V7" stroke="#34699A" stroke-width="2"/></svg>
                                    @endif
                                </div>
                                <div class="notif-body">
                                    <strong>{{ $notif->title }}</strong>
                                    <p>{{ $notif->message }}</p>
                                    <span class="notif-time">{{ $notif->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Tampilan kalau sistem tidak mengirimkan notifikasi apa-apa --}}
                    <div class="empty-state" style="padding: 20px 0;">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" style="width: 36px; height: 36px;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        <p style="font-size: 13px;">Tidak ada notifikasi saat ini.</p>
                    </div>
                @endif
            </div>

        </div>

    </main>

    @include('layouts.partials.footer')

</body>
</html>