@extends('layouts.app')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko - Daftar Barang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F9FAFB; }
    </style>
</head>
<body class="text-gray-800">

    @include('layouts.partials.navbar')

    <main class="max-w-6xl mx-auto px-4 py-8">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('home') }}" class="flex items-center justify-center w-8 h-8 rounded-full border-2 border-black hover:bg-gray-100 transition">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Toko</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Barang saya</h2>

            <div class="max-w-md mx-auto mb-8 relative">
                <form action="{{ route('items.index') }}" method="GET">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" id="search-input" name="search" placeholder="cari barang" value="{{ request('search') }}" class="w-full pl-12 pr-4 py-2.5 rounded-full border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition" autocomplete="off">
                </form>
            </div>

            @php
                $categories = [
                    1 => ['icon' => '💻', 'name' => 'Elektronik & Gadget'],
                    2 => ['icon' => '🎉', 'name' => 'Pesta & Event'],
                    3 => ['icon' => '🏠', 'name' => 'Rumah Tangga'],
                    4 => ['icon' => '🏀', 'name' => 'Hobi & Olahraga'],
                    5 => ['icon' => '👗', 'name' => 'Fashion & Aksesoris'],
                ];
                $currentCategory = request('category');
            @endphp

            <div class="flex flex-wrap justify-center gap-3 mb-10">
                <a href="{{ route('items.index', ['search' => request('search')]) }}" 
                class="flex items-center gap-2 px-4 py-2 rounded-xl border text-sm transition {{ !$currentCategory ? 'border-blue-500 bg-blue-50 text-blue-700 font-semibold' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50' }}">
                    Semua
                </a>
                
                @foreach($categories as $id => $cat)
                    <a href="{{ route('items.index', ['category' => $id, 'search' => request('search')]) }}" 
                    class="flex items-center gap-2 px-4 py-2 rounded-xl border text-sm transition {{ $currentCategory == $id ? 'border-blue-500 bg-blue-50 text-blue-700 font-semibold' : 'border-gray-200 bg-white text-gray-700 hover:bg-gray-50' }}">
                        {{ $cat['icon'] }} {{ $cat['name'] }}
                    </a>
                @endforeach
            </div>

            <div id="items-container">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                    
                    @forelse($items as $item)
                        @php
                            $activeRental = $item->rentals->where('status', 'disewa')->first();
                            $firstImage = is_array($item->image) ? ($item->image[0] ?? null) : $item->image;
                            $imageUrl = $firstImage ? asset('storage/' . $firstImage) : 'https://placehold.co/400x400?text=No+Image';
                        @endphp

                        <div class="border border-gray-200 rounded-xl p-4 flex gap-4 bg-white relative {{ $item->status != 'available' && !$activeRental ? 'opacity-75' : '' }}">
                            
                            <a href="{{ route('items.show', $item->id) }}" class="block flex-shrink-0">
                                <img src="{{ $imageUrl }}" alt="{{ $item->name }}" class="w-28 h-28 object-cover rounded-lg {{ $item->status != 'available' && !$activeRental ? 'grayscale' : '' }}">
                            </a>
                            
                            <div class="flex flex-col flex-1 justify-between">
                                <a href="{{ route('items.show', $item->id) }}" class="block hover:underline">
                                    <h3 class="text-sm font-semibold text-gray-900 leading-tight">{{ $item->name }}</h3>
                                    <p class="text-xs text-gray-500 mt-1">{{ $item->category ? $item->category->name : 'Tanpa Kategori' }}</p>
                                    <p class="text-sm font-bold text-gray-900 mt-1">Rp {{ number_format($item->price_per_day, 0, ',', '.') }} <span class="text-xs font-normal text-gray-500">/hari</span></p>
                                </a>
                                
                                <div class="flex items-center justify-between mt-3">
                                    @if($activeRental)
                                        <div class="flex items-center gap-2">
                                            <span class="bg-yellow-300 text-yellow-900 text-[11px] font-semibold px-2 py-0.5 rounded">Disewa</span>
                                            <span class="text-[11px] text-gray-500">
                                                Sisa {{ \Carbon\Carbon::parse($activeRental->end_date)->diffInDays(now()) }} hari
                                            </span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1.5 z-10">
                                            <span class="text-[11px] text-gray-500 status-label-{{ $item->id }}">{{ $item->status == 'available' ? 'Aktif' : 'Tidak Aktif' }}</span>
                                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 cursor-pointer" 
                                                {{ $item->status == 'available' ? 'checked' : '' }} 
                                                onchange="toggleItemStatus(this, {{ $item->id }})">
                                        </div>
                                    @endif

                                    <div class="flex gap-2 z-10">
                                        <a href="{{ route('items.edit', $item->id) }}" class="bg-[#34699A] hover:bg-[#28537a] text-white px-3 py-1.5 rounded-lg text-xs flex items-center gap-1 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            Edit
                                        </a>
                                        
                                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs flex items-center gap-1 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 text-center py-12">
                            <p class="text-gray-500 text-sm">Belum ada barang yang disewakan di toko Anda.</p>
                        </div>
                    @endforelse

                </div>

                <div class="mb-8">
                    {{ $items->links() }}
                </div>
            </div>

            <div class="flex justify-center">
                <a href="{{ route('items.create') }}" class="bg-[#34699A] hover:bg-[#28537a] text-white font-medium py-2.5 px-6 rounded-lg transition shadow-sm flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Sewakan barang
                </a>
            </div>

        </div>
    </main>

    @include('layouts.partials.footer')

    <script>
        // 1. Logika Live Search
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            const itemsContainer = document.getElementById('items-container');
            let typingTimer;
            const doneTypingInterval = 400; // Jeda 400ms

            if (searchInput && itemsContainer) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(typingTimer);
                    
                    typingTimer = setTimeout(() => {
                        const url = new URL(window.location.href);
                        url.searchParams.set('search', searchInput.value);

                        fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newContainer = doc.getElementById('items-container');
                            
                            if (newContainer) {
                                itemsContainer.innerHTML = newContainer.innerHTML;
                            }
                        })
                        .catch(error => console.error('Error fetching search results:', error));
                        
                        window.history.pushState({}, '', url);

                    }, doneTypingInterval);
                });
            }
        });

        // 2. Logika AJAX Ubah Status Aktif/Tidak Aktif
        function toggleItemStatus(checkbox, itemId) {
            const url = `/items/${itemId}/toggle-status`;
            const token = '{{ csrf_token() }}'; 

            fetch(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const label = document.querySelector(`.status-label-${itemId}`);
                    const card = checkbox.closest('.border-gray-200');
                    const img = card.querySelector('img');
                    
                    if (data.status === 'available') {
                        if(label) label.textContent = 'Aktif';
                        card.classList.remove('opacity-75');
                        img.classList.remove('grayscale');
                    } else {
                        if(label) label.textContent = 'Tidak Aktif';
                        card.classList.add('opacity-75');
                        img.classList.add('grayscale');
                    }
                } else {
                    checkbox.checked = !checkbox.checked;
                    alert('Gagal mengubah status barang.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                checkbox.checked = !checkbox.checked;
            });
        }
    </script>
</body>
</html>