<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $kategoriAktif ? $kategoriAktif->name : 'Katalog' }} - Rentalin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        body { background: #F5F7FA; font-family: 'Inter', sans-serif; }
        .katalog-wrap { width: 100%; max-width: 1289px; margin: 0 auto; padding: 28px 40px 60px; box-sizing: border-box; }

        /* Header */
        .katalog-header { display: flex; align-items: center; gap: 14px; margin-bottom: 28px; }
        .btn-back {
            width: 36px; height: 36px; border-radius: 50%;
            border: 1.5px solid #D1D5DB; background: #fff;
            display: flex; align-items: center; justify-content: center;
            text-decoration: none; color: #374151; flex-shrink: 0;
        }
        .btn-back:hover { background: #F3F4F6; }
        .katalog-header h1 { font-size: 20px; font-weight: 700; color: #1E1E1E; margin: 0; }

        /* Filter kategori */
        .filter-bar { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 24px; }
        .filter-btn {
            padding: 8px 18px; border-radius: 20px; font-size: 13px;
            font-weight: 500; cursor: pointer; text-decoration: none;
            border: 1.5px solid #34699A; color: #34699A; background: #fff;
            transition: all .15s;
        }
        .filter-btn:hover { background: #EFF6FF; }
        .filter-btn.active { background: #34699A; color: #fff; }

        /* Grid produk */
        .produk-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
        }
        .card {
            background: #fff; border-radius: 12px;
            box-shadow: 0 1px 8px rgba(0,0,0,0.07);
            overflow: hidden; text-decoration: none; color: inherit;
            display: block; transition: transform .15s, box-shadow .15s;
        }
        .card:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,0.12); }
        .card-img { width: 100%; aspect-ratio: 1/1; object-fit: cover; display: block; }
        .card-img-placeholder {
            width: 100%; aspect-ratio: 1/1; background: #EFF6FF;
            display: flex; align-items: center; justify-content: center;
        }
        .card-body { padding: 12px; }
        .card-title { font-size: 13px; font-weight: 600; color: #1E1E1E; margin: 0 0 4px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .card-price { font-size: 13px; font-weight: 700; color: #34699A; margin: 0 0 6px; }
        .card-meta { display: flex; flex-wrap: wrap; gap: 4px; font-size: 11px; color: #6B7280; }

        /* Empty state */
        .empty-state { text-align: center; padding: 80px 0; color: #9CA3AF; }
        .empty-state p { font-size: 15px; margin-top: 12px; }

        /* Pagination custom — tidak pakai .pagination bawaan Laravel */
        .pag-wrap { display: flex; justify-content: center; margin-top: 36px; }
        .pag-inner { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; justify-content: center; }
        .pag-btn {
            display: flex; align-items: center; justify-content: center;
            width: 36px; height: 36px; border-radius: 8px;
            border: 1px solid #D1D5DB; background: #fff;
            font-size: 14px; color: #374151; text-decoration: none;
            cursor: pointer; transition: all .15s; font-family: 'Inter', sans-serif;
            box-sizing: border-box;
        }
        .pag-btn:hover { background: #EFF6FF; border-color: #34699A; color: #34699A; }
        .pag-btn.active { background: #34699A; color: #fff; border-color: #34699A; font-weight: 600; }
        .pag-btn.disabled { opacity: 0.35; pointer-events: none; cursor: default; }

        @media (max-width: 1024px) { .produk-grid { grid-template-columns: repeat(4, 1fr); } }
        @media (max-width: 768px)  { .produk-grid { grid-template-columns: repeat(2, 1fr); } }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    <main class="katalog-wrap">

        {{-- Header --}}
        <div class="katalog-header">
            <a href="{{ route('home') }}" class="btn-back">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M10 13L5 8L10 3" stroke="#374151" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <h1>{{ $kategoriAktif ? $kategoriAktif->name : 'Semua Produk' }}</h1>
        </div>

        {{-- Filter bar kategori --}}
        <div class="filter-bar">
            <a href="{{ route('items.katalog', array_merge(request()->except('kategori'), ['search' => request('search')])) }}"
               class="filter-btn {{ !request('kategori') ? 'active' : '' }}">
                Semua
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('items.katalog', array_merge(request()->except('kategori'), ['kategori' => $cat->slug, 'search' => request('search')])) }}"
                   class="filter-btn {{ request('kategori') === $cat->slug ? 'active' : '' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        {{-- Grid produk --}}
        @if ($items->count() > 0)
            <div class="produk-grid">
                @foreach ($items as $item)
                    <a href="{{ route('items.show', $item->id) }}" class="card">
                        @php
                            $images = is_array($item->image) ? $item->image : json_decode($item->image, true);
                            $firstImg = $images[0] ?? null;
                        @endphp

                        @if ($firstImg)
                            <img src="{{ Storage::url($firstImg) }}" alt="{{ $item->name }}" class="card-img" loading="lazy">
                        @else
                            <div class="card-img-placeholder">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
                                    <rect x="3" y="3" width="18" height="18" rx="3" stroke="#34699A" stroke-width="1.5"/>
                                    <path d="M3 9h18" stroke="#34699A" stroke-width="1.5"/>
                                </svg>
                            </div>
                        @endif

                        <div class="card-body">
                            <h3 class="card-title">{{ $item->name }}</h3>
                            <p class="card-price">Rp.{{ number_format($item->price_per_day, 0, ',', '.') }} /hari</p>
                            <div class="card-meta">
                                <span>⭐ 5.0</span>
                                <span>• {{ $item->rentals_count }} penyewa</span>
                                @if ($item->kecamatan)
                                    <span>• {{ $item->kecamatan }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination custom --}}
            @if ($items->hasPages())
            <div class="pag-wrap">
                <div class="pag-inner">

                    {{-- Tombol Prev --}}
                    @if ($items->onFirstPage())
                        <span class="pag-btn disabled">‹</span>
                    @else
                        <a href="{{ $items->previousPageUrl() }}" class="pag-btn">‹</a>
                    @endif

                    {{-- Nomor halaman --}}
                    @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                        @if ($page == $items->currentPage())
                            <span class="pag-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Tombol Next --}}
                    @if ($items->hasMorePages())
                        <a href="{{ $items->nextPageUrl() }}" class="pag-btn">›</a>
                    @else
                        <span class="pag-btn disabled">›</span>
                    @endif

                </div>
            </div>
            @endif

        @else
            <div class="empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none">
                    <rect x="3" y="3" width="18" height="18" rx="3" stroke="#D1D5DB" stroke-width="1.5"/>
                    <path d="M3 9h18" stroke="#D1D5DB" stroke-width="1.5"/>
                </svg>
                <p>Tidak ada produk ditemukan.</p>
            </div>
        @endif

    </main>

    @include('layouts.partials.footer')

</body>
</html>