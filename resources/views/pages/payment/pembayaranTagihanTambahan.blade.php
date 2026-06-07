<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Tambahan Kerusakan</title>
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
    $claim = $rental->damageClaim;
    $payment = $rental->payment;

    $tagihan = $additionalPayment->amount ?? 0;

    $damageFee = optional($claim)->repair_fee ?? $rental->damage_fee ?? 0;
    $deposit = 500000;

    $startDate = $rental->start_date
        ? Carbon::parse($rental->start_date)->format('d M Y')
        : '-';

    $endDate = $rental->end_date
        ? Carbon::parse($rental->end_date)->format('d M Y')
        : '-';

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
        : '-';
@endphp

<main class="w-full max-w-[435px] sm:max-w-[940px] lg:max-w-[1220px] mx-auto px-[20px] sm:px-[44px] lg:px-[66px] pt-[28px] pb-[70px]">

    {{-- Header --}}
    <div class="flex items-center gap-[12px] mb-[24px]">
        <a href="{{ route('transaksi.lihatKlaim', $rental->id) }}"
           class="w-[34px] h-[34px] flex items-center justify-center shrink-0">
            <img src="{{ asset('assets/icons/icon-back.png') }}"
                 class="w-[28px] h-[28px] object-contain"
                 alt="Kembali">
        </a>

        <div>
            <h1 class="text-[22px] sm:text-[24px] font-bold leading-[32px]">
                Pembayaran Tagihan Tambahan
            </h1>

            <p class="text-[13px] text-[#6B7280] mt-[3px]">
                Selesaikan tagihan tambahan agar transaksi dapat ditutup.
            </p>
        </div>
    </div>

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

    <form id="mainConfirmForm"
          action="{{ route('transaksi.simpanPembayaranTagihanTambahan', $rental->id) }}"
          method="POST"
          class="grid grid-cols-1 lg:grid-cols-[1fr_0.78fr] gap-[18px]">

        @csrf
        @method('PUT')

        {{-- Kiri --}}
        <section class="space-y-[18px]">

            {{-- Info --}}
            <section class="bg-[#FFF3C4] border border-[#F6D36A] rounded-[10px] px-[16px] sm:px-[20px] py-[14px] flex items-start gap-[12px]">
                <img src="{{ asset('assets/icons/icon-warning-yellow.png') }}"
                     class="w-[28px] h-[28px] object-contain shrink-0"
                     alt="Peringatan">

                <div>
                    <h2 class="text-[15px] font-bold text-[#7A5200]">
                        Tagihan tambahan kerusakan
                    </h2>

                    <p class="text-[12px] text-[#7A5200] leading-[20px] mt-[4px]">
                        Tagihan ini muncul karena biaya kerusakan melebihi deposit. Setelah dibayar, transaksi akan diselesaikan.
                    </p>
                </div>
            </section>

            {{-- Ringkasan Barang --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[14px]">
                    Ringkasan Barang
                </h2>

                <div class="border border-[#D7E5FA] rounded-[9px] px-[12px] py-[12px] flex gap-[12px] bg-[#F8FBFF]">
                    <img src="{{ $imageUrl }}"
                         class="w-[78px] h-[78px] rounded-[8px] object-cover shrink-0"
                         alt="{{ optional($item)->name ?? 'Item Image' }}">

                    <div class="min-w-0 flex-1">
                        <div class="flex items-start justify-between gap-[10px]">
                            <h3 class="text-[14px] sm:text-[15px] font-bold leading-[21px] line-clamp-2">
                                {{ optional($item)->name ?? '-' }}
                            </h3>

                            <span class="h-[24px] px-[10px] rounded-full text-[10px] font-semibold bg-[#FFD6DE] text-[#E3455D] shrink-0">
                                Kerusakan
                            </span>
                        </div>

                        <div class="flex flex-wrap items-center gap-[6px] mt-[7px]">
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

                            {{ $startDate }} - {{ $endDate }}
                        </p>
                    </div>
                </div>

                <div class="mt-[16px] space-y-[10px] text-[13px]">
                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Pemilik
                        </span>

                        <span class="font-semibold text-right">
                            {{ optional($owner)->name ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Jenis Kerusakan
                        </span>

                        <span class="font-semibold text-right">
                            {{ optional($claim)->damage_type ?? '-' }}
                        </span>
                    </div>
                </div>
            </section>

            {{-- Rincian Kerusakan --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[14px]">
                    Rincian Tagihan
                </h2>

                <div class="space-y-[11px] text-[13px]">
                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Biaya Kerusakan
                        </span>

                        <span class="font-semibold text-[#E3455D]">
                            Rp{{ number_format($damageFee, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Deposit
                        </span>

                        <span class="font-semibold">
                            - Rp{{ number_format($deposit, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="border-t border-[#D7E5FA] pt-[11px] flex justify-between gap-[12px]">
                        <span class="font-bold">
                            Sisa Tagihan
                        </span>

                        <span class="font-bold text-[#34699A]">
                            Rp{{ number_format($tagihan, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="mt-[14px] bg-[#EAF3FF] text-[#34699A] rounded-[8px] px-[14px] py-[12px] flex items-start gap-[10px]">
                    <img src="{{ asset('assets/icons/icon-info-blue.png') }}"
                         class="w-[18px] h-[18px] object-contain mt-[2px]"
                         alt="Info">

                    <p class="text-[12px] font-semibold leading-[20px]">
                        Setelah tagihan tambahan dibayar, transaksi akan berubah menjadi Selesai dan barang dapat diproses kembali oleh pemilik.
                    </p>
                </div>
            </section>

            @if($isPaylater)
                <section class="bg-[#FFF8E6] border border-[#F6D36A] rounded-[10px] px-[16px] sm:px-[20px] py-[14px] flex items-start gap-[12px]">
                    <img src="{{ asset('assets/icons/icon-paylater.png') }}"
                         class="w-[24px] h-[24px] object-contain shrink-0"
                         alt="PayLater">

                    <div>
                        <h2 class="text-[14px] font-bold text-[#7A5200]">
                            Transaksi utama menggunakan PayLater
                        </h2>

                        <p class="text-[12px] text-[#7A5200] leading-[20px] mt-[4px]">
                            Cicilan utama tetap berjalan. Tempo berikutnya: {{ $nextDueDate }}.
                            Untuk detail cicilan, buka halaman Profil bagian Cicilan.
                        </p>
                    </div>
                </section>
            @endif
        </section>

        {{-- Kanan --}}
        <aside class="space-y-[18px]">

            {{-- QRIS --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[14px]">
                    Pembayaran QRIS
                </h2>

                <div class="bg-[#F8FBFF] border border-[#D7E5FA] rounded-[10px] px-[14px] py-[16px] text-center">
                    <img src="{{ asset('assets/img/qris/qris-placeholder.png') }}"
                         class="w-[190px] h-[190px] object-contain mx-auto"
                         alt="QRIS">

                    <p class="text-[12px] text-[#6B7280] leading-[19px] mt-[10px]">
                        Scan kode QR untuk membayar tagihan tambahan kerusakan.
                    </p>
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
                            Metode
                        </span>

                        <span class="font-semibold">
                            QRIS
                        </span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Status
                        </span>

                        <span class="font-semibold text-[#D38A00]">
                            Menunggu Pembayaran
                        </span>
                    </div>

                    <div class="border-t border-[#D7E5FA] pt-[11px] flex justify-between gap-[12px]">
                        <span class="font-bold">
                            Total Bayar
                        </span>

                        <span class="font-bold text-[#34699A]">
                            Rp{{ number_format($tagihan, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </section>

            {{-- Action --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <button type="button"
                        onclick="openConfirmModal()"
                        class="w-full h-[42px] rounded-[8px] bg-[#34699A] text-white text-[13px] font-semibold">
                    Konfirmasi Pembayaran
                </button>

                <a href="{{ route('transaksi.lihatKlaim', $rental->id) }}"
                   class="w-full h-[42px] rounded-[8px] border border-[#34699A] text-[#34699A] text-[13px] font-semibold flex items-center justify-center mt-[10px]">
                    Kembali
                </a>
            </section>
        </aside>
    </form>
</main>

@include('layouts.partials.footer')

{{-- Modal Konfirmasi --}}
<div id="confirmModal"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-[9999] px-[20px]">
    <div class="bg-white rounded-[12px] w-full max-w-[330px] px-[24px] py-[28px] text-center">
        <img src="{{ asset('assets/icons/icon-question.png') }}"
             class="w-[54px] h-[54px] object-contain mx-auto mb-[18px]"
             alt="Konfirmasi">

        <h3 class="text-[15px] font-bold text-[#34699A] mb-[8px]">
            Konfirmasi pembayaran?
        </h3>

        <p class="text-[12px] text-[#696969] leading-[20px] mb-[22px]">
            Setelah dikonfirmasi, tagihan tambahan akan dianggap lunas dan transaksi diselesaikan.
        </p>

        <div class="grid grid-cols-2 gap-[10px]">
            <button type="button"
                    onclick="closeConfirmModal()"
                    class="h-[36px] rounded-[6px] border border-[#34699A] text-[#34699A] text-[12px] font-semibold">
                Batal
            </button>

            <button type="button"
                    onclick="submitMainForm()"
                    class="h-[36px] rounded-[6px] bg-[#34699A] text-white text-[12px] font-semibold">
                Ya, Bayar
            </button>
        </div>
    </div>
</div>

<script>
    function openConfirmModal() {
        document.getElementById('confirmModal').classList.remove('hidden');
        document.getElementById('confirmModal').classList.add('flex');
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
        document.getElementById('confirmModal').classList.remove('flex');
    }

    function submitMainForm() {
        document.getElementById('mainConfirmForm').submit();
    }
</script>

</body>
</html>