<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran Perpanjangan Sewa</title>
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
    $payment = $rental->payment;

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

    $oldEndDate = $dataPerpanjangan['old_end_date']
        ? Carbon::parse($dataPerpanjangan['old_end_date'])->format('d M Y')
        : '-';

    $newEndDate = $dataPerpanjangan['new_end_date']
        ? Carbon::parse($dataPerpanjangan['new_end_date'])->format('d M Y')
        : '-';

    $startDate = $rental->start_date
        ? Carbon::parse($rental->start_date)->format('d M Y')
        : '-';

    $extraDays = $dataPerpanjangan['extra_days'] ?? 0;
    $extensionPrice = $dataPerpanjangan['extension_price'] ?? 0;

    $paylater2x = $extraDays > 0 ? ceil($extensionPrice / 2) : 0;
    $paylater4x = $extraDays > 0 ? ceil($extensionPrice / 4) : 0;

    $itemImage = optional($item)->image;
    $imageUrl = $itemImage
        ? asset('assets/products/' . $itemImage)
        : asset('assets/products/default-product.png');
@endphp

<main class="w-full max-w-[435px] sm:max-w-[940px] lg:max-w-[1220px] mx-auto px-[20px] sm:px-[44px] lg:px-[66px] pt-[28px] pb-[70px]">

    {{-- Header --}}
    <div class="flex items-center gap-[12px] mb-[24px]">
        <a href="{{ route('transaksi.formPerpanjanganSewa', $rental->id) }}"
           class="w-[34px] h-[34px] flex items-center justify-center shrink-0">
            <img src="{{ asset('assets/icons/icon-back.png') }}"
                 class="w-[28px] h-[28px] object-contain"
                 alt="Kembali">
        </a>

        <div>
            <h1 class="text-[22px] sm:text-[24px] font-bold leading-[32px]">
                Pembayaran Perpanjangan
            </h1>

            <p class="text-[13px] text-[#6B7280] mt-[3px]">
                Pilih metode pembayaran untuk menyelesaikan perpanjangan sewa.
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
                <div class="w-[30px] h-[30px] mx-auto rounded-full bg-[#34699A] text-white flex items-center justify-center text-[13px] font-bold">
                    2
                </div>
                <p class="text-[11px] text-[#34699A] font-semibold mt-[7px]">
                    Pembayaran
                </p>
            </div>

            <div class="text-center relative">
                <div class="hidden sm:block absolute top-[15px] left-[-45%] w-[90%] h-[1px] bg-[#C3DAFE]"></div>
                <div class="w-[30px] h-[30px] mx-auto rounded-full bg-[#E5E7EB] text-[#6B7280] flex items-center justify-center text-[13px] font-bold">
                    3
                </div>
                <p class="text-[11px] text-[#6B7280] font-semibold mt-[7px]">
                    Selesai
                </p>
            </div>
        </div>
    </section>

    @if(session('error'))
        <div class="mb-[18px] bg-[#FFECEF] border border-[#F4B8C2] text-[#E3455D] px-[14px] py-[12px] rounded-[8px] text-[13px] font-semibold">
            {{ session('error') }}
        </div>
    @endif

    <form id="mainConfirmForm"
          action="{{ route('transaksi.simpanPembayaranPerpanjangan', $rental->id) }}"
          method="POST"
          class="grid grid-cols-1 lg:grid-cols-[1fr_0.78fr] gap-[18px]">

        @csrf
        @method('PUT')

        {{-- Kiri --}}
        <section class="space-y-[18px]">

            {{-- Ringkasan Perpanjangan --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[14px]">
                    Ringkasan Perpanjangan
                </h2>

                <div class="border border-[#D7E5FA] rounded-[9px] px-[12px] py-[12px] flex gap-[12px] bg-[#F8FBFF] mb-[16px]">
                    <img src="{{ $imageUrl }}"
                         <img src="{{ $imageUrl }}"
                              alt="{{ optional($item)->name ?? 'Produk' }}"
                              class="w-[82px] h-[82px] rounded-[7px] object-cover flex-shrink-0">

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
                                ID Transaksi: {{ $rental->rental_code }}
                            </span>
                        </div>

                        <p class="text-[11px] text-[#6B7280] mt-[7px]">
                            Disewa dari {{ optional($owner)->name ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="space-y-[11px] text-[13px]">
                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Tanggal mulai sewa
                        </span>

                        <span class="font-semibold text-right">
                            {{ $startDate }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Tanggal selesai saat ini
                        </span>

                        <span class="font-semibold text-right">
                            {{ $oldEndDate }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Tanggal selesai baru
                        </span>

                        <span class="font-semibold text-right text-[#348B55]">
                            {{ $newEndDate }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Durasi tambahan
                        </span>

                        <span class="font-semibold text-right">
                            {{ $extraDays }} hari
                        </span>
                    </div>

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

            {{-- Metode Pembayaran --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[5px]">
                    Metode Pembayaran
                </h2>

                <p class="text-[12px] text-[#6B7280] mb-[16px]">
                    Pilih pembayaran penuh atau cicilan PayLater.
                </p>

                <div class="space-y-[12px]">

                    {{-- Bayar Penuh --}}
                    <label id="fullPaymentCard"
                           class="payment-card border border-[#34699A] bg-[#EAF3FF] rounded-[10px] px-[14px] py-[14px] flex gap-[12px] cursor-pointer">
                        <input type="radio"
                               name="metode_pembayaran"
                               value="qris"
                               class="mt-[4px] js-payment-option"
                               checked
                               required>

                        <div class="flex-1">
                            <div class="flex items-center justify-between gap-[10px]">
                                <div class="flex items-center gap-[8px]">
                                    <img src="{{ asset('assets/icons/icon-wallet.png') }}"
                                         class="w-[18px] h-[18px] object-contain"
                                         alt="Bayar">
                                    <p class="text-[14px] font-bold">
                                        Bayar Penuh
                                    </p>
                                </div>

                                <span class="text-[12px] text-[#34699A] font-bold">
                                    Rp{{ number_format($extensionPrice, 0, ',', '.') }}
                                </span>
                            </div>

                            <p class="text-[12px] text-[#6B7280] leading-[20px] mt-[6px]">
                                Selesaikan seluruh pembayaran perpanjangan sekarang.
                            </p>
                        </div>
                    </label>

                    {{-- PayLater --}}
                    <label id="paylaterCard"
                           class="payment-card border border-[#D7DCE3] bg-white rounded-[10px] px-[14px] py-[14px] flex gap-[12px] cursor-pointer">
                        <input type="radio"
                               name="metode_pembayaran"
                               value="paylater"
                               class="mt-[4px] js-payment-option"
                               required>

                        <div class="flex-1">
                            <div class="flex items-center gap-[8px]">
                                <img src="{{ asset('assets/icons/icon-paylater.png') }}"
                                     class="w-[18px] h-[18px] object-contain"
                                     alt="PayLater">

                                <p class="text-[14px] font-bold">
                                    Cicilan (PayLater)
                                </p>
                            </div>

                            <p class="text-[12px] text-[#6B7280] leading-[20px] mt-[6px]">
                                Siklus pembayaran per 14 hari.
                            </p>
                        </div>
                    </label>

                    {{-- Tenor PayLater --}}
                    <div id="paylaterTenorBox"
                         class="hidden border border-[#34699A] bg-[#F8FBFF] rounded-[10px] px-[14px] py-[14px]">
                        <p class="text-[13px] font-bold mb-[10px]">
                            Pilih Tenor
                        </p>

                        <div class="space-y-[8px]">
                            <label class="tenor-card border border-[#34699A] bg-white rounded-[8px] px-[12px] py-[10px] flex items-center justify-between gap-[12px] cursor-pointer">
                                <div>
                                    <p class="text-[13px] font-bold">
                                        Cicilan 2x
                                    </p>

                                    <p class="text-[11px] text-[#6B7280]">
                                        Siklus 14 hari
                                    </p>
                                </div>

                                <div class="text-right">
                                    <input type="radio"
                                           name="installment_plan"
                                           value="2"
                                           class="js-tenor-option hidden">

                                    <p class="text-[13px] font-bold text-[#34699A]">
                                        Rp{{ number_format($paylater2x, 0, ',', '.') }}
                                    </p>
                                </div>
                            </label>

                            <label class="tenor-card border border-[#D7DCE3] bg-white rounded-[8px] px-[12px] py-[10px] flex items-center justify-between gap-[12px] cursor-pointer">
                                <div>
                                    <p class="text-[13px] font-bold">
                                        Cicilan 4x
                                    </p>

                                    <p class="text-[11px] text-[#6B7280]">
                                        Siklus 14 hari
                                    </p>
                                </div>

                                <div class="text-right">
                                    <input type="radio"
                                           name="installment_plan"
                                           value="4"
                                           class="js-tenor-option hidden">

                                    <p class="text-[13px] font-bold text-[#34699A]">
                                        Rp{{ number_format($paylater4x, 0, ',', '.') }}
                                    </p>
                                </div>
                            </label>
                        </div>

                        <div class="mt-[12px] bg-[#DDEBFF] rounded-[6px] px-[10px] py-[9px] flex justify-between gap-[12px] text-[12px]">
                            <span class="text-[#6B7280]">
                                Pembayaran Pertama
                            </span>

                            <span id="firstInstallmentText" class="font-bold">
                                -
                            </span>
                        </div>
                    </div>

                </div>
            </section>

            {{-- Info --}}
            <section class="bg-[#EAF3FF] text-[#34699A] rounded-[10px] px-[14px] py-[12px] flex items-start gap-[10px]">
                <img src="{{ asset('assets/icons/icon-info-blue.png') }}"
                     class="w-[18px] h-[18px] object-contain mt-[2px]"
                     alt="Info">

                <p class="text-[12px] font-semibold leading-[20px]">
                    Jika menggunakan PayLater, cicilan perpanjangan akan tampil di halaman Profil bagian Cicilan.
                </p>
            </section>
        </section>

        {{-- Kanan --}}
        <aside class="space-y-[18px]">

            {{-- QRIS --}}
            <section id="qrisSection"
                     class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[14px]">
                    QRIS
                </h2>

                <div class="bg-[#F8FBFF] border border-[#D7E5FA] rounded-[10px] px-[14px] py-[16px] text-center">
                    <img src="{{ asset('assets/img/qris/qris-placeholder.png') }}"
                         class="w-[190px] h-[190px] object-contain mx-auto"
                         alt="QRIS">

                    <p class="text-[12px] text-[#6B7280] leading-[19px] mt-[10px]">
                        Scan kode QR untuk menyelesaikan pembayaran perpanjangan sewa.
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
                            Total Perpanjangan
                        </span>

                        <span class="font-semibold">
                            Rp{{ number_format($extensionPrice, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Metode
                        </span>

                        <span id="selectedMethodText" class="font-semibold text-right">
                            Bayar Penuh
                        </span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Dibayar Sekarang
                        </span>

                        <span id="payNowText" class="font-semibold text-right text-[#34699A]">
                            Rp{{ number_format($extensionPrice, 0, ',', '.') }}
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

                <a href="{{ route('transaksi.formPerpanjanganSewa', $rental->id) }}"
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
            Setelah pembayaran berhasil, tanggal selesai sewa akan diperbarui otomatis.
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
    const extensionPrice = Number(@json($extensionPrice));
    const paylater2x = Number(@json($paylater2x));
    const paylater4x = Number(@json($paylater4x));

    const paymentOptions = document.querySelectorAll('.js-payment-option');
    const tenorOptions = document.querySelectorAll('.js-tenor-option');
    const paylaterTenorBox = document.getElementById('paylaterTenorBox');
    const qrisSection = document.getElementById('qrisSection');

    const selectedMethodText = document.getElementById('selectedMethodText');
    const payNowText = document.getElementById('payNowText');
    const firstInstallmentText = document.getElementById('firstInstallmentText');

    function formatRupiah(value) {
        return 'Rp' + Number(value).toLocaleString('id-ID');
    }

    function resetPaymentCards() {
        document.querySelectorAll('.payment-card').forEach(function(card) {
            card.classList.remove('border-[#34699A]', 'bg-[#EAF3FF]');
            card.classList.add('border-[#D7DCE3]', 'bg-white');
        });
    }

    function resetTenorCards() {
        document.querySelectorAll('.tenor-card').forEach(function(card) {
            card.classList.remove('border-[#34699A]');
            card.classList.add('border-[#D7DCE3]');
        });
    }

    paymentOptions.forEach(function(option) {
        option.addEventListener('change', function() {
            resetPaymentCards();

            const card = option.closest('.payment-card');
            card.classList.remove('border-[#D7DCE3]', 'bg-white');
            card.classList.add('border-[#34699A]', 'bg-[#EAF3FF]');

            if (option.value === 'paylater') {
                paylaterTenorBox.classList.remove('hidden');
                qrisSection.classList.add('hidden');

                selectedMethodText.innerText = 'PayLater';
                payNowText.innerText = '-';

                const firstTenor = document.querySelector('.js-tenor-option[value="2"]');
                firstTenor.checked = true;
                updateTenor('2');
            } else {
                paylaterTenorBox.classList.add('hidden');
                qrisSection.classList.remove('hidden');

                tenorOptions.forEach(function(tenor) {
                    tenor.checked = false;
                });

                selectedMethodText.innerText = 'Bayar Penuh';
                payNowText.innerText = formatRupiah(extensionPrice);
                firstInstallmentText.innerText = '-';
            }
        });
    });

    tenorOptions.forEach(function(option) {
        option.addEventListener('change', function() {
            updateTenor(option.value);
        });
    });

    function updateTenor(plan) {
        resetTenorCards();

        const activeTenor = document.querySelector('.js-tenor-option[value="' + plan + '"]');
        const activeCard = activeTenor.closest('.tenor-card');

        activeCard.classList.remove('border-[#D7DCE3]');
        activeCard.classList.add('border-[#34699A]');

        const firstInstallment = plan === '2' ? paylater2x : paylater4x;

        selectedMethodText.innerText = 'PayLater ' + plan + 'x';
        payNowText.innerText = formatRupiah(firstInstallment);
        firstInstallmentText.innerText = formatRupiah(firstInstallment);
    }

    function openConfirmModal() {
        const selectedPayment = document.querySelector('.js-payment-option:checked');

        if (!selectedPayment) {
            alert('Pilih metode pembayaran terlebih dahulu.');
            return;
        }

        if (selectedPayment.value === 'paylater') {
            const selectedTenor = document.querySelector('.js-tenor-option:checked');

            if (!selectedTenor) {
                alert('Pilih tenor PayLater terlebih dahulu.');
                return;
            }
        }

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