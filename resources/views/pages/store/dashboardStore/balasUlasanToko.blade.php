<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balas Ulasan - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        body { background: #F5F7FA; font-family: 'Inter', sans-serif; margin: 0; }
        .page-wrap { width: 100%; max-width: 1289px; margin: 0 auto; padding: 28px 40px 60px; box-sizing: border-box; }

        /* ── Layout ── */
        .pengaturan-layout { display: grid; grid-template-columns: 260px 1fr; gap: 24px; align-items: start; }

        /* ── Sidebar & Back Button ── */
        .sidebar { background: transparent; border-radius: 14px; overflow: hidden; }
        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 10px 24px 10px;
            text-decoration: none;
            color: #1E1E1E;
        }
        .sidebar-header:hover { opacity: 0.8; }
        .sidebar-header svg { width: 24px; height: 24px; }
        .sidebar-title { font-size: 20px; font-weight: 700; margin: 0; font-family: 'Plus Jakarta Sans', sans-serif;}

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .sidebar-item { display: flex; align-items: center; gap: 12px; padding: 12px 16px; font-size: 14px; font-weight: 500; color: #4B5563; text-decoration: none; border-radius: 8px; transition: all 0.2s; }
        .sidebar-item:hover { background: #E5E7EB; color: #1E1E1E; }
        .sidebar-item.active { background: #EFF6FF; color: #34699A; font-weight: 600; }
        .sidebar-item svg { width: 18px; height: 18px; flex-shrink: 0; }

        /* ── Content ── */
        .content-card { background: transparent; padding: 0; }
        .content-title { font-size: 22px; font-weight: 700; color: #1E1E1E; margin: 0 0 24px; font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Review Target Card ── */
        .review-target {
            margin-bottom: 24px;
        }
        .rt-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }
        .rt-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .rt-user img {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            object-fit: cover;
        }
        .rt-info .name {
            font-size: 14px;
            font-weight: 600;
            color: #1E1E1E;
        }
        .rt-info .date {
            font-size: 11px;
            color: #6B7280;
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }
        .rt-stars {
            color: #FBBF24;
            font-size: 16px;
            letter-spacing: 2px;
        }
        .rt-quote {
            background: #F3F4F6;
            border-left: 3px solid #34699A;
            padding: 14px 16px;
            font-style: italic;
            color: #4B5563;
            font-size: 14px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 16px;
        }
        .rt-product {
            font-size: 12px;
            color: #1E1E1E;
            font-weight: 600;
        }
        .rt-product span {
            color: #34699A;
            margin-left: 4px;
        }

        /* ── Reply Form Box ── */
        .reply-box {
            background: #FFFFFF;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .reply-header {
            padding: 16px 20px 8px;
            font-size: 11px;
            font-weight: 700;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .reply-input {
            width: 100%;
            border: none;
            padding: 8px 20px 20px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: #1E1E1E;
            resize: vertical;
            min-height: 140px;
            box-sizing: border-box;
        }
        .reply-input:focus { outline: none; }
        .reply-input::placeholder { color: #9CA3AF; }
        
        .reply-footer {
            display: flex;
            justify-content: flex-end;
            padding: 12px 20px;
            background: #FFFFFF;
        }
        .btn-kirim {
            background: #34699A;
            color: #FFFFFF;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-kirim:hover { background: #2a557d; }
        
        /* Error Message Styling */
        .text-error {
            color: #DC2626;
            font-size: 12px;
            padding: 0 20px 10px;
            margin-top: -10px;
        }

        /* ── Tip Box ── */
        .tip-box {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #EFF6FF;
            border: 1px solid #BFDBFE;
            border-radius: 8px;
            padding: 14px 16px;
            color: #374151;
            font-size: 13px;
        }
        .tip-box svg {
            color: #3B82F6;
            flex-shrink: 0;
            width: 20px;
            height: 20px;
        }

        /* ── Responsiveness ── */
        @media (max-width: 900px) {
            .pengaturan-layout { grid-template-columns: 1fr; gap: 32px; }
            .sidebar { border-bottom: 1px solid #E5E7EB; padding-bottom: 24px; border-radius: 0; }
            .sidebar-menu { flex-direction: row; flex-wrap: wrap; }
            .page-wrap { padding: 20px; }
        }
        @media (max-width: 480px) {
            .rt-header { flex-direction: column; gap: 12px; }
        }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    <main class="page-wrap">
        <div class="pengaturan-layout">

            {{-- Sidebar Kiri --}}
            <nav class="sidebar">
                <a href="{{ route('store.pengaturan.ulasan') }}" class="sidebar-header">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    <h1 class="sidebar-title">Ulasan & Rating</h1>
                </a>

                <div class="sidebar-menu">
                    <a href="{{ route('store.pengaturan') }}" class="sidebar-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                            <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                        </svg>
                        Informasi Toko
                    </a>
                    <a href="{{ route('store.pengaturan.ulasan') }}" class="sidebar-item active">
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
                </div>
            </nav>

            {{-- Konten Utama: Balas Ulasan --}}
            <div class="content-card">
                <h2 class="content-title">Balas Ulasan</h2>

                {{-- Data Ulasan yang Sedang Dibalas (Dinamis dari Controller) --}}
                <div class="review-target">
                    <div class="rt-header">
                        <div class="rt-user">
                            {{-- Generate inisial 2 huruf dari nama user untuk gambar avatar --}}
                            <img src="https://placehold.co/80x80/1a1a1a/white?text={{ urlencode(substr($review->nama_penyewa, 0, 2)) }}" alt="{{ $review->nama_penyewa }}">
                            <div class="rt-info">
                                <div class="name">{{ $review->nama_penyewa }}</div>
                                <div class="date">{{ $review->tanggal }}</div>
                            </div>
                        </div>
                        <div class="rt-stars">
                            {{-- Menampilkan jumlah bintang secara otomatis --}}
                            @for ($i = 0; $i < $review->rating; $i++)
                                ⭐
                            @endfor
                        </div>
                    </div>
                    
                    <div class="rt-quote">
                        "{{ $review->komentar }}"
                    </div>

                    <div class="rt-product">
                        Produk: <span>{{ $review->produk }}</span>
                    </div>
                </div>

                {{-- Form Balasan --}}
                <form action="{{ route('store.pengaturan.ulasan.simpan', $review->id) }}" method="POST">
                    @csrf
                    <div class="reply-box">
                        <div class="reply-header">
                            Tulis Balasan Anda di Sini
                        </div>
                        <textarea name="reply_text" class="reply-input" placeholder="Terima kasih atas ulasannya! Kami senang Anda menyukai produk kami..." required>{{ old('reply_text') }}</textarea>
                        
                        {{-- Menampilkan pesan error jika validasi controller gagal --}}
                        @error('reply_text')
                            <div class="text-error">{{ $message }}</div>
                        @enderror

                        <div class="reply-footer">
                            <button type="submit" class="btn-kirim">Kirim Balasan</button>
                        </div>
                    </div>
                </form>

                {{-- Kotak Tips --}}
                <div class="tip-box">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Tips: Balas ulasan dengan sopan dan profesional untuk meningkatkan kepercayaan pelanggan baru.</span>
                </div>

            </div>

        </div>
    </main>

    @include('layouts.partials.footer')

</body>
</html>