@extends('layouts.app')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang - Rentalin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F9FAFB; }
        /* Sembunyikan scrollbar untuk thumbnail tapi tetap bisa di-scroll */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="text-gray-800">

    @include('layouts.partials.navbar')

    <main class="max-w-6xl mx-auto px-4 py-8">
        
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ url()->previous() }}" class="flex items-center justify-center w-10 h-10 rounded-full border border-gray-300 hover:bg-gray-100 transition">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Detail barang</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                
                @php
                    $images = is_array($item->image) ? $item->image : ($item->image ? [$item->image] : []);
                    $firstImage = !empty($images) ? asset('storage/' . $images[0]) : 'https://placehold.co/800x400?text=No+Image';
                @endphp
                <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-sm">
                    <div class="aspect-[16/9] w-full rounded-xl overflow-hidden bg-gray-100 mb-3 relative">
                        <img src="{{ $firstImage }}" id="main-product-image" class="w-full h-full object-cover transition-opacity duration-300" alt="{{ $item->name }}">
                    </div>
                    <div class="flex gap-3 overflow-x-auto hide-scrollbar">
                        @forelse($images as $index => $img)
                            <img src="{{ asset('storage/' . $img) }}" 
                                 alt="Thumbnail {{ $index + 1 }}" 
                                 class="thumb-item w-20 h-20 object-cover cursor-pointer rounded-lg border-2 flex-shrink-0 transition-all {{ $index === 0 ? 'border-[#34699A] opacity-100' : 'border-transparent opacity-60 hover:opacity-100' }}"
                                 onclick="changeMainImage(this, '{{ asset('storage/' . $img) }}')">
                        @empty
                            <img src="https://placehold.co/100x100?text=No+Image" class="w-20 h-20 object-cover rounded-lg border border-gray-200 opacity-50">
                        @endforelse
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <h2 class="text-2xl font-bold text-gray-900 leading-tight mb-2">{{ $item->name }}</h2>
                    <div class="flex items-center gap-1.5 text-gray-500 text-sm mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Lokasi: <span class="font-semibold text-gray-700">{{ ucfirst($item->kecamatan ?? 'Tidak diketahui') }}</span>
                    </div>

                    <div class="flex items-center justify-between pt-5 border-t border-gray-100">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($item->owner->name ?? 'User') }}&background=EBF4FF&color=34699A" alt="Owner" class="w-12 h-12 rounded-full object-cover">
                            <div>
                                <p class="text-xs text-gray-500 mb-0.5">Disewakan oleh</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $item->owner->name ?? 'Pengguna Rentalin' }}</p>
                                <p class="text-xs text-gray-400">Bergabung sejak {{ $item->owner->created_at ? $item->owner->created_at->format('Y') : '2024' }}</p>
                            </div>
                        </div>
                        <a href="#" class="bg-[#34699A] hover:bg-[#28537a] text-white px-5 py-2.5 rounded-xl text-sm font-medium transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            Chat pemilik
                        </a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi</h3>
                    <div class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                        {{ $item->description }}
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Kelengkapan Barang</h3>
                    @if(!empty($item->kelengkapan) && is_array($item->kelengkapan))
                        <ul class="space-y-2">
                            @foreach($item->kelengkapan as $kelengkapan)
                                <li class="flex items-start gap-2 text-sm text-gray-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#34699A] mt-1.5 flex-shrink-0"></span>
                                    {{ $kelengkapan }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500 italic">Tidak ada rincian kelengkapan khusus.</p>
                    @endif
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aturan dan kebijakan sewa</h3>
                    <div class="space-y-4 text-sm text-gray-600">
                        @if($item->has_deposit)
                        <div>
                            <p class="font-medium text-gray-900 mb-1">Uang Deposit: Rp {{ number_format($item->deposit_amount, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500">(dikembalikan 100% jika barang kembali tanpa kerusakan dan tidak terlambat).</p>
                        </div>
                        @endif

                        @if($item->late_fee_percentage)
                        <div>
                            <p class="font-medium text-gray-900 mb-1">Denda Keterlambatan:</p>
                            <p>{{ $item->late_fee_percentage }}% dari harga sewa per hari.</p>
                        </div>
                        @endif

                        @if(!empty($item->cancellation_policies) && is_array($item->cancellation_policies))
                        <div>
                            <p class="font-medium text-gray-900 mb-2">Kebijakan pembatalan:</p>
                            <ul class="list-disc pl-5 space-y-1.5">
                                @foreach($item->cancellation_policies as $policy)
                                    <li>Jika dibatalkan <strong>{{ $policy['days_before'] }} hari</strong> sebelum waktu mulai sewa: Refund <strong>{{ $policy['refund_percentage'] }}%</strong></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ulasan</h3>
                    
                    <div class="flex items-center gap-6 mb-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-2xl font-bold text-gray-900">{{ number_format($averageRating, 1) }}</span>
                            <span class="text-sm text-gray-500 mt-1">/ 5.0</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button class="px-4 py-1.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Semua ({{ $totalReviews }})</button>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @forelse($reviews as $review)
                            <div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name ?? 'User') }}&background=0D8ABC&color=fff" class="w-8 h-8 rounded-full object-cover" alt="Avatar">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $review->user->name ?? 'Pengguna' }}</p>
                                            <div class="flex text-yellow-400 text-[10px]">
                                                @for($i = 0; $i < $review->rating; $i++)
                                                    ⭐
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $review->created_at->translatedFormat('d F Y') }}</span>
                                </div>
                                
                                @if($review->comment)
                                    <p class="text-sm text-gray-600 pl-11">{{ $review->comment }}</p>
                                @endif

                                @if($review->image)
                                    <div class="pl-11 mt-2">
                                        <img src="{{ asset('storage/' . $review->image) }}" class="w-20 h-20 object-cover rounded-lg border border-gray-200" alt="Foto ulasan">
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-6">
                                <p class="text-gray-500 text-sm italic">Belum ada ulasan untuk barang ini.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    @if($totalReviews > 0)
                        <a href="{{ route('items.reviews', $item->id) }}" class="block text-center w-full mt-4 text-[#34699A] text-sm font-medium py-2 hover:bg-blue-50 rounded-lg transition">Lihat semua ({{ $totalReviews }}) ❯</a>
                    @endif
                </div>

            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-xl shadow-blue-900/5 p-6 sticky top-24">
                    
                    <div class="mb-6">
                        <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</span>
                        <span class="text-sm text-gray-500">/hari</span>
                    </div>

                    <form action="{{ route('rentals.store', $item->id) }}" method="POST" id="booking-form">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Tanggal Sewa</label>
                            <div class="grid grid-cols-2 gap-2 border border-gray-300 rounded-xl p-1 bg-gray-50">
                                <div class="bg-white p-2 rounded-lg border border-gray-100 shadow-sm">
                                    <p class="text-[10px] text-gray-500 font-medium mb-1 uppercase">Tanggal Mulai</p>
                                    <input type="date" id="start-date" name="start_date" class="w-full text-sm font-medium outline-none bg-transparent" required>
                                </div>
                                <div class="bg-white p-2 rounded-lg border border-gray-100 shadow-sm">
                                    <p class="text-[10px] text-gray-500 font-medium mb-1 uppercase">Tanggal Selesai</p>
                                    <input type="date" id="end-date" name="end_date" class="w-full text-sm font-medium outline-none bg-transparent" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Metode serah terima</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition {{ !$item->is_cod ? 'opacity-50 cursor-not-allowed' : '' }}">
                                    <input type="radio" name="delivery_method" value="cod" class="w-4 h-4 text-[#34699A] focus:ring-[#34699A]" {{ $item->is_cod ? 'checked' : 'disabled' }}>
                                    <span class="text-sm text-gray-700">COD (Ambil di tempat)</span>
                                </label>
                                
                                <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition {{ !$item->is_delivery ? 'opacity-50 cursor-not-allowed' : '' }}">
                                    <input type="radio" name="delivery_method" value="delivery" class="w-4 h-4 text-[#34699A] focus:ring-[#34699A]" {{ !$item->is_cod && $item->is_delivery ? 'checked' : '' }} {{ !$item->is_delivery ? 'disabled' : '' }}>
                                    <span class="text-sm text-gray-700">Dikirim kurir <span class="text-xs text-gray-400">(biaya ditanggung penyewa)</span></span>
                                </label>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4 mb-6 space-y-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600">Durasi sewa</span>
                                <span class="font-medium text-gray-900"><span id="duration-text">-</span> hari</span>
                            </div>
                            <div class="flex justify-between items-center text-base font-bold">
                                <span class="text-gray-900">Total Harga</span>
                                <span class="text-[#34699A]">Rp <span id="total-price-text">-</span></span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#34699A] hover:bg-[#28537a] text-white font-semibold py-3.5 rounded-xl transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed" id="btn-submit" disabled>
                            Pesan Sekarang
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </main>

    @include('layouts.partials.footer')

    <script>
        // Data PHP ke JavaScript untuk Kalkulasi
        const pricePerDay = {{ $item->price_per_day }};
        
        // Elemen DOM
        const startDateInput = document.getElementById('start-date');
        const endDateInput = document.getElementById('end-date');
        const durationText = document.getElementById('duration-text');
        const totalPriceText = document.getElementById('total-price-text');
        const btnSubmit = document.getElementById('btn-submit');

        // Batasi tanggal mulai minimal hari ini
        const today = new Date().toISOString().split('T')[0];
        startDateInput.setAttribute('min', today);

        // Event Listeners untuk Perubahan Tanggal
        startDateInput.addEventListener('change', function() {
            // Tanggal selesai minimal adalah tanggal mulai
            endDateInput.setAttribute('min', this.value);
            if (endDateInput.value && endDateInput.value < this.value) {
                endDateInput.value = this.value;
            }
            calculateBooking();
        });

        endDateInput.addEventListener('change', calculateBooking);

        function calculateBooking() {
            if (startDateInput.value && endDateInput.value) {
                const start = new Date(startDateInput.value);
                const end = new Date(endDateInput.value);
                
                // Menghitung selisih hari (minimal 1 hari jika tanggal sama)
                const diffTime = Math.abs(end - start);
                let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                if (diffDays === 0) diffDays = 1; // Sewa di hari yang sama dihitung 1 hari

                // Menghitung total harga
                const totalPrice = diffDays * pricePerDay;

                // Update UI
                durationText.textContent = diffDays;
                totalPriceText.textContent = totalPrice.toLocaleString('id-ID');
                
                // Aktifkan tombol
                btnSubmit.removeAttribute('disabled');
            } else {
                durationText.textContent = '-';
                totalPriceText.textContent = '-';
                btnSubmit.setAttribute('disabled', 'true');
            }
        }

        // Fungsi Ganti Gambar Utama
        function changeMainImage(thumbElement, imageUrl) {
            const mainImg = document.getElementById('main-product-image');
            
            // Animasi fade out/in sederhana
            mainImg.style.opacity = '0.7';
            setTimeout(() => {
                mainImg.src = imageUrl;
                mainImg.style.opacity = '1';
            }, 150);

            // Perbarui styling border thumbnail
            document.querySelectorAll('.thumb-item').forEach(el => {
                el.classList.remove('border-[#34699A]', 'opacity-100');
                el.classList.add('border-transparent', 'opacity-60');
            });
            
            thumbElement.classList.remove('border-transparent', 'opacity-60');
            thumbElement.classList.add('border-[#34699A]', 'opacity-100');
        }
    </script>
</body>
</html>