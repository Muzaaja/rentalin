<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi Penyewa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body class="bg-[#F5F7FA] text-[#1E1E1E] [font-family:'Plus_Jakarta_Sans',sans-serif]">

@include('layouts.partials.navbar')

@php
    use Carbon\Carbon;

    $statusAktif = $statusAktif ?? request('status', 'semua');

    function labelStatusPenyewaView($status)
    {
        return match ($status) {
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'diproses' => 'Diproses',
            'pesanan_masuk' => 'Diproses',
            'dikirim' => 'Dikirim',
            'menunggu_penerimaan' => 'Menunggu Penerimaan',
            'disewa' => 'Disewa',
            'pengembalian' => 'Pengembalian',
            'kerusakan' => 'Kerusakan',
            'dibatalkan' => 'Dibatalkan',
            'belum_dikembalikan' => 'Belum Dikembalikan',
            'selesai' => 'Selesai',
            default => ucfirst(str_replace('_', ' ', $status)),
        };
    }

    function badgeClassPenyewaView($status)
    {
        return match ($status) {
            'menunggu_pembayaran' => 'bg-[#FFF0C2] text-[#D38A00]',
            'diproses', 'pesanan_masuk' => 'bg-[#DDEBFF] text-[#0077A8]',
            'dikirim', 'menunggu_penerimaan' => 'bg-[#DDEBFF] text-[#0077A8]',
            'disewa' => 'bg-[#DDEBFF] text-[#0077A8]',
            'pengembalian' => 'bg-[#FFF0C2] text-[#D38A00]',
            'selesai' => 'bg-[#CFF3D9] text-[#118642]',
            'kerusakan', 'dibatalkan', 'belum_dikembalikan' => 'bg-[#FFD6DE] text-[#E3455D]',
            default => 'bg-[#E5E7EB] text-[#6B7280]',
        };
    }

    function labelPembayaranPenyewaView($payment)
    {
        if (!$payment) {
            return 'Belum ada pembayaran';
        }

        if (($payment->payment_type ?? null) === 'paylater') {
            $plan = $payment->installment_plan ?? '-';
            $paid = $payment->installment_paid ?? 0;

            return 'PayLater ' . $paid . '/' . $plan . ' cicilan';
        }

        if (($payment->payment_status ?? $payment->status ?? null) === 'paid') {
            return 'Bayar Penuh';
        }

        return ucfirst(str_replace('_', ' ', $payment->payment_status ?? $payment->status ?? 'Pending'));
    }

    function guideTitlePenyewaView($statusAktif)
    {
        return match ($statusAktif) {
            'diproses' => 'Pesanan sedang diproses',
            'disewa' => 'Barang sedang disewa',
            'pengembalian' => 'Proses pengembalian berjalan',
            'selesai' => 'Transaksi selesai',
            'bermasalah' => 'Transaksi membutuhkan perhatian',
            default => 'Panduan Proses Transaksi',
        };
    }

    function guideTextPenyewaView($statusAktif)
    {
        return match ($statusAktif) {
            'diproses' => 'Jika ingin janjian, cek posisi paket, atau menanyakan pengiriman, silakan hubungi pemilik melalui chat.',
            'disewa' => 'Saat barang sudah diterima, Anda dapat memperpanjang sewa atau mengembalikan barang sesuai tanggal sewa.',
            'pengembalian' => 'Pastikan dokumentasi pengembalian sudah lengkap agar pemilik dapat memeriksa barang.',
            'selesai' => 'Transaksi sudah selesai. Jangan lupa beri penilaian untuk pengalaman sewa Anda.',
            'bermasalah' => 'Periksa detail transaksi untuk melihat alasan pembatalan, keterlambatan, atau klaim kerusakan.',
            default => 'Lihat cara transaksi dari awal hingga selesai.',
        };
    }

    function statusMessagePenyewaView($status)
    {
        return match ($status) {
            'menunggu_pembayaran' => 'Selesaikan pembayaran agar pesanan dapat diproses.',

            'diproses', 'pesanan_masuk', 'dikirim', 'menunggu_penerimaan'
                => 'Klik Konfirmasi Penerimaan jika barang sudah diterima. Hubungi pemilik untuk janjian serah terima atau menanyakan posisi paket.',

            'disewa'
                => 'Barang sedang dalam masa sewa, klik pesanan dikembalikan jika barang sudah dikembalikan. Jika ingin memperpanjang sewa, ajukan perpanjangan sebelum tanggal pengembalian berakhir.',

            'pengembalian'
                => 'Pengembalian sudah diajukan. Tunggu pemilik memeriksa barang dan mengonfirmasi pengembalian.',

            'selesai'
                => 'Transaksi telah selesai. Jangan lupa beri penilaian untuk pengalaman sewa Anda.',

            'dibatalkan'
                => 'Pesanan dibatalkan. Pengembalian dana diproses sesuai kebijakan pembatalan.',

            'belum_dikembalikan'
                => 'Masa sewa telah berakhir dan barang belum dikembalikan. Segera kembalikan barang ke pemilik.',

            'kerusakan'
                => 'Terdapat klaim kerusakan pada transaksi ini. Tinjau klaim untuk melihat bukti dan memberikan tanggapan.',

            default => 'Lihat detail transaksi untuk informasi terbaru.',
        };
    }

    function statusMessageClassPenyewaView($status)
    {
        return in_array($status, ['dibatalkan', 'belum_dikembalikan', 'kerusakan'])
            ? 'bg-[#FFECEF] text-[#E3455D]'
            : 'bg-[#EAF3FF] text-[#34699A]';
    }

    function statusMessageIconPenyewaView($status)
    {
        return in_array($status, ['dibatalkan', 'belum_dikembalikan', 'kerusakan'])
            ? 'assets/icons/icon-warning-red.png'
            : 'assets/icons/icon-info-blue.png';
    }
@endphp

<main class="w-full max-w-[435px] sm:max-w-[940px] lg:max-w-[1220px] mx-auto px-[20px] sm:px-[44px] lg:px-[66px] pt-[28px] pb-[70px]">

    {{-- Header --}}
    <section class="mb-[22px]">
        <div class="flex items-center gap-[12px]">
            {{-- Tombol Back - Murni Icon, Tanpa Fill/Line --}}
            <a href="{{ url()->previous() }}" class="block p-0 bg-transparent border-none">
                <img src="{{ asset('assets/icons/icon-back.png') }}" alt="Back" class="w-[24px] h-[24px] block">
            </a>
            
            <h1 class="text-[22px] sm:text-[26px] font-bold text-[#1E1E1E]">
                Riwayat Transaksi
            </h1>
        </div>

        <div class="mt-[18px] inline-flex items-center gap-[8px] bg-[#DDEBFF] text-[#34699A] rounded-[8px] px-[14px] py-[8px]">
            <img src="{{ asset('assets/icons/icon-user-blue.png') }}"
                 class="w-[16px] h-[16px] object-contain"
                 alt="Penyewa">

            <span class="text-[13px] font-semibold">
                Penyewa
            </span>
        </div>
    </section>

    {{-- Flash Error --}}
    @if(session('error'))
        <div class="mb-[18px] bg-[#FFECEF] border border-[#F4B8C2] text-[#E3455D] px-[14px] py-[12px] rounded-[8px] text-[13px] font-semibold">
            {{ session('error') }}
        </div>
    @endif

    {{-- Modal Success --}}
    @if(session('success') || session('success_title') || session('success_message'))
        <div id="successModal"
            class="fixed inset-0 bg-black/40 flex items-center justify-center z-[9999] px-[20px]">
            <div class="bg-white rounded-[12px] w-full max-w-[320px] px-[24px] py-[30px] text-center shadow-[0px_8px_24px_rgba(0,0,0,0.18)]">

                <div class="w-[64px] h-[64px] rounded-full bg-[#34699A] mx-auto mb-[20px] flex items-center justify-center">
                    <span class="text-white text-[34px] font-bold leading-none">
                        ✓
                    </span>
                </div>

                <h3 class="text-[15px] font-bold text-[#34699A] mb-[8px]">
                    {{ session('success_title', 'Berhasil!') }}
                </h3>

                <p class="text-[12px] text-[#696969] leading-[20px] mb-[22px]">
                    {{ session('success_message', session('success')) }}
                </p>

                <button type="button"
                        onclick="document.getElementById('successModal').remove()"
                        class="h-[32px] px-[22px] rounded-[6px] bg-[#34699A] text-white text-[12px] font-semibold">
                    Selesai
                </button>
            </div>
        </div>
    @endif

    {{-- Filter --}}
    <section class="mb-[22px]">
        <div class="flex flex-wrap justify-between gap-[10px]">
            @foreach($filters as $key => $label)
                <a href="{{ route('riwayat.transaksi.penyewa', ['status' => $key]) }}"
                   class="min-w-[108px] h-[38px] rounded-[20px] border text-[13px] font-semibold flex items-center justify-center px-[18px]
                        {{ $statusAktif === $key
                            ? 'bg-[#34699A] text-white border-[#34699A]'
                            : 'bg-white text-[#34699A] border-[#7BAFE3]' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </section>

    {{-- Guide --}}
    <section class="bg-[#DDEBFF] border border-[#C3DAFE] rounded-[10px] px-[16px] sm:px-[20px] py-[14px] mb-[18px] flex items-start justify-between gap-[12px]">
        <div class="flex items-start gap-[12px]">
            <img src="{{ asset('assets/icons/icon-info-blue.png') }}"
                 class="w-[26px] h-[26px] object-contain mt-[2px]"
                 alt="Panduan">

            <div>
                <h2 class="text-[15px] font-bold text-[#1E1E1E]">
                    {{ guideTitlePenyewaView($statusAktif) }}
                </h2>

                <p class="text-[12px] text-[#6B7280] leading-[19px] mt-[4px]">
                    {{ guideTextPenyewaView($statusAktif) }}
                </p>
            </div>
        </div>

        <img src="{{ asset('assets/icons/icon-process.png') }}"
             class="hidden sm:block w-[28px] h-[28px] object-contain"
             alt="Proses">
    </section>

    {{-- List transaksi --}}
    <section class="space-y-[16px]">
        @forelse($rentals as $rental)
            @php
                $item = $rental->item;
                $owner = $rental->owner;
                $payment = $rental->payment;
                $status = $rental->status;

                $labelStatus = $rental->label_status ?? labelStatusPenyewaView($status);
                $badgeClass = badgeClassPenyewaView($status);
                $statusMessage = statusMessagePenyewaView($status);
                $statusMessageClass = statusMessageClassPenyewaView($status);
                $statusMessageIcon = statusMessageIconPenyewaView($status);

                $startDate = $rental->start_date
                    ? Carbon::parse($rental->start_date)->format('d M Y')
                    : '-';

                $endDate = $rental->end_date
                    ? Carbon::parse($rental->end_date)->format('d M Y')
                    : '-';

                $durasi = ($rental->start_date && $rental->end_date)
                    ? Carbon::parse($rental->start_date)->diffInDays(Carbon::parse($rental->end_date))
                    : 0;

                /*
                    Kode gambar dari teman kamu:
                    - ambil image dari item
                    - kalau array ambil index pertama
                    - kalau kosong pakai default
                    - disesuaikan storage/assets
                */
                $itemImage = optional($item)->image;
                $firstImage = is_array($itemImage) ? ($itemImage[0] ?? null) : $itemImage;

                if ($firstImage) {
                    $imageUrl = str_starts_with($firstImage, 'items/')
                        || str_starts_with($firstImage, 'uploads/')
                        || str_starts_with($firstImage, 'products/')
                            ? asset('storage/' . $firstImage)
                            : asset('assets/products/' . $firstImage);
                } else {
                    $imageUrl = asset('assets/products/default-product.png');
                }

                $isPaylater = optional($payment)->payment_type === 'paylater';

                $nextDueDate = optional($payment)->next_due_date
                    ? Carbon::parse($payment->next_due_date)->format('d M Y')
                    : null;
            @endphp

            <article class="bg-white border border-[#C3DAFE] rounded-[10px] overflow-hidden shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">

                {{-- Header toko --}}
                <div class="px-[14px] sm:px-[18px] py-[12px] border-b border-[#C3DAFE] flex items-center justify-between gap-[12px]">
                    <div class="flex items-center gap-[9px] min-w-0">
                        <img src="{{ asset('assets/icons/icon-store.png') }}"
                             class="w-[18px] h-[18px] object-contain shrink-0"
                             alt="Toko">

                        <p class="text-[13px] sm:text-[14px] font-bold truncate">
                            {{ optional($owner)->name ?? 'Rentalin Store' }}
                        </p>
                    </div>

                    <span class="h-[26px] px-[12px] rounded-full text-[11px] font-semibold inline-flex items-center shrink-0 {{ $badgeClass }}">
                        {{ $labelStatus }}
                    </span>
                </div>

                {{-- Body --}}
                <div class="px-[14px] sm:px-[18px] py-[14px]">

                    <div class="flex items-start justify-between gap-[12px]">

                        {{-- Kiri: Gambar + Detail Produk --}}
                        <div class="flex gap-[12px] min-w-0 flex-1">
                            <img src="{{ $imageUrl }}"
                                class="w-[74px] h-[74px] sm:w-[82px] sm:h-[82px] rounded-[7px] object-cover flex-shrink-0"
                                alt="{{ optional($item)->name ?? 'Item Image' }}">

                            <div class="min-w-0 flex-1">
                                <h3 class="text-[14px] sm:text-[15px] font-bold leading-[21px] line-clamp-2">
                                    {{ optional($item)->name ?? '-' }}
                                </h3>

                                <div class="flex flex-wrap items-center gap-[6px] mt-[6px]">
                                    <span class="text-[10px] text-[#8A8A8A] border border-[#D7DCE3] rounded-[4px] px-[6px] py-[2px]">
                                        Jumlah: 1 Buah
                                    </span>

                                    <span class="text-[10px] text-[#8A8A8A] border border-[#D7DCE3] rounded-[4px] px-[6px] py-[2px]">
                                        ID Transaksi: {{ $rental->rental_code }}
                                    </span>
                                </div>

                                <p class="text-[11px] text-[#6B7280] mt-[7px] inline-flex items-center gap-[4px]">
                                    <img src="{{ asset('assets/icons/icon-calendar.png') }}"
                                        class="w-[12px] h-[12px] object-contain"
                                        alt="Tanggal">

                                    {{ $startDate }} - {{ $endDate }} • {{ $durasi }} hari
                                </p>

                                <p class="text-[11px] text-[#6B7280] mt-[4px]">
                                    Pembayaran: {{ labelPembayaranPenyewaView($payment) }}
                                </p>

                                @if($isPaylater)
                                    <div class="mt-[5px] flex flex-wrap items-center gap-[8px]">
                                        <p class="text-[11px] text-[#D38A00]">
                                            Tempo berikutnya:
                                            {{ $nextDueDate ?? '-' }}
                                        </p>

                                        <a href="{{ route('profile.edit') }}#cicilan"
                                        class="text-[11px] font-semibold text-[#34699A] underline">
                                            Lihat Cicilan
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Kanan: Total Pesanan --}}
                        <div class="w-[112px] sm:w-[130px] flex-shrink-0 text-right pt-[20px]">
                            <p class="text-[12px] sm:text-[13px] text-[#6B7280]">
                                Total Pesanan
                            </p>

                            <p class="text-[18px] sm:text-[20px] font-bold text-[#34699A] mt-[4px] leading-none">
                                Rp{{ number_format($rental->total_price ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    {{-- Action --}}
                    <div class="mt-[14px] pt-[12px] border-t border-[#C3DAFE] flex flex-wrap justify-end gap-[8px]">

                        @if($status === 'menunggu_pembayaran')
                            <a href="{{ route('checkout') }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Bayar Sekarang
                            </a>

                            <a href="{{ route('transaksi.formBatalkanPesanan', $rental->id) }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#E3455D] border border-[#E3455D] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Batalkan Pesanan
                            </a>
                        @endif

                        @if(in_array($status, ['diproses', 'pesanan_masuk']))
                            <a href="{{ route('transaksi.formKonfirmasiPenerimaan', $rental->id) }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Konfirmasi Penerimaan
                            </a>

                            <a href="{{ route('transaksi.formBatalkanPesanan', $rental->id) }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#E3455D] border border-[#E3455D] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Batalkan Pesanan
                            </a>

                            <a href="{{ route('chat') }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Hubungi Pemilik
                            </a>
                        @endif

                        @if(in_array($status, ['dikirim', 'menunggu_penerimaan']))
                            <a href="{{ route('transaksi.formKonfirmasiPenerimaan', $rental->id) }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Konfirmasi Penerimaan
                            </a>

                            <a href="{{ route('chat') }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Hubungi Pemilik
                            </a>

                            <a href="{{ route('transaksi.detail', $rental->id) }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Detail Transaksi
                            </a>
                        @endif

                        @if($status === 'disewa')
                            <a href="{{ route('transaksi.formPerpanjanganSewa', $rental->id) }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Perpanjang Sewa
                            </a>

                            <a href="{{ route('transaksi.formPesananDikembalikan', $rental->id) }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Pesanan Dikembalikan
                            </a>

                            <a href="{{ route('transaksi.detail', $rental->id) }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Detail Transaksi
                            </a>
                        @endif

                        @if($status === 'pengembalian')
                            <a href="{{ route('transaksi.detail', $rental->id) }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Detail Transaksi
                            </a>

                            <a href="{{ route('chat') }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Hubungi Pemilik
                            </a>
                        @endif

                        @if($status === 'selesai')
                            <a href="{{ route('ulasan.create', $rental->id) }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Nilai
                            </a>

                            <a href="{{ route('store') }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Sewa Kembali
                            </a>

                            <a href="{{ route('transaksi.detail', $rental->id) }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Detail Transaksi
                            </a>
                        @endif

                        @if($status === 'belum_dikembalikan')
                            <a href="{{ route('transaksi.formPesananDikembalikan', $rental->id) }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Pesanan Dikembalikan
                            </a>

                            <a href="{{ route('chat') }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Hubungi Pemilik
                            </a>
                        @endif

                        @if($status === 'kerusakan')
                            <a href="{{ route('transaksi.lihatKlaim', $rental->id) }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Lihat Klaim
                            </a>

                            <a href="{{ route('transaksi.detail', $rental->id) }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Detail Transaksi
                            </a>
                        @endif

                        @if($status === 'dibatalkan')
                            <a href="{{ route('transaksi.detail', $rental->id) }}"
                               class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Detail Transaksi
                            </a>
                        @endif

                    </div>

                    {{-- Pesan status --}}
                    <div class="mt-[10px] rounded-[7px] px-[10px] py-[10px] flex items-start gap-[8px] {{ $statusMessageClass }}">
                        <img src="{{ asset($statusMessageIcon) }}"
                             class="w-[16px] h-[16px] object-contain mt-[1px]"
                             alt="Info">

                        <p class="text-[11px] leading-[18px] font-medium">
                            {{ $statusMessage }}
                        </p>
                    </div>
                </div>
            </article>
        @empty
            <div class="bg-white border border-[#D7E5FA] rounded-[10px] px-[18px] py-[30px] text-center">
                <p class="text-[13px] text-[#6B7280]">
                    Belum ada transaksi pada status ini.
                </p>
            </div>
        @endforelse
    </section>

    {{-- Pagination custom --}}
    @if($rentals->hasPages())
        <div class="mt-[36px] flex items-center justify-center gap-[12px]">

            {{-- Previous --}}
            @if($rentals->onFirstPage())
                <span class="w-[48px] h-[48px] rounded-[8px] border border-[#D7E5FA] bg-[#F1F5F9] text-[#A0AEC0] flex items-center justify-center cursor-not-allowed">
                    ‹
                </span>
            @else
                <a href="{{ $rentals->previousPageUrl() }}"
                   class="w-[48px] h-[48px] rounded-[8px] border border-[#7BAFE3] bg-white text-[#34699A] flex items-center justify-center font-bold">
                    ‹
                </a>
            @endif

            {{-- Page numbers --}}
            @foreach(range(1, $rentals->lastPage()) as $page)
                @if($page == $rentals->currentPage())
                    <span class="w-[48px] h-[48px] rounded-[8px] bg-[#34699A] text-white flex items-center justify-center font-bold">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $rentals->url($page) }}"
                       class="w-[48px] h-[48px] rounded-[8px] border border-[#7BAFE3] bg-white text-[#34699A] flex items-center justify-center font-bold">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Next --}}
            @if($rentals->hasMorePages())
                <a href="{{ $rentals->nextPageUrl() }}"
                   class="w-[48px] h-[48px] rounded-[8px] border border-[#7BAFE3] bg-white text-[#34699A] flex items-center justify-center font-bold">
                    ›
                </a>
            @else
                <span class="w-[48px] h-[48px] rounded-[8px] border border-[#D7E5FA] bg-[#F1F5F9] text-[#A0AEC0] flex items-center justify-center cursor-not-allowed">
                    ›
                </span>
            @endif
        </div>
    @endif

</main>

@include('layouts.partials.footer')

</body>
</html>