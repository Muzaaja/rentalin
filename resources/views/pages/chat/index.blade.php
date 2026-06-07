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

<main class="max-w-6xl mx-auto px-6 py-8">
    <h1 class="text-2xl font-bold text-[#1F2A44] mb-6">Chat</h1>

    <div class="bg-white border border-[#DDE8F5] rounded-2xl overflow-hidden">
        @forelse($rentals as $rental)
            @php
                $currentUser = auth()->user();

                $otherUser = $currentUser->id == $rental->owner_id
                    ? $rental->tenant
                    : $rental->owner;
            @endphp

            <a href="{{ route('chat.show', $rental->id) }}"
               class="flex items-center gap-4 px-5 py-4 border-b hover:bg-[#F2F7FF] transition">

                <div class="w-12 h-12 rounded-full bg-[#D7E5FA] flex items-center justify-center text-[#34699A] font-bold">
                    {{ strtoupper(substr($otherUser->name ?? 'U', 0, 1)) }}
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex justify-between gap-3">
                        <h2 class="font-semibold text-[#1F2A44] truncate">
                            {{ $otherUser->name ?? 'User' }}
                        </h2>

                        <span class="text-xs text-gray-400">
                            {{ $rental->chats_max_created_at ? \Carbon\Carbon::parse($rental->chats_max_created_at)->format('H:i') : '' }}
                        </span>
                    </div>

                    <p class="text-sm text-gray-500 truncate">
                        {{ $rental->chats->last()?->message ?? 'Belum ada pesan' }}
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