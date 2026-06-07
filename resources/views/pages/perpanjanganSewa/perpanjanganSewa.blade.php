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

<body class="bg-[#F5F7FA] text-[#1E1E1E] [font-family:'Plus_Jakarta_Sans',sans-serif]">

@include('layouts.partials.navbar')

@php
    use Carbon\Carbon;

    $item = $rental->item;
    $owner = $rental->owner;

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

    $startDate = $rental->start_date
        ? Carbon::parse($rental->start_date)->format('d M Y')
        : '-';

    $endDate = $rental->end_date
        ? Carbon::parse($rental->end_date)->format('d M Y')
        : '-';

    $currentEndDate = $rental->end_date
        ? Carbon::parse($rental->end_date)
        : now();

    $pricePerDay = optional($item)->price_per_day ?? 0;

    $tanggalTidakTersedia = $tanggalTidakTersedia ?? [];

    $itemImage = optional($item)->image;
    $imageUrl = $itemImage
        ? asset('assets/products/' . $itemImage)
        : asset('assets/products/default-product.png');
@endphp

<main class="w-full max-w-[435px] sm:max-w-[940px] lg:max-w-[1220px] mx-auto px-[20px] sm:px-[44px] lg:px-[66px] pt-[28px] pb-[70px]">

    <div class="flex items-center gap-[12px] mb-[24px]">
        <a href="{{ route('transaksi.detail', $rental->id) }}"
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
                Pilih tanggal akhir sewa baru yang masih tersedia.
            </p>
        </div>
    </div>

    {{-- Stepper --}}
    <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[24px] py-[18px] mb-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
        <div class="grid grid-cols-3 items-start gap-[10px]">
            <div class="text-center">
                <div class="w-[30px] h-[30px] mx-auto rounded-full bg-[#34699A] text-white flex items-center justify-center text-[13px] font-bold">
                    1
                </div>
                <p class="text-[11px] text-[#34699A] font-semibold mt-[7px]">
                    Pilih Tanggal
                </p>
            </div>

            <div class="text-center relative">
                <div class="hidden sm:block absolute top-[15px] left-[-45%] w-[90%] h-[1px] bg-[#C3DAFE]"></div>
                <div class="w-[30px] h-[30px] mx-auto rounded-full bg-[#E5E7EB] text-[#6B7280] flex items-center justify-center text-[13px] font-bold">
                    2
                </div>
                <p class="text-[11px] text-[#6B7280] font-semibold mt-[7px]">
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
          action="{{ route('transaksi.lanjutPembayaranPerpanjangan', $rental->id) }}"
          method="POST"
          class="grid grid-cols-1 lg:grid-cols-[1fr_0.75fr] gap-[18px]">

        @csrf
        @method('PUT')

        {{-- Kiri --}}
        <section class="space-y-[18px]">

            {{-- Barang --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[14px]">
                    Barang yang Disewa
                </h2>

                <div class="border border-[#D7E5FA] rounded-[9px] px-[12px] py-[12px] flex gap-[12px] bg-[#F8FBFF]">
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
            </section>

            {{-- Tanggal Sewa --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[14px]">
                    Tanggal Sewa
                </h2>

                <div class="grid grid-cols-2 border border-[#C3CAD5] rounded-[8px] overflow-hidden mb-[16px]">
                    <div class="px-[14px] py-[12px] border-r border-[#C3CAD5] bg-[#F8FAFC]">
                        <p class="text-[11px] text-[#6B7280] uppercase tracking-[0.03em]">
                            Tanggal Mulai
                        </p>

                        <p class="text-[14px] font-semibold mt-[5px]">
                            {{ $startDate }}
                        </p>
                    </div>

                    <div class="px-[14px] py-[12px] bg-[#F8FAFC]">
                        <p class="text-[11px] text-[#6B7280] uppercase tracking-[0.03em]">
                            Tanggal Selesai Saat Ini
                        </p>

                        <p class="text-[14px] font-semibold mt-[5px] text-[#D38A00]">
                            {{ $endDate }}
                        </p>
                    </div>
                </div>

                <label class="block text-[13px] font-bold mb-[8px]">
                    Pilih Tanggal Selesai Baru
                    <span class="text-[#E3455D]">*</span>
                </label>

                <input type="hidden"
                       name="tanggal_selesai_baru"
                       id="tanggal_selesai_baru"
                       required>

                <div id="calendarGrid" class="grid grid-cols-7 gap-[8px]"></div>

                <div class="flex flex-wrap items-center gap-[12px] mt-[14px] text-[12px]">
                    <div class="flex items-center gap-[6px]">
                        <span class="w-[14px] h-[14px] rounded-[4px] bg-[#34699A] inline-block"></span>
                        <span>Tanggal dipilih</span>
                    </div>

                    <div class="flex items-center gap-[6px]">
                        <span class="w-[14px] h-[14px] rounded-[4px] bg-[#E5E7EB] inline-block"></span>
                        <span>Tidak tersedia</span>
                    </div>

                    <div class="flex items-center gap-[6px]">
                        <span class="w-[14px] h-[14px] rounded-[4px] border border-[#C3DAFE] inline-block"></span>
                        <span>Tersedia</span>
                    </div>
                </div>

                <p id="dateError" class="hidden text-[12px] text-[#E3455D] font-semibold mt-[10px]">
                    Tanggal ini tidak tersedia.
                </p>
            </section>

            {{-- Info --}}
            <section class="bg-[#EAF3FF] text-[#34699A] rounded-[10px] px-[14px] py-[12px] flex items-start gap-[10px]">
                <img src="{{ asset('assets/icons/icon-info-blue.png') }}"
                     class="w-[18px] h-[18px] object-contain mt-[2px]"
                     alt="Info">

                <p class="text-[12px] font-semibold leading-[20px]">
                    Tanggal yang tidak tersedia langsung ditandai dan tidak bisa dipilih. Jika ingin menanyakan jadwal barang, silakan hubungi pemilik melalui chat.
                </p>
            </section>
        </section>

        {{-- Kanan --}}
        <aside class="space-y-[18px]">

            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[14px]">
                    Ringkasan Perpanjangan
                </h2>

                <div class="space-y-[11px] text-[13px]">
                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Harga per hari
                        </span>

                        <span class="font-semibold">
                            Rp{{ number_format($pricePerDay, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Tanggal akhir baru
                        </span>

                        <span id="summaryNewDate" class="font-semibold text-right">
                            -
                        </span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Durasi tambahan
                        </span>

                        <span id="summaryExtraDays" class="font-semibold">
                            -
                        </span>
                    </div>

                    <div class="border-t border-[#D7E5FA] pt-[11px] flex justify-between gap-[12px]">
                        <span class="font-bold">
                            Total Perpanjangan
                        </span>

                        <span id="summaryTotal" class="font-bold text-[#34699A]">
                            -
                        </span>
                    </div>
                </div>
            </section>

            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <button type="button"
                        onclick="openConfirmModal()"
                        class="w-full h-[42px] rounded-[8px] bg-[#34699A] text-white text-[13px] font-semibold">
                    Lanjut ke Pembayaran
                </button>

                <a href="{{ route('transaksi.detail', $rental->id) }}"
                   class="w-full h-[42px] rounded-[8px] border border-[#34699A] text-[#34699A] text-[13px] font-semibold flex items-center justify-center mt-[10px]">
                    Batal
                </a>
            </section>
        </aside>
    </form>
</main>

@include('layouts.partials.footer')

{{-- Modal --}}
<div id="confirmModal"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-[9999] px-[20px]">
    <div class="bg-white rounded-[12px] w-full max-w-[330px] px-[24px] py-[28px] text-center">
        <img src="{{ asset('assets/icons/icon-question.png') }}"
             class="w-[54px] h-[54px] object-contain mx-auto mb-[18px]"
             alt="Konfirmasi">

        <h3 class="text-[15px] font-bold text-[#34699A] mb-[8px]">
            Lanjut ke pembayaran?
        </h3>

        <p class="text-[12px] text-[#696969] leading-[20px] mb-[22px]">
            Pastikan tanggal selesai baru sudah benar dan tersedia.
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
                Lanjut
            </button>
        </div>
    </div>
</div>

<script>
    const unavailableDates = @json($tanggalTidakTersedia);
    const currentEndDate = new Date(@json($currentEndDate->format('Y-m-d')) + 'T00:00:00');
    const pricePerDay = Number(@json($pricePerDay));

    const selectedInput = document.getElementById('tanggal_selesai_baru');
    const calendarGrid = document.getElementById('calendarGrid');
    const dateError = document.getElementById('dateError');

    const summaryNewDate = document.getElementById('summaryNewDate');
    const summaryExtraDays = document.getElementById('summaryExtraDays');
    const summaryTotal = document.getElementById('summaryTotal');

    function formatRupiah(value) {
        return 'Rp' + Number(value).toLocaleString('id-ID');
    }

    function formatDate(dateString) {
        const date = new Date(dateString + 'T00:00:00');

        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }

    function dateToYmd(date) {
        return date.toISOString().slice(0, 10);
    }

    function createCalendar() {
        calendarGrid.innerHTML = '';

        const start = new Date(currentEndDate);
        start.setDate(start.getDate() + 1);

        for (let i = 0; i < 28; i++) {
            const date = new Date(start);
            date.setDate(start.getDate() + i);

            const ymd = dateToYmd(date);
            const isUnavailable = unavailableDates.includes(ymd);

            const button = document.createElement('button');
            button.type = 'button';
            button.innerText = date.getDate();
            button.dataset.date = ymd;

            button.className = 'h-[38px] rounded-[8px] border text-[13px] font-semibold transition';

            if (isUnavailable) {
                button.disabled = true;
                button.className += ' bg-[#E5E7EB] text-[#9CA3AF] border-[#E5E7EB] cursor-not-allowed';
            } else {
                button.className += ' bg-white text-[#34699A] border-[#C3DAFE] hover:bg-[#EAF3FF]';
                button.addEventListener('click', function () {
                    selectDate(ymd, button);
                });
            }

            calendarGrid.appendChild(button);
        }
    }

    function selectDate(ymd, activeButton) {
        selectedInput.value = ymd;
        dateError.classList.add('hidden');

        document.querySelectorAll('#calendarGrid button').forEach(function (btn) {
            if (!btn.disabled) {
                btn.className = 'h-[38px] rounded-[8px] border text-[13px] font-semibold transition bg-white text-[#34699A] border-[#C3DAFE] hover:bg-[#EAF3FF]';
            }
        });

        activeButton.className = 'h-[38px] rounded-[8px] border text-[13px] font-semibold transition bg-[#34699A] text-white border-[#34699A]';

        const selectedDate = new Date(ymd + 'T00:00:00');
        const diffTime = selectedDate - currentEndDate;
        const extraDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        const total = extraDays * pricePerDay;

        summaryNewDate.innerText = formatDate(ymd);
        summaryExtraDays.innerText = extraDays + ' hari';
        summaryTotal.innerText = formatRupiah(total);
    }

    function openConfirmModal() {
        if (!selectedInput.value) {
            dateError.innerText = 'Pilih tanggal selesai baru terlebih dahulu.';
            dateError.classList.remove('hidden');
            return;
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

    createCalendar();
</script>

</body>
</html>