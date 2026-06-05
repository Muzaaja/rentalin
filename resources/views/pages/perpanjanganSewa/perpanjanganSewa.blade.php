<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpanjangan Sewa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

@php
    use Carbon\Carbon;

    $item = $rental->item;
    $owner = $rental->owner;
    $tenant = $rental->tenant;

    $startDate = $rental->start_date
        ? Carbon::parse($rental->start_date)->translatedFormat('d M Y')
        : '-';

    $endDate = $rental->end_date
        ? Carbon::parse($rental->end_date)->translatedFormat('d M Y')
        : '-';

    $durasi = ($rental->start_date && $rental->end_date)
        ? Carbon::parse($rental->start_date)->diffInDays(Carbon::parse($rental->end_date))
        : 0;

    $totalHarga = 'Rp' . number_format($rental->total_price ?? 0, 0, ',', '.');

    $metodePengiriman = optional($rental->payment)->payment_method ?? 'COD (Bayar di tempat)';

    $alamatPengiriman = optional($tenant)->address
        ?? 'Jl. Raya Soreang No.KM. 17, Pamekaran';

    $minDate = $rental->end_date
        ? Carbon::parse($rental->end_date)->addDay()->format('Y-m-d')
        : now()->addDay()->format('Y-m-d');
@endphp

<body class="bg-[#F5F7FA] text-[#1E1E1E] [font-family:'Plus_Jakarta_Sans',sans-serif]">

@include('layouts.partials.navbar')

<main class="w-full max-w-[435px] sm:max-w-[940px] lg:max-w-[1220px] mx-auto px-[20px] sm:px-[44px] lg:px-[66px] pt-[22px] sm:pt-[38px] pb-[48px] lg:pb-[70px]">

    <div class="flex items-center gap-[14px] mb-[28px] sm:mb-[34px]">
        <a href="{{ route('riwayat.transaksi.penyewa') }}"
           class="w-[34px] h-[34px] rounded-full border border-[#1E1E1E] flex items-center justify-center text-[24px] leading-none flex-shrink-0">
            ‹
        </a>

        <h1 class="text-[24px] sm:text-[26px] font-bold">
            Perpanjangan Sewa
        </h1>
    </div>

    @if($errors->any())
        <div class="mb-[18px] bg-[#FFECEF] border border-[#F4B8C2] text-[#E3455D] px-[14px] py-[12px] rounded-[8px] text-[13px] font-semibold">
            <ul class="list-disc pl-[18px]">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-[18px] bg-[#FFECEF] border border-[#F4B8C2] text-[#E3455D] px-[14px] py-[12px] rounded-[8px] text-[13px] font-semibold">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-[410px_1fr] gap-[28px] items-start">

        <section class="bg-white border border-[#E5EAF0] rounded-[8px] px-[14px] sm:px-[22px] py-[20px] sm:py-[22px] shadow-[0px_2px_6px_rgba(0,0,0,0.10)]">
            <h2 class="text-[18px] font-bold mb-[26px]">
                Barang yang Disewa
            </h2>

            <div class="flex items-center gap-[14px] sm:gap-[18px] mb-[22px]">
                <img
                    src="{{ asset('assets/products/' . (optional($item)->image ?? 'default-product.png')) }}"
                    alt="{{ optional($item)->name ?? 'Produk' }}"
                    class="w-[82px] h-[70px] sm:w-[100px] sm:h-[86px] rounded-[6px] object-cover flex-shrink-0"
                >

                <div class="min-w-0">
                    <h3 class="text-[18px] font-bold leading-[24px]">
                        {{ optional($item)->name ?? '-' }}
                    </h3>

                    <div class="flex items-center gap-[8px] sm:gap-[10px] mt-[12px] text-[13px] flex-wrap">
                        <span class="text-[#696969]">
                            Disewa dari:
                        </span>

                        <span class="font-semibold">
                            {{ optional($owner)->name ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="border-t border-[#C3DAFE] pt-[18px] space-y-[24px] sm:space-y-[28px]">

                <div class="flex items-center justify-between gap-[20px]">
                    <div class="flex items-center gap-[12px] text-[#696969]">
                        <img src="{{ asset('assets/icons/icon-transaction.png') }}"
                             class="w-[18px] h-[18px] object-contain"
                             alt="ID">

                        <span class="text-[13px]">
                            ID Transaksi
                        </span>
                    </div>

                    <p class="text-[13px] font-semibold text-right">
                        {{ $rental->rental_code }}
                    </p>
                </div>

                <div class="flex items-start justify-between gap-[20px]">
                    <div class="flex items-center gap-[12px] text-[#696969]">
                        <img src="{{ asset('assets/icons/icon-calendar.png') }}"
                             class="w-[18px] h-[18px] object-contain"
                             alt="Periode">

                        <span class="text-[13px]">
                            Periode Sewa Saat Ini
                        </span>
                    </div>

                    <p class="text-[13px] font-semibold text-right leading-[22px]">
                        {{ $startDate }} - {{ $endDate }}<br>
                        <span class="text-[#696969] font-normal">
                            ({{ $durasi }} hari)
                        </span>
                    </p>
                </div>

                <div class="flex items-start justify-between gap-[20px]">
                    <div class="flex items-center gap-[12px] text-[#696969]">
                        <img src="{{ asset('assets/icons/icon-delivery.png') }}"
                             class="w-[18px] h-[18px] object-contain"
                             alt="Metode">

                        <span class="text-[13px]">
                            Metode Pengiriman
                        </span>
                    </div>

                    <p class="text-[13px] font-semibold text-right leading-[20px]">
                        {{ $metodePengiriman }}
                    </p>
                </div>

                <div class="flex items-start justify-between gap-[20px]">
                    <div class="flex items-center gap-[12px] text-[#696969]">
                        <img src="{{ asset('assets/icons/icon-location.png') }}"
                             class="w-[18px] h-[18px] object-contain"
                             alt="Alamat">

                        <span class="text-[13px]">
                            Alamat Pengiriman
                        </span>
                    </div>

                    <p class="text-[13px] font-semibold text-right leading-[22px]">
                        {{ $alamatPengiriman }}
                    </p>
                </div>

            </div>

            <div class="border-t border-[#C3DAFE] mt-[28px] pt-[18px] flex items-center justify-between">
                <p class="text-[14px] text-[#696969] font-medium">
                    Total Pembayaran Awal
                </p>

                <p class="text-[18px] font-bold text-[#34699A]">
                    {{ $totalHarga }}
                </p>
            </div>
        </section>

        <form action="{{ route('transaksi.simpanPerpanjanganSewa', $rental->id) }}"
              method="POST"
              class="bg-white border border-[#E5EAF0] rounded-[8px] px-[14px] sm:px-[26px] py-[22px] shadow-[0px_2px_6px_rgba(0,0,0,0.10)]">

            @csrf
            @method('PUT')

            <h2 class="text-[18px] font-bold mb-[10px]">
                Pilih Durasi Perpanjangan
            </h2>

            <p class="text-[13px] text-[#696969] leading-[22px] mb-[22px]">
                Pilih durasi tambahan atau tentukan tanggal pengembalian baru.
                Tanggal selesai rental akan diperbarui setelah kamu menekan tombol simpan.
            </p>

            <div class="mb-[22px]">
                <label class="block text-[14px] font-bold mb-[10px]">
                    Pilihan Cepat Durasi Tambahan
                </label>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-[12px]">
                    <label class="border border-[#C3DAFE] rounded-[8px] px-[14px] py-[14px] cursor-pointer hover:bg-[#F8FBFF]">
                        <input type="radio" name="durasi_tambahan" value="1" class="mr-[8px]">
                        <span class="text-[14px] font-bold">+1 Hari</span>
                    </label>

                    <label class="border border-[#C3DAFE] rounded-[8px] px-[14px] py-[14px] cursor-pointer hover:bg-[#F8FBFF]">
                        <input type="radio" name="durasi_tambahan" value="3" class="mr-[8px]">
                        <span class="text-[14px] font-bold">+3 Hari</span>
                    </label>

                    <label class="border border-[#C3DAFE] rounded-[8px] px-[14px] py-[14px] cursor-pointer hover:bg-[#F8FBFF]">
                        <input type="radio" name="durasi_tambahan" value="7" class="mr-[8px]">
                        <span class="text-[14px] font-bold">+7 Hari</span>
                    </label>
                </div>
            </div>

            <div class="mb-[22px]">
                <label class="block text-[14px] font-bold mb-[10px]">
                    Atau Pilih Tanggal Pengembalian Baru
                </label>

                <input type="date"
                       name="end_date"
                       value="{{ old('end_date') }}"
                       min="{{ $minDate }}"
                       class="w-full h-[44px] rounded-[8px] border border-[#C3DAFE] px-[14px] text-[14px] outline-none focus:border-[#34699A]">
            </div>

            <div class="bg-[#FFF3C4] text-[#8A6400] rounded-[8px] px-[14px] py-[12px] mb-[22px]">
                <p class="text-[12px] font-medium leading-[20px]">
                    Jika kamu memilih durasi tambahan dan tanggal manual sekaligus, controller akan memprioritaskan durasi tambahan.
                </p>
            </div>

            <div class="flex justify-end gap-[10px]">
                <a href="{{ route('riwayat.transaksi.penyewa') }}"
                   class="h-[42px] px-[22px] rounded-[8px] border border-[#34699A] text-[#34699A] text-[13px] font-semibold flex items-center">
                    Batal
                </a>

                <button type="submit"
                        class="h-[42px] px-[22px] rounded-[8px] bg-[#34699A] text-white text-[13px] font-semibold">
                    Simpan Perpanjangan
                </button>
            </div>

        </form>

    </div>

</main>

@include('layouts.partials.footer')

</body>
</html>