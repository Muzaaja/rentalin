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

    $isOwner = (int) $currentUser->id === (int) $rental->owner_id;

    $otherUser = $isOwner
        ? $rental->tenant
        : $rental->owner;

    $myChatRole = $isOwner ? 'Sebagai Pemilik' : 'Sebagai Penyewa';

    $itemName = $rental->item->name ?? 'Produk Rentalin';
    $itemImage = $rental->item->image ?? null;
    $rentalCode = $rental->rental_code ?? ('RTL-' . $rental->id);
@endphp

<main class="w-full">
    <div class="grid grid-cols-12 min-h-[calc(100vh-88px)] border-t border-[#BFD8F4]">

        {{-- SIDEBAR CHAT --}}
        <aside class="col-span-4 bg-white border-r border-[#BFD8F4]">

            <div class="h-[76px] px-6 border-b border-[#BFD8F4] flex items-center justify-between">
                <div>
                    <h1 class="text-[28px] font-bold text-black">Chat</h1>
                    <p class="text-xs text-gray-500">Kelola percakapan Rentalin</p>
                </div>

                <button type="button" class="text-[#34699A]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.1-5.4a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0Z" />
                    </svg>
                </button>
            </div>

            {{-- FILTER ROLE CHAT --}}
            <div class="px-5 py-3 border-b border-[#BFD8F4] flex gap-2 overflow-x-auto">
                <a href="{{ route('chat.index', ['filter' => 'semua']) }}"
                   class="px-3 py-1.5 rounded-full text-xs border whitespace-nowrap
                   {{ ($filter ?? 'semua') === 'semua' ? 'bg-[#34699A] text-white border-[#34699A]' : 'text-[#34699A] border-[#BFD8F4]' }}">
                    Semua
                </a>

                <a href="{{ route('chat.index', ['filter' => 'penyewa']) }}"
                   class="px-3 py-1.5 rounded-full text-xs border whitespace-nowrap
                   {{ ($filter ?? 'semua') === 'penyewa' ? 'bg-[#34699A] text-white border-[#34699A]' : 'text-[#34699A] border-[#BFD8F4]' }}">
                    Sebagai Penyewa
                </a>

                @if($hasStore ?? false)
                    <a href="{{ route('chat.index', ['filter' => 'pemilik']) }}"
                       class="px-3 py-1.5 rounded-full text-xs border whitespace-nowrap
                       {{ ($filter ?? 'semua') === 'pemilik' ? 'bg-[#34699A] text-white border-[#34699A]' : 'text-[#34699A] border-[#BFD8F4]' }}">
                        Sebagai Pemilik
                    </a>
                @endif
            </div>

            <div class="h-[calc(100vh-210px)] overflow-y-auto">
                @forelse($rentals as $item)
                    @php
                        $itemIsOwner = (int) $currentUser->id === (int) $item->owner_id;

                        $itemOtherUser = $itemIsOwner
                            ? $item->tenant
                            : $item->owner;

                        $itemRole = $itemIsOwner ? 'Sebagai Pemilik' : 'Sebagai Penyewa';

                        $lastChat = $item->chats()->latest()->first();

                        $previewMessage = $lastChat
                            ? $lastChat->message
                            : 'Belum ada pesan';

                        $previewTime = $lastChat
                            ? $lastChat->created_at->format('H:i')
                            : '';

                        $sidebarItemName = $item->item->name ?? 'Produk Rentalin';
                    @endphp

                    <a href="{{ route('chat.show', $item->id) }}"
                       class="block px-5 py-4 border-b border-[#BFD8F4] hover:bg-[#F2F7FF] transition
                       {{ (int) $item->id === (int) $rental->id ? 'bg-[#EEF6FF]' : '' }}">

                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full bg-[#D7E5FA] flex items-center justify-center text-[#34699A] font-bold text-xl flex-shrink-0 overflow-hidden">
                                @if($itemOtherUser && $itemOtherUser->avatar)
                                    <img src="{{ asset('storage/' . $itemOtherUser->avatar) }}"
                                         alt="{{ $itemOtherUser->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($itemOtherUser->name ?? 'U', 0, 1)) }}
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between gap-3">
                                    <h2 class="font-semibold text-black truncate">
                                        {{ $itemOtherUser->name ?? 'User' }}
                                    </h2>

                                    <span class="text-sm text-gray-400 whitespace-nowrap">
                                        {{ $previewTime ?: 'Time' }}
                                    </span>
                                </div>

                                <p class="text-xs text-[#34699A] truncate mt-0.5">
                                    {{ $itemRole }} • {{ $sidebarItemName }}
                                </p>

                                <p class="text-gray-400 truncate mt-1">
                                    {{ $previewMessage }}
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-6 text-center text-gray-500 text-sm">
                        Belum ada percakapan.
                    </div>
                @endforelse
            </div>
        </aside>

        {{-- AREA CHAT --}}
        <section class="col-span-8 flex flex-col bg-[#F3F8FD]">

            {{-- HEADER LAWAN CHAT --}}
            <div class="h-[108px] bg-white border-b border-[#BFD8F4] px-7 flex items-center justify-between">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-full bg-[#D7E5FA] flex items-center justify-center text-[#34699A] font-bold text-xl overflow-hidden">
                        @if($otherUser && $otherUser->avatar)
                            <img src="{{ asset('storage/' . $otherUser->avatar) }}"
                                 alt="{{ $otherUser->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($otherUser->name ?? 'U', 0, 1)) }}
                        @endif
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-black">
                            {{ $otherUser->name ?? 'User' }}
                        </h2>
                        <p class="text-[#6A8DFF] text-sm">Online</p>
                        <p class="text-xs text-gray-500">{{ $myChatRole }}</p>
                    </div>
                </div>

                <a href="{{ route('chat.index') }}"
                   class="px-4 py-2 rounded-lg border border-[#34699A] text-[#34699A] text-sm hover:bg-[#EEF6FF]">
                    Kembali
                </a>
            </div>

            {{-- CARD PRODUK / TRANSAKSI --}}
            <div class="px-7 py-4 bg-[#F8FBFF] border-b border-[#DDE8F5]">
                <div class="bg-white border border-[#DDE8F5] rounded-xl p-4 flex items-center justify-between gap-4">

                    <div class="flex items-center gap-4 min-w-0">
                        <div class="w-20 h-20 rounded-lg bg-[#EEF6FF] border border-[#DDE8F5] overflow-hidden flex-shrink-0 flex items-center justify-center text-xs text-gray-400">
                            @if($itemImage)
                                <img src="{{ asset('storage/' . $itemImage) }}"
                                     alt="{{ $itemName }}"
                                     class="w-full h-full object-cover">
                            @else
                                Produk
                            @endif
                        </div>

                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 mb-1">Sedang membahas</p>

                            <h3 class="font-bold text-[#1F2A44] truncate">
                                {{ $itemName }}
                            </h3>

                            <p class="text-sm text-gray-500">
                                ID Transaksi: {{ $rentalCode }}
                            </p>

                            <p class="text-sm text-gray-500">
                                Status:
                                <span class="inline-block px-2 py-1 rounded-full bg-[#E4F8EA] text-[#238C45] text-xs font-semibold">
                                    {{ ucwords(str_replace('_', ' ', $rental->status)) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <a href="#"
                       class="px-4 py-2 rounded-lg border border-[#34699A] text-[#34699A] text-sm hover:bg-[#EEF6FF] whitespace-nowrap">
                        Lihat Detail
                    </a>
                </div>
            </div>

            {{-- TANGGAL --}}
            <div class="text-center text-black font-medium py-4">
                Hari Ini
            </div>

            {{-- MESSAGES --}}
            <div id="messages" class="flex-1 overflow-y-auto px-7 py-4 space-y-4">

                @forelse($rental->chats as $chat)
                    @if((int) $chat->sender_id === (int) auth()->id())
                        <div class="flex justify-end">
                            <div class="max-w-[58%] bg-[#C3DAFE] text-black px-6 py-4 rounded-xl rounded-br-sm">
                                <p>{{ $chat->message }}</p>
                                <p class="text-xs text-gray-500 text-right mt-2">
                                    {{ $chat->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex justify-start">
                            <div class="max-w-[58%] bg-[#FFF1B8] text-black px-6 py-4 rounded-xl rounded-bl-sm">
                                <p>{{ $chat->message }}</p>
                                <p class="text-xs text-gray-500 text-right mt-2">
                                    {{ $chat->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="text-center text-gray-500 text-sm mt-10">
                        Belum ada pesan. Mulai percakapan sekarang.
                    </div>
                @endforelse

            </div>

            {{-- FORM INPUT --}}
            <form id="chat-form" class="px-7 py-5 bg-[#F3F8FD] flex items-center gap-4">
                @csrf

                <div class="flex-1 bg-white border border-[#BFD8F4] rounded-2xl px-4 py-3 flex items-center gap-3">
                    <button type="button" class="text-black text-xl leading-none">
                        +
                    </button>

                    <input
                        type="text"
                        id="message-input"
                        class="flex-1 outline-none bg-transparent text-sm"
                        placeholder="Tulis pesan..."
                        autocomplete="off"
                    >
                </div>

                <button type="submit" class="text-[#6A8DFF] hover:text-[#34699A] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-11 h-11" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M2 21l21-9L2 3v7l15 2-15 2v7z"/>
                    </svg>
                </button>
            </form>
        </section>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rentalId = @json($rental->id);
        const currentUserId = @json(auth()->id());
        const sendUrl = @json(route('chat.send', $rental->id));

        const messagesBox = document.getElementById('messages');
        const form = document.getElementById('chat-form');
        const input = document.getElementById('message-input');

        function scrollToBottom() {
            messagesBox.scrollTop = messagesBox.scrollHeight;
        }

        scrollToBottom();

        function appendMessage(data, isMine) {
            const wrapper = document.createElement('div');
            wrapper.className = isMine ? 'flex justify-end' : 'flex justify-start';

            const bubble = document.createElement('div');

            if (isMine) {
                bubble.className = 'max-w-[58%] bg-[#C3DAFE] text-black px-6 py-4 rounded-xl rounded-br-sm';
            } else {
                bubble.className = 'max-w-[58%] bg-[#FFF1B8] text-black px-6 py-4 rounded-xl rounded-bl-sm';
            }

            const messageText = document.createElement('p');
            messageText.textContent = data.message;

            const timeText = document.createElement('p');
            timeText.className = 'text-xs text-gray-500 text-right mt-2';
            timeText.textContent = data.created_at;

            bubble.appendChild(messageText);
            bubble.appendChild(timeText);
            wrapper.appendChild(bubble);
            messagesBox.appendChild(wrapper);

            scrollToBottom();
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const message = input.value.trim();

            if (!message) {
                return;
            }

            input.value = '';

            fetch(sendUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    message: message,
                }),
            })
            .then(async response => {
                const data = await response.json();

                if (!response.ok) {
                    console.error('Send message error:', data);
                    alert('Pesan gagal dikirim.');
                    return;
                }

                if (data.success) {
                    appendMessage(data.message, true);
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('Pesan gagal dikirim.');
            });
        });

        setTimeout(function () {
            if (!window.Echo) {
                console.error('Echo masih belum aktif. Cek app.js, bootstrap.js, echo.js, dan npm run dev.');
                return;
            }

            console.log('Echo aktif. Masuk ke channel:', `rental-chat.${rentalId}`);

            window.Echo.private(`rental-chat.${rentalId}`)
                .subscribed(() => {
                    console.log('Berhasil subscribe ke channel:', `rental-chat.${rentalId}`);
                })
                .error((error) => {
                    console.error('Gagal subscribe private channel:', error);
                })
                .listen('.message.sent', (event) => {
                    console.log('Event message.sent diterima:', event);

                    if (parseInt(event.sender_id) !== parseInt(currentUserId)) {
                        appendMessage(event, false);
                    }
                });
        }, 500);
    });
</script>

</body>
</html>