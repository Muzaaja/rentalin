<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpanjangan Berhasil</title>
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
    $extension = $rental->latestExtension;

    $startDate = $rental->start_date
        ? Carbon::parse($rental->start_date)->format('d M Y')
        : '-';

    $oldEndDate = optional($extension)->old_end_date
        ? Carbon::parse($extension->old_end_date)->format('d M Y')
        : '-';

    $newEndDate = optional($extension)->new_end_date
        ? Carbon::parse($extension->new_end_date)->format('d M Y')
        : ($rental->end_date ? Carbon::parse($rental->end_date)->format('d M Y') : '-');

    $extraDays = optional($extension)->extra_days ?? 0;
    $extensionPrice = optional($extension)->extension_price ?? 0;

    $paymentType = optional($extension)->payment_type;
    $paymentMethod = optional($extension)->payment_method;
    $paymentStatus = optional($extension)->payment_status;

    $isPaylater = $paymentType === 'paylater';

    $nextDueDate = optional($extension)->next_due_date
        ? Carbon::parse($extension->next_due_date)->format('d M Y')
        : '-';

    /*
        Kode gambar dari teman kamu, tapi disesuaikan:
        - Kalau image array, ambil gambar pertama.
        - Kalau image string dummy, ambil dari assets/products.
        - Kalau image upload storage, ambil dari storage.
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
@endphp

<main class="w-full max-w-[435px] sm:max-w-[940px] lg:max-w-[1220px] mx-auto px-[20px] sm:px-[44px] lg:px-[66px] pt-[28px] pb-[70px]">

    {{-- Header --}}
    <div class="flex items-center gap-[12px] mb-[24px]">
        <a href="{{ route('riwayat.transaksi.penyewa') }}"
           class="w-[34px] h-[34px] flex items-center justify-center shrink-0">
            <img src="{{ asset('assets/icons/icon-back.png') }}"
                 class="w-[28px] h-[28px] object-contain"
                 alt="Kembali">
        </a>

        <div>
            <h1 class="text-[22px] sm:text-[24px] font-bold leading-[32px]">
                Perpanjangan Sewa
            </h1>

            <p class="text-[13px] text-[#6B7280] mt-[3px]">
                Perpanjangan sewa berhasil diproses.
            </p>
        </div>
    </div>

    {{-- Stepper --}}
    <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[24px] py-[18px] mb-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
        <div class="grid grid-cols-3 items-start gap-[10px]">
            <div class="text-center">
                <div class="w-[30px] h-[30px] mx-auto rounded-full bg-[#CFF3D9] text-[#348B55] flex items-center justify-center text-[13px] font-bold">
                    ✓
                </div>
                <p class="text-[11px] text-[#348B55] font-semibold mt-[7px]">
                    Pilih Tanggal
                </p>
            </div>

            <div class="text-center relative">
                <div class="hidden sm:block absolute top-[15px] left-[-45%] w-[90%] h-[1px] bg-[#34699A]"></div>
                <div class="w-[30px] h-[30px] mx-auto rounded-full bg-[#CFF3D9] text-[#348B55] flex items-center justify-center text-[13px] font-bold">
                    ✓
                </div>
                <p class="text-[11px] text-[#348B55] font-semibold mt-[7px]">
                    Pembayaran
                </p>
            </div>

            <div class="text-center relative">
                <div class="hidden sm:block absolute top-[15px] left-[-45%] w-[90%] h-[1px] bg-[#34699A]"></div>
                <div class="w-[30px] h-[30px] mx-auto rounded-full bg-[#34699A] text-white flex items-center justify-center text-[13px] font-bold">
                    3
                </div>
                <p class="text-[11px] text-[#34699A] font-semibold mt-[7px]">
                    Selesai
                </p>
            </div>
        </div>
    </section>

    {{-- Success message --}}
    <section class="bg-[#E8F8EF] border border-[#B7E8C8] rounded-[10px] px-[16px] sm:px-[24px] py-[18px] mb-[18px] flex items-start gap-[14px]">
        <img src="{{ asset('assets/icons/icon-success-green.png') }}"
             class="w-[44px] h-[44px] object-contain shrink-0"
             alt="Berhasil">

        <div>
            <h2 class="text-[18px] font-bold text-[#118642]">
                Perpanjangan Sewa Berhasil!
            </h2>

            <p class="text-[13px] text-[#1E1E1E] leading-[22px] mt-[5px]">
                Sewa Anda telah diperpanjang. Tanggal selesai sewa dan ketersediaan barang telah diperbarui otomatis.
            </p>

            <div class="mt-[9px] flex flex-wrap items-center gap-[8px]">
                <span class="text-[10px] text-[#348B55] bg-[#D7F6E3] rounded-[4px] px-[7px] py-[3px]">
                    ID Transaksi
                </span>

                <span class="text-[12px] font-bold">
                    {{ $rental->rental_code }}
                </span>
            </div>
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_0.9fr] gap-[18px]">

        {{-- Ringkasan Barang --}}
        <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
            <h2 class="text-[16px] font-bold mb-[14px]">
                Ringkasan Barang
            </h2>

            <div class="border border-[#D7E5FA] rounded-[9px] px-[12px] py-[12px] flex gap-[12px] bg-[#F8FBFF] mb-[16px]">
                <img src="{{ $imageUrl }}"
                     class="w-[78px] h-[78px] rounded-[8px] object-cover shrink-0"
                     alt="{{ optional($item)->name ?? 'Item Image' }}">

                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between gap-[10px]">
                        <h3 class="text-[14px] sm:text-[15px] font-bold leading-[21px] line-clamp-2">
                            {{ optional($item)->name ?? '-' }}
                        </h3>

                        <span class="h-[24px] px-[10px] rounded-full text-[10px] font-semibold bg-[#DDEBFF] text-[#34699A] shrink-0">
                            Disewa
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center gap-[6px] mt-[7px]">
                        <span class="text-[10px] text-[#8A8A8A] border border-[#D7DCE3] rounded-[4px] px-[6px] py-[2px]">
                            Jumlah: 1 Buah
                        </span>

                        <span class="text-[10px] text-[#8A8A8A] border border-[#D7DCE3] rounded-[4px] px-[6px] py-[2px]">
                            Sewa dari {{ optional($owner)->name ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="space-y-[10px] text-[13px]">
                <div class="flex justify-between gap-[12px]">
                    <span class="text-[#6B7280]">
                        Tanggal mulai sewa
                    </span>

                    <span class="font-semibold">
                        {{ $startDate }}
                    </span>
                </div>

                <div class="flex justify-between gap-[12px]">
                    <span class="text-[#6B7280]">
                        Tanggal selesai sebelumnya
                    </span>

                    <span class="font-semibold">
                        {{ $oldEndDate }}
                    </span>
                </div>

                <div class="flex justify-between gap-[12px]">
                    <span class="text-[#6B7280]">
                        Tanggal selesai baru
                    </span>

                    <span class="font-semibold text-[#348B55]">
                        {{ $newEndDate }}
                    </span>
                </div>

                <div class="flex justify-between gap-[12px]">
                    <span class="text-[#6B7280]">
                        Durasi tambahan
                    </span>

                    <span class="font-semibold">
                        {{ $extraDays }} hari
                    </span>
                </div>
            </div>

            <div class="mt-[16px] bg-[#E8F8EF] rounded-[8px] px-[14px] py-[12px] flex items-start gap-[10px]">
                <img src="{{ asset('assets/icons/icon-calendar-green.png') }}"
                     class="w-[22px] h-[22px] object-contain"
                     alt="Perpanjangan">

                <div>
                    <p class="text-[13px] font-bold text-[#118642]">
                        Perpanjangan Aktif
                    </p>

                    <p class="text-[12px] text-[#118642] mt-[4px]">
                        Masa sewa diperbarui sampai {{ $newEndDate }}.
                    </p>
                </div>
            </div>
        </section>

        {{-- Detail Pembayaran --}}
        <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
            <h2 class="text-[16px] font-bold mb-[14px]">
                Detail Pembayaran
            </h2>

            <div class="space-y-[11px] text-[13px]">
                <div class="flex justify-between gap-[12px]">
                    <span class="text-[#6B7280]">
                        Metode Pembayaran
                    </span>

                    <span class="font-semibold text-right">
                        {{ $isPaylater ? 'PayLater' : 'QRIS / Bayar Penuh' }}
                    </span>
                </div>

                <div class="flex justify-between gap-[12px]">
                    <span class="text-[#6B7280]">
                        Status Pembayaran
                    </span>

                    <span class="font-semibold text-right">
                        @if($paymentStatus === 'paid')
                            Lunas
                        @elseif($paymentStatus === 'paylater_aktif')
                            PayLater Aktif
                        @else
                            {{ $paymentStatus ?? '-' }}
                        @endif
                    </span>
                </div>

                @if($isPaylater)
                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Cicilan
                        </span>

                        <span class="font-semibold">
                            {{ optional($extension)->installment_paid ?? 0 }}/{{ optional($extension)->installment_plan ?? '-' }} cicilan
                        </span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Tempo Berikutnya
                        </span>

                        <span class="font-semibold text-[#D38A00]">
                            {{ $nextDueDate }}
                        </span>
                    </div>

                    <a href="{{ route('profile.edit') }}#cicilan"
                       class="w-full h-[38px] rounded-[8px] border border-[#34699A] text-[#34699A] text-[12px] font-semibold inline-flex items-center justify-center mt-[6px]">
                        Lihat Detail Cicilan
                    </a>
                @endif

                <div class="border-t border-[#D7E5FA] pt-[11px] flex justify-between gap-[12px]">
                    <span class="font-bold">
                        Total Perpanjangan
                    </span>

                    <span class="font-bold text-[#34699A]">
                        Rp{{ number_format($extensionPrice, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </section>
    </div>

    {{-- Next Step --}}
    <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] mt-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
        <h2 class="text-[16px] font-bold mb-[14px]">
            Apa yang terjadi selanjutnya?
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-[14px]">
            <div class="flex gap-[12px]">
                <img src="{{ asset('assets/icons/icon-calendar-blue.png') }}"
                     class="w-[38px] h-[38px] object-contain shrink-0"
                     alt="Durasi">

                <div>
                    <p class="text-[13px] font-bold">
                        Durasi sewa diperbarui
                    </p>

                    <p class="text-[12px] text-[#6B7280] mt-[4px] leading-[19px]">
                        Tanggal berakhir sewa Anda sekarang {{ $newEndDate }}.
                    </p>
                </div>
            </div>

            <div class="flex gap-[12px]">
                <img src="{{ asset('assets/icons/icon-calender-checklist.png') }}"
                     class="w-[38px] h-[38px] object-contain shrink-0"
                     alt="Otomatis">

                <div>
                    <p class="text-[13px] font-bold">
                        Tidak perlu konfirmasi pemilik
                    </p>

                    <p class="text-[12px] text-[#6B7280] mt-[4px] leading-[19px]">
                        Sistem otomatis memperbarui masa sewa dan ketersediaan barang.
                    </p>
                </div>
            </div>

            <div class="flex gap-[12px]">
                <img src="{{ asset('assets/icons/icon-notif.png') }}"
                     class="w-[38px] h-[38px] object-contain shrink-0"
                     alt="Notifikasi">

                <div>
                    <p class="text-[13px] font-bold">
                        Informasi dikirim
                    </p>

                    <p class="text-[12px] text-[#6B7280] mt-[4px] leading-[19px]">
                        Pemilik dapat melihat informasi perpanjangan pada detail transaksi.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <div class="bg-[#EAF3FF] text-[#34699A] rounded-[8px] px-[14px] py-[12px] flex items-start gap-[10px] mt-[18px]">
        <img src="{{ asset('assets/icons/icon-info-blue.png') }}"
             class="w-[18px] h-[18px] object-contain mt-[2px]"
             alt="Info">

        <p class="text-[12px] font-semibold leading-[20px]">
            Jika ingin menanyakan posisi barang atau informasi penyewaan, silakan hubungi pemilik melalui fitur chat.
        </p>
    </div>

    <div class="flex flex-col sm:flex-row justify-end gap-[10px] mt-[28px]">
        <a href="{{ route('transaksi.detail', $rental->id) }}"
           class="h-[42px] px-[22px] rounded-[8px] border border-[#34699A] text-[#34699A] text-[13px] font-semibold flex items-center justify-center">
            Lihat Detail Transaksi
        </a>

        <a href="{{ route('riwayat.transaksi.penyewa') }}"
           class="h-[42px] px-[22px] rounded-[8px] bg-[#34699A] text-white text-[13px] font-semibold flex items-center justify-center">
            Selesai
        </a>
    </div>
</main>

@include('layouts.partials.footer')

</body>
</html>