<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Edukasi - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        body { background: #F5F7FA; font-family: 'Inter', sans-serif; }
        .page-wrap { width: 100%; max-width: 1289px; margin: 0 auto; padding: 28px 40px 60px; box-sizing: border-box; }
        .page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
        .btn-back { display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .btn-back img { width: 36px; height: 36px; display: block; }
        .page-title { font-size: 20px; font-weight: 700; color: #1E1E1E; margin: 0; }

        .pengaturan-layout { display: grid; grid-template-columns: 260px 1fr; gap: 24px; align-items: start; }

        .sidebar { background: #fff; border-radius: 14px; box-shadow: 0 2px 20px rgba(0,0,0,0.07); overflow: hidden; }
        .sidebar-item { display: flex; align-items: center; gap: 12px; padding: 15px 20px; font-size: 14px; font-weight: 500; color: #374151; text-decoration: none; border-left: 3px solid transparent; transition: all 0.2s; }
        .sidebar-item:hover { background: #F9FAFB; color: #34699A; }
        .sidebar-item.active { background: #EFF6FF; color: #34699A; font-weight: 600; border-left-color: #34699A; }
        .sidebar-item svg { width: 18px; height: 18px; flex-shrink: 0; }

        .content-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 20px rgba(0,0,0,0.07); padding: 32px; }
        .content-title { font-size: 18px; font-weight: 700; color: #1E1E1E; margin: 0 0 28px; }

        /* ── Edukasi grid ── */
        .edukasi-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; }

        .edu-section-title {
            font-size: 15px;
            font-weight: 700;
            color: #1E1E1E;
            margin: 0 0 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #F3F4F6;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .edu-item { padding: 12px 0; border-bottom: 1px solid #F3F4F6; cursor: pointer; }
        .edu-item:last-child { border-bottom: none; }
        .edu-item:hover .edu-item-title { color: #34699A; }
        .edu-item-title { font-size: 14px; font-weight: 600; color: #1E1E1E; margin-bottom: 4px; transition: color 0.2s; }
        .edu-item-desc { font-size: 13px; color: #6B7280; line-height: 1.5; }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    <main class="page-wrap">

        <div class="page-header">
            <a href="{{ route('store.dashboardToko') }}" class="btn-back">
                <img src="{{ asset('assets/icons/arrow-left-circle.png') }}" alt="Kembali">
            </a>
            <h1 class="page-title">Pengaturan Toko</h1>
        </div>

        <div class="pengaturan-layout">

            {{-- Sidebar --}}
            <nav class="sidebar">
                <a href="{{ route('store.pengaturan') }}" class="sidebar-item">
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
                <a href="{{ route('store.pengaturan.edukasi') }}" class="sidebar-item active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5-10-5z"/>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                    </svg>
                    Pusat Edukasi
                </a>
            </nav>

            {{-- Konten Pusat Edukasi --}}
            <div class="content-card">
                <h2 class="content-title">Pusat Edukasi</h2>

                <div class="edukasi-grid">

                    {{-- Panduan Pemula --}}
                    <div>
                        <div class="edu-section-title">📋 Panduan Pemula</div>
                        <div class="edu-item">
                            <div class="edu-item-title">Cara Membuka Toko Baru</div>
                            <div class="edu-item-desc">Daftarkan akun penjual Anda, verifikasi identitas, dan lengkapi detail toko untuk mulai berjualan segera.</div>
                        </div>
                        <div class="edu-item">
                            <div class="edu-item-title">Panduan Dashboard Penjual</div>
                            <div class="edu-item-desc">Kelola stok, pantau pesanan, dan lihat ringkasan penjualan harian Anda melalui panel kontrol utama.</div>
                        </div>
                        <div class="edu-item">
                            <div class="edu-item-title">Verifikasi Rekening Bank</div>
                            <div class="edu-item-desc">Pastikan nama di rekening bank sesuai dengan KTP Anda untuk proses pencairan dana yang lancar.</div>
                        </div>
                        <div class="edu-item">
                            <div class="edu-item-title">Pengaturan Profil Toko</div>
                            <div class="edu-item-desc">Unggah logo menarik dan tulis deskripsi toko yang informatif untuk meningkatkan kepercayaan pembeli.</div>
                        </div>
                    </div>

                    {{-- Manajemen Produk --}}
                    <div>
                        <div class="edu-section-title">📦 Manajemen Produk</div>
                        <div class="edu-item">
                            <div class="edu-item-title">Cara Upload Produk Massal</div>
                            <div class="edu-item-desc">Gunakan fitur template Excel kami untuk mengunggah ratusan produk sekaligus dalam hitungan menit.</div>
                        </div>
                        <div class="edu-item">
                            <div class="edu-item-title">Tips Foto Produk Menarik</div>
                            <div class="edu-item-desc">Gunakan latar belakang polos dan pencahayaan alami untuk menonjolkan fitur terbaik produk Anda.</div>
                        </div>
                        <div class="edu-item">
                            <div class="edu-item-title">Optimasi Judul & Deskripsi</div>
                            <div class="edu-item-desc">Sertakan kata kunci yang relevan agar produk Anda lebih mudah ditemukan oleh calon pembeli.</div>
                        </div>
                        <div class="edu-item">
                            <div class="edu-item-title">Aturan Kategori Produk</div>
                            <div class="edu-item-desc">Pilih kategori yang paling tepat untuk menghindari moderasi produk atau penalti sistem.</div>
                        </div>
                    </div>

                    {{-- Tips Penjualan --}}
                    <div>
                        <div class="edu-section-title">📈 Tips Penjualan</div>
                        <div class="edu-item">
                            <div class="edu-item-title">Cara Ikut Promo Kilat</div>
                            <div class="edu-item-desc">Daftarkan produk unggulan Anda pada jadwal promo mendatang untuk lonjakan traffic instan.</div>
                        </div>
                        <div class="edu-item">
                            <div class="edu-item-title">Membuat Voucher Toko</div>
                            <div class="edu-item-desc">Tingkatkan konversi dengan memberikan potongan harga khusus bagi pembeli baru atau pelanggan setia.</div>
                        </div>
                        <div class="edu-item">
                            <div class="edu-item-title">Analisis Performa Produk</div>
                            <div class="edu-item-desc">Pantau tingkat klik dan rasio pesanan untuk mengetahui produk mana yang perlu dioptimalkan.</div>
                        </div>
                        <div class="edu-item">
                            <div class="edu-item-title">Strategi Iklan Kata Kunci</div>
                            <div class="edu-item-desc">Tentukan budget harian dan pilih kata kunci spesifik untuk mendapatkan ROI iklan yang maksimal.</div>
                        </div>
                    </div>

                    {{-- Kebijakan & Keamanan --}}
                    <div>
                        <div class="edu-section-title">🛡️ Kebijakan & Keamanan</div>
                        <div class="edu-item">
                            <div class="edu-item-title">Aturan Pengiriman Barang</div>
                            <div class="edu-item-desc">Kirim pesanan tepat waktu sesuai batas pengiriman untuk menjaga performa toko Anda tetap hijau.</div>
                        </div>
                        <div class="edu-item">
                            <div class="edu-item-title">Kebijakan Pengembalian Dana</div>
                            <div class="edu-item-desc">Pahami prosedur pengembalian dana untuk menangani komplain pembeli secara profesional dan adil.</div>
                        </div>
                        <div class="edu-item">
                            <div class="edu-item-title">Menghindari Penipuan (Phishing)</div>
                            <div class="edu-item-desc">Jangan pernah memberikan OTP atau password Anda kepada siapapun, termasuk pihak yang mengaku tim kami.</div>
                        </div>
                        <div class="edu-item">
                            <div class="edu-item-title">Sistem Poin Penalti</div>
                            <div class="edu-item-desc">Hindari pelanggaran kebijakan untuk mencegah pembatasan fitur penjualan di akun toko Anda.</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </main>

    @include('layouts.partials.footer')

</body>
</html>