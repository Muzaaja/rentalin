<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beri Penilaian - Rentalin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .star-rating { display: flex; flex-direction: row-reverse; justify-content: flex-start; }
        .star-rating input { display: none; }
        .star-rating label { font-size: 30px; color: #D1D5DB; cursor: pointer; padding: 0 5px; }
        .star-rating label:hover, .star-rating label:hover ~ label, .star-rating input:checked ~ label { color: #F59E0B; }
    </style>
</head>
<body class="bg-[#F5F7FA] [font-family:'Plus_Jakarta_Sans',sans-serif]">

@include('layouts.partials.navbar')

<main class="max-w-[700px] mx-auto p-6">
    <a href="{{ route('riwayat.transaksi.penyewa') }}" class="flex items-center text-[#1E1E1E] font-bold mb-6">
        <span class="mr-2 text-xl">←</span> Review
    </a>

    <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm">
        <h2 class="text-xl font-bold mb-2">Tulis Ulasan</h2>
        <p class="text-sm text-gray-500 mb-6">Ulasanmu akan sangat membantu kami dalam mengembangkan performa dan membantu penyewa lain.</p>

        {{-- Product Info --}}
        <div class="bg-[#F8FAFC] p-4 rounded-lg flex items-center gap-4 mb-8">
            @php
                $img = is_array($rental->item->image) ? ($rental->item->image[0] ?? null) : $rental->item->image;
                $url = $img ? asset('storage/'.$img) : asset('assets/products/default-product.png');
            @endphp
            <img src="{{ $url }}" class="w-16 h-16 rounded-md object-cover">
            <div>
                <h3 class="font-bold text-sm">{{ $rental->item->name }}</h3>
                <p class="text-xs text-gray-500">Disewakan oleh: {{ $rental->owner->name ?? 'Pemilik Toko' }}</p>
                <p class="text-xs text-gray-400">Masa Sewa: {{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($rental->end_date)->format('d M Y') }}</p>
            </div>
        </div>

        <form action="{{ route('ulasan.store', $rental->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label class="block text-sm font-semibold mb-2">Beri rating pengalaman sewa</label>
            <div class="star-rating mb-6">
                <input type="radio" id="s5" name="rating" value="5" required><label for="s5">★</label>
                <input type="radio" id="s4" name="rating" value="4"><label for="s4">★</label>
                <input type="radio" id="s3" name="rating" value="3"><label for="s3">★</label>
                <input type="radio" id="s2" name="rating" value="2"><label for="s2">★</label>
                <input type="radio" id="s1" name="rating" value="1"><label for="s1">★</label>
            </div>

            <label class="block text-sm font-semibold mb-2">Tulis pengalamanmu</label>
            <textarea name="comment" rows="4" class="w-full border rounded-lg p-3 mb-6 focus:ring-2 focus:ring-[#34699A] outline-none" placeholder="Ceritakan pengalamanmu menyewa barang ini."></textarea>

            <label class="block text-sm font-semibold mb-2">Tambahkan Foto <span class="text-gray-400 font-normal">(Opsional, maks 10MB)</span></label>
            <div onclick="document.getElementById('file-upload').click()" class="border-2 border-dashed border-[#34699A] rounded-lg p-6 flex flex-col items-center justify-center cursor-pointer mb-8 text-[#34699A]">
                <span class="text-4xl mb-2">🖼️</span>
                <p class="text-xs font-semibold">JPEG or PNG</p>
                <input type="file" name="image" id="file-upload" class="hidden" accept="image/*">
            </div>

            <button type="submit" class="w-full bg-[#34699A] text-white py-3 rounded-lg font-bold">Kirim Ulasan ▷</button>
        </form>
    </div>
</main>
</body>
</html>