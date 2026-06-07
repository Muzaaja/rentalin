<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Penyerahan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

<body class="bg-[#F5F7FA] text-[#1E1E1E] [font-family:'Plus_Jakarta_Sans',sans-serif]">

@include('layouts.partials.navbar')

<main class="w-full max-w-[435px] sm:max-w-[940px] lg:max-w-[1220px] mx-auto px-[20px] sm:px-[44px] lg:px-[66px] pt-[22px] sm:pt-[38px] pb-[48px] lg:pb-[70px]">

    <div class="flex items-center gap-[14px] mb-[28px] sm:mb-[34px]">
        <a href="{{ url()->previous() }}"
           class="w-[34px] h-[34px] flex items-center justify-center">
            <img src="{{ asset('assets/icons/icon-back.png') }}"
                 class="w-[28px] h-[28px] object-contain"
                 alt="Kembali">
        </a>

        <h1 class="text-[24px] sm:text-[26px] font-bold">
            Konfirmasi Penyerahan
        </h1>
    </div>

    @if($errors->any())
        <div class="mb-[18px] bg-[#FFECEF] border border-[#F4B8C2] text-[#E3455D] px-[14px] py-[12px] rounded-[8px] text-[13px] font-semibold">
            <ul class="list-disc pl-[18px]">
                @foreach($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        use Carbon\Carbon;

        $item = $rental->item;
        $owner = $rental->owner;
        $tenant = $rental->tenant;

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

        $kelengkapanBarang = [];

        if (!empty(optional($item)->kelengkapan)) {
            if (is_array($item->kelengkapan)) {
                $kelengkapanBarang = $item->kelengkapan;
            } else {
                $decodedKelengkapan = json_decode($item->kelengkapan, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedKelengkapan)) {
                    $kelengkapanBarang = $decodedKelengkapan;
                } else {
                    $kelengkapanBarang = preg_split('/\r\n|\r|\n|,/', $item->kelengkapan);
                }
            }

            $kelengkapanBarang = array_filter(array_map('trim', $kelengkapanBarang));
        }
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-[410px_1fr] gap-[28px] items-start">

        <section class="bg-white border border-[#E5EAF0] rounded-[8px] px-[14px] sm:px-[22px] py-[20px] sm:py-[22px] shadow-[0px_2px_6px_rgba(0,0,0,0.10)]">
            <h2 class="text-[18px] font-bold mb-[26px]">
                Ringkasan Barang
            </h2>

            <div class="flex items-center gap-[14px] sm:gap-[18px] mb-[22px]">
                <img src="{{ $imageUrl }}"
                     alt="{{ optional($item)->name ?? 'Produk' }}"
                     class="w-[82px] h-[70px] sm:w-[100px] sm:h-[86px] rounded-[6px] object-cover flex-shrink-0">

                <div class="min-w-0">
                    <h3 class="text-[18px] font-bold leading-[24px]">
                        {{ optional($item)->name ?? '-' }}
                    </h3>

                    <div class="flex items-center gap-[8px] sm:gap-[10px] mt-[12px] text-[13px] flex-wrap">
                        <span class="text-[#696969]">
                            Disewa oleh:
                        </span>

                        <span class="font-semibold">
                            {{ optional($tenant)->name ?? '-' }}
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
                            Alamat Penyerahan
                        </span>
                    </div>

                    <p class="text-[13px] font-semibold text-right leading-[22px]">
                        {{ $alamatPengiriman }}
                    </p>
                </div>

            </div>

            <div class="border-t border-[#C3DAFE] mt-[28px] pt-[18px] flex items-center justify-between">
                <p class="text-[14px] text-[#696969] font-medium">
                    Total Pembayaran
                </p>

                <p class="text-[18px] font-bold text-[#34699A]">
                    {{ $totalHarga }}
                </p>
            </div>
        </section>

        <form id="mainConfirmForm"
              action="{{ route('transaksi.simpanKonfirmasiPenyerahan', $rental->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="bg-white border border-[#E5EAF0] rounded-[8px] px-[14px] sm:px-[26px] py-[22px] shadow-[0px_2px_6px_rgba(0,0,0,0.10)]">

            @csrf
            @method('PUT')

            <div class="mb-[22px]">
                <h2 class="text-[18px] font-bold text-[#1E1E1E] mb-[10px]">
                    Bukti Penyerahan
                    <span class="text-[#E3455D]">*</span>
                </h2>

                <p class="text-[14px] text-[#5F6B7A] leading-[24px] mb-[18px]">
                    Upload minimal 3 foto yang memperlihatkan kondisi barang saat akan diserahkan.
                </p>

                <label class="w-full min-h-[178px] border-2 border-dashed border-[#34699A] rounded-[8px] bg-[#F8FAFC] flex flex-col items-center justify-center cursor-pointer px-[14px] py-[18px]">
                    <img src="{{ asset('assets/icons/icon-upload-image.png') }}"
                        class="w-[42px] h-[42px] object-contain mb-[14px]"
                        alt="Upload">

                    <p class="text-[20px] font-semibold text-[#000000] leading-none">
                        Upload Foto Bukti
                    </p>

                    <p class="text-[13px] text-[#8A8A8A] mt-[8px]">
                        JPEG, PNG, or PDF (Max 10MB)
                    </p>

                    <input type="file"
                        name="foto_bukti[]"
                        class="hidden js-upload-input"
                        multiple
                        required
                        accept="image/*,.pdf">
                </label>

                <div class="js-preview-wrapper grid grid-cols-3 gap-[10px] mt-[14px]"></div>

                <p class="js-upload-error hidden text-[12px] text-[#E3455D] font-semibold mt-[10px]">
                    Minimal upload 3 foto dokumentasi.
                </p>
            </div>

            <div class="mb-[22px]">
                <label class="block text-[18px] font-bold mb-[10px]">
                    Checklist Kelengkapan Barang
                </label>

                <p class="text-[14px] text-[#696969] leading-[20px] mb-[12px]">
                    Centang kelengkapan barang yang diserahkan kepada penyewa.
                </p>

                @if(count($kelengkapanBarang) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-[10px]">
                        @foreach($kelengkapanBarang as $kelengkapan)
                            <label class="border border-[#C3DAFE] rounded-[8px] px-[12px] py-[10px] text-[13px] font-medium cursor-pointer">
                                <input type="checkbox"
                                       name="kelengkapan_keluar[]"
                                       value="{{ $kelengkapan }}"
                                       class="mr-[8px]">
                                {{ $kelengkapan }}
                            </label>
                        @endforeach
                    </div>
                @else
                    <div class="bg-[#FFF3C4] text-[#8A6400] rounded-[8px] px-[14px] py-[12px]">
                        <p class="text-[12px] font-medium leading-[20px]">
                            Data kelengkapan barang belum tersedia dari form create barang.
                        </p>
                    </div>
                @endif
            </div>

            <div class="bg-[#EAF3FF] text-[#34699A] rounded-[8px] px-[14px] py-[12px] flex items-start gap-[10px] mb-[22px]">
                <img src="{{ asset('assets/icons/icon-info-blue.png') }}"
                     class="w-[18px] h-[18px] object-contain mt-[2px]"
                     alt="Info">

                <p class="text-[12px] font-semibold leading-[20px]">
                    Setelah penyerahan dikonfirmasi, penyewa akan diminta mengonfirmasi penerimaan barang.
                </p>
            </div>

            <div class="flex justify-end gap-[10px]">
                <a href="{{ route('riwayat.transaksi.penyewa') }}"
                   class="h-[42px] px-[22px] rounded-[8px] border border-[#34699A] text-[#34699A] text-[13px] font-semibold flex items-center">
                    Batal
                </a>

                <button type="button"
                        onclick="openConfirmModal()"
                        class="h-[42px] px-[22px] rounded-[8px] bg-[#34699A] text-white text-[13px] font-semibold">
                    Konfirmasi Penyerahan
                </button>
            </div>
        </form>
    </div>
</main>

@include('layouts.partials.footer')

@if(session('success_title') || session('success_message'))
    <div id="successModal"
         class="fixed inset-0 bg-black/40 flex items-center justify-center z-[9999] px-[20px]">
        <div class="bg-white rounded-[12px] w-full max-w-[320px] px-[24px] py-[30px] text-center shadow-[0px_8px_24px_rgba(0,0,0,0.18)]">

            <div class="w-[64px] h-[64px] rounded-full bg-[#34699A] mx-auto mb-[20px] flex items-center justify-center">
                <span class="text-white text-[34px] font-bold leading-none">✓</span>
            </div>

            <h3 class="text-[15px] font-bold text-[#34699A] mb-[8px]">
                {{ session('success_title', 'Konfirmasi Penyerahan Berhasil') }}
            </h3>

            <p class="text-[12px] text-[#696969] leading-[20px] mb-[22px]">
                {{ session('success_message', session('success', 'Data penyerahan barang berhasil disimpan.')) }}
            </p>

            <button type="button"
                    onclick="document.getElementById('successModal').remove()"
                    class="h-[32px] px-[22px] rounded-[6px] bg-[#34699A] text-white text-[12px] font-semibold">
                Selesai
            </button>
        </div>
    </div>
@endif

<div id="confirmModal"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-[9999] px-[20px]">
    <div class="bg-white rounded-[12px] w-full max-w-[320px] px-[24px] py-[28px] text-center">
        <img src="{{ asset('assets/icons/icon-question.png') }}"
             class="w-[54px] h-[54px] object-contain mx-auto mb-[18px]"
             alt="Konfirmasi">

        <h3 class="text-[15px] font-bold text-[#34699A] mb-[8px]">
            Yakin konfirmasi penyerahan?
        </h3>

        <p class="text-[12px] text-[#696969] leading-[20px] mb-[22px]">
            Pastikan barang sudah diserahkan dan dokumentasi yang diunggah sudah benar.
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
                Ya, Konfirmasi
            </button>
        </div>
    </div>
</div>

<script>
    const selectedFilesMap = new WeakMap();

    document.querySelectorAll('.js-upload-input').forEach(function (input) {
        selectedFilesMap.set(input, []);

        input.addEventListener('change', function () {
            const form = input.closest('form');
            const wrapper = form.querySelector('.js-preview-wrapper');
            const errorText = form.querySelector('.js-upload-error');

            const oldFiles = selectedFilesMap.get(input) || [];
            const newFiles = Array.from(input.files);

            newFiles.forEach(function (file) {
                const isDuplicate = oldFiles.some(function (existingFile) {
                    return existingFile.name === file.name
                        && existingFile.size === file.size
                        && existingFile.lastModified === file.lastModified;
                });

                if (!isDuplicate) {
                    oldFiles.push(file);
                }
            });

            selectedFilesMap.set(input, oldFiles);
            updateInputFiles(input);
            renderPreview(input, wrapper);
            validateUpload(input, errorText, false);
        });
    });

    function updateInputFiles(input) {
        const dataTransfer = new DataTransfer();
        const files = selectedFilesMap.get(input) || [];

        files.forEach(function (file) {
            dataTransfer.items.add(file);
        });

        input.files = dataTransfer.files;
    }

    function renderPreview(input, wrapper) {
        if (!wrapper) {
            return;
        }

        const files = selectedFilesMap.get(input) || [];

        wrapper.innerHTML = '';

        files.forEach(function (file, index) {
            const item = document.createElement('div');
            item.className = 'relative w-full h-[96px] rounded-[8px] border border-[#D7DCE3] bg-white overflow-hidden flex items-center justify-center text-[11px] text-[#6B7280]';

            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = 'w-full h-full object-cover';
                img.alt = file.name;
                item.appendChild(img);
            } else {
                item.innerText = file.name;
            }

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.innerHTML = '×';
            removeBtn.className = 'absolute top-[4px] right-[4px] w-[22px] h-[22px] rounded-full bg-[#E3455D] text-white text-[14px] leading-none flex items-center justify-center';

            removeBtn.addEventListener('click', function () {
                const currentFiles = selectedFilesMap.get(input) || [];
                currentFiles.splice(index, 1);

                selectedFilesMap.set(input, currentFiles);
                updateInputFiles(input);
                renderPreview(input, wrapper);

                const form = input.closest('form');
                const errorText = form.querySelector('.js-upload-error');

                validateUpload(input, errorText, false);
            });

            item.appendChild(removeBtn);
            wrapper.appendChild(item);
        });
    }

    function validateUpload(input, errorText, showError = true) {
        const files = selectedFilesMap.get(input) || Array.from(input.files);

        if (files.length < 3) {
            if (showError && errorText) {
                errorText.classList.remove('hidden');
                errorText.textContent = 'Minimal upload 3 foto dokumentasi.';
            }

            return false;
        }

        const isOverLimit = files.some(function (file) {
            return file.size > 10 * 1024 * 1024;
        });

        if (isOverLimit) {
            if (showError && errorText) {
                errorText.classList.remove('hidden');
                errorText.textContent = 'Ukuran maksimal setiap file adalah 10MB.';
            }

            return false;
        }

        if (errorText) {
            errorText.classList.add('hidden');
        }

        return true;
    }

    function openConfirmModal() {
        const form = document.getElementById('mainConfirmForm');
        const fileInput = form.querySelector('input[name="foto_bukti[]"]');
        const errorText = form.querySelector('.js-upload-error');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        if (fileInput && !validateUpload(fileInput, errorText, true)) {
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
        const form = document.getElementById('mainConfirmForm');
        const fileInput = form.querySelector('input[name="foto_bukti[]"]');
        const errorText = form.querySelector('.js-upload-error');

        if (fileInput && !validateUpload(fileInput, errorText, true)) {
            return;
        }

        form.submit();
    }
</script>

</body>
</html>