@extends('layouts.app')

@push('styles')
<style>
    /* ── Override card agar putih dan ada shadow ── */
    .produk-section .card {
        background: #ffffff !important;
        border-radius: 12px !important;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08) !important;
        overflow: hidden;
        transition: transform .15s, box-shadow .15s;
        display: block;
    }
    .produk-section .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.13) !important;
    }

    /* Gambar item */
    .produk-section .card-img {
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        display: block;
    }

    /* Placeholder gambar */
    .produk-section .card-img-placeholder {
        width: 100%;
        aspect-ratio: 1 / 1;
        background: #EFF6FF;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Body card */
    .produk-section .card-body {
        padding: 12px 14px 14px;
    }
    .produk-section .card-title {
        font-size: 13px;
        font-weight: 600;
        color: #1E1E1E;
        margin: 0 0 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .produk-section .card-price {
        font-size: 13px;
        font-weight: 700;
        color: #34699A;
        margin: 0 0 6px;
    }
    .produk-section .card-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        color: #6B7280;
    }
    .produk-section .card-rating {
        display: flex;
        align-items: center;
        gap: 3px;
    }
    .produk-section .card-rating img {
        width: 13px;
        height: 13px;
    }

    /* Grid produk */
    .produk-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    /* Section background subtle untuk Rekomendasi */
    .produk-section.bg-subtle {
        background: #F0F4F8;
    }

    @media (max-width: 900px) {
        .produk-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 500px) {
        .produk-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    }
</style>
@endpush

@section('content')

    {{-- ═══════════════════════════════════════════ --}}
    {{-- HERO                                        --}}
    {{-- ═══════════════════════════════════════════ --}}
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Sewa Apa Saja,<br>Kapan Saja</h1>
                <p class="hero-desc">Temukan berbagai kebutuhan dalam<br>satu platform yang praktis dan aman.</p>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- KATEGORI                                    --}}
    {{-- ═══════════════════════════════════════════ --}}
    <section class="kategori-section">
        <div class="container">
            <div class="kategori-container-home">

                @php
                    $iconMap = [
                        'elektronik-gadget' => 'icon-gadget@2x.png',
                        'fashion-aksesoris' => 'icon-fashion@2x.png',
                        'pesta-event'       => 'icon-event@2x.png',
                        'rumah-tangga'      => 'icon-rumah-tangga@2x.png',
                        'hobi-olahraga'     => 'icon-hobby@2x.png',
                    ];
                @endphp

                @foreach ($categories as $cat)
                    <a href="{{ route('items.katalog', ['kategori' => $cat->slug]) }}"
                       class="kategori-item" style="text-decoration:none;color:inherit;">
                        <div class="icon-box">
                            <img src="{{ asset('assets/img/kategori/' . ($iconMap[$cat->slug] ?? 'icon-gadget@2x.png')) }}"
                                 alt="{{ $cat->name }}">
                        </div>
                        <p>{{ $cat->name }}</p>
                    </a>
                @endforeach

            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- PRODUK TERPOPULER                           --}}
    {{-- ═══════════════════════════════════════════ --}}
    <section class="produk-section">
        <div class="container">
            <h2 class="section-title">Produk Terpopuler</h2>
            <div class="produk-grid">
                @forelse ($produkTerpopuler as $item)
                    <a href="{{ route('items.show', $item->id) }}" style="text-decoration:none;color:inherit;">
                        <article class="card">
                            @php
                                $images = is_array($item->image) ? $item->image : json_decode($item->image, true);
                                $firstImg = $images[0] ?? null;
                            @endphp
                            @if ($firstImg)
                                <img src="{{ Storage::url($firstImg) }}" alt="{{ $item->name }}" class="card-img" loading="lazy">
                            @else
                                <div class="card-img card-img-placeholder">
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
                                    <div class="card-rating">
                                        <img src="{{ asset('assets/icons/star-rate-rounded.svg') }}" alt="Rating"> 5.0
                                    </div>
                                    <div class="card-renters">• {{ $item->rentals_count }} penyewa</div>
                                    @if ($item->kecamatan)
                                        <div class="card-location">• {{ $item->kecamatan }}</div>
                                    @endif
                                </div>
                            </div>
                        </article>
                    </a>
                @empty
                    <p style="color:#6B7280;font-size:14px;">Belum ada produk tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- REKOMENDASI                                 --}}
    {{-- ═══════════════════════════════════════════ --}}
    <section class="produk-section bg-subtle">
        <div class="container">
            <h2 class="section-title">Rekomendasi untuk Anda</h2>
            <div class="produk-grid">
                @forelse ($rekomendasi as $item)
                    <a href="{{ route('items.show', $item->id) }}" 
                    style="text-decoration:none;color:inherit;flex:0 0 220px;width:220px;min-width:220px;max-width:220px;">
                        <article class="card">
                            @php
                                $images = is_array($item->image) ? $item->image : json_decode($item->image, true);
                                $firstImg = $images[0] ?? null;
                            @endphp
                            @if ($firstImg)
                                <img src="{{ Storage::url($firstImg) }}" alt="{{ $item->name }}" class="card-img" loading="lazy">
                            @else
                                <div class="card-img card-img-placeholder">
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
                                    <div class="card-rating">
                                        <img src="{{ asset('assets/icons/star-rate-rounded.svg') }}" alt="Rating"> 5.0
                                    </div>
                                    @if ($item->kecamatan)
                                        <div class="card-location">• {{ $item->kecamatan }}</div>
                                    @endif
                                </div>
                            </div>
                        </article>
                    </a>
                @empty
                    <p style="color:#6B7280;font-size:14px;">Belum ada rekomendasi.</p>
                @endforelse
            </div>
        </div>
    </section>

@endsection