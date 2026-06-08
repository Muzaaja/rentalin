<!DOCTYPE html>
<html lang="id">
<head>
    {{-- konfigurasi halaman dan asset --}}
    <meta charset="UTF-8">
    <title>Pesanan Dikembalikan</title>
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

{{-- konten utama --}}
<main class="w-full max-w-[1220px] mx-auto px-[16px] sm:px-[28px] md:px-[44px] lg:px-[66px] pt-[22px] sm:pt-[38px] pb-[48px] lg:pb-[70px]">

    <div class="flex items-center gap-[14px] mb-[28px] sm:mb-[34px]">
        <a href="{{ url()->previous() }}"
           class="w-[34px] h-[34px] flex items-center justify-center">
            <img src="{{ asset('assets/icons/icon-back.png') }}"
                 class="w-[28px] h-[28px] object-contain"
                 alt="Kembali">
        </a>

        <h1 class="text-[24px] sm:text-[26px] font-bold">
            Pesanan Dikembalikan
        </h1>
    </div>

    {{-- pesan error validasi --}}
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
    // data utama dari controller
        use Carbon\Carbon;

        // relasi transaksi
    $item = $rental->item;
        $owner = $rental->owner;
        $tenant = $rental->tenant;

        // gambar barang dari CRUD atau dummy
    $itemImage = optional($item)->image;
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

    <div class="grid grid-cols-1 md:grid-cols-[410px_1fr] gap-[28px] items-start">

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
                            Disewa dari:
                        </span>

                        <img src="{{ asset('assets/icons/icon-store-small.png') }}"
                             class="w-[18px] h-[18px] object-contain flex-shrink-0"
                             alt="Store">

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
                            Alamat Pengiriman
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

        {{-- form utama --}}
    <form id="mainConfirmForm"
              action="{{ route('transaksi.simpanPesananDikembalikan', $rental->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="bg-white border border-[#E5EAF0] rounded-[8px] px-[14px] sm:px-[26px] py-[22px] shadow-[0px_2px_6px_rgba(0,0,0,0.10)]">

            @csrf
            @method('PUT')

            <div class="mb-[22px]">
                <h2 class="text-[18px] font-bold text-[#1E1E1E] mb-[10px]">
                    Bukti Pengembalian
                    <span class="text-[#E3455D]">*</span>
                </h2>

                <p class="text-[14px] text-[#5F6B7A] leading-[24px] mb-[18px]">
                    Upload minimal 3 foto yang memperlihatkan kondisi barang saat akan dikembalikan.
                </p>

                <label class="w-full min-h-[178px] border-2 border-dashed border-[#34699A] rounded-[8px] bg-[#F8FAFC] flex flex-col items-center justify-center cursor-pointer px-[14px] py-[18px]">
                    <img src="{{ asset('assets/icons/icon-upload-image.png') }}"
                        class="w-[42px] h-[42px] object-contain mb-[14px]"
                        alt="Upload">

                    <p class="text-[20px] font-semibold text-[#000000] leading-none">
                        Upload Foto Bukti
                    </p>

                    <p class="text-[13px] text-[#8A8A8A] mt-[8px]">
                        JPEG atau PNG (Max 10MB/foto)
                    </p>

                    <input type="file"
                        name="foto_bukti[]"
                        class="hidden js-upload-input"
                               data-min-files="3"
                               data-max-files="5"
                        multiple
                        required
                        accept="image/jpeg,image/png">
                </label>

                <div class="mt-[10px] flex items-center justify-between gap-[12px]">
                    <p class="text-[12px] text-[#6B7280]">
                        Minimal 3 foto, maksimal 5 foto.
                    </p>
                    <p class="js-upload-counter text-[12px] font-semibold text-[#34699A]">
                        0/5 foto
                    </p>
                </div>

                <div class="js-preview-wrapper hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-[10px] mt-[14px]"></div>

                <p class="js-upload-error hidden text-[12px] text-[#E3455D] font-semibold mt-[10px]"></p>
            </div>

            <div class="mb-[22px]">
                <label class="block text-[18px] font-bold mb-[10px]">
                    Checklist Kelengkapan Barang Kembali
                </label>

                <p class="text-[14px] text-[#696969] leading-[20px] mb-[12px]">
                    Centang kelengkapan ketika barang akan dikembalikan.
                </p>

                @if(count($kelengkapanBarang) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-[10px]">
                        @foreach($kelengkapanBarang as $kelengkapan)
                            <label class="border border-[#C3DAFE] rounded-[8px] px-[12px] py-[10px] text-[13px] font-medium cursor-pointer">
                                <input type="checkbox"
                                       name="kelengkapan_dikembalikan[]"
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
                    Setelah pesanan ditandai dikembalikan, pemilik akan memeriksa kondisi barang.
                </p>
            </div>

            <div class="flex justify-end gap-[10px]">
                <a href="{{ route('riwayat.transaksi.penyewa') }}"
                   class="h-[42px] px-[22px] rounded-[8px] border border-[#34699A] text-[#34699A] hover:bg-[#EAF3FF] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[13px] font-semibold flex items-center">
                    Batal
                </a>

                <button type="button"
                        onclick="openConfirmModal()"
                        class="h-[42px] px-[22px] rounded-[8px] bg-[#34699A] text-white hover:bg-[#28527A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[13px] font-semibold">
                    Pesanan Dikembalikan
                </button>
            </div>
        </form>
    </div>
</main>

{{-- footer --}}
@include('layouts.partials.footer')

@if(session('success_title') || session('success_message'))
    <div id="successModal"
         class="fixed inset-0 bg-black/40 flex items-center justify-center z-[9999] px-[20px]">
        <div class="bg-white border border-[#BFD8F4] rounded-[12px] w-full max-w-[320px] px-[24px] py-[28px] text-center shadow-[0px_8px_24px_rgba(0,0,0,0.18)]">

            <div class="w-[64px] h-[64px] rounded-full bg-[#34699A] mx-auto mb-[20px] flex items-center justify-center">
                <span class="text-white text-[34px] font-bold leading-none">✓</span>
            </div>

            <h3 class="text-[15px] font-bold text-[#34699A] mb-[8px]">
                {{ session('success_title', 'Pengembalian Barang Berhasil') }}
            </h3>

            <p class="text-[12px] text-[#696969] leading-[20px] mb-[22px]">
                {{ session('success_message', session('success', 'Data pengembalian barang berhasil dikirim.')) }}
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
    <div class="bg-white border border-[#BFD8F4] rounded-[12px] w-full max-w-[320px] px-[24px] py-[28px] text-center shadow-[0px_8px_24px_rgba(0,0,0,0.18)]">
        <img src="{{ asset('assets/icons/icon-question.png') }}"
             class="w-[54px] h-[54px] object-contain mx-auto mb-[18px]"
             alt="Konfirmasi">

        <h3 class="text-[15px] font-bold text-[#34699A] mb-[8px]">
            Yakin pesanan dikembalikan?
        </h3>

        <p class="text-[12px] text-[#696969] leading-[20px] mb-[22px]">
            Pastikan barang sudah dikembalikan dan dokumentasi sudah lengkap.
        </p>

        <div class="grid grid-cols-2 gap-[10px]">
            <button type="button"
                    onclick="closeConfirmModal()"
                    class="h-[36px] rounded-[6px] border border-[#34699A] text-[#34699A] hover:bg-[#EAF3FF] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold">
                Batal
            </button>

            <button type="button"
                    onclick="submitMainForm()"
                    class="h-[36px] rounded-[6px] bg-[#34699A] text-white hover:bg-[#28527A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold">
                Ya, Konfirmasi
            </button>
        </div>
    </div>
</div>

<script>
    // script interaksi halaman
    const selectedFilesMap = new WeakMap();

    // pasang event upload ke semua input foto
    document.querySelectorAll('.js-upload-input').forEach(function (input) {
        selectedFilesMap.set(input, []);

        // jalan saat user memilih foto
        input.addEventListener('change', function () {
            const oldFiles = selectedFilesMap.get(input) || [];
            const newFiles = Array.from(input.files || []);

            const mergedFiles = oldFiles.slice();

            for (const file of newFiles) {
                const isDuplicate = mergedFiles.some(function (existingFile) {
                    return existingFile.name === file.name
                        && existingFile.size === file.size
                        && existingFile.lastModified === file.lastModified;
                });

                if (!isDuplicate) {
                    mergedFiles.push(file);
                }
            }

            selectedFilesMap.set(input, mergedFiles);
            updateInputFiles(input);
            validateUpload(input, false);
            renderPreview(input);
        });
    });

    // ambil aturan upload dari atribut input
    function uploadConfig(input) {
        return {
            min: parseInt(input.dataset.minFiles || '3', 10),
            max: parseInt(input.dataset.maxFiles || '5', 10),
            maxSize: 10 * 1024 * 1024,
            allowedTypes: ['image/jpeg', 'image/png'],
        };
    }

    // ambil elemen yang berhubungan dengan upload
    function getUploadElements(input) {
        const form = input.closest('form');

        return {
            form: form,
            wrapper: form.querySelector('.js-preview-wrapper'),
            errorText: form.querySelector('.js-upload-error'),
            counter: form.querySelector('.js-upload-counter'),
        };
    }

    // sinkronkan daftar foto ke input file
    // masukkan ulang daftar foto ke input file
    function updateInputFiles(input) {
        const dataTransfer = new DataTransfer();
        const files = selectedFilesMap.get(input) || [];

        files.forEach(function (file) {
            dataTransfer.items.add(file);
        });

        input.files = dataTransfer.files;
    }

    // tampilkan pesan error upload
    function setUploadError(input, message) {
        const elements = getUploadElements(input);

        if (elements.errorText) {
            elements.errorText.textContent = message;
            elements.errorText.classList.remove('hidden');
        }
    }

    // bersihkan pesan error upload
    function clearUploadError(input) {
        const elements = getUploadElements(input);

        if (elements.errorText) {
            elements.errorText.textContent = '';
            elements.errorText.classList.add('hidden');
        }
    }

    // perbarui jumlah foto yang dipilih
    function updateCounter(input) {
        const files = selectedFilesMap.get(input) || [];
        const elements = getUploadElements(input);
        const config = uploadConfig(input);

        if (elements.counter) {
            elements.counter.textContent = files.length + '/' + config.max + ' foto';
        }
    }

    // cek minimal, maksimal, format, dan ukuran foto
    function validateUpload(input, showError = true) {
        const files = selectedFilesMap.get(input) || Array.from(input.files || []);
        const config = uploadConfig(input);

        clearUploadError(input);
        updateCounter(input);

        if (files.length < config.min) {
            if (showError) {
                setUploadError(input, 'Minimal upload 3 foto bukti.');
            }

            return false;
        }

        if (files.length > config.max) {
            setUploadError(input, 'Maksimal upload 5 foto.');
            return false;
        }

        for (const file of files) {
            if (!config.allowedTypes.includes(file.type)) {
                setUploadError(input, 'Format file harus JPEG atau PNG.');
                return false;
            }

            if (file.size > config.maxSize) {
                setUploadError(input, 'Ukuran setiap file maksimal 10MB.');
                return false;
            }
        }

        return true;
    }

    // tampilkan pratinjau foto dan tombol hapus
    function renderPreview(input) {
        const files = selectedFilesMap.get(input) || [];
        const elements = getUploadElements(input);
        const wrapper = elements.wrapper;

        updateCounter(input);

        if (!wrapper) {
            return;
        }

        wrapper.innerHTML = '';

        if (files.length === 0) {
            wrapper.classList.add('hidden');
            return;
        }

        wrapper.classList.remove('hidden');

        files.forEach(function (file, index) {
            const item = document.createElement('div');
            item.className = 'relative w-full h-[108px] rounded-[8px] border border-[#D7DCE3] bg-white overflow-hidden shadow-[0px_1px_4px_rgba(15,23,42,0.08)]';

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.className = 'w-full h-full object-cover';
            img.alt = file.name;

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.innerHTML = '×';
            removeBtn.className = 'absolute top-[6px] right-[6px] w-[24px] h-[24px] rounded-full bg-white text-[#E3455D] border border-[#E3455D] text-[18px] leading-[20px] font-bold flex items-center justify-center hover:bg-[#FFECEF] focus:outline-none focus:ring-2 focus:ring-[#F4B8C2] transition';

            removeBtn.addEventListener('click', function () {
                const currentFiles = selectedFilesMap.get(input) || [];
                currentFiles.splice(index, 1);
                selectedFilesMap.set(input, currentFiles);
                updateInputFiles(input);
                renderPreview(input);
                validateUpload(input, false);
            });

            const fileName = document.createElement('p');
            fileName.className = 'absolute left-0 right-0 bottom-0 bg-black/55 text-white text-[10px] px-[6px] py-[4px] truncate';
            fileName.textContent = file.name;

            item.appendChild(img);
            item.appendChild(removeBtn);
            item.appendChild(fileName);
            wrapper.appendChild(item);
        });
    }

    // buka popup konfirmasi
    function openConfirmModal() {
        const form = document.getElementById('mainConfirmForm');
        const fileInput = form.querySelector('input[name="foto_bukti[]"]');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        if (fileInput && !validateUpload(fileInput, true)) {
            return;
        }

        document.getElementById('confirmModal').classList.remove('hidden');
        document.getElementById('confirmModal').classList.add('flex');
    }

    // tutup popup konfirmasi
    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
        document.getElementById('confirmModal').classList.remove('flex');
    }

    // kirim form setelah user setuju
    function submitMainForm() {
        const form = document.getElementById('mainConfirmForm');
        const fileInput = form.querySelector('input[name="foto_bukti[]"]');

        if (fileInput && !validateUpload(fileInput, true)) {
            return;
        }

        form.submit();
    }
</script>

</body>
</html>