<!DOCTYPE html>
<html lang="id">
<head>
    {{-- konfigurasi halaman dan asset --}}
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

{{-- tampilan halaman --}}
<body class="bg-[#F5F7FA] text-[#1E1E1E] [font-family:'Plus_Jakarta_Sans',sans-serif]">

{{-- navbar --}}
{{-- bagian header utama dari partial navbar --}}
@include('layouts.partials.navbar')

@php
    // data utama dari controller
    use Carbon\Carbon;
    use App\Models\Review;

    // relasi transaksi
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
    $currentUserId = auth()->id();

    $isOwner = (int) $currentUserId === (int) $rental->owner_id;
    $isTenant = (int) $currentUserId === (int) $rental->tenant_id;

    // cek apakah penyewa sudah pernah memberi ulasan
    $sudahAdaUlasan = Review::where('rental_id', $rental->id)
        ->where('user_id', $currentUserId)
        ->exists();

    $backRoute = $isOwner
        ? route('riwayat.transaksi.pemilik')
        : route('riwayat.transaksi.penyewa');

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
        : '-';

    $updatedDate = $rental->updated_at
        ? Carbon::parse($rental->updated_at)->format('d M Y')
        : '-';

    $acceptedDate = $rental->acceptance_date ?? $rental->accepted_at ?? null;

    $acceptedDateFormatted = $acceptedDate
        ? Carbon::parse($acceptedDate)->format('d M Y')
        : '-';

    $hargaSewa = (float) (optional($item)->price_per_day ?? 0);

    $deposit = optional($item)->has_deposit
        ? (float) (optional($item)->deposit_amount ?? 0)
        : 0;

    $lateFeePercentage = (float) (optional($item)->late_fee_percentage ?? 0);
    $dendaPerHari = $hargaSewa * ($lateFeePercentage / 100);

    // cek apakah ada perpanjangan yang benar-benar berhasil
    $hasExtension = $extension
        && $extension->id
        && in_array(optional($extension)->payment_status, ['paid', 'paylater_aktif', 'partially_paid']);

    // biaya perpanjangan hanya dihitung kalau perpanjangan sudah berhasil
    $extensionPrice = $hasExtension
        ? (float) (optional($extension)->extension_price ?? 0)
        : 0;

    $damageFee = (float) (optional($claim)->repair_fee ?? $rental->damage_fee ?? 0);

    $totalSewaAwal = $hargaSewa * max($durasi, 1);
    $totalPesanan = (float) ($rental->total_price ?? ($totalSewaAwal + $deposit + $extensionPrice));

    $isPaylater = optional($payment)->payment_type === 'paylater';

    $paymentLabel = $isPaylater
        ? 'PayLater'
        : (optional($payment)->payment_method ?? 'Bayar Penuh');

    $paymentStatus = optional($payment)->payment_status
        ?? optional($payment)->status
        ?? '-';

    $nextDueDate = optional($payment)->next_due_date
        ? Carbon::parse($payment->next_due_date)->format('d M Y')
        : '-';

    $extensionOldDate = optional($extension)->old_end_date
        ? Carbon::parse($extension->old_end_date)->format('d M Y')
        : $endDate;

    $extensionNewDate = optional($extension)->new_end_date
        ? Carbon::parse($extension->new_end_date)->format('d M Y')
        : $endDate;

    $pendingAdditionalPayment = $additionalPayments
        ->where('payment_status', 'menunggu_pembayaran')
        ->first();

    $rawDeliveryMethod = strtolower($rental->delivery_method
        ?? $rental->shipping_method
        ?? $rental->delivery_type
        ?? $rental->handover_method
        ?? '');

    $deliveryMethod = str_contains($rawDeliveryMethod, 'cod')
        || str_contains($rawDeliveryMethod, 'serah')
        || str_contains($rawDeliveryMethod, 'ambil')
        || str_contains($rawDeliveryMethod, 'langsung')
            ? 'cod'
            : 'delivery';

    $deliveryMethodLabel = $deliveryMethod === 'cod'
        ? 'COD / Penyerahan Langsung'
        : 'Delivery';

    $expedition = $rental->expedition
        ?? $rental->shipping_courier
        ?? '-';

    // nomor resi dari konfirmasi pengiriman
    $trackingNumber = $rental->nomor_resi
        ?? $rental->tracking_number
        ?? $rental->resi_number
        ?? '-';

    $shippingAddress = $rental->shipping_address
        ?? optional($tenant)->address
        ?? '-';

    // gambar barang dari CRUD atau dummy
    $itemImage = optional($item)->image;

    // decode gambar kalau tersimpan sebagai JSON
    if (is_string($itemImage) && str_starts_with(trim($itemImage), '[')) {
        $decodedImage = json_decode($itemImage, true);
        $itemImage = is_array($decodedImage) ? $decodedImage : $itemImage;
    }

    // ambil gambar pertama untuk preview
    $firstImage = is_array($itemImage) ? ($itemImage[0] ?? null) : $itemImage;

    // tentukan path gambar barang
    if ($firstImage) {
        $imageUrl = str_starts_with($firstImage, 'items/')
            || str_starts_with($firstImage, 'uploads/')
            || str_starts_with($firstImage, 'products/')
                ? asset('storage/' . $firstImage)
                : asset('assets/products/' . $firstImage);
    } else {
        $imageUrl = asset('assets/products/default-product.png');
    }

    $store = optional($owner)->toko;
    $storeName = optional($store)->nama_toko
        ?? optional($owner)->name
        ?? 'Rentalin Store';

    $storeImage = optional($store)->foto_toko;

    if ($storeImage) {
        $storeImageUrl = str_starts_with($storeImage, 'toko/')
            || str_starts_with($storeImage, 'uploads/')
            || str_starts_with($storeImage, 'store/')
                ? asset('storage/' . $storeImage)
                : asset('assets/store/' . $storeImage);
    } else {
        $storeImageUrl = asset('assets/icons/icon-store.png');
    }

    function labelStatusDetailView($status)
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
            return asset('assets/products/default-product.png');
        }

        if (
            str_starts_with($path, 'rental-documents/')
            || str_starts_with($path, 'documents/')
            || str_starts_with($path, 'uploads/')
            || str_starts_with($path, 'damage/')
            || str_starts_with($path, 'items/')
            || str_starts_with($path, 'products/')
        ) {
            return asset('storage/' . $path);
        }

        return asset('storage/' . $path);
    }

    function documentPathDetailView($document)
    {
        return $document->file_path
            ?? $document->image
            ?? $document->path
            ?? null;
    }

    function paymentStatusLabelDetailView($status)
    {
        return match ($status) {
            'paid' => 'Lunas',
            'partially_paid' => 'PayLater Aktif',
            'pending' => 'Menunggu Pembayaran',
            'overdue' => 'Terlambat',
            'failed' => 'Gagal',
            default => ucfirst(str_replace('_', ' ', $status ?? '-')),
        };
    }

    function hasExtensionDetailView($extension)
    {
        return $extension
            && $extension->id
            && in_array(optional($extension)->payment_status, ['paid', 'paylater_aktif', 'partially_paid']);
    }

    function timelineStepsDetailView($status, $extension = null, $claim = null)
    {
        $steps = [
            [
                'key' => 'menunggu_pembayaran',
                'label' => 'Pesanan Dibuat',
                'description' => 'Pesanan dibuat oleh penyewa.',
            ],
            [
                'key' => 'pesanan_masuk',
                'label' => 'Pembayaran Berhasil',
                'description' => 'Pembayaran berhasil dan pesanan masuk ke pemilik.',
            ],
            [
                'key' => 'dikirim',
                'label' => 'Barang Diproses',
                'description' => 'Pemilik mengirim atau menyerahkan barang.',
            ],
            [
                'key' => 'menunggu_penerimaan',
                'label' => 'Menunggu Penerimaan',
                'description' => 'Menunggu penyewa mengonfirmasi penerimaan barang.',
            ],
            [
                'key' => 'disewa',
                'label' => 'Sedang Disewa',
                'description' => 'Barang sedang berada dalam masa sewa.',
            ],
        ];

        if (hasExtensionDetailView($extension)) {
            $steps[] = [
                'key' => 'perpanjangan',
                'label' => 'Perpanjangan Sewa',
                'description' => 'Penyewa melakukan perpanjangan masa sewa.',
            ];
        }

        $steps[] = [
            'key' => 'pengembalian',
            'label' => 'Pengembalian',
            'description' => 'Penyewa mengembalikan barang kepada pemilik.',
        ];

        if ($status === 'kerusakan' || ($claim && $claim->id)) {
            $steps[] = [
                'key' => 'kerusakan',
                'label' => 'Klaim Kerusakan',
                'description' => 'Pemilik mengajukan klaim kerusakan kepada penyewa.',
            ];
        }

        $steps[] = [
            'key' => 'selesai',
            'label' => 'Selesai',
            'description' => 'Transaksi selesai.',
        ];

        return $steps;
    }

    function isTimelineActiveDetailView($stepKey, $status, $extension = null, $claim = null)
    {
        $order = [
            'menunggu_pembayaran' => 1,
            'diproses' => 2,
            'pesanan_masuk' => 2,
            'dikirim' => 3,
            'menunggu_penerimaan' => 4,
            'disewa' => 5,
            'perpanjangan' => 6,
            'pengembalian' => 7,
            'belum_dikembalikan' => 7,
            'kerusakan' => 8,
            'selesai' => 9,
        ];

        if ($status === 'dibatalkan') {
            return in_array($stepKey, ['menunggu_pembayaran']);
        }

        if ($stepKey === 'perpanjangan') {
            return hasExtensionDetailView($extension);
        }

        if ($stepKey === 'kerusakan') {
            return $status === 'kerusakan' || ($claim && $claim->id);
        }

        $statusOrder = $order[$status] ?? 1;
        $stepOrder = $order[$stepKey] ?? 1;

        return $stepOrder <= $statusOrder;
    }

    $timelineSteps = timelineStepsDetailView($status, $extension, $claim);

    $documentGroups = [
        'owner_shipping' => [
            'title' => 'Dikirim oleh Pemilik',
            'description' => 'Foto kondisi barang sebelum dikirim.',
        ],
        'owner_handover' => [
            'title' => 'Diserahkan oleh Pemilik',
            'description' => 'Foto serah terima barang saat COD.',
        ],
        'tenant_acceptance' => [
            'title' => 'Diterima oleh Penyewa',
            'description' => 'Foto kondisi barang saat diterima penyewa.',
        ],
        'tenant_return' => [
            'title' => 'Dikembalikan oleh Penyewa',
            'description' => 'Foto kondisi barang saat dikembalikan.',
        ],
        'owner_return_check' => [
            'title' => 'Diperiksa oleh Pemilik',
            'description' => 'Foto pemeriksaan barang setelah dikembalikan.',
        ],
        'damage_claim' => [
            'title' => 'Bukti Klaim Kerusakan',
            'description' => 'Foto bukti kerusakan yang diajukan pemilik.',
        ],
    ];
@endphp

{{-- konten utama --}}
<main class="w-full max-w-[1220px] mx-auto px-[16px] sm:px-[28px] md:px-[44px] lg:px-[66px] pt-[28px] pb-[70px]">

    {{-- header halaman --}}
    <div class="flex items-center gap-[12px] mb-[24px]">
        <a href="{{ $backRoute }}"
           class="w-[34px] h-[34px] flex items-center justify-center shrink-0 rounded-full transition-all duration-200 hover:bg-[#EAF3FF] focus:outline-none focus:ring-2 focus:ring-[#34699A]/30"
           aria-label="Kembali">
            <img src="{{ asset('assets/icons/icon-back.png') }}"
                 class="w-[28px] h-[28px] object-contain"
                 alt="Kembali">
        </a>

        <div>
            <h1 class="text-[22px] sm:text-[24px] font-bold leading-[32px]">
                Detail Transaksi
            </h1>

            <p class="text-[13px] text-[#6B7280] mt-[3px]">
                Informasi lengkap transaksi, dokumentasi, pembayaran, dan proses sewa.
            </p>
        </div>
    </div>

    {{-- pesan error --}}
    {{-- pesan error dari session --}}
    @if(session('error'))
        <div class="mb-[18px] bg-[#FFECEF] border border-[#F4B8C2] text-[#E3455D] px-[14px] py-[12px] rounded-[8px] text-[13px] font-semibold">
            {{ session('error') }}
        </div>
    @endif

    {{-- popup sukses --}}
    {{-- popup sukses --}}
    @if(session('success') || session('success_title') || session('success_message'))
        <div id="successModal"
             class="fixed inset-0 bg-black/40 flex items-center justify-center z-[9999] px-[20px]">
            <div class="bg-white border border-[#BFD8F4] rounded-[12px] w-full max-w-[320px] px-[24px] py-[30px] text-center shadow-[0px_8px_24px_rgba(0,0,0,0.18)]">

                <div class="w-[64px] h-[64px] rounded-full bg-[#34699A] mx-auto mb-[20px] flex items-center justify-center">
                    <span class="text-white text-[34px] font-bold leading-none">✓</span>
                </div>

                <h3 class="text-[15px] font-bold text-[#34699A] mb-[8px]">
                    {{ session('success_title', 'Berhasil!') }}
                </h3>

                <p class="text-[12px] text-[#696969] leading-[20px] mb-[22px]">
                    {{ session('success_message', session('success')) }}
                </p>

                <button type="button"
                        onclick="document.getElementById('successModal').remove()"
                        class="h-[32px] px-[22px] rounded-[6px] bg-[#34699A] text-white hover:bg-[#28527A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold">
                    Selesai
                </button>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-[1fr_0.78fr] gap-[18px]">

        {{-- kolom kiri --}}
        <section class="space-y-[18px]">

            {{-- ringkasan transaksi --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <div class="flex items-start justify-between gap-[12px] mb-[14px]">
                    <div>
                        <h2 class="text-[16px] font-bold">
                            Ringkasan Transaksi
                        </h2>

                        <p class="text-[12px] text-[#6B7280] mt-[4px]">
                            ID Transaksi: {{ $rental->rental_code }}
                        </p>
                    </div>

                    <span class="h-[26px] px-[12px] rounded-full text-[11px] font-semibold inline-flex items-center shrink-0 {{ badgeClassDetailView($status) }}">
                        {{ labelStatusDetailView($status) }}
                    </span>
                </div>

                <div class="border border-[#D7E5FA] rounded-[9px] px-[12px] py-[12px] flex gap-[12px] bg-[#F8FBFF]">
                    <img src="{{ $imageUrl }}"
                         class="w-[78px] h-[78px] rounded-[8px] object-cover shrink-0"
                         alt="{{ optional($item)->name ?? 'Item Image' }}">

                    <div class="min-w-0 flex-1">
                        <h3 class="text-[14px] sm:text-[15px] font-bold leading-[21px] line-clamp-2">
                            {{ optional($item)->name ?? '-' }}
                        </h3>

                        <div class="flex flex-wrap items-center gap-[6px] mt-[7px]">
                            <span class="text-[10px] text-[#8A8A8A] border border-[#D7DCE3] rounded-[4px] px-[6px] py-[2px]">
                                Jumlah: 1 Buah
                            </span>

                            <span class="text-[10px] text-[#8A8A8A] border border-[#D7DCE3] rounded-[4px] px-[6px] py-[2px]">
                                {{ $deliveryMethodLabel }}
                            </span>
                        </div>

                        <p class="text-[11px] text-[#6B7280] mt-[7px] inline-flex items-center gap-[4px]">
                            <img src="{{ asset('assets/icons/icon-calendar.png') }}"
                                 class="w-[12px] h-[12px] object-contain"
                                 alt="Tanggal">

                            {{ $startDate }} - {{ $endDate }} • {{ $durasi }} hari
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-[12px] mt-[16px] text-[13px]">
                    <div class="border border-[#D7E5FA] rounded-[8px] px-[12px] py-[10px]">
                        <p class="text-[#6B7280] mb-[5px]">
                            Pemilik / Toko
                        </p>

                        <div class="flex items-center gap-[8px]">
                            <img src="{{ $storeImageUrl }}"
                                 class="w-[24px] h-[24px] rounded-full object-cover border border-[#D7E5FA]"
                                 alt="{{ $storeName }}">

                            <p class="font-bold truncate">
                                {{ $storeName }}
                            </p>
                        </div>
                    </div>

                    <div class="border border-[#D7E5FA] rounded-[8px] px-[12px] py-[10px]">
                        <p class="text-[#6B7280] mb-[5px]">
                            Penyewa
                        </p>

                        <p class="font-bold">
                            {{ optional($tenant)->name ?? '-' }}
                        </p>
                    </div>
                </div>
            </section>

            {{-- alur transaksi --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[16px]">
                    Timeline Transaksi
                </h2>

                <div class="space-y-[14px]">
                    @foreach($timelineSteps as $index => $step)
                        @php
                            $isActive = isTimelineActiveDetailView($step['key'], $status, $extension, $claim);
                            $isLast = $loop->last;
                        @endphp

                        <div class="flex gap-[12px]">
                            <div class="flex flex-col items-center">
                                <div class="w-[28px] h-[28px] rounded-full flex items-center justify-center text-[12px] font-bold
                                    {{ $isActive ? 'bg-[#34699A] text-white' : 'bg-[#E5E7EB] text-[#9CA3AF]' }}">
                                    {{ $isActive ? '✓' : $index + 1 }}
                                </div>

                                @unless($isLast)
                                    <div class="w-[2px] h-[34px] {{ $isActive ? 'bg-[#34699A]' : 'bg-[#E5E7EB]' }}"></div>
                                @endunless
                            </div>

                            <div class="pb-[8px]">
                                <p class="text-[13px] font-bold {{ $isActive ? 'text-[#1E1E1E]' : 'text-[#9CA3AF]' }}">
                                    {{ $step['label'] }}
                                </p>

                                <p class="text-[12px] leading-[19px] mt-[3px] {{ $isActive ? 'text-[#6B7280]' : 'text-[#9CA3AF]' }}">
                                    {{ $step['description'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($status === 'dibatalkan')
                    <div class="mt-[16px] bg-[#FFECEF] border border-[#F4B8C2] rounded-[8px] px-[14px] py-[12px]">
                        <p class="text-[12px] text-[#E3455D] font-semibold leading-[20px]">
                            Transaksi ini dibatalkan. Pembatalan hanya dilakukan saat pesanan belum dibayar.
                        </p>
                    </div>
                @endif
            </section>

            {{-- info perpanjangan --}}
            @if($hasExtension)
                <section class="bg-[#E8F8EF] border border-[#B7E8C8] rounded-[10px] px-[16px] sm:px-[22px] py-[18px]">
                    <div class="flex items-start gap-[12px]">
                        <div class="w-[44px] h-[44px] rounded-full bg-[#28A85B] text-white flex items-center justify-center shrink-0">
                            <span class="text-[25px] font-bold leading-none">✓</span>
                        </div>

                        <div class="flex-1">
                            <h2 class="text-[16px] font-bold text-[#118642]">
                                Perpanjangan Sewa Berhasil
                            </h2>

                            <p class="text-[13px] text-[#118642] leading-[21px] mt-[5px]">
                                Tanggal pengembalian berubah dari {{ $extensionOldDate }} menjadi {{ $extensionNewDate }}.
                            </p>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-[10px] mt-[14px]">
                                <div class="bg-white/70 rounded-[8px] px-[12px] py-[10px]">
                                    <p class="text-[11px] text-[#6B7280]">Durasi Tambahan</p>
                                    <p class="text-[13px] font-bold">{{ optional($extension)->extra_days ?? 0 }} hari</p>
                                </div>

                                <div class="bg-white/70 rounded-[8px] px-[12px] py-[10px]">
                                    <p class="text-[11px] text-[#6B7280]">Total Perpanjangan</p>
                                    <p class="text-[13px] font-bold">Rp{{ number_format($extensionPrice, 0, ',', '.') }}</p>
                                </div>

                                <div class="bg-white/70 rounded-[8px] px-[12px] py-[10px]">
                                    <p class="text-[11px] text-[#6B7280]">Pembayaran</p>
                                    <p class="text-[13px] font-bold">
                                        {{ optional($extension)->payment_type === 'paylater' ? 'PayLater' : strtoupper(optional($extension)->payment_method ?? 'QRIS') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            {{-- dokumentasi transaksi --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[5px]">
                    Dokumentasi
                </h2>

                <p class="text-[12px] text-[#6B7280] mb-[16px]">
                    Dokumentasi digunakan sebagai bukti kondisi barang selama proses transaksi.
                </p>

                <div class="space-y-[18px]">
                    @php
                        $hasAnyDocument = false;
                    @endphp

                    @foreach($documentGroups as $processKey => $group)
                        @php
                            $groupDocuments = $documents->where('process', $processKey)->values();
                            $previewDocuments = $groupDocuments->take(3);
                            $hasMore = $groupDocuments->count() > 3;

                            if ($groupDocuments->count() > 0) {
                                $hasAnyDocument = true;
                            }
                        @endphp

                        @if($groupDocuments->count() > 0)
                            <div class="border-t border-[#D7E5FA] pt-[16px] first:border-t-0 first:pt-0">
                                <div class="flex items-start justify-between gap-[12px] mb-[10px]">
                                    <div>
                                        <h3 class="text-[14px] font-bold">
                                            {{ $group['title'] }}
                                        </h3>

                                        <p class="text-[12px] text-[#6B7280] mt-[3px]">
                                            {{ $group['description'] }}
                                        </p>
                                    </div>

                                    @if($hasMore)
                                        <button type="button"
                                                onclick="openDocumentModal('{{ $processKey }}')"
                                                class="text-[12px] text-[#34699A] hover:text-[#28527A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition font-semibold underline shrink-0">
                                            Lihat Semua
                                        </button>
                                    @endif
                                </div>

                                <div class="grid grid-cols-3 gap-[8px]">
                                    @foreach($previewDocuments as $document)
                                        @php
                                            $documentPath = documentPathDetailView($document);
                                        @endphp

                                        <button type="button"
                                                onclick="openImagePreview('{{ formatDokumenUrlDetailView($documentPath) }}')"
                                                class="h-[88px] sm:h-[110px] rounded-[8px] overflow-hidden border border-[#D7E5FA] bg-[#F8FBFF] hover:border-[#34699A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition">
                                            <img src="{{ formatDokumenUrlDetailView($documentPath) }}"
                                                 class="w-full h-full object-cover"
                                                 alt="Dokumentasi">
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @if(!$hasAnyDocument)
                        <div class="bg-[#F8FBFF] border border-[#D7E5FA] rounded-[8px] px-[14px] py-[18px] text-center">
                            <p class="text-[12px] text-[#6B7280]">
                                Belum ada dokumentasi yang tersedia.
                            </p>
                        </div>
                    @endif
                </div>
            </section>

            {{-- klaim kerusakan --}}
            @if($claim || $status === 'kerusakan')
                <section class="bg-white border border-[#FFD6DE] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                    <div class="flex items-start justify-between gap-[12px] mb-[14px]">
                        <div>
                            <h2 class="text-[16px] font-bold text-[#E3455D]">
                                Informasi Klaim Kerusakan
                            </h2>

                            <p class="text-[12px] text-[#6B7280] mt-[4px]">
                                Detail klaim kerusakan yang diajukan pemilik.
                            </p>
                        </div>

                        <span class="h-[26px] px-[12px] rounded-full text-[11px] font-semibold bg-[#FFD6DE] text-[#E3455D]">
                            Kerusakan
                        </span>
                    </div>

                    <div class="space-y-[11px] text-[13px]">
                        <div class="flex justify-between gap-[12px]">
                            <span class="text-[#6B7280]">Jenis Kerusakan</span>
                            <span class="font-semibold text-right">{{ optional($claim)->damage_type ?? '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-[12px]">
                            <span class="text-[#6B7280]">Bagian Rusak</span>
                            <span class="font-semibold text-right">{{ optional($claim)->damage_part ?? '-' }}</span>
                        </div>

                        <div class="flex justify-between gap-[12px]">
                            <span class="text-[#6B7280]">Biaya Kerusakan</span>
                            <span class="font-semibold text-[#E3455D]">
                                Rp{{ number_format($damageFee, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-[12px]">
                            <span class="text-[#6B7280]">Status Klaim</span>
                            <span class="font-semibold text-right">
                                {{ ucfirst(str_replace('_', ' ', optional($claim)->status ?? 'submitted')) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-[14px] bg-[#FFECEF] rounded-[8px] px-[14px] py-[12px]">
                        <p class="text-[12px] text-[#E3455D] font-semibold leading-[20px]">
                            {{ optional($claim)->description ?? $rental->damage_description ?? 'Belum ada deskripsi klaim.' }}
                        </p>
                    </div>

                    @if($pendingAdditionalPayment && $isTenant)
                        <a href="{{ route('transaksi.formPembayaranTagihanTambahan', $rental->id) }}"
                           class="mt-[14px] w-full h-[40px] rounded-[8px] bg-[#34699A] text-white hover:bg-[#28527A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[13px] font-semibold flex items-center justify-center">
                            Bayar Tagihan Tambahan
                        </a>
                    @else
                        <a href="{{ route('transaksi.lihatKlaim', $rental->id) }}"
                           class="mt-[14px] w-full h-[40px] rounded-[8px] border border-[#34699A] text-[#34699A] hover:bg-[#EAF3FF] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[13px] font-semibold flex items-center justify-center">
                            Lihat Klaim
                        </a>
                    @endif
                </section>
            @endif
        </section>

        {{-- kolom kanan --}}
        <aside class="space-y-[18px]">

            {{-- detail pembayaran --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[14px]">
                    Rincian Pembayaran
                </h2>

                <div class="space-y-[11px] text-[13px]">
                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">Metode Pembayaran</span>
                        <span class="font-semibold text-right">{{ $paymentLabel }}</span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">Status Pembayaran</span>
                        <span class="font-semibold text-right">{{ paymentStatusLabelDetailView($paymentStatus) }}</span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">Harga Sewa</span>
                        <span class="font-semibold text-right">Rp{{ number_format($hargaSewa, 0, ',', '.') }}/hari</span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">Durasi Sewa</span>
                        <span class="font-semibold text-right">{{ $durasi }} hari</span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">Deposit</span>
                        <span class="font-semibold text-right">Rp{{ number_format($deposit, 0, ',', '.') }}</span>
                    </div>

                    @if($hasExtension)
                        <div class="flex justify-between gap-[12px]">
                            <span class="text-[#6B7280]">Biaya Perpanjangan</span>
                            <span class="font-semibold text-right">Rp{{ number_format($extensionPrice, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">Denda Keterlambatan</span>
                        <span class="font-semibold text-right">Rp{{ number_format($dendaPerHari, 0, ',', '.') }}/hari</span>
                    </div>

                    @if($isPaylater)
                        <div class="border-t border-[#D7E5FA] pt-[11px] space-y-[11px]">
                            <div class="flex justify-between gap-[12px]">
                                <span class="text-[#6B7280]">Cicilan</span>
                                <span class="font-semibold">
                                    {{ optional($payment)->installment_paid ?? 0 }}/{{ optional($payment)->installment_plan ?? '-' }} cicilan
                                </span>
                            </div>

                            <div class="flex justify-between gap-[12px]">
                                <span class="text-[#6B7280]">Tempo Berikutnya</span>
                                <span class="font-semibold text-[#D38A00]">{{ $nextDueDate }}</span>
                            </div>

                            <a href="{{ route('profile.cicilan.index') }}"
                               class="w-full h-[38px] rounded-[8px] border border-[#34699A] text-[#34699A] hover:bg-[#EAF3FF] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold inline-flex items-center justify-center mt-[6px]">
                                Lihat / Bayar Cicilan
                            </a>
                        </div>
                    @endif

                    <div class="border-t border-[#D7E5FA] pt-[11px] flex justify-between gap-[12px]">
                        <span class="font-bold">Total Pesanan</span>
                        <span class="font-bold text-[#34699A]">Rp{{ number_format($totalPesanan, 0, ',', '.') }}</span>
                    </div>
                </div>
            </section>

            {{-- info pengiriman --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[14px]">
                    Info Pengiriman
                </h2>

                <div class="space-y-[11px] text-[13px]">
                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">Metode</span>
                        <span class="font-semibold text-right">{{ $deliveryMethodLabel }}</span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">Ekspedisi</span>
                        <span class="font-semibold text-right">{{ $expedition }}</span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">No. Resi</span>
                        <span class="font-semibold text-right">{{ $trackingNumber }}</span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">Alamat</span>
                        <span class="font-semibold text-right max-w-[220px] leading-[20px]">{{ $shippingAddress }}</span>
                    </div>
                </div>
            </section>

            {{-- jadwal sewa --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[14px]">
                    Jadwal Sewa
                </h2>

                <div class="grid grid-cols-2 border border-[#C3CAD5] rounded-[8px] overflow-hidden">
                    <div class="px-[14px] py-[12px] border-r border-[#C3CAD5] bg-[#F8FAFC]">
                        <p class="text-[11px] text-[#6B7280] uppercase tracking-[0.03em]">Mulai</p>
                        <p class="text-[13px] font-semibold mt-[5px]">{{ $startDate }}</p>
                    </div>

                    <div class="px-[14px] py-[12px] bg-[#F8FAFC]">
                        <p class="text-[11px] text-[#6B7280] uppercase tracking-[0.03em]">Selesai</p>
                        <p class="text-[13px] font-semibold mt-[5px]">{{ $endDate }}</p>
                    </div>
                </div>

                <div class="mt-[14px] bg-[#EAF3FF] text-[#34699A] rounded-[8px] px-[14px] py-[12px] flex items-start gap-[10px]">
                    <img src="{{ asset('assets/icons/icon-info-blue.png') }}"
                         class="w-[18px] h-[18px] object-contain mt-[2px]"
                         alt="Info">

                    <p class="text-[12px] font-semibold leading-[20px]">
                        Untuk melacak pesanan, janjian COD, atau menanyakan posisi paket, gunakan fitur chat.
                    </p>
                </div>
            </section>

            {{-- informasi pembatalan --}}
            @if($status === 'dibatalkan')
                <section class="bg-white border border-[#F4B8C2] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                    <div class="flex items-start gap-[10px]">
                        <img src="{{ asset('assets/icons/icon-warning-red.png') }}"
                             class="w-[22px] h-[22px] object-contain mt-[2px]"
                             alt="Pembatalan">

                        <div>
                            <h2 class="text-[16px] font-bold text-[#E3455D]">
                                Transaksi Dibatalkan
                            </h2>

                            <p class="text-[13px] text-[#E3455D] leading-[22px] mt-[6px]">
                                Transaksi ini dibatalkan sebelum pembayaran dilakukan.
                            </p>
                        </div>
                    </div>

                    <div class="mt-[16px] bg-[#FFF8FA] rounded-[8px] px-[14px] py-[14px] space-y-[10px]">
                        <div class="flex justify-between gap-[16px]">
                            <span class="text-[13px] text-[#6B7280]">Alasan Pembatalan</span>
                            <span class="text-[13px] font-semibold text-[#1E1E1E] text-right">
                                {{ optional($cancellation)->reason ?? '-' }}
                            </span>
                        </div>

                        @if(optional($cancellation)->note)
                            <div class="flex justify-between gap-[16px]">
                                <span class="text-[13px] text-[#6B7280]">Catatan</span>
                                <span class="text-[13px] font-semibold text-[#1E1E1E] text-right">
                                    {{ optional($cancellation)->note }}
                                </span>
                            </div>
                        @endif

                        <div class="flex justify-between gap-[16px]">
                            <span class="text-[13px] text-[#6B7280]">Refund</span>
                            <span class="text-[13px] font-bold text-[#34699A] text-right">
                                Rp{{ number_format(optional($cancellation)->refund_amount ?? 0, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between gap-[16px]">
                            <span class="text-[13px] text-[#6B7280]">Status Refund</span>
                            <span class="text-[13px] font-semibold text-[#E3455D] text-right">
                                {{ ucfirst(str_replace('_', ' ', optional($cancellation)->refund_status ?? 'tidak_ada_refund')) }}
                            </span>
                        </div>
                    </div>
                </section>
            @endif

            {{-- bantuan dan tombol aksi --}}
            <section class="bg-[#EAF3FF] border border-[#C3DAFE] rounded-[10px] px-[16px] sm:px-[22px] py-[18px]">
                <h2 class="text-[16px] font-bold text-[#34699A]">
                    Butuh Bantuan?
                </h2>

                <p class="text-[12px] text-[#34699A] leading-[20px] mt-[5px]">
                    Gunakan tombol di bawah untuk melanjutkan proses transaksi atau membuka chat.
                </p>

                <div class="mt-[14px] flex flex-col gap-[8px]">

                    @if($isTenant && $status === 'menunggu_pembayaran')
                        <a href="{{ route('checkout.index', $rental->id) }}"
                           class="w-full h-[38px] rounded-[8px] bg-[#34699A] text-white hover:bg-[#28527A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold flex items-center justify-center">
                            Bayar Sekarang
                        </a>

                        <a href="{{ route('transaksi.formBatalkanPesanan', $rental->id) }}"
                           class="w-full h-[38px] rounded-[8px] bg-white border border-[#E3455D] text-[#E3455D] hover:bg-[#FFECEF] focus:outline-none focus:ring-2 focus:ring-[#F4B8C2] focus:ring-offset-2 transition text-[12px] font-semibold flex items-center justify-center">
                            Batalkan Pesanan
                        </a>
                    @endif

                    @if($isTenant && in_array($status, ['diproses', 'pesanan_masuk', 'dikirim', 'menunggu_penerimaan']))
                        <a href="{{ route('transaksi.formKonfirmasiPenerimaan', $rental->id) }}"
                           class="w-full h-[38px] rounded-[8px] bg-[#34699A] text-white hover:bg-[#28527A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold flex items-center justify-center">
                            Konfirmasi Penerimaan
                        </a>
                    @endif

                    @if($isTenant && $status === 'disewa')
                        <a href="{{ route('transaksi.formPerpanjanganSewa', $rental->id) }}"
                           class="w-full h-[38px] rounded-[8px] bg-[#34699A] text-white hover:bg-[#28527A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold flex items-center justify-center">
                            Perpanjang Sewa
                        </a>

                        <a href="{{ route('transaksi.formPesananDikembalikan', $rental->id) }}"
                           class="w-full h-[38px] rounded-[8px] bg-white border border-[#34699A] text-[#34699A] hover:bg-[#EAF3FF] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold flex items-center justify-center">
                            Pesanan Dikembalikan
                        </a>
                    @endif

                    @if($isTenant && $status === 'belum_dikembalikan')
                        <a href="{{ route('transaksi.formPesananDikembalikan', $rental->id) }}"
                           class="w-full h-[38px] rounded-[8px] bg-[#34699A] text-white hover:bg-[#28527A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold flex items-center justify-center">
                            Pesanan Dikembalikan
                        </a>
                    @endif

                    @if($isTenant && $status === 'selesai')
                        @if(!$sudahAdaUlasan)
                            <a href="{{ route('ulasan.create', $rental->id) }}"
                               class="w-full h-[38px] rounded-[8px] bg-[#34699A] text-white hover:bg-[#28527A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold flex items-center justify-center">
                                Nilai
                            </a>
                        @endif

                        <a href=href="{{ $item ? route('items.show', ['item' => $item->id, 'from' => 'riwayat-transaksi']) : route('items.index') }}"
                           class="w-full h-[38px] rounded-[8px] bg-white border border-[#34699A] text-[#34699A] hover:bg-[#EAF3FF] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold flex items-center justify-center">
                            Sewa Kembali
                        </a>
                    @endif

                    @if($isOwner && in_array($status, ['diproses', 'pesanan_masuk']))
                        @if($deliveryMethod === 'cod')
                            <a href="{{ route('transaksi.formKonfirmasiPenyerahan', $rental->id) }}"
                               class="w-full h-[38px] rounded-[8px] bg-[#34699A] text-white hover:bg-[#28527A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold flex items-center justify-center">
                                Konfirmasi Penyerahan
                            </a>
                        @else
                            <a href="{{ route('transaksi.formKonfirmasiPengiriman', $rental->id) }}"
                               class="w-full h-[38px] rounded-[8px] bg-[#34699A] text-white hover:bg-[#28527A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold flex items-center justify-center">
                                Konfirmasi Pengiriman
                            </a>
                        @endif
                    @endif

                    @if($isOwner && $status === 'pengembalian')
                        <a href="{{ route('transaksi.formKonfirmasiPengembalian', $rental->id) }}"
                           class="w-full h-[38px] rounded-[8px] bg-[#34699A] text-white hover:bg-[#28527A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold flex items-center justify-center">
                            Konfirmasi Pengembalian
                        </a>

                        <a href="{{ route('transaksi.formPengajuanKerusakan', $rental->id) }}"
                           class="w-full h-[38px] rounded-[8px] bg-white border border-[#E3455D] text-[#E3455D] hover:bg-[#FFECEF] focus:outline-none focus:ring-2 focus:ring-[#F4B8C2] focus:ring-offset-2 transition text-[12px] font-semibold flex items-center justify-center">
                            Ajukan Kerusakan
                        </a>
                    @endif

                    @if(in_array($status, ['kerusakan']))
                        <a href="{{ route('transaksi.lihatKlaim', $rental->id) }}"
                           class="w-full h-[38px] rounded-[8px] bg-[#34699A] text-white hover:bg-[#28527A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold flex items-center justify-center">
                            Lihat Klaim
                        </a>
                    @endif

                    @if($isOwner || $isTenant)
                        <a href="{{ route('chat.start.rental', $rental->id) }}"
                           class="w-full h-[38px] rounded-[8px] bg-white border border-[#34699A] text-[#34699A] hover:bg-[#EAF3FF] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold flex items-center justify-center">
                            {{ $isOwner ? 'Chat dengan Penyewa' : 'Chat dengan Pemilik' }}
                        </a>
                    @endif
                </div>
            </section>
        </aside>
    </div>
</main>

{{-- popup pratinjau gambar --}}
<div id="imagePreviewModal"
     class="fixed inset-0 hidden items-center justify-center bg-black/60 z-[9999] px-[20px]">
    <div class="bg-white border border-[#BFD8F4] rounded-[12px] w-full max-w-[720px] p-[12px] shadow-[0px_8px_24px_rgba(0,0,0,0.18)]">
        <div class="flex justify-end mb-[8px]">
            <button type="button"
                    onclick="closeImagePreview()"
                    class="w-[32px] h-[32px] rounded-full bg-[#EAF3FF] text-[#34699A] hover:bg-[#D7E5FA] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] transition font-bold">
                ×
            </button>
        </div>

        <img id="imagePreviewTarget"
             src=""
             class="w-full max-h-[75vh] object-contain rounded-[8px]"
             alt="Preview Dokumentasi">
    </div>
</div>

{{-- popup semua dokumentasi --}}
@foreach($documentGroups as $processKey => $group)
    @php
        $groupDocuments = $documents->where('process', $processKey)->values();
    @endphp

    @if($groupDocuments->count() > 3)
        <div id="documentModal-{{ $processKey }}"
             class="fixed inset-0 hidden items-center justify-center bg-black/60 z-[9998] px-[20px]">
            <div class="bg-white border border-[#BFD8F4] rounded-[12px] w-full max-w-[760px] p-[18px] shadow-[0px_8px_24px_rgba(0,0,0,0.18)]">
                <div class="flex items-start justify-between gap-[14px] mb-[14px]">
                    <div>
                        <h3 class="text-[16px] font-bold">
                            {{ $group['title'] }}
                        </h3>

                        <p class="text-[12px] text-[#6B7280] mt-[4px]">
                            {{ $group['description'] }}
                        </p>
                    </div>

                    <button type="button"
                            onclick="closeDocumentModal('{{ $processKey }}')"
                            class="w-[32px] h-[32px] rounded-full bg-[#EAF3FF] text-[#34699A] hover:bg-[#D7E5FA] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] transition font-bold shrink-0">
                        ×
                    </button>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-[10px] max-h-[70vh] overflow-y-auto">
                    @foreach($groupDocuments as $document)
                        @php
                            $documentPath = documentPathDetailView($document);
                        @endphp

                        <button type="button"
                                onclick="openImagePreview('{{ formatDokumenUrlDetailView($documentPath) }}')"
                                class="h-[120px] rounded-[8px] overflow-hidden border border-[#D7E5FA] bg-[#F8FBFF] hover:border-[#34699A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition">
                            <img src="{{ formatDokumenUrlDetailView($documentPath) }}"
                                 class="w-full h-full object-cover"
                                 alt="Dokumentasi">
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endforeach

{{-- footer --}}
@include('layouts.partials.footer')

<script>
    // script interaksi halaman
    // buka popup pratinjau gambar dokumentasi
    function openImagePreview(url) {
        const modal = document.getElementById('imagePreviewModal');
        const image = document.getElementById('imagePreviewTarget');

        if (!modal || !image) {
            return;
        }

        image.src = url;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    // tutup popup pratinjau gambar dokumentasi
    function closeImagePreview() {
        const modal = document.getElementById('imagePreviewModal');
        const image = document.getElementById('imagePreviewTarget');

        if (!modal || !image) {
            return;
        }

        image.src = '';
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // buka popup daftar dokumentasi berdasarkan proses
    function openDocumentModal(processKey) {
        const modal = document.getElementById('documentModal-' + processKey);

        if (!modal) {
            return;
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    // tutup popup daftar dokumentasi berdasarkan proses
    function closeDocumentModal(processKey) {
        const modal = document.getElementById('documentModal-' + processKey);

        if (!modal) {
            return;
        }

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.addEventListener('keydown', function (event) {
        if (event.key !== 'Escape') {
            return;
        }

        closeImagePreview();

        document.querySelectorAll('[id^="documentModal-"]').forEach(function (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });
    });
</script>

</body>
</html>