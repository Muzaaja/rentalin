<!DOCTYPE html>
<html lang="id">
<head>
    {{-- konfigurasi halaman --}}
    <meta charset="UTF-8">
    <title>Chat - Rentalin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- css utama --}}
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    {{-- realtime chat --}}
    @vite(['resources/js/app.js'])

    {{-- token form --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-[#F5F8FC] min-h-screen text-[#1E1E1E] [font-family:'Plus_Jakarta_Sans',sans-serif]">

{{-- navbar --}}
@include('layouts.partials.navbar')

@php
    // user yang sedang login
    $currentUser = auth()->user();
@endphp

{{-- konten utama --}}
<main class="w-full min-h-[calc(100vh-90px)] px-[16px] sm:px-[28px] md:px-[44px] lg:px-[66px] pt-[28px] pb-[70px]">

    {{-- header halaman --}}
    <section class="mb-[24px]">
        <div class="flex items-start gap-[12px] min-w-0">
            {{-- tombol kembali --}}
            <a href="{{ route('home') }}"
            onclick="event.preventDefault(); if (window.history.length > 1) { window.history.back(); } else { window.location.href = this.href; }"
            class="w-[38px] h-[38px] mt-[2px] rounded-full flex items-center justify-center hover:bg-[#EAF3FF] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition shrink-0"
            aria-label="Kembali">
                <img src="{{ asset('assets/icons/icon-back.png') }}"
                    class="w-[28px] h-[28px] object-contain"
                    alt="Kembali">
            </a>

            <div class="min-w-0">
                <h1 class="text-[28px] sm:text-[32px] font-bold text-[#1F2A44] leading-[38px]">
                    Chat
                </h1>

                <p class="text-[14px] sm:text-[15px] text-[#6B7280] mt-[4px]">
                    Kelola percakapan Rentalin
                </p>
            </div>
        </div>
    </section>

    {{-- filter role --}}
    @if($hasStore)
        <section class="mb-[18px]">
            <div class="flex gap-[10px] overflow-x-auto pb-[2px]">
                <a href="{{ route('chat.index', ['filter' => 'semua']) }}"
                   class="h-[38px] px-[18px] rounded-full text-[13px] font-semibold border whitespace-nowrap inline-flex items-center justify-center transition focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2
                   {{ ($filter ?? 'semua') === 'semua' ? 'bg-[#34699A] text-white border-[#34699A] hover:bg-[#28527A]' : 'text-[#34699A] border-[#BFD8F4] bg-white hover:bg-[#EAF3FF]' }}">
                    Semua
                </a>

                <a href="{{ route('chat.index', ['filter' => 'penyewa']) }}"
                   class="h-[38px] px-[18px] rounded-full text-[13px] font-semibold border whitespace-nowrap inline-flex items-center justify-center transition focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2
                   {{ ($filter ?? 'semua') === 'penyewa' ? 'bg-[#34699A] text-white border-[#34699A] hover:bg-[#28527A]' : 'text-[#34699A] border-[#BFD8F4] bg-white hover:bg-[#EAF3FF]' }}">
                    Sebagai Penyewa
                </a>

                <a href="{{ route('chat.index', ['filter' => 'pemilik']) }}"
                   class="h-[38px] px-[18px] rounded-full text-[13px] font-semibold border whitespace-nowrap inline-flex items-center justify-center transition focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2
                   {{ ($filter ?? 'semua') === 'pemilik' ? 'bg-[#34699A] text-white border-[#34699A] hover:bg-[#28527A]' : 'text-[#34699A] border-[#BFD8F4] bg-white hover:bg-[#EAF3FF]' }}">
                    Sebagai Pemilik
                </a>
            </div>
        </section>
    @endif

    {{-- daftar chat --}}
    <section class="w-full bg-white border border-[#DDE8F5] rounded-[16px] overflow-hidden shadow-[0px_2px_8px_rgba(15,23,42,0.05)]">
        @forelse($rentals as $rental)
            @php
                // posisi user di transaksi
                $isOwner = (int) $currentUser->id === (int) $rental->owner_id;

                // lawan bicara
                $otherUser = $isOwner
                    ? $rental->tenant
                    : $rental->owner;

                // label role di chat
                $roleLabel = $isOwner ? 'Sebagai Pemilik' : 'Sebagai Penyewa';

                // pesan terakhir
                $lastChat = $rental->chats->first();

                $previewMessage = $lastChat
                    ? $lastChat->message
                    : 'Belum ada pesan';

                $previewTime = $lastChat
                    ? $lastChat->created_at->format('H:i')
                    : '';

                // nama barang
                $itemName = $rental->item->name ?? 'Produk Rentalin';
            @endphp

            {{-- item chat --}}
            <a href="{{ route('chat.show', $rental->id) }}"
               class="flex items-center gap-[14px] sm:gap-[18px] px-[16px] sm:px-[22px] py-[16px] sm:py-[18px] border-b border-[#DDE8F5] last:border-b-0 hover:bg-[#F2F7FF] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-inset transition">

                {{-- avatar lawan bicara --}}
                <div class="w-[58px] h-[58px] sm:w-[64px] sm:h-[64px] rounded-full bg-[#D7E5FA] flex items-center justify-center text-[#34699A] font-bold text-[22px] flex-shrink-0 overflow-hidden">
                    @if($otherUser && $otherUser->avatar)
                        <img src="{{ asset('storage/' . $otherUser->avatar) }}"
                             alt="{{ $otherUser->name }}"
                             class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($otherUser->name ?? 'U', 0, 1)) }}
                    @endif
                </div>

                {{-- isi chat --}}
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between gap-[12px]">
                        <h2 class="text-[15px] sm:text-[17px] font-bold text-[#1F2A44] truncate">
                            {{ $otherUser->name ?? 'User' }}
                        </h2>

                        <span class="text-[11px] sm:text-[12px] text-[#9CA3AF] whitespace-nowrap">
                            {{ $previewTime }}
                        </span>
                    </div>

                    <p class="text-[12px] sm:text-[13px] text-[#34699A] truncate mt-[3px]">
                        {{ $roleLabel }} • {{ $itemName }}
                    </p>

                    <p class="text-[13px] sm:text-[14px] text-[#6B7280] truncate mt-[6px]">
                        {{ $previewMessage }}
                    </p>
                </div>
            </a>
        @empty
            {{-- chat kosong --}}
            <div class="px-[20px] py-[46px] text-center">
                <div class="w-[58px] h-[58px] rounded-full bg-[#EAF3FF] mx-auto flex items-center justify-center mb-[14px]">
                    <img src="{{ asset('assets/icons/icon-chat.png') }}"
                         onerror="this.style.display='none'"
                         class="w-[28px] h-[28px] object-contain"
                         alt="Chat">
                </div>

                <p class="text-[15px] font-bold text-[#1F2A44]">
                    Belum ada percakapan
                </p>

                <p class="text-[13px] text-[#6B7280] mt-[5px]">
                    Percakapan akan muncul setelah kamu menghubungi pemilik atau penyewa.
                </p>
            </div>
        @endforelse
    </section>
</main>

{{-- footer --}}
@include('layouts.partials.footer')

</body>
</html>