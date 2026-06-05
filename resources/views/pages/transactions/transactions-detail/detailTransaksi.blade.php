<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

@php
    use Carbon\Carbon;

    function rupiahDetail($angka) {
        return 'Rp' . number_format($angka ?? 0, 0, ',', '.');
    }

    $durasi = ($rental->start_date && $rental->end_date)
        ? Carbon::parse($rental->start_date)->diffInDays(Carbon::parse($rental->end_date))
        : 0;
@endphp

<body class="bg-[#F5F7FA] text-[#1E1E1E] [font-family:'Plus_Jakarta_Sans',sans-serif]">

<main class="w-full max-w-[435px] sm:max-w-[920px] mx-auto px-[20px] sm:px-[48px] py-[32px]">
    <div class="flex items-center gap-[14px] mb-[24px]">
        <a href="{{ url()->previous() }}"
           class="w-[36px] h-[36px] rounded-full border border-[#1E1E1E] flex items-center justify-center">
            <img src="{{ asset('assets/icons/icon-back.png') }}"
                 class="w-[18px] h-[18px] object-contain"
                 alt="Back">
        </a>

        <h1 class="text-[24px] font-bold">
            Detail Transaksi
        </h1>
    </div>

    @if(session('success'))
        <div class="mb-[18px] bg-[#E8F8EF] border border-[#B7E8C8] text-[#118642] px-[14px] py-[12px] rounded-[8px] text-[13px] font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <section class="bg-white border border-[#D7E5FA] rounded-[10px] p-[18px] shadow-sm mb-[18px]">
        <div class="flex gap-[14px]">
            <img src="{{ asset('assets/products/' . (optional($rental->item)->image ?? 'default-product.png')) }}"
                 class="w-[100px] h-[100px] rounded-[8px] object-cover"
                 alt="{{ optional($rental->item)->name }}">

            <div class="flex-1">
                <h2 class="text-[18px] font-bold leading-[24px]">
                    {{ optional($rental->item)->name ?? '-' }}
                </h2>

                <p class="text-[12px] text-[#6B7280] mt-[6px]">
                    ID Transaksi: {{ $rental->rental_code }}
                </p>

                <p class="text-[12px] text-[#6B7280] mt-[4px]">
                    Status: {{ $rental->status }}
                </p>

                <p class="text-[18px] text-[#34699A] font-bold mt-[10px]">
                    {{ rupiahDetail($rental->total_price) }}
                </p>
            </div>
        </div>
    </section>

    <section class="bg-white border border-[#D7E5FA] rounded-[10px] p-[18px] shadow-sm mb-[18px]">
        <h2 class="text-[17px] font-bold mb-[14px]">Informasi Sewa</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-[14px] text-[13px]">
            <div>
                <p class="text-[#6B7280]">Pemilik</p>
                <p class="font-bold mt-[3px]">{{ optional($rental->owner)->name ?? '-' }}</p>
            </div>

            <div>
                <p class="text-[#6B7280]">Penyewa</p>
                <p class="font-bold mt-[3px]">{{ optional($rental->tenant)->name ?? '-' }}</p>
            </div>

            <div>
                <p class="text-[#6B7280]">Tanggal Mulai</p>
                <p class="font-bold mt-[3px]">{{ $rental->start_date }}</p>
            </div>

            <div>
                <p class="text-[#6B7280]">Tanggal Selesai</p>
                <p class="font-bold mt-[3px]">{{ $rental->end_date }}</p>
            </div>

            <div>
                <p class="text-[#6B7280]">Durasi</p>
                <p class="font-bold mt-[3px]">{{ $durasi }} hari</p>
            </div>

            <div>
                <p class="text-[#6B7280]">Metode Pembayaran</p>
                <p class="font-bold mt-[3px]">{{ optional($rental->payment)->payment_method ?? '-' }}</p>
            </div>
        </div>
    </section>

    <section class="bg-white border border-[#D7E5FA] rounded-[10px] p-[18px] shadow-sm">
        <h2 class="text-[17px] font-bold mb-[14px]">Dokumentasi Transaksi</h2>

        @if($rental->documents && $rental->documents->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-[12px]">
                @foreach($rental->documents as $document)
                    <div class="rounded-[8px] overflow-hidden bg-[#D9D9D9]">
                        <img src="{{ asset('storage/' . $document->image) }}"
                             class="w-full h-[130px] object-cover"
                             alt="Dokumentasi">
                        <p class="text-[11px] text-[#6B7280] px-[8px] py-[6px] bg-white">
                            {{ $document->process }}
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-[13px] text-[#6B7280]">
                Belum ada dokumentasi yang diunggah.
            </p>
        @endif
    </section>
</main>

</body>
</html>