<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tinjau Klaim Kerusakan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

@php
    use Carbon\Carbon;

    function rupiahKlaim($angka) {
        return 'Rp' . number_format($angka ?? 0, 0, ',', '.');
    }

    $item = $rental->item;
    $owner = $rental->owner;
    $tenant = $rental->tenant;
    $claim = $rental->damageClaim;

    $repairFee = $claim->repair_fee ?? $rental->damage_fee ?? 0;

    /*
        Deposit sementara.
        Kalau nanti sudah ada kolom deposit di tabel rentals/payments,
        bagian ini bisa diganti dari database.
    */
    $deposit = 500000;

    $sisaTagihan = max($repairFee - $deposit, 0);

    $startDate = $rental->start_date
        ? Carbon::parse($rental->start_date)->translatedFormat('d M Y')
        : '-';

    $endDate = $rental->end_date
        ? Carbon::parse($rental->end_date)->translatedFormat('d M Y')
        : '-';

    $durasi = ($rental->start_date && $rental->end_date)
        ? Carbon::parse($rental->start_date)->diffInDays(Carbon::parse($rental->end_date))
        : 0;

    $tanggalDiajukan = $claim && $claim->created_at
        ? $claim->created_at->translatedFormat('d M Y')
        : now()->translatedFormat('d M Y');

    $batasRespons = $claim && $claim->created_at
        ? $claim->created_at->copy()->addDays(3)->translatedFormat('d M Y, H.i') . ' WIB'
        : now()->addDays(3)->translatedFormat('d M Y, H.i') . ' WIB';

    $damageDocuments = $rental->documents
        ? $rental->documents->where('process', 'damage_claim')
        : collect();
@endphp

<body class="bg-[#F5F7FA] text-[#1E1E1E] [font-family:'Plus_Jakarta_Sans',sans-serif]">

@include('layouts.partials.navbar')

<main class="w-full max-w-[435px] sm:max-w-[940px] lg:max-w-[1220px] mx-auto px-[20px] sm:px-[44px] lg:px-[66px] pt-[22px] sm:pt-[38px] pb-[48px] lg:pb-[70px]">

    <div class="flex items-center gap-[14px] mb-[28px] sm:mb-[34px]">
        <a href="{{ route('riwayat.transaksi.penyewa') }}"
           class="w-[34px] h-[34px] rounded-full border border-[#1E1E1E] flex items-center justify-center text-[24px] leading-none flex-shrink-0">
            ‹
        </a>

        <div>
            <h1 class="text-[24px] sm:text-[26px] font-bold">
                Tinjau Klaim Kerusakan
            </h1>

            <p class="text-[13px] text-[#696969] leading-[22px] mt-[6px]">
                Pemilik mengajukan klaim kerusakan setelah barang dikembalikan.
                Pada alur ini, penyewa wajib menyetujui klaim agar transaksi dapat diselesaikan.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-[18px] bg-[#E8F8EF] border border-[#B7E8C8] text-[#118642] px-[14px] py-[12px] rounded-[8px] text-[13px] font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-[18px] bg-[#FFECEF] border border-[#F4B8C2] text-[#E3455D] px-[14px] py-[12px] rounded-[8px] text-[13px] font-semibold">
            <ul class="list-disc pl-[18px]">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="bg-[#FFF3C4] border border-[#F4D77A] rounded-[8px] px-[18px] sm:px-[22px] py-[18px] sm:py-[20px] mb-[24px] flex items-start gap-[16px]">
        <div class="w-[44px] h-[44px] rounded-full bg-[#F59E0B] text-white flex items-center justify-center text-[22px] font-bold flex-shrink-0">
            !
        </div>

        <div>
            <h2 class="text-[18px] sm:text-[20px] font-bold">
                Klaim kerusakan perlu disetujui
            </h2>

            <p class="text-[13px] mt-[8px] leading-[22px]">
                <span class="font-semibold">Batas respons:</span>
                <span class="text-[#D38A00] font-bold ml-[6px]">
                    {{ $batasRespons }}
                </span>
            </p>
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-[410px_1fr] gap-[28px] items-start">

        <section class="bg-white border border-[#E5EAF0] rounded-[8px] px-[14px] sm:px-[22px] py-[20px] sm:py-[22px] shadow-[0px_2px_6px_rgba(0,0,0,0.10)]">
            <div class="flex items-center justify-between mb-[26px] gap-[12px]">
                <h2 class="text-[18px] font-bold">
                    Informasi Barang
                </h2>

                <span class="h-[28px] px-[16px] rounded-full bg-[#FFD6DE] text-[#E3455D] text-[12px] font-bold flex items-center">
                    Kerusakan
                </span>
            </div>

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
                            Pemilik:
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
                            Periode Sewa
                        </span>
                    </div>

                    <p class="text-[13px] font-semibold text-right leading-[22px]">
                        {{ $startDate }} - {{ $endDate }}<br>
                        <span class="text-[#696969] font-normal">
                            ({{ $durasi }} hari)
                        </span>
                    </p>
                </div>

                <div class="flex items-center justify-between gap-[20px]">
                    <div class="flex items-center gap-[12px] text-[#696969]">
                        <span class="text-[18px]">💰</span>

                        <span class="text-[13px]">
                            Deposit
                        </span>
                    </div>

                    <p class="text-[13px] font-semibold text-right">
                        {{ rupiahKlaim($deposit) }}
                    </p>
                </div>

            </div>
        </section>

        <section class="bg-white border border-[#E5EAF0] rounded-[8px] px-[14px] sm:px-[26px] py-[22px] shadow-[0px_2px_6px_rgba(0,0,0,0.10)]">
            <h2 class="text-[18px] font-bold mb-[10px]">
                Laporan Kerusakan
            </h2>

            <p class="text-[13px] text-[#696969] leading-[22px] mb-[22px]">
                Berikut adalah detail klaim kerusakan yang diajukan oleh pemilik.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-[14px] mb-[22px]">
                <div class="border border-[#E5EAF0] rounded-[8px] px-[14px] py-[12px]">
                    <p class="text-[12px] text-[#696969] mb-[4px]">
                        Diajukan pada
                    </p>

                    <p class="text-[13px] font-bold">
                        {{ $tanggalDiajukan }}
                    </p>
                </div>

                <div class="border border-[#E5EAF0] rounded-[8px] px-[14px] py-[12px]">
                    <p class="text-[12px] text-[#696969] mb-[4px]">
                        Status Klaim
                    </p>

                    <p class="text-[13px] font-bold">
                        {{ $claim && $claim->status === 'accepted' ? 'Disetujui' : 'Menunggu persetujuan' }}
                    </p>
                </div>

                <div class="border border-[#E5EAF0] rounded-[8px] px-[14px] py-[12px]">
                    <p class="text-[12px] text-[#696969] mb-[4px]">
                        Jenis Kerusakan
                    </p>

                    <p class="text-[13px] font-bold">
                        {{ $claim->damage_type ?? '-' }}
                    </p>
                </div>

                <div class="border border-[#E5EAF0] rounded-[8px] px-[14px] py-[12px]">
                    <p class="text-[12px] text-[#696969] mb-[4px]">
                        Bagian Rusak / Tidak Lengkap
                    </p>

                    <p class="text-[13px] font-bold">
                        {{ $claim->damage_part ?? '-' }}
                    </p>
                </div>
            </div>

            <div class="mb-[22px]">
                <h3 class="text-[14px] font-bold mb-[8px]">
                    Deskripsi Kerusakan
                </h3>

                <p class="text-[13px] leading-[22px] text-[#333333] bg-[#F8FAFC] border border-[#E5EAF0] rounded-[8px] px-[14px] py-[12px]">
                    {{ $claim->description ?? $rental->damage_description ?? 'Belum ada deskripsi kerusakan.' }}
                </p>
            </div>

            <div class="mb-[22px]">
                <h3 class="text-[14px] font-bold mb-[10px]">
                    Foto Bukti Kerusakan
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-[12px]">
                    @forelse($damageDocuments as $document)
                        <div class="h-[135px] rounded-[8px] overflow-hidden bg-[#D9D9D9]">
                            <img src="{{ asset('storage/' . $document->image) }}"
                                 class="w-full h-full object-cover"
                                 alt="Bukti Kerusakan">
                        </div>
                    @empty
                        <div class="h-[135px] rounded-[8px] bg-[#D9D9D9] flex items-center justify-center text-[12px] text-[#696969]">
                            Belum ada foto
                        </div>

                        <div class="h-[135px] rounded-[8px] bg-[#D9D9D9] hidden sm:flex items-center justify-center text-[12px] text-[#696969]">
                            Belum ada foto
                        </div>

                        <div class="h-[135px] rounded-[8px] bg-[#D9D9D9] hidden sm:flex items-center justify-center text-[12px] text-[#696969]">
                            Belum ada foto
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="border border-[#E5EAF0] rounded-[8px] px-[14px] py-[14px] mb-[22px]">
                <h3 class="text-[14px] font-bold mb-[12px]">
                    Rincian Biaya
                </h3>

                <div class="space-y-[10px] text-[13px]">
                    <div class="flex justify-between gap-[18px]">
                        <span class="text-[#696969]">
                            Deposit penyewa
                        </span>

                        <span class="font-semibold">
                            {{ rupiahKlaim($deposit) }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-[18px]">
                        <span class="text-[#696969]">
                            Biaya kerusakan
                        </span>

                        <span class="font-semibold text-[#E3455D]">
                            - {{ rupiahKlaim($repairFee) }}
                        </span>
                    </div>

                    <div class="border-t border-[#C3DAFE] pt-[12px] flex justify-between gap-[18px]">
                        <span class="font-bold">
                            Sisa tagihan
                        </span>

                        <span class="font-bold text-[#34699A]">
                            {{ rupiahKlaim($sisaTagihan) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-[#EAF3FF] text-[#34699A] rounded-[8px] px-[14px] py-[12px] mb-[22px]">
                <p class="text-[12px] font-semibold leading-[20px]">
                    Klaim kerusakan wajib disetujui agar transaksi dapat diselesaikan.
                    Tidak ada alur banding pada sistem ini.
                </p>
            </div>

            <div class="flex justify-end gap-[10px]">
                <a href="{{ route('riwayat.transaksi.penyewa') }}"
                   class="h-[42px] px-[22px] rounded-[8px] border border-[#34699A] text-[#34699A] text-[13px] font-semibold flex items-center">
                    Kembali
                </a>

                @if($claim && $claim->status === 'accepted')
                    <div class="h-[42px] px-[22px] rounded-[8px] bg-[#E8F8EF] border border-[#A8E6BF] text-[#2FA866] text-[13px] font-semibold flex items-center">
                        Klaim Sudah Disetujui
                    </div>
                @else
                    <form action="{{ route('transaksi.setujuiKlaim', $rental->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <button type="submit"
                                class="h-[42px] px-[22px] rounded-[8px] bg-[#34699A] text-white text-[13px] font-semibold">
                            Setujui Klaim
                        </button>
                    </form>
                @endif
            </div>
        </section>

    </div>

</main>

@include('layouts.partials.footer')

</body>
</html>