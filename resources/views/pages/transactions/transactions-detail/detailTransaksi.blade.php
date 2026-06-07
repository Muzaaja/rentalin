<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
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

    $item = $rental->item;
    $owner = $rental->owner;
    $tenant = $rental->tenant;
    $payment = $rental->payment;
    $documents = $rental->documents ?? collect();
    $extension = $rental->latestExtension;
    $claim = $rental->damageClaim;
    $additionalPayments = $rental->additionalPayments ?? collect();
    $cancellation = $rental->cancellation;

    $status = $rental->status;

    $startDate = $rental->start_date
        ? Carbon::parse($rental->start_date)->format('d M Y')
        : '-';

    $endDate = $rental->end_date
        ? Carbon::parse($rental->end_date)->format('d M Y')
        : '-';

    $durasi = ($rental->start_date && $rental->end_date)
        ? Carbon::parse($rental->start_date)->diffInDays(Carbon::parse($rental->end_date))
        : 0;

    $createdDate = $rental->created_at
        ? Carbon::parse($rental->created_at)->format('d M Y')
        : $startDate;

    $acceptedDate = $rental->acceptance_date ?? $rental->updated_at ?? null;
    $acceptedDateFormatted = $acceptedDate
        ? Carbon::parse($acceptedDate)->format('d M Y')
        : '-';

    $extensionOldDate = optional($extension)->old_end_date
        ? Carbon::parse($extension->old_end_date)->format('d M Y')
        : $endDate;

    $extensionNewDate = optional($extension)->new_end_date
        ? Carbon::parse($extension->new_end_date)->format('d M Y')
        : $endDate;

    $sisaWaktu = '-';
    if ($rental->end_date) {
        $today = Carbon::today();
        $end = Carbon::parse($rental->end_date);
        $diff = $today->diffInDays($end, false);

        if ($diff > 0) {
            $sisaWaktu = $diff . ' hari lagi';
        } elseif ($diff === 0) {
            $sisaWaktu = 'Hari ini';
        } else {
            $sisaWaktu = 'Terlambat ' . abs($diff) . ' hari';
        }
    }

    /*
        Kode gambar produk:
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

    function labelStatusDetailView($status)
    {
        return match ($status) {
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'diproses' => 'Disewa',
            'pesanan_masuk' => 'Disewa',
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

    function badgeClassDetailView($status)
    {
        return match ($status) {
            'menunggu_pembayaran' => 'bg-[#FFF0C2] text-[#D38A00]',
            'diproses', 'pesanan_masuk', 'dikirim', 'menunggu_penerimaan', 'disewa' => 'bg-[#DDEBFF] text-[#34699A]',
            'pengembalian' => 'bg-[#FFF0C2] text-[#D38A00]',
            'selesai' => 'bg-[#CFF3D9] text-[#118642]',
            'kerusakan', 'dibatalkan', 'belum_dikembalikan' => 'bg-[#FFD6DE] text-[#E3455D]',
            default => 'bg-[#E5E7EB] text-[#6B7280]',
        };
    }

    function formatDokumenUrlDetailView($path)
    {
        if (!$path) {
            return null;
        }

        if (
            str_starts_with($path, 'rental-documents/')
            || str_starts_with($path, 'documents/')
            || str_starts_with($path, 'uploads/')
            || str_starts_with($path, 'damage/')
            || str_starts_with($path, 'items/')
        ) {
            return asset('storage/' . $path);
        }

        return asset('storage/' . $path);
    }

    function documentPathDetailView($document)
    {
        return $document->image
            ?? $document->file_path
            ?? $document->path
            ?? null;
    }

    $isPaylater = optional($payment)->payment_type === 'paylater';

    $paymentLabel = $isPaylater
        ? 'PayLater'
        : (optional($payment)->payment_method ?? 'COD');

    $hargaSewa = optional($item)->price_per_day ?? 0;
    $deposit = $rental->deposit ?? 50000;
    $extensionPrice = optional($extension)->extension_price ?? 0;
    $denda = $rental->late_fee ?? 20000;

    $totalPesanan = $rental->total_price ?? (($hargaSewa * max($durasi, 1)) + $deposit + $extensionPrice);

    $deliveryMethod = $rental->delivery_method
        ?? $rental->shipping_method
        ?? $rental->delivery_type
        ?? 'Delivery';

    $expedition = $rental->expedition
        ?? $rental->shipping_courier
        ?? 'SiCepat - Regular Package';

    $trackingNumber = $rental->tracking_number
        ?? $rental->resi_number
        ?? $rental->nomor_resi
        ?? '005258591834';

    $shippingAddress = $rental->shipping_address
        ?? optional($tenant)->address
        ?? 'Budi Santoso (+62 812-3383-0935), Jl. Braga, Kecamatan Sumur Bandung, Kota Bandung, Jawa Barat 40111';

    $timelineRows = [
        [
            'label' => 'Pesanan Dibuat',
            'date' => $createdDate,
            'active' => true,
        ],
        [
            'label' => 'Pembayaran Berhasil',
            'date' => $createdDate,
            'active' => !in_array($status, ['menunggu_pembayaran']),
        ],
        [
            'label' => 'Barang Diproses',
            'date' => $rental->processed_at ? Carbon::parse($rental->processed_at)->format('d M Y') : ($createdDate !== '-' ? Carbon::parse($createdDate)->addDay()->format('d M Y') : '-'),
            'active' => !in_array($status, ['menunggu_pembayaran']),
        ],
        [
            'label' => 'Konfirmasi Penerimaan',
            'date' => $acceptedDateFormatted !== '-' ? $acceptedDateFormatted : ($rental->start_date ? Carbon::parse($rental->start_date)->format('d M Y') : '-'),
            'active' => in_array($status, ['disewa', 'pengembalian', 'kerusakan', 'belum_dikembalikan', 'selesai']),
        ],
    ];

    if ($extension) {
        $timelineRows[] = [
            'label' => 'Perpanjangan Dibuat',
            'date' => $extension->created_at ? Carbon::parse($extension->created_at)->format('d M Y') : $extensionOldDate,
            'active' => true,
        ];
    }

    $timelineRows[] = [
        'label' => 'Sedang Disewa',
        'date' => $extension ? ($extensionOldDate . ' - ' . $extensionNewDate) : ($startDate . ' - ' . $endDate),
        'active' => in_array($status, ['disewa', 'pengembalian', 'kerusakan', 'belum_dikembalikan', 'selesai']),
    ];

    $timelineRows[] = [
        'label' => 'Konfirmasi Pengembalian',
        'date' => in_array($status, ['pengembalian']) ? 'Menunggu Pengembalian' : 'Menunggu Pengembalian',
        'active' => in_array($status, ['pengembalian', 'kerusakan', 'selesai']),
    ];

    $timelineRows[] = [
        'label' => 'Selesai',
        'date' => $status === 'selesai' ? 'Transaksi Selesai' : 'Transaksi Selesai',
        'active' => $status === 'selesai',
    ];

    $documentCards = [
        [
            'title' => 'Dikirim oleh Pemilik',
            'description' => 'Foto kondisi barang sebelum dikirim',
            'processes' => ['owner_shipping', 'owner_handover'],
        ],
        [
            'title' => 'Dikirim oleh Penyewa',
            'description' => 'Foto kondisi barang sebelum dikirim',
            'processes' => ['tenant_acceptance'],
        ],
        [
            'title' => 'Dikirim oleh Penyewa',
            'description' => 'Foto kondisi barang sebelum dikirim',
            'processes' => ['tenant_return', 'owner_return_check', 'damage_claim'],
        ],
    ];

    $pendingAdditionalPayment = $additionalPayments
        ->where('payment_status', 'menunggu_pembayaran')
        ->first();
@endphp

<main class="w-full max-w-[435px] md:max-w-[900px] lg:max-w-[1220px] mx-auto px-[20px] md:px-[44px] lg:px-[66px] pt-[34px] pb-[90px]">

    {{-- Header --}}
    <div class="flex items-center gap-[12px] mb-[44px]">
        <a href="{{ route('riwayat.transaksi.penyewa') }}"
           class="w-[36px] h-[36px] flex items-center justify-center shrink-0">
            <img src="{{ asset('assets/icons/icon-back.png') }}"
                 class="w-[30px] h-[30px] object-contain"
                 alt="Kembali">
        </a>

        <h1 class="text-[24px] md:text-[26px] font-bold leading-[34px]">
            Detail Transaksi
        </h1>
    </div>

    {{-- Success Banner Perpanjangan --}}
    @if($extension)
        <section class="bg-[#E8F8EF] rounded-[6px] px-[18px] md:px-[32px] py-[18px] md:py-[22px] mb-[24px]">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-[18px]">

                <div class="flex items-start gap-[18px]">
                    <div class="w-[50px] h-[50px] rounded-full bg-[#28A85B] flex items-center justify-center shrink-0 mt-[2px]">
                        <span class="text-white text-[30px] leading-none font-bold">
                            ✓
                        </span>
                    </div>

                    <div>
                        <h2 class="text-[23px] md:text-[25px] font-bold text-[#111827] leading-[32px]">
                            Perpanjangan Sewa Berhasil!
                        </h2>

                        <p class="text-[14px] md:text-[15px] font-semibold text-[#111827] mt-[7px]">
                            Tanggal pengembalian baru:
                            <span class="text-[#118642]">
                                {{ $extensionNewDate }}
                            </span>
                        </p>

                        <p class="text-[13px] text-[#6B7280] mt-[8px]">
                            Terima kasih telah memperpanjang sewa di Rentalin.
                        </p>
                    </div>
                </div>

                <a href="{{ route('transaksi.perpanjanganBerhasil', $rental->id) }}"
                   class="h-[42px] px-[20px] rounded-[6px] bg-white border border-[#34699A] text-[#34699A] text-[14px] font-semibold flex items-center justify-center shrink-0">
                    Lihat Detail Perpanjangan
                </a>
            </div>
        </section>
    @endif

    {{-- Grid utama --}}
    <section class="grid grid-cols-1 md:grid-cols-2 gap-[10px] md:gap-[12px]">

        {{-- Informasi Barang --}}
        <div class="bg-white border border-[#D7E5FA] rounded-[6px] px-[18px] py-[18px] shadow-[0px_2px_7px_rgba(0,0,0,0.16)]">
            <h2 class="text-[17px] font-bold mb-[14px]">
                Informasi Barang
            </h2>

            <div class="border border-[#BFD8F4] bg-[#F8FBFF] rounded-[6px] px-[14px] py-[14px] flex items-start gap-[16px]">
                <img src="{{ $imageUrl }}"
                     class="w-[70px] h-[70px] rounded-[5px] object-cover shrink-0"
                     alt="{{ optional($item)->name ?? 'Produk' }}">

                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between gap-[10px]">
                        <div class="min-w-0">
                            <h3 class="text-[15px] font-bold leading-[22px] line-clamp-2">
                                {{ optional($item)->name ?? '-' }}
                            </h3>

                            <p class="text-[11px] text-[#6B7280] mt-[7px]">
                                QTY: 1 Buah
                                <span class="mx-[5px]">•</span>
                                Sewa dari {{ optional($owner)->name ?? 'Rentalin Store' }}
                            </p>
                        </div>

                        <span class="h-[22px] px-[10px] rounded-full text-[10px] font-semibold inline-flex items-center shrink-0 {{ badgeClassDetailView($status) }}">
                            {{ labelStatusDetailView($status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="border-t border-[#D7E5FA] mt-[18px] pt-[18px] grid grid-cols-2 gap-x-[26px] gap-y-[18px]">

                <div class="flex items-start gap-[10px]">
                    <img src="{{ asset('assets/icons/icon-id-transaction.png') }}"
                         class="w-[20px] h-[20px] object-contain mt-[2px]"
                         alt="ID">

                    <div>
                        <p class="text-[11px] text-[#6B7280]">
                            ID Transaksi
                        </p>

                        <p class="text-[12px] font-bold text-[#111827] mt-[4px]">
                            {{ $rental->rental_code }}
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-[10px]">
                    <img src="{{ asset('assets/icons/icon-document-blue.png') }}"
                         class="w-[20px] h-[20px] object-contain mt-[2px]"
                         alt="Tanggal">

                    <div>
                        <p class="text-[11px] text-[#6B7280]">
                            Tanggal Pesanan
                        </p>

                        <p class="text-[12px] font-bold text-[#111827] mt-[4px]">
                            {{ $createdDate }}
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-[10px]">
                    <img src="{{ asset('assets/icons/icon-calendar.png') }}"
                         class="w-[20px] h-[20px] object-contain mt-[2px]"
                         alt="Jadwal">

                    <div>
                        <p class="text-[11px] text-[#6B7280]">
                            Jadwal Penyewaan
                        </p>

                        <p class="text-[12px] font-bold text-[#111827] mt-[4px]">
                            {{ $startDate }} - {{ $endDate }}
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-[10px]">
                    <img src="{{ asset('assets/icons/icon-calendar-blue.png') }}"
                         class="w-[20px] h-[20px] object-contain mt-[2px]"
                         alt="Pengembalian">

                    <div>
                        <p class="text-[11px] text-[#6B7280]">
                            Tanggal Pengembalian
                        </p>

                        <p class="text-[12px] font-bold text-[#111827] mt-[4px]">
                            {{ $extension ? $extensionNewDate : $endDate }}
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-[10px]">
                    <img src="{{ asset('assets/icons/icon-calendar-blue.png') }}"
                         class="w-[20px] h-[20px] object-contain mt-[2px]"
                         alt="Durasi">

                    <div>
                        <p class="text-[11px] text-[#6B7280]">
                            Durasi Sewa
                        </p>

                        <p class="text-[12px] font-bold text-[#111827] mt-[4px]">
                            {{ $durasi }} hari
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-[10px]">
                    <img src="{{ asset('assets/icons/icon-time-blue.png') }}"
                         class="w-[20px] h-[20px] object-contain mt-[2px]"
                         alt="Sisa Waktu">

                    <div>
                        <p class="text-[11px] text-[#6B7280]">
                            Sisa waktu sewa
                        </p>

                        <p class="text-[12px] font-bold mt-[4px] {{ str_contains($sisaWaktu, 'Terlambat') || str_contains($sisaWaktu, 'hari lagi') ? 'text-[#E38B2C]' : 'text-[#111827]' }}">
                            {{ $sisaWaktu }}
                        </p>
                    </div>
                </div>

            </div>

            {{-- Info pembatalan, warna netral dan posisinya di bawah ringkasan barang --}}
            @if($status === 'dibatalkan')
                <div class="mt-[18px] bg-[#F8FBFF] border border-[#D7E5FA] rounded-[8px] px-[14px] py-[14px]">
                    <h3 class="text-[14px] font-bold text-[#34699A] mb-[10px]">
                        Informasi Pembatalan
                    </h3>

                    <div class="space-y-[8px]">
                        <div class="flex justify-between gap-[14px]">
                            <span class="text-[12px] text-[#6B7280]">
                                Alasan Pembatalan
                            </span>

                            <span class="text-[12px] font-semibold text-[#111827] text-right">
                                {{ optional($cancellation)->reason ?? '-' }}
                            </span>
                        </div>

                        @if(optional($cancellation)->note)
                            <div class="flex justify-between gap-[14px]">
                                <span class="text-[12px] text-[#6B7280]">
                                    Catatan
                                </span>

                                <span class="text-[12px] font-semibold text-[#111827] text-right">
                                    {{ optional($cancellation)->note }}
                                </span>
                            </div>
                        @endif

                        <div class="flex justify-between gap-[14px]">
                            <span class="text-[12px] text-[#6B7280]">
                                Estimasi Refund
                            </span>

                            <span class="text-[12px] font-bold text-[#34699A] text-right">
                                Rp{{ number_format(optional($cancellation)->refund_amount ?? 0, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-[14px]">
                            <span class="text-[12px] text-[#6B7280]">
                                Status Refund
                            </span>

                            <span class="text-[12px] font-semibold text-[#111827] text-right">
                                {{ ucfirst(str_replace('_', ' ', optional($cancellation)->refund_status ?? '-')) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Timeline --}}
        <div class="bg-white border border-[#D7E5FA] rounded-[6px] px-[18px] py-[18px] shadow-[0px_2px_7px_rgba(0,0,0,0.16)]">
            <h2 class="text-[17px] font-bold mb-[16px]">
                Timeline Transaksi
            </h2>

            <div class="space-y-[0px]">
                @foreach($timelineRows as $index => $row)
                    @php
                        $isActive = $row['active'];
                        $isCurrent = $extension && $row['label'] === 'Sedang Disewa';
                    @endphp

                    <div class="grid grid-cols-[34px_1fr_150px] gap-[8px] items-start min-h-[42px]">
                        <div class="flex flex-col items-center">
                            <div class="w-[24px] h-[24px] rounded-full flex items-center justify-center text-[11px] font-bold
                                {{ $isActive ? 'bg-[#27A85B] text-white' : 'bg-white border border-[#C8CDD4] text-[#9CA3AF]' }}
                                {{ $isCurrent ? '!bg-[#34699A] !text-white !border-[#34699A]' : '' }}">
                                {{ $isActive && !$isCurrent ? '✓' : $index + 1 }}
                            </div>

                            @if(!$loop->last)
                                <div class="w-[2px] h-[26px] {{ $isActive ? 'bg-[#27A85B]' : 'bg-[#D1D5DB]' }}"></div>
                            @endif
                        </div>

                        <p class="text-[13px] font-bold pt-[3px] {{ $isActive ? 'text-[#111827]' : 'text-[#6B7280]' }}">
                            {{ $row['label'] }}
                        </p>

                        <p class="text-[12px] text-[#6B7280] text-right pt-[3px]">
                            {{ $row['date'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Info Pengiriman --}}
        <div class="bg-white border border-[#D7E5FA] rounded-[6px] px-[18px] py-[18px] shadow-[0px_2px_7px_rgba(0,0,0,0.16)]">
            <h2 class="text-[17px] font-bold mb-[18px]">
                Info Pengiriman
            </h2>

            <div class="space-y-[14px]">
                <div class="flex justify-between gap-[16px]">
                    <span class="text-[13px] text-[#6B7280]">
                        Metode Pengiriman
                    </span>

                    <span class="text-[13px] font-bold text-[#111827] text-right">
                        {{ $deliveryMethod }}
                    </span>
                </div>

                <div class="flex justify-between gap-[16px]">
                    <span class="text-[13px] text-[#6B7280]">
                        Ekspedisi
                    </span>

                    <span class="text-[13px] font-bold text-[#111827] text-right">
                        {{ $expedition }}
                    </span>
                </div>

                <div class="flex justify-between gap-[16px]">
                    <span class="text-[13px] text-[#6B7280]">
                        No. Resi
                    </span>

                    <span class="text-[13px] font-bold text-[#111827] text-right">
                        {{ $trackingNumber }}
                    </span>
                </div>

                <div class="flex justify-between gap-[16px]">
                    <span class="text-[13px] text-[#6B7280]">
                        Alamat Pengiriman
                    </span>

                    <span class="text-[13px] font-bold text-[#111827] text-right max-w-[260px] leading-[20px]">
                        {{ $shippingAddress }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Rincian Pembayaran --}}
        <div class="bg-white border border-[#D7E5FA] rounded-[6px] px-[18px] py-[18px] shadow-[0px_2px_7px_rgba(0,0,0,0.16)]">
            <h2 class="text-[17px] font-bold mb-[18px]">
                Rincian Pembayaran
            </h2>

            <div class="space-y-[13px]">
                <div class="flex justify-between gap-[16px]">
                    <span class="text-[13px] text-[#6B7280]">
                        Metode Pembayaran
                    </span>

                    <span class="text-[13px] font-bold text-[#111827] text-right">
                        {{ $paymentLabel }}
                    </span>
                </div>

                <div class="flex justify-between gap-[16px]">
                    <span class="text-[13px] text-[#6B7280]">
                        Harga Sewa
                    </span>

                    <span class="text-[13px] font-bold text-[#111827] text-right">
                        Rp{{ number_format($hargaSewa, 0, ',', '.') }}/hari
                    </span>
                </div>

                <div class="flex justify-between gap-[16px]">
                    <span class="text-[13px] text-[#6B7280]">
                        Deposit
                    </span>

                    <span class="text-[13px] font-bold text-[#111827] text-right">
                        Rp{{ number_format($deposit, 0, ',', '.') }}
                    </span>
                </div>

                @if($extension)
                    <div class="flex justify-between gap-[16px]">
                        <span class="text-[13px] text-[#6B7280]">
                            Biaya Perpanjangan
                        </span>

                        <span class="text-[13px] font-bold text-[#111827] text-right">
                            Rp{{ number_format($extensionPrice, 0, ',', '.') }}
                            <span class="text-[#34699A]">
                                (+{{ optional($extension)->extra_days ?? 0 }} hari)
                            </span>
                        </span>
                    </div>
                @endif

                <div class="flex justify-between gap-[16px]">
                    <span class="text-[13px] text-[#6B7280]">
                        Denda Keterlambatan
                    </span>

                    <span class="text-[13px] font-bold text-[#111827] text-right">
                        Rp{{ number_format($denda, 0, ',', '.') }}/hari
                    </span>
                </div>
            </div>

            <div class="border-t border-[#D7E5FA] mt-[16px] pt-[16px] flex justify-between gap-[16px]">
                <span class="text-[15px] font-bold text-[#111827]">
                    Total Pesanan
                </span>

                <span class="text-[16px] font-bold text-[#34699A] text-right">
                    Rp{{ number_format($totalPesanan, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </section>

    {{-- Dokumentasi --}}
    <section class="mt-[10px] bg-white border border-[#D7E5FA] rounded-[6px] px-[18px] py-[18px] shadow-[0px_2px_7px_rgba(0,0,0,0.16)]">
        <h2 class="text-[17px] font-bold mb-[14px]">
            Dokumentasi
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-[12px]">
            @foreach($documentCards as $cardIndex => $card)
                @php
                    $cardDocuments = $documents
                        ->filter(function ($document) use ($card) {
                            return in_array($document->process, $card['processes']);
                        })
                        ->values();

                    $previewDocuments = $cardDocuments->take(3);
                @endphp

                <div class="border border-[#BFD8F4] bg-[#F8FBFF] rounded-[6px] px-[16px] py-[14px]">
                    <h3 class="text-[13px] font-bold text-[#111827]">
                        {{ $card['title'] }}
                    </h3>

                    <p class="text-[12px] text-[#6B7280] mt-[8px]">
                        {{ $card['description'] }}
                    </p>

                    <div class="grid grid-cols-3 gap-[12px] mt-[14px]">
                        @for($i = 0; $i < 3; $i++)
                            @php
                                $document = $previewDocuments[$i] ?? null;
                                $documentPath = $document ? documentPathDetailView($document) : null;
                                $documentUrl = $documentPath ? formatDokumenUrlDetailView($documentPath) : null;
                            @endphp

                            @if($documentUrl)
                                <button type="button"
                                        onclick="openImagePreview('{{ $documentUrl }}')"
                                        class="h-[86px] rounded-[6px] overflow-hidden bg-[#D9D9D9]">
                                    <img src="{{ $documentUrl }}"
                                         class="w-full h-full object-cover"
                                         alt="Dokumentasi">
                                </button>
                            @else
                                <div class="h-[86px] rounded-[6px] bg-[#D9D9D9]"></div>
                            @endif
                        @endfor
                    </div>

                    <div class="mt-[14px] flex justify-center">
                        @if($cardDocuments->count() > 3)
                            <button type="button"
                                    onclick="openDocumentModal('document-card-{{ $cardIndex }}')"
                                    class="h-[34px] px-[22px] rounded-[6px] border border-[#34699A] text-[#34699A] text-[13px] font-semibold">
                                Lihat Semua
                            </button>
                        @else
                            <button type="button"
                                    class="h-[34px] px-[22px] rounded-[6px] border border-[#34699A] text-[#34699A] text-[13px] font-semibold">
                                Lihat Semua
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-[16px] rounded-[6px] bg-[#EAF3FF] px-[14px] py-[12px] flex items-center gap-[10px]">
            <img src="{{ asset('assets/icons/icon-info-blue.png') }}"
                 class="w-[18px] h-[18px] object-contain"
                 alt="Info">

            <p class="text-[12px] text-[#34699A] font-semibold">
                Dokumentasi digunakan sebagai bukti kondisi barang sebelum dikirim dan saat diterima.
            </p>
        </div>
    </section>

    {{-- Butuh Bantuan --}}
    <section class="mt-[22px] bg-[#EAF3FF] rounded-[6px] px-[20px] md:px-[28px] py-[20px] flex flex-col md:flex-row md:items-center md:justify-between gap-[18px]">
        <div class="flex items-center gap-[18px]">
            <div class="w-[46px] h-[46px] rounded-full bg-white border border-[#BFD8F4] flex items-center justify-center shrink-0">
                <span class="text-[#34699A] text-[25px] font-bold">
                    ?
                </span>
            </div>

            <div>
                <h2 class="text-[21px] font-bold text-[#34699A]">
                    Butuh Bantuan?
                </h2>

                <p class="text-[13px] text-[#34699A] font-semibold leading-[20px] mt-[4px]">
                    Jika ada pertanyaan atau kendala terkait transaksi ini,<br class="hidden md:block">
                    hubungi pemilik toko melalui fitur chat.
                </p>
            </div>
        </div>

        <div class="flex flex-wrap justify-end gap-[12px]">
            @if($status === 'disewa')
                <a href="{{ route('transaksi.formPerpanjanganSewa', $rental->id) }}"
                   class="h-[42px] px-[26px] rounded-[6px] bg-[#34699A] text-white text-[14px] font-semibold flex items-center justify-center">
                    Perpanjang Sewa
                </a>
            @endif

            <a href="{{ route('chat') }}"
               class="h-[42px] px-[26px] rounded-[6px] bg-white border border-[#34699A] text-[#34699A] text-[14px] font-semibold flex items-center justify-center">
                Chat dengan Pemilik
            </a>
        </div>
    </section>

</main>

@include('layouts.partials.footer')

{{-- Preview Image Modal --}}
<div id="imagePreviewModal"
     class="fixed inset-0 bg-black/60 hidden items-center justify-center z-[9999] px-[20px]">
    <button type="button"
            onclick="closeImagePreview()"
            class="absolute top-[20px] right-[24px] text-white text-[30px] leading-none">
        ×
    </button>

    <img id="imagePreviewModalImg"
         src=""
         class="max-w-full max-h-[84vh] rounded-[10px] bg-white"
         alt="Preview">
</div>

<script>
    function openImagePreview(src) {
        const modal = document.getElementById('imagePreviewModal');
        const img = document.getElementById('imagePreviewModalImg');

        if (!modal || !img) return;

        img.src = src;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeImagePreview() {
        const modal = document.getElementById('imagePreviewModal');
        const img = document.getElementById('imagePreviewModalImg');

        if (!modal || !img) return;

        img.src = '';
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

</body>
</html>