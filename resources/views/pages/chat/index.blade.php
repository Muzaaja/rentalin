<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Chat - Rentalin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    @vite(['resources/js/app.js'])

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-[#F5F8FC] min-h-screen text-[#1E1E1E] [font-family:'Plus_Jakarta_Sans',sans-serif]">

@include('layouts.partials.navbar')

@php
    $currentUser = auth()->user();
@endphp

<main class="max-w-6xl mx-auto px-6 py-8">
    <div class="mb-6">
        <h1 class="text-[28px] font-bold text-[#1F2A44]">Chat</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola percakapan Rentalin</p>
    </div>

    @if($hasStore)
        <div class="mb-5 flex gap-2 overflow-x-auto">
            <a href="{{ route('chat.index', ['filter' => 'semua']) }}"
               class="px-4 py-2 rounded-full text-sm border whitespace-nowrap
               {{ ($filter ?? 'semua') === 'semua' ? 'bg-[#34699A] text-white border-[#34699A]' : 'text-[#34699A] border-[#BFD8F4] bg-white' }}">
                Semua
            </a>

            <a href="{{ route('chat.index', ['filter' => 'penyewa']) }}"
               class="px-4 py-2 rounded-full text-sm border whitespace-nowrap
               {{ ($filter ?? 'semua') === 'penyewa' ? 'bg-[#34699A] text-white border-[#34699A]' : 'text-[#34699A] border-[#BFD8F4] bg-white' }}">
                Sebagai Penyewa
            </a>

            <a href="{{ route('chat.index', ['filter' => 'pemilik']) }}"
               class="px-4 py-2 rounded-full text-sm border whitespace-nowrap
               {{ ($filter ?? 'semua') === 'pemilik' ? 'bg-[#34699A] text-white border-[#34699A]' : 'text-[#34699A] border-[#BFD8F4] bg-white' }}">
                Sebagai Pemilik
            </a>
        </div>
    @endif

    <div class="bg-white border border-[#DDE8F5] rounded-2xl overflow-hidden">
        @forelse($rentals as $rental)
            @php
                $isOwner = (int) $currentUser->id === (int) $rental->owner_id;

                $otherUser = $isOwner
                    ? $rental->tenant
                    : $rental->owner;

                $roleLabel = $isOwner ? 'Sebagai Pemilik' : 'Sebagai Penyewa';

                $lastChat = $rental->chats->first();

                $previewMessage = $lastChat
                    ? $lastChat->message
                    : 'Belum ada pesan';

                $previewTime = $lastChat
                    ? $lastChat->created_at->format('H:i')
                    : '';

                $itemName = $rental->item->name ?? 'Produk Rentalin';
            @endphp

            <a href="{{ route('chat.show', $rental->id) }}"
               class="flex items-center gap-4 px-5 py-4 border-b border-[#DDE8F5] hover:bg-[#F2F7FF] transition">

                <div class="w-14 h-14 rounded-full bg-[#D7E5FA] flex items-center justify-center text-[#34699A] font-bold text-xl flex-shrink-0 overflow-hidden">
                    @if($otherUser && $otherUser->avatar)
                        <img src="{{ asset('storage/' . $otherUser->avatar) }}"
                             alt="{{ $otherUser->name }}"
                             class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($otherUser->name ?? 'U', 0, 1)) }}
                    @endif
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex justify-between gap-3">
                        <h2 class="font-semibold text-[#1F2A44] truncate">
                            {{ $otherUser->name ?? 'User' }}
                        </h2>

                        <span class="text-xs text-gray-400 whitespace-nowrap">
                            {{ $previewTime }}
                        </span>
                    </div>

                    <p class="text-xs text-[#34699A] truncate mt-0.5">
                        {{ $roleLabel }} • {{ $itemName }}
                    </p>

                    <p class="text-sm text-gray-500 truncate mt-1">
                        {{ $previewMessage }}
                    </p>
                </div>
            </a>
        @empty
            <div class="p-8 text-center text-gray-500">
                Belum ada percakapan.
            </div>
        @endforelse
    </div>
</main>

@include('layouts.partials.footer')

</body>
</html>