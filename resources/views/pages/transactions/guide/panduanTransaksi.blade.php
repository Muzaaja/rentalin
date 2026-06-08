<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panduan Proses Transaksi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body class="bg-[#F5F7FA] text-[#1E1E1E] [font-family:'Plus_Jakarta_Sans',sans-serif]">

@include('layouts.partials.navbar')

@php
    $role = $role ?? 'penyewa';

    $isPenyewa = $role === 'penyewa';

    $backRoute = $isPenyewa
        ? route('riwayat.transaksi.penyewa')
        : route('riwayat.transaksi.pemilik');

    $roleLabel = $isPenyewa ? 'Penyewa' : 'Pemilik';

    $normalSteps = $isPenyewa
        ? [
            [
                'title' => 'Menunggu Pembayaran',
                'text' => 'Selesaikan pembayaran agar pesanan dapat diproses oleh pemilik.',
                'icon' => 'wallet',
            ],
            [
                'title' => 'Pesanan Diproses',
                'text' => 'Pesanan sudah dibayar dan sedang menunggu pemilik mengirim atau menyerahkan barang.',
                'icon' => 'box',
            ],
            [
                'title' => 'Konfirmasi Penerimaan',
                'text' => 'Klik jika barang sudah diterima dan dokumentasi penerimaan sudah lengkap.',
                'icon' => 'checklist',
            ],
            [
                'title' => 'Sedang Disewa',
                'text' => 'Gunakan barang sesuai durasi sewa. Hubungi pemilik jika perlu koordinasi.',
                'icon' => 'phone',
            ],
            [
                'title' => 'Pesanan Dikembalikan',
                'text' => 'Klik setelah barang diserahkan kembali ke pemilik dan bukti pengembalian sudah diunggah.',
                'icon' => 'return',
            ],
            [
                'title' => 'Nilai',
                'text' => 'Beri penilaian setelah transaksi selesai.',
                'icon' => 'star',
            ],
        ]
        : [
            [
                'title' => 'Pesanan Masuk',
                'text' => 'Pesanan sudah dibayar oleh penyewa dan siap diproses.',
                'icon' => 'box',
            ],
            [
                'title' => 'Konfirmasi Pengiriman',
                'text' => 'Klik jika barang dikirim melalui ekspedisi dan dokumentasi sudah lengkap.',
                'icon' => 'truck',
            ],
            [
                'title' => 'Konfirmasi Penyerahan',
                'text' => 'Klik jika barang diserahkan langsung kepada penyewa melalui COD.',
                'icon' => 'handover',
            ],
            [
                'title' => 'Sedang Disewa',
                'text' => 'Pantau masa sewa dan gunakan chat untuk koordinasi dengan penyewa.',
                'icon' => 'phone',
            ],
            [
                'title' => 'Konfirmasi Pengembalian',
                'text' => 'Klik setelah barang diterima kembali dan kondisi barang sudah diperiksa.',
                'icon' => 'return',
            ],
            [
                'title' => 'Selesai',
                'text' => 'Transaksi selesai dan barang dapat disewakan kembali jika tersedia.',
                'icon' => 'check',
            ],
        ];

    $specialSteps = $isPenyewa
        ? [
            [
                'title' => 'Dibatalkan',
                'text' => 'Pesanan dibatalkan. Jika belum dibayar, tidak ada proses refund.',
                'icon' => 'x',
            ],
            [
                'title' => 'Tinjau Klaim',
                'text' => 'Jika ada kerusakan, masuk ke detail klaim untuk melihat bukti dan memberi tanggapan.',
                'icon' => 'shield',
            ],
            [
                'title' => 'Belum Dikembalikan',
                'text' => 'Masa sewa habis dan barang belum dikembalikan. Segera lakukan pengembalian.',
                'icon' => 'clock',
            ],
            [
                'title' => 'Hubungi Pemilik',
                'text' => 'Gunakan chat untuk janjian COD, cek posisi barang, atau diskusi kendala.',
                'icon' => 'chat',
            ],
            [
                'title' => 'Detail Transaksi',
                'text' => 'Lihat rincian pembayaran, dokumentasi, status, dan bukti transaksi.',
                'icon' => 'doc',
            ],
        ]
        : [
            [
                'title' => 'Dibatalkan',
                'text' => 'Pesanan dibatalkan oleh penyewa sebelum pembayaran dilakukan.',
                'icon' => 'x',
            ],
            [
                'title' => 'Pengajuan Kerusakan',
                'text' => 'Ajukan klaim jika barang kembali dalam kondisi rusak atau tidak sesuai.',
                'icon' => 'shield',
            ],
            [
                'title' => 'Belum Dikembalikan',
                'text' => 'Masa sewa habis dan barang belum dikembalikan oleh penyewa.',
                'icon' => 'clock',
            ],
            [
                'title' => 'Hubungi Penyewa',
                'text' => 'Gunakan chat untuk menanyakan pengembalian, COD, atau kendala transaksi.',
                'icon' => 'chat',
            ],
            [
                'title' => 'Detail Transaksi',
                'text' => 'Lihat rincian pembayaran, dokumentasi, status, klaim, dan riwayat transaksi.',
                'icon' => 'doc',
            ],
        ];

    function guideIconSvg($type)
    {
        return match ($type) {
            'wallet' => '<svg viewBox="0 0 24 24" class="w-[24px] h-[24px]" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 7.5h16v12H4z"/><path d="M16 12h4v3h-4z"/><path d="M4 7.5l11-3v3"/></svg>',
            'box' => '<svg viewBox="0 0 24 24" class="w-[24px] h-[24px]" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 8.5l-9-5-9 5 9 5 9-5z"/><path d="M3 8.5v7l9 5 9-5v-7"/><path d="M12 13.5v7"/></svg>',
            'checklist' => '<svg viewBox="0 0 24 24" class="w-[24px] h-[24px]" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6l1 1 2-2"/><path d="M3 12l1 1 2-2"/><path d="M3 18l1 1 2-2"/></svg>',
            'phone' => '<svg viewBox="0 0 24 24" class="w-[24px] h-[24px]" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.9v3a2 2 0 0 1-2.2 2A19.8 19.8 0 0 1 3.1 5.2 2 2 0 0 1 5.1 3h3a2 2 0 0 1 2 1.7l.4 2.2a2 2 0 0 1-.6 1.8L8.7 9.9a16 16 0 0 0 5.4 5.4l1.2-1.2a2 2 0 0 1 1.8-.6l2.2.4A2 2 0 0 1 22 16.9z"/></svg>',
            'return' => '<svg viewBox="0 0 24 24" class="w-[24px] h-[24px]" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 14l-4-4 4-4"/><path d="M5 10h11a5 5 0 0 1 0 10h-4"/></svg>',
            'star' => '<svg viewBox="0 0 24 24" class="w-[24px] h-[24px]" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3l2.8 5.7 6.2.9-4.5 4.4 1.1 6.2L12 17.3 6.4 20.2 7.5 14 3 9.6l6.2-.9L12 3z"/></svg>',
            'x' => '<svg viewBox="0 0 24 24" class="w-[24px] h-[24px]" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M9 9l6 6"/><path d="M15 9l-6 6"/></svg>',
            'shield' => '<svg viewBox="0 0 24 24" class="w-[24px] h-[24px]" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>',
            'clock' => '<svg viewBox="0 0 24 24" class="w-[24px] h-[24px]" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>',
            'chat' => '<svg viewBox="0 0 24 24" class="w-[24px] h-[24px]" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 12a8 8 0 0 1-8 8H7l-4 3 1.5-5A8 8 0 1 1 21 12z"/><path d="M8 12h.01M12 12h.01M16 12h.01"/></svg>',
            'doc' => '<svg viewBox="0 0 24 24" class="w-[24px] h-[24px]" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 2h9l5 5v15H6z"/><path d="M15 2v6h5"/><path d="M9 13h6"/><path d="M9 17h6"/></svg>',
            'truck' => '<svg viewBox="0 0 24 24" class="w-[24px] h-[24px]" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 6h11v10H3z"/><path d="M14 10h4l3 3v3h-7z"/><circle cx="7" cy="18" r="2"/><circle cx="18" cy="18" r="2"/></svg>',
            'handover' => '<svg viewBox="0 0 24 24" class="w-[24px] h-[24px]" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M7 11l3 3 7-7"/><path d="M3 21h18"/><path d="M5 17h14"/><path d="M6 17V7h12v10"/></svg>',
            'check' => '<svg viewBox="0 0 24 24" class="w-[24px] h-[24px]" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M8 12l2.5 2.5L16 9"/></svg>',
            default => '<svg viewBox="0 0 24 24" class="w-[24px] h-[24px]" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>',
        };
    }
@endphp

<main class="w-full max-w-[435px] sm:max-w-[940px] lg:max-w-[1220px] mx-auto px-[20px] sm:px-[44px] lg:px-[66px] pt-[28px] pb-[80px]">

    {{-- Header --}}
    <section class="mb-[22px]">
        <div class="flex items-center gap-[12px]">
            <a href="{{ $backRoute }}"
               class="w-[34px] h-[34px] flex items-center justify-center shrink-0 rounded-full transition-all duration-200 hover:bg-[#EAF3FF] focus:outline-none focus:ring-2 focus:ring-[#34699A]/30"
               aria-label="Kembali">
                <img src="{{ asset('assets/icons/icon-back.png') }}"
                     class="w-[26px] h-[26px] object-contain"
                     alt="Kembali">
            </a>

            <div>
                <h1 class="text-[22px] sm:text-[26px] font-bold text-[#1E1E1E] leading-[32px]">
                    Panduan Proses Transaksi
                </h1>

                <p class="text-[13px] text-[#6B7280] mt-[4px]">
                    Panduan singkat untuk role {{ $roleLabel }}.
                </p>
            </div>
        </div>
    </section>

    {{-- Role badge --}}
    <section class="mb-[18px]">
        <div class="inline-flex items-center gap-[8px] bg-[#DDEBFF] text-[#34699A] rounded-[8px] px-[14px] py-[8px]">
            <img src="{{ $isPenyewa ? asset('assets/icons/icon-user-blue.png') : asset('assets/icons/icon-store.png') }}"
                class="w-[16px] h-[16px] object-contain"
                alt="{{ $roleLabel }}">

            <span class="text-[13px] font-semibold">
                {{ $roleLabel }}
            </span>
        </div>
    </section>

    {{-- Slide 1 --}}
    <section class="bg-white border border-[#C3DAFE] rounded-[12px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_10px_rgba(15,23,42,0.06)] mb-[18px]">
        <div class="flex items-start justify-between gap-[12px] mb-[14px]">
            <div class="flex items-start gap-[10px]">
                <div class="w-[28px] h-[28px] rounded-full bg-[#EAF3FF] text-[#34699A] flex items-center justify-center shrink-0">
                    <svg viewBox="0 0 24 24" class="w-[17px] h-[17px]" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5z"/>
                    </svg>
                </div>

                <div>
                    <h2 class="text-[16px] sm:text-[18px] font-bold">
                        Panduan Singkat Transaksi
                    </h2>

                    <p class="text-[12px] sm:text-[13px] text-[#6B7280] mt-[3px]">
                        Alur normal transaksi dari awal sampai selesai.
                    </p>
                </div>
            </div>

            <span class="h-[24px] px-[10px] rounded-full bg-[#EAF3FF] text-[#34699A] text-[10px] font-semibold flex items-center">
                Slide 1 dari 2
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-[12px]">
            @foreach($normalSteps as $index => $step)
                <article class="relative bg-white border border-[#D7E5FA] rounded-[10px] px-[13px] py-[14px] min-h-[155px] transition-all duration-200 hover:-translate-y-[2px] hover:shadow-[0px_8px_18px_rgba(52,105,154,0.14)] focus-within:ring-2 focus-within:ring-[#34699A]/25">
                    <div class="absolute top-[10px] left-[10px] w-[18px] h-[18px] rounded-full bg-[#34699A] text-white text-[10px] font-bold flex items-center justify-center">
                        {{ $index + 1 }}
                    </div>

                    <div class="mt-[18px] text-[#34699A]">
                        {!! guideIconSvg($step['icon']) !!}
                    </div>

                    <h3 class="text-[13px] font-bold leading-[18px] mt-[12px]">
                        {{ $step['title'] }}
                    </h3>

                    <p class="text-[11px] text-[#4B5563] leading-[17px] mt-[6px]">
                        {{ $step['text'] }}
                    </p>
                </article>
            @endforeach
        </div>

        <div class="flex justify-center gap-[5px] mt-[16px]">
            <span class="w-[6px] h-[6px] rounded-full bg-[#34699A]"></span>
            <span class="w-[6px] h-[6px] rounded-full bg-[#C3DAFE]"></span>
        </div>
    </section>

    {{-- Slide 2 --}}
    <section class="bg-white border border-[#C3DAFE] rounded-[12px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_10px_rgba(15,23,42,0.06)]">
        <div class="flex items-start justify-between gap-[12px] mb-[14px]">
            <div class="flex items-start gap-[10px]">
                <div class="w-[28px] h-[28px] rounded-full bg-[#EAF3FF] text-[#34699A] flex items-center justify-center shrink-0">
                    <svg viewBox="0 0 24 24" class="w-[17px] h-[17px]" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 7v5"/>
                        <path d="M12 16h.01"/>
                    </svg>
                </div>

                <div>
                    <h2 class="text-[16px] sm:text-[18px] font-bold">
                        Kondisi Khusus Transaksi
                    </h2>

                    <p class="text-[12px] sm:text-[13px] text-[#6B7280] mt-[3px]">
                        Panduan jika transaksi bermasalah atau membutuhkan tindak lanjut.
                    </p>
                </div>
            </div>

            <span class="h-[24px] px-[10px] rounded-full bg-[#EAF3FF] text-[#34699A] text-[10px] font-semibold flex items-center">
                Slide 2 dari 2
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-[12px]">
            @foreach($specialSteps as $index => $step)
                <article class="relative bg-white border border-[#D7E5FA] rounded-[10px] px-[13px] py-[14px] min-h-[155px] transition-all duration-200 hover:-translate-y-[2px] hover:shadow-[0px_8px_18px_rgba(52,105,154,0.14)] focus-within:ring-2 focus-within:ring-[#34699A]/25">
                    <div class="absolute top-[10px] left-[10px] w-[18px] h-[18px] rounded-full bg-[#34699A] text-white text-[10px] font-bold flex items-center justify-center">
                        {{ $index + 1 }}
                    </div>

                    <div class="mt-[18px] text-[#34699A]">
                        {!! guideIconSvg($step['icon']) !!}
                    </div>

                    <h3 class="text-[13px] font-bold leading-[18px] mt-[12px]">
                        {{ $step['title'] }}
                    </h3>

                    <p class="text-[11px] text-[#4B5563] leading-[17px] mt-[6px]">
                        {{ $step['text'] }}
                    </p>
                </article>
            @endforeach
        </div>

        <div class="mt-[16px] bg-[#EAF3FF] text-[#34699A] rounded-[8px] px-[12px] py-[10px] flex items-start gap-[8px]">
            <svg viewBox="0 0 24 24" class="w-[17px] h-[17px] shrink-0 mt-[1px]" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="9"/>
                <path d="M12 8v4"/>
                <path d="M12 16h.01"/>
            </svg>

            <p class="text-[12px] font-medium leading-[18px]">
                Jika transaksi bermasalah, cek detail transaksi atau hubungi {{ $isPenyewa ? 'pemilik' : 'penyewa' }} untuk penyelesaian.
            </p>
        </div>
    </section>
</main>

@include('layouts.partials.footer')

</body>
</html>