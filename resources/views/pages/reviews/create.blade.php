<!DOCTYPE html>
<html lang="id">
<head>
    {{-- konfigurasi halaman dan asset --}}
    <meta charset="UTF-8">
    <title>Beri Penilaian - Rentalin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">

    <style>
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 4px;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            font-size: 34px;
            color: #D1D5DB;
            cursor: pointer;
            line-height: 1;
            transition: 0.2s ease;
        }

        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input:checked ~ label {
            color: #F59E0B;
        }
    </style>
</head>

{{-- tampilan halaman --}}
<body class="bg-[#F5F7FA] text-[#1E1E1E] [font-family:'Plus_Jakarta_Sans',sans-serif]">

{{-- navbar --}}
{{-- bagian header utama dari partial navbar --}}
@include('layouts.partials.navbar')

@php
    // data utama dari controller
    use Carbon\Carbon;

    // relasi transaksi
    $item = $rental->item;
    $owner = $rental->owner;
    $toko = optional($owner)->toko;
    $itemName = optional($item)->name ?? 'Produk Rentalin';
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

    $storeName = optional($toko)->nama_toko
        ?? optional($owner)->name
        ?? 'Pemilik Rentalin';

    $startDate = $rental->start_date
        ? Carbon::parse($rental->start_date)->format('d M Y')
        : '-';

    $endDate = $rental->end_date
        ? Carbon::parse($rental->end_date)->format('d M Y')
        : '-';

    $durasi = ($rental->start_date && $rental->end_date)
        ? Carbon::parse($rental->start_date)->diffInDays(Carbon::parse($rental->end_date))
        : 0;
@endphp

{{-- konten utama --}}
<main class="w-full max-w-[1220px] mx-auto px-[16px] sm:px-[28px] md:px-[44px] lg:px-[66px] pt-[28px] pb-[70px]">

    {{-- header --}}
    <section class="mb-[24px]">
        <div class="flex items-center gap-[12px]">
            <a href="{{ route('riwayat.transaksi.penyewa') }}"
               class="w-[34px] h-[34px] flex items-center justify-center rounded-full hover:bg-[#EAF3FF] focus:outline-none focus:ring-2 focus:ring-[#34699A]/30 transition"
               aria-label="Kembali">
                <img src="{{ asset('assets/icons/icon-back.png') }}"
                     class="w-[24px] h-[24px] object-contain"
                     alt="Kembali">
            </a>

            <div>
                <h1 class="text-[22px] sm:text-[26px] font-bold">
                    Beri Penilaian
                </h1>

                <p class="text-[13px] text-[#6B7280] mt-[3px]">
                    Nilai pengalaman sewa untuk transaksi {{ $rental->rental_code ?? '-' }}.
                </p>
            </div>
        </div>
    </section>

    {{-- error --}}
    {{-- pesan error validasi --}}
    @if($errors->any())
        <div class="mb-[18px] bg-[#FFECEF] border border-[#F4B8C2] text-[#E3455D] px-[14px] py-[12px] rounded-[8px] text-[13px] font-semibold">
            <ul class="list-disc pl-[18px] space-y-[4px]">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="grid grid-cols-1 md:grid-cols-[0.8fr_1.2fr] gap-[18px] items-start">

        {{-- ringkasan --}}
        <aside class="bg-white border border-[#C3DAFE] rounded-[12px] px-[16px] sm:px-[20px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
            <h2 class="text-[16px] font-bold mb-[16px]">
                Ringkasan Barang
            </h2>

            <div class="flex gap-[12px]">
                <img src="{{ $imageUrl }}"
                     class="w-[82px] h-[82px] rounded-[8px] object-cover flex-shrink-0"
                     alt="{{ $itemName }}">

                <div class="min-w-0 flex-1">
                    <h3 class="text-[15px] font-bold leading-[21px] line-clamp-2">
                        {{ $itemName }}
                    </h3>

                    <p class="text-[12px] text-[#6B7280] mt-[6px]">
                        Disewakan oleh:
                        <span class="font-semibold text-[#1E1E1E]">
                            {{ $storeName }}
                        </span>
                    </p>

                    <p class="text-[11px] text-[#6B7280] mt-[6px] inline-flex items-center gap-[4px]">
                        <img src="{{ asset('assets/icons/icon-calendar.png') }}"
                             class="w-[12px] h-[12px] object-contain"
                             alt="Tanggal">

                        {{ $startDate }} - {{ $endDate }} • {{ $durasi }} hari
                    </p>
                </div>
            </div>

            <div class="mt-[18px] border-t border-[#D7E5FA] pt-[14px] space-y-[10px] text-[13px]">
                <div class="flex justify-between gap-[12px]">
                    <span class="text-[#6B7280]">ID Transaksi</span>
                    <span class="font-semibold text-right">{{ $rental->rental_code ?? '-' }}</span>
                </div>

                <div class="flex justify-between gap-[12px]">
                    <span class="text-[#6B7280]">Status</span>
                    <span class="font-semibold text-[#118642]">Selesai</span>
                </div>

                <div class="flex justify-between gap-[12px]">
                    <span class="text-[#6B7280]">Total Pesanan</span>
                    <span class="font-bold text-[#34699A]">Rp{{ number_format($rental->total_price ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </aside>

        {{-- form --}}
        <section class="bg-white border border-[#C3DAFE] rounded-[12px] px-[16px] sm:px-[22px] py-[20px] sm:py-[24px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
            <h2 class="text-[18px] font-bold mb-[6px]">
                Tulis Ulasan
            </h2>

            <p class="text-[13px] text-[#6B7280] leading-[20px] mb-[22px]">
                Ceritakan pengalamanmu selama menyewa barang ini.
            </p>

            {{-- form utama --}}
    <form id="reviewForm"
                  action="{{ route('ulasan.store', $rental->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                {{-- rating --}}
                <div class="mb-[22px]">
                    <label class="block text-[13px] font-bold mb-[10px]">
                        Beri rating pengalaman sewa
                        <span class="text-[#E3455D]">*</span>
                    </label>

                    <div class="star-rating">
                        <input type="radio" id="rating-5" name="rating" value="5" required>
                        <label for="rating-5">★</label>

                        <input type="radio" id="rating-4" name="rating" value="4">
                        <label for="rating-4">★</label>

                        <input type="radio" id="rating-3" name="rating" value="3">
                        <label for="rating-3">★</label>

                        <input type="radio" id="rating-2" name="rating" value="2">
                        <label for="rating-2">★</label>

                        <input type="radio" id="rating-1" name="rating" value="1">
                        <label for="rating-1">★</label>
                    </div>
                </div>

                {{-- komentar --}}
                <div class="mb-[22px]">
                    <label for="comment" class="block text-[13px] font-bold mb-[8px]">
                        Tulis pengalamanmu
                    </label>

                    <textarea name="comment"
                              id="comment"
                              rows="5"
                              placeholder="Ceritakan pengalamanmu menyewa barang ini."
                              class="w-full rounded-[8px] border border-[#C3DAFE] px-[12px] py-[12px] text-[13px] outline-none transition focus:border-[#34699A] focus:ring-2 focus:ring-[#34699A]/20">{{ old('comment') }}</textarea>
                </div>

                {{-- upload foto --}}
                <div class="mb-[26px]">
                    <label class="block text-[13px] font-bold mb-[8px]">
                        Tambahkan Foto
                        <span class="text-[#9CA3AF] font-normal">
                            (Opsional, maksimal 5 foto, 10MB/foto)
                        </span>
                    </label>

                    <label for="file-upload"
                           class="w-full min-h-[150px] border-2 border-dashed border-[#34699A] rounded-[10px] bg-[#F8FBFF] hover:bg-[#EAF3FF] cursor-pointer flex flex-col items-center justify-center text-center px-[18px] py-[24px] transition focus-within:ring-2 focus-within:ring-[#34699A]/30">
                        <img src="{{ asset('assets/icons/icon-upload-image.png') }}"
                             class="w-[34px] h-[34px] object-contain mb-[10px]"
                             alt="Upload">

                        <p class="text-[15px] font-bold text-[#1E1E1E]">
                            Upload Foto Ulasan
                        </p>

                        <p class="text-[13px] text-[#6B7280] mt-[5px]">
                            JPEG atau PNG (Maks 5 foto, 10MB/foto)
                        </p>

                        <input type="file"
                               name="images[]"
                               id="file-upload"
                               class="hidden js-review-upload-input"
                               accept="image/jpeg,image/png"
                               multiple>
                    </label>

                    <div class="mt-[10px] flex items-center justify-between gap-[12px]">
                        <p class="text-[12px] text-[#6B7280]">
                            Foto bersifat opsional.
                        </p>
                        <p class="js-review-upload-counter text-[12px] font-semibold text-[#34699A]">
                            0/5 foto
                        </p>
                    </div>

                    <p class="js-review-upload-error hidden text-[12px] text-[#E3455D] font-semibold mt-[10px]"></p>

                    <div class="js-review-preview-wrapper hidden mt-[14px] grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-[10px]"></div>
                </div>

                {{-- action --}}
                <div class="flex flex-col sm:flex-row justify-end gap-[10px]">
                    <a href="{{ route('riwayat.transaksi.penyewa') }}"
                       class="h-[40px] px-[18px] rounded-[8px] bg-white text-[#34699A] border border-[#34699A] hover:bg-[#EAF3FF] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[13px] font-semibold flex items-center justify-center">
                        Batal
                    </a>

                    <button type="submit"
                            class="h-[40px] px-[22px] rounded-[8px] bg-[#34699A] text-white border border-[#34699A] hover:bg-[#28527A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[13px] font-semibold flex items-center justify-center">
                        Kirim Ulasan
                    </button>
                </div>
            </form>
        </section>
    </section>
</main>

{{-- footer --}}
@include('layouts.partials.footer')

<script>
    // script interaksi halaman
    const reviewUploadInput = document.querySelector('.js-review-upload-input');
    const reviewPreviewWrapper = document.querySelector('.js-review-preview-wrapper');
    const reviewErrorText = document.querySelector('.js-review-upload-error');
    const reviewCounter = document.querySelector('.js-review-upload-counter');
    let reviewFiles = [];

    // tampilkan pesan error upload ulasan
    function setReviewError(message) {
        reviewErrorText.textContent = message;
        reviewErrorText.classList.remove('hidden');
    }

    // bersihkan pesan error upload ulasan
    function clearReviewError() {
        reviewErrorText.textContent = '';
        reviewErrorText.classList.add('hidden');
    }

    // masukkan ulang foto ulasan ke input file
    function updateReviewInputFiles() {
        const dataTransfer = new DataTransfer();
        reviewFiles.forEach(function (file) {
            dataTransfer.items.add(file);
        });
        reviewUploadInput.files = dataTransfer.files;
    }

    // tampilkan pratinjau foto ulasan dan tombol hapus
    function renderReviewPreviews() {
        reviewPreviewWrapper.innerHTML = '';
        reviewCounter.textContent = reviewFiles.length + '/5 foto';

        if (reviewFiles.length === 0) {
            reviewPreviewWrapper.classList.add('hidden');
            return;
        }

        reviewPreviewWrapper.classList.remove('hidden');

        reviewFiles.forEach(function (file, index) {
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
                reviewFiles.splice(index, 1);
                updateReviewInputFiles();
                renderReviewPreviews();
                clearReviewError();
            });

            const fileName = document.createElement('p');
            fileName.className = 'absolute left-0 right-0 bottom-0 bg-black/55 text-white text-[10px] px-[6px] py-[4px] truncate';
            fileName.textContent = file.name;

            item.appendChild(img);
            item.appendChild(removeBtn);
            item.appendChild(fileName);
            reviewPreviewWrapper.appendChild(item);
        });
    }

    if (reviewUploadInput) {
        // jalan saat user memilih foto ulasan
        reviewUploadInput.addEventListener('change', function () {
            clearReviewError();
            const newFiles = Array.from(reviewUploadInput.files || []);
            const allowedTypes = ['image/jpeg', 'image/png'];
            const maxSize = 10 * 1024 * 1024;

            for (const file of newFiles) {
                if (!allowedTypes.includes(file.type)) {
                    reviewUploadInput.value = '';
                    setReviewError('Format file harus JPEG atau PNG.');
                    updateReviewInputFiles();
                    renderReviewPreviews();
                    return;
                }

                if (file.size > maxSize) {
                    reviewUploadInput.value = '';
                    setReviewError('Ukuran setiap file maksimal 10MB.');
                    updateReviewInputFiles();
                    renderReviewPreviews();
                    return;
                }
            }

            if (reviewFiles.length + newFiles.length > 5) {
                reviewUploadInput.value = '';
                setReviewError('Maksimal upload 5 foto.');
                updateReviewInputFiles();
                renderReviewPreviews();
                return;
            }

            reviewFiles = reviewFiles.concat(newFiles);
            updateReviewInputFiles();
            renderReviewPreviews();
        });
    }
</script>

</body>
</html>