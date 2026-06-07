<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi Pemilik</title>
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

    function labelStatusPemilikView($status)
    {
        return match ($status) {
            'diproses' => 'Pesanan Masuk',
            'pesanan_masuk' => 'Pesanan Masuk',
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

    function badgeClassPemilikView($status)
    {
        return match ($status) {
            'diproses', 'pesanan_masuk' => 'bg-[#DDEBFF] text-[#0077A8]',
            'dikirim', 'menunggu_penerimaan' => 'bg-[#DDEBFF] text-[#0077A8]',
            'disewa' => 'bg-[#DDEBFF] text-[#0077A8]',
            'pengembalian' => 'bg-[#FFF0C2] text-[#D38A00]',
            'selesai' => 'bg-[#CFF3D9] text-[#118642]',
            'kerusakan', 'dibatalkan', 'belum_dikembalikan' => 'bg-[#FFD6DE] text-[#E3455D]',
            default => 'bg-[#E5E7EB] text-[#6B7280]',
        };
    }

    function labelPembayaranPemilikView($payment)
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

    function guideTitlePemilikView($statusAktif)
    {
        return match ($statusAktif) {
            'diproses' => 'Pesanan baru masuk',
            'pesanan_masuk' => 'Pesanan baru masuk',
            'disewa' => 'Barang sedang disewa',
            'pengembalian' => 'Menunggu pemeriksaan barang',
            'selesai' => 'Transaksi selesai',
            'bermasalah' => 'Transaksi membutuhkan tindak lanjut',
            default => 'Panduan Proses Transaksi',
        };
    }

    function guideTextPemilikView($statusAktif)
    {
        return match ($statusAktif) {
            'diproses' => 'Pesanan sudah dibayar oleh penyewa. Lanjutkan dengan konfirmasi pengiriman atau penyerahan barang.',
            'pesanan_masuk' => 'Pesanan sudah dibayar oleh penyewa. Lanjutkan dengan konfirmasi pengiriman atau penyerahan barang.',
            'disewa' => 'Barang sedang berada di penyewa. Pantau tanggal pengembalian dan komunikasi melalui chat jika diperlukan.',
            'pengembalian' => 'Penyewa sudah mengembalikan barang. Periksa kondisi barang, checklist kelengkapan, dan dokumentasi.',
            'selesai' => 'Transaksi sudah selesai. Barang dapat disewakan kembali jika status item tersedia.',
            'bermasalah' => 'Periksa detail transaksi untuk melihat kerusakan, pembatalan, atau keterlambatan pengembalian.',
            default => 'Kelola pesanan dari proses masuk, pengiriman, penyewaan, pengembalian, hingga selesai.',
        };
    }

    function statusMessagePemilikView($status, $deliveryMethod = null)
    {
        if (in_array($status, ['diproses', 'pesanan_masuk'])) {
            return $deliveryMethod === 'cod'
                ? 'Klik Konfirmasi Penyerahan jika barang sudah diserahkan kepada penyewa.'
                : 'Klik Konfirmasi Pengiriman jika barang sudah dikirim.';
        }

        return match ($status) {
            'dikirim', 'menunggu_penerimaan' => 'Menunggu penyewa mengonfirmasi penerimaan barang.',
            'disewa' => 'Hubungi Penyewa jika ingin koordinasi selama masa sewa.',
            'pengembalian' => 'Klik Konfirmasi Pengembalian setelah barang diterima kembali dari penyewa.',
            'selesai' => 'Transaksi telah selesai. Anda dapat melihat detail transaksi dan penilaian dari penyewa.',
            'dibatalkan' => 'Pesanan dibatalkan. Cek detail transaksi untuk melihat informasi pembatalan dan pengembalian dana.',
            'belum_dikembalikan' => 'Masa sewa telah berakhir dan barang belum dikembalikan. Segera hubungi penyewa untuk tindak lanjut.',
            'kerusakan' => 'Jika barang mengalami kerusakan, tinjau klaim untuk melihat perkembangan.',
            default => 'Lihat detail transaksi untuk informasi terbaru.',
        };
    }

    function statusMessageClassPemilikView($status)
    {
        return in_array($status, ['dibatalkan', 'belum_dikembalikan', 'kerusakan'])
            ? 'bg-[#FFECEF] text-[#E3455D]'
            : 'bg-[#EAF3FF] text-[#34699A]';
    }

    function statusMessageIconPemilikView($status)
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
            {{-- Tombol Back Mengarah ke Dashboard Toko --}}
            <a href="{{ route('store.dashboardToko') }}" class="btn-back block p-0 bg-transparent border-none shrink-0 hover:opacity-70 transition-opacity" title="Kembali ke Dashboard">
                <img src="{{ asset('assets/icons/icon-back.png') }}" alt="Kembali" class="block w-[24px] h-[24px] object-contain">
            </a>
            
            <h1 class="text-[22px] sm:text-[26px] font-bold text-[#1E1E1E]">
                Riwayat Transaksi
            </h1>
        </div>

        <div class="mt-[18px] inline-flex items-center gap-[8px] bg-[#DDEBFF] text-[#34699A] rounded-[8px] px-[14px] py-[8px]">
            <img src="{{ asset('assets/icons/icon-user-blue.png') }}"
                 class="w-[16px] h-[16px] object-contain"
                 alt="Pemilik">

            <span class="text-[13px] font-semibold">
                Pemilik
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

    {{-- Filter Status --}}
    <section class="mb-[22px]">
        <div class="flex flex-wrap justify-between gap-[10px]">
            @foreach($filters as $key => $label)
                <a href="{{ route('riwayat.transaksi.pemilik', ['status' => $key]) }}"
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
                    {{ guideTitlePemilikView($statusAktif) }}
                </h2>

                <p class="text-[12px] text-[#6B7280] leading-[19px] mt-[4px]">
                    {{ guideTextPemilikView($statusAktif) }}
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
                $tenant = $rental->tenant;
                $payment = $rental->payment;
                $status = $rental->status;

                $labelStatus = $rental->label_status ?? labelStatusPemilikView($status);
                $badgeClass = badgeClassPemilikView($status);
                $statusMessageClass = statusMessageClassPemilikView($status);
                $statusMessageIcon = statusMessageIconPemilikView($status);

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
                    - kalau image array, ambil gambar pertama
                    - kalau path upload, ambil dari storage
                    - kalau nama file dummy, ambil dari assets/products
                    - kalau kosong, pakai default
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

                /*
                    delivery_method:
                    - delivery / dikirim / ekspedisi = Konfirmasi Pengiriman
                    - cod / penyerahan / serah = Konfirmasi Penyerahan
                    Jika kolom belum ada, default ke pengiriman agar button tidak dobel.
                */
                $rawDeliveryMethod = strtolower($rental->delivery_method
                    ?? $rental->shipping_method
                    ?? $rental->delivery_type
                    ?? $rental->handover_method
                    ?? '');

                $deliveryMethod = str_contains($rawDeliveryMethod, 'cod')
                    || str_contains($rawDeliveryMethod, 'serah')
                    || str_contains($rawDeliveryMethod, 'ambil')
                        ? 'cod'
                        : 'delivery';

                $statusMessage = statusMessagePemilikView($status, $deliveryMethod);
            @endphp

            <article class="bg-white border border-[#C3DAFE] rounded-[10px] overflow-hidden shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">

                {{-- Header --}}
                <div class="px-[14px] sm:px-[18px] py-[12px] border-b border-[#C3DAFE] flex items-center justify-between gap-[12px]">
                    <div class="flex items-center gap-[9px] min-w-0">
                        <img src="{{ asset('assets/icons/icon-user-blue.png') }}"
                             class="w-[18px] h-[18px] object-contain shrink-0"
                             alt="Penyewa">

                        <p class="text-[13px] sm:text-[14px] font-bold truncate">
                            {{ optional($tenant)->name ?? 'Penyewa Rentalin' }}
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
                                    Pembayaran: {{ labelPembayaranPemilikView($payment) }}
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

                        @if(in_array($status, ['diproses', 'pesanan_masuk']))
                            @php
                                $method = strtolower($deliveryMethod ?? '');
                                $isCod = str_contains($method, 'cod')
                                    || str_contains($method, 'ambil')
                                    || str_contains($method, 'serah')
                                    || str_contains($method, 'langsung');
                            @endphp

                            @if($isCod)
                                <a href="{{ route('transaksi.formKonfirmasiPenyerahan', $rental->id) }}"
                                class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                    Konfirmasi Penyerahan
                                </a>
                            @else
                                <a href="{{ route('transaksi.formKonfirmasiPengiriman', $rental->id) }}"
                                class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                    Konfirmasi Pengiriman
                                </a>
                            @endif

                            <a href="{{ route('transaksi.detail', $rental->id) }}"
                            class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Detail Transaksi
                            </a>

                            <a href="{{ route('chat') }}"
                            class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Hubungi Penyewa
                            </a>
                        @endif

                        @if(in_array($status, ['dikirim', 'menunggu_penerimaan', 'disewa']))
                            <a href="{{ route('transaksi.detail', $rental->id) }}"
                            class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Detail Transaksi
                            </a>

                            <a href="{{ route('chat') }}"
                            class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Hubungi Penyewa
                            </a>
                        @endif

                        @if($status === 'pengembalian')
                            <a href="{{ route('transaksi.formKonfirmasiPengembalian', $rental->id) }}"
                            class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Konfirmasi Pengembalian
                            </a>

                            <a href="{{ route('transaksi.detail', $rental->id) }}"
                            class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Detail Transaksi
                            </a>

                            <a href="{{ route('chat') }}"
                            class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Hubungi Penyewa
                            </a>
                        @endif

                        @if($status === 'belum_dikembalikan')
                            <a href="{{ route('transaksi.detail', $rental->id) }}"
                            class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Detail Transaksi
                            </a>

                            <a href="{{ route('chat') }}"
                            class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Hubungi Penyewa
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

                            <a href="{{ route('chat') }}"
                            class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Hubungi Penyewa
                            </a>
                        @endif

                        @if(in_array($status, ['selesai', 'dibatalkan']))
                            <a href="{{ route('transaksi.detail', $rental->id) }}"
                            class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center justify-center">
                                Detail Transaksi
                            </a>
                        @endif

                    </div>

                    {{-- Message Status --}}
                    @php
                        $isDangerStatus = in_array($status, ['kerusakan', 'dibatalkan', 'belum_dikembalikan']);
                    @endphp

                    <div class="mt-[12px] rounded-[8px] px-[12px] py-[10px] flex items-start gap-[8px]
                        {{ $isDangerStatus ? 'bg-[#FFECEF] text-[#E3455D]' : 'bg-[#EAF3FF] text-[#34699A]' }}">

                        <img src="{{ asset($isDangerStatus ? 'assets/icons/icon-warning-red.png' : 'assets/icons/icon-info-blue.png') }}"
                            class="w-[16px] h-[16px] object-contain mt-[1px]"
                            alt="Info">

                        <p class="text-[11px] leading-[18px] font-medium">
                            @if(in_array($status, ['diproses', 'pesanan_masuk']))
                                Pesanan sudah dibayar penyewa. Klik konfirmasi jika barang sudah dikirim atau diserahkan.
                            @elseif(in_array($status, ['dikirim', 'menunggu_penerimaan']))
                                Barang sedang menunggu konfirmasi penerimaan dari penyewa.
                            @elseif($status === 'disewa')
                                Hubungi penyewa jika ingin koordinasi selama masa sewa.
                            @elseif($status === 'pengembalian')
                                Klik Konfirmasi Pengembalian setelah barang diterima kembali dari penyewa.
                            @elseif($status === 'selesai')
                                Transaksi telah selesai. Anda dapat melihat detail transaksi dan penilaian dari penyewa.
                            @elseif($status === 'dibatalkan')
                                Transaksi ini telah dibatalkan. Detail alasan pembatalan dapat dilihat di halaman detail transaksi.
                            @elseif($status === 'belum_dikembalikan')
                                Masa sewa telah berakhir dan barang belum dikembalikan. Segera hubungi penyewa untuk tindak lanjut.
                            @elseif($status === 'kerusakan')
                                Jika barang mengalami kerusakan, tinjau klaim untuk melihat perkembangan.
                            @else
                                Lihat detail transaksi untuk informasi terbaru.
                            @endif
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

    {{-- Pagination --}}
    @if($rentals->hasPages())
        <div class="mt-[36px] flex items-center justify-center gap-[12px]">

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