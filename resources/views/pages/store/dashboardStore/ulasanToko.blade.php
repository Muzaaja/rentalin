<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan & Rating - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        body { background: #F5F7FA; font-family: 'Inter', sans-serif; }
        .page-wrap { width: 100%; max-width: 1289px; margin: 0 auto; padding: 28px 40px 60px; box-sizing: border-box; }
        .page-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
        .btn-back { display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .btn-back img { width: 36px; height: 36px; display: block; }
        .page-title { font-size: 20px; font-weight: 700; color: #1E1E1E; margin: 0; }

        /* ── Layout ── */
        .pengaturan-layout { display: grid; grid-template-columns: 260px 1fr; gap: 24px; align-items: start; }

        /* ── Sidebar (sama di semua halaman pengaturan) ── */
        .sidebar { background: #fff; border-radius: 14px; box-shadow: 0 2px 20px rgba(0,0,0,0.07); overflow: hidden; }
        .sidebar-item { display: flex; align-items: center; gap: 12px; padding: 15px 20px; font-size: 14px; font-weight: 500; color: #374151; text-decoration: none; border-left: 3px solid transparent; transition: all 0.2s; }
        .sidebar-item:hover { background: #F9FAFB; color: #34699A; }
        .sidebar-item.active { background: #EFF6FF; color: #34699A; font-weight: 600; border-left-color: #34699A; }
        .sidebar-item svg { width: 18px; height: 18px; flex-shrink: 0; }

        /* ── Content ── */
        .content-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 20px rgba(0,0,0,0.07); padding: 32px; }
        .content-title { font-size: 18px; font-weight: 700; color: #1E1E1E; margin: 0 0 4px; }
        .content-subtitle { font-size: 13px; color: #6B7280; margin: 0 0 24px; }

        /* ── Rating summary ── */
        .rating-summary { display: grid; grid-template-columns: 180px 1fr; gap: 0; background: #F9FAFB; border-radius: 12px; overflow: hidden; margin-bottom: 24px; }
        .rating-big { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 24px; border-right: 1px solid #E5E7EB; }
        .rating-number { font-size: 48px; font-weight: 800; color: #1E1E1E; font-family: 'Plus Jakarta Sans', sans-serif; line-height: 1; }
        .rating-max { font-size: 20px; color: #9CA3AF; font-weight: 400; }
        .rating-stars { display: flex; gap: 4px; margin: 8px 0 4px; }
        .star { font-size: 18px; }
        .rating-total { font-size: 12px; color: #9CA3AF; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }

        .rating-bars { padding: 16px 24px; display: flex; flex-direction: column; gap: 8px; justify-content: center; }
        .bar-row { display: flex; align-items: center; gap: 12px; }
        .bar-label { font-size: 13px; color: #6B7280; width: 50px; flex-shrink: 0; }
        .bar-track { flex: 1; height: 8px; background: #E5E7EB; border-radius: 4px; overflow: hidden; }
        .bar-fill { height: 100%; border-radius: 4px; background: #F59E0B; }
        .bar-count { font-size: 13px; color: #6B7280; width: 20px; text-align: right; flex-shrink: 0; }

        /* ── Filter + Reviews ── */
        .reviews-layout { display: grid; grid-template-columns: 160px 1fr; gap: 20px; }
        .filter-box { background: #F9FAFB; border-radius: 12px; padding: 16px; }
        .filter-title { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 12px; }
        .filter-item { display: flex; align-items: center; gap: 8px; padding: 8px 0; cursor: pointer; }
        .filter-item input[type="checkbox"] { accent-color: #34699A; width: 15px; height: 15px; cursor: pointer; }
        .filter-item label { font-size: 13px; color: #374151; cursor: pointer; display: flex; align-items: center; gap: 4px; }

        /* ── Review cards ── */
        .reviews-list { display: flex; flex-direction: column; gap: 12px; }
        .review-card { background: #F9FAFB; border-radius: 12px; padding: 16px 20px; }
        .review-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 8px; }
        .reviewer { display: flex; align-items: center; gap: 10px; }
        .reviewer img { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; }
        .reviewer-name { font-size: 14px; font-weight: 600; color: #1E1E1E; }
        .reviewer-stars { display: flex; gap: 2px; margin-top: 2px; }
        .reviewer-stars span { font-size: 13px; }
        .review-date { font-size: 12px; color: #9CA3AF; }
        .review-text { font-size: 13px; color: #374151; margin-bottom: 10px; line-height: 1.5; }
        .btn-balas {
            background: #fff;
            color: #374151;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 8px;
            border: 1px solid #D1D5DB;
            cursor: pointer;
            float: right;
            transition: all 0.2s;
        }
        .btn-balas:hover { border-color: #34699A; color: #34699A; }
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
            </nav>

            {{-- Konten Ulasan & Rating --}}
            <div class="content-card">
                <h2 class="content-title">Ulasan & Rating</h2>
                <p class="content-subtitle">Lihat dan kelola penilaian dari penyewa barang Anda</p>

                {{-- Rating Summary --}}
                <div class="rating-summary">
                    <div class="rating-big">
                        <div>
                            <span class="rating-number">4.9</span><span class="rating-max">/5.0</span>
                        </div>
                        <div class="rating-stars">
                            <span class="star">⭐</span><span class="star">⭐</span><span class="star">⭐</span>
                            <span class="star">⭐</span><span class="star">⭐</span>
                        </div>
                        <div class="rating-total">TOTAL 10 ULASAN</div>
                    </div>
                    <div class="rating-bars">
                        <div class="bar-row">
                            <span class="bar-label">5 Star</span>
                            <div class="bar-track"><div class="bar-fill" style="width: 6%;"></div></div>
                            <span class="bar-count">1</span>
                        </div>
                        <div class="bar-row">
                            <span class="bar-label">4 Star</span>
                            <div class="bar-track"><div class="bar-fill" style="width: 100%;"></div></div>
                            <span class="bar-count">15</span>
                        </div>
                        <div class="bar-row">
                            <span class="bar-label">3 Star</span>
                            <div class="bar-track"><div class="bar-fill" style="width: 0%;"></div></div>
                            <span class="bar-count">0</span>
                        </div>
                        <div class="bar-row">
                            <span class="bar-label">2 Star</span>
                            <div class="bar-track"><div class="bar-fill" style="width: 6%;"></div></div>
                            <span class="bar-count">1</span>
                        </div>
                        <div class="bar-row">
                            <span class="bar-label">1 Star</span>
                            <div class="bar-track"><div class="bar-fill" style="width: 0%;"></div></div>
                            <span class="bar-count">0</span>
                        </div>
                    </div>
                </div>

                {{-- Filter + List --}}
                <div class="reviews-layout">

                    {{-- Filter --}}
                    <div class="filter-box">
                        <div class="filter-title">Filter Ulasan</div>
                        @foreach([5,4,3,2,1] as $star)
                        <div class="filter-item">
                            <input type="checkbox" id="star{{ $star }}" name="filter_star[]" value="{{ $star }}">
                            <label for="star{{ $star }}">⭐ {{ $star }}</label>
                        </div>
                        @endforeach
                    </div>

                    {{-- Review list --}}
                    <div class="reviews-list">

                        <div class="review-card">
                            <div class="review-header">
                                <div class="reviewer">
                                    <img src="https://placehold.co/36x36/34699A/white?text=C" alt="Cap America">
                                    <div>
                                        <div class="reviewer-name">Cap America</div>
                                        <div class="reviewer-stars">
                                            <span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="review-date">14 April 1944</span>
                            </div>
                            <p class="review-text">Buat menumpas nazi juga bisa</p>
                            <div style="clear:both;"></div>
                        </div>

                        <div class="review-card">
                            <div class="review-header">
                                <div class="reviewer">
                                    <img src="https://placehold.co/36x36/DC2626/white?text=R" alt="Red Skull">
                                    <div>
                                        <div class="reviewer-name">Red Skull</div>
                                        <div class="reviewer-stars">
                                            <span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span><span>☆</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="review-date">14 April 1944</span>
                            </div>
                            <p class="review-text">Markas gw hancur gara gara ni tank</p>
                            <div style="clear:both;"></div>
                        </div>

                        <div class="review-card">
                            <div class="review-header">
                                <div class="reviewer">
                                    <img src="https://placehold.co/36x36/DC2626/white?text=R" alt="Red Skull">
                                    <div>
                                        <div class="reviewer-name">Red Skull</div>
                                        <div class="reviewer-stars">
                                            <span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span><span>☆</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="review-date">14 April 1944</span>
                            </div>
                            <p class="review-text">Gw pinjem buat balas dendam</p>
                            <div style="clear:both;"></div>
                        </div>

                        <div class="review-card">
                            <div class="review-header">
                                <div class="reviewer">
                                    <img src="https://placehold.co/36x36/DC2626/white?text=R" alt="Red Skull">
                                    <div>
                                        <div class="reviewer-name">Red Skull</div>
                                        <div class="reviewer-stars">
                                            <span>⭐</span><span>⭐</span><span>☆</span><span>☆</span><span>☆</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="review-date">14 April 1944</span>
                            </div>
                            <p class="review-text">Markas gw hancur gara gara ni tank</p>
                            <div style="clear:both;"></div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </main>

    @include('layouts.partials.footer')

</body>
</html>