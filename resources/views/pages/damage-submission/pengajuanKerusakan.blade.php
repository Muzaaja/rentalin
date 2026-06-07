<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengajuan Kerusakan</title>
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
        Kode gambar item dari teman kamu:
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

    function documentUrlPengajuanKerusakanView($path)
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
        ) {
            return asset('storage/' . $path);
        }

        return asset('storage/' . $path);
    }

    /*
        Foto sebelum:
        diambil dari database dokumentasi awal.
        Prioritas:
        owner_shipping / owner_handover / tenant_acceptance
    */
    $beforeDocuments = $documents
        ->whereIn('process', ['owner_shipping', 'owner_handover', 'tenant_acceptance'])
        ->values();

    $beforePreview = $beforeDocuments->take(3);

    /*
        Kelengkapan barang:
        diambil dari item->kelengkapan.
        Kalau masih string JSON, decode dulu.
    */
    $kelengkapanBarang = optional($item)->kelengkapan ?? [];

    if (is_string($kelengkapanBarang)) {
        $decoded = json_decode($kelengkapanBarang, true);
        $kelengkapanBarang = is_array($decoded) ? $decoded : [];
    }

    if (!is_array($kelengkapanBarang)) {
        $kelengkapanBarang = [];
    }

    $isPaylater = optional($payment)->payment_type === 'paylater';

    $nextDueDate = optional($payment)->next_due_date
        ? Carbon::parse($payment->next_due_date)->format('d M Y')
        : '-';
@endphp

<main class="w-full max-w-[435px] sm:max-w-[940px] lg:max-w-[1220px] mx-auto px-[20px] sm:px-[44px] lg:px-[66px] pt-[28px] pb-[70px]">

    {{-- Header --}}
    <div class="flex items-center gap-[12px] mb-[24px]">
        <a href="{{ route('riwayat.transaksi.pemilik') }}"
           class="w-[34px] h-[34px] flex items-center justify-center shrink-0">
            <img src="{{ asset('assets/icons/icon-back.png') }}"
                 class="w-[28px] h-[28px] object-contain"
                 alt="Kembali">
        </a>

        <div>
            <h1 class="text-[22px] sm:text-[24px] font-bold leading-[32px]">
                Pengajuan Kerusakan
            </h1>

            <p class="text-[13px] text-[#6B7280] mt-[3px]">
                Ajukan klaim jika barang kembali dalam kondisi rusak atau tidak lengkap.
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

    @if($errors->any())
        <div class="mb-[18px] bg-[#FFECEF] border border-[#F4B8C2] text-[#E3455D] px-[14px] py-[12px] rounded-[8px] text-[13px] font-semibold">
            <p class="mb-[6px]">
                Ada data yang belum sesuai:
            </p>

            <ul class="list-disc pl-[18px] space-y-[4px]">
                @foreach($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="mainConfirmForm"
          action="{{ route('transaksi.simpanPengajuanKerusakan', $rental->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="grid grid-cols-1 lg:grid-cols-[1fr_0.78fr] gap-[18px]">

        @csrf

        {{-- Kiri --}}
        <section class="space-y-[18px]">

            {{-- Info --}}
            <section class="bg-[#FFF3C4] border border-[#F6D36A] rounded-[10px] px-[16px] sm:px-[20px] py-[14px] flex items-start gap-[12px]">
                <img src="{{ asset('assets/icons/icon-warning-yellow.png') }}"
                     class="w-[28px] h-[28px] object-contain shrink-0"
                     alt="Peringatan">

                <div>
                    <h2 class="text-[15px] font-bold text-[#7A5200]">
                        Pastikan bukti kerusakan jelas
                    </h2>

                    <p class="text-[12px] text-[#7A5200] leading-[20px] mt-[4px]">
                        Upload minimal 3 foto bukti kerusakan. Klaim ini akan ditampilkan kepada penyewa untuk disetujui.
                    </p>
                </div>
            </section>

            {{-- Ringkasan Barang --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <div class="flex items-start justify-between gap-[12px] mb-[14px]">
                    <div>
                        <h2 class="text-[16px] font-bold">
                            Ringkasan Barang
                        </h2>

                        <p class="text-[12px] text-[#6B7280] mt-[4px]">
                            ID Transaksi: {{ $rental->rental_code }}
                        </p>
                    </div>

                    <span class="h-[26px] px-[12px] rounded-full text-[11px] font-semibold bg-[#E9E1FF] text-[#6B4BC3] shrink-0">
                        Pengembalian
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
                                Penyewa: {{ optional($tenant)->name ?? '-' }}
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
            </section>

            {{-- Foto Kondisi Sebelum --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <div class="flex items-start justify-between gap-[12px] mb-[14px]">
                    <div>
                        <h2 class="text-[16px] font-bold">
                            Foto Kondisi Sebelum
                        </h2>

                        <p class="text-[12px] text-[#6B7280] mt-[4px]">
                            Foto ini diambil dari dokumentasi awal transaksi, jadi pemilik tidak perlu upload ulang.
                        </p>
                    </div>

                    @if($beforeDocuments->count() > 3)
                        <button type="button"
                                onclick="openBeforeModal()"
                                class="text-[12px] text-[#34699A] font-semibold underline shrink-0">
                            Lihat Semua
                        </button>
                    @endif
                </div>

                @if($beforePreview->count() > 0)
                    <div class="grid grid-cols-3 gap-[8px]">
                        @foreach($beforePreview as $document)
                            @php
                                $documentPath = $document->file_path
                                    ?? $document->image
                                    ?? $document->path
                                    ?? null;
                            @endphp

                            <button type="button"
                                    onclick="openImagePreview('{{ documentUrlPengajuanKerusakanView($documentPath) }}')"
                                    class="h-[88px] sm:h-[110px] rounded-[8px] overflow-hidden border border-[#D7E5FA] bg-[#F8FBFF]">
                                <img src="{{ documentUrlPengajuanKerusakanView($documentPath) }}"
                                     class="w-full h-full object-cover"
                                     alt="Foto Sebelum">
                            </button>
                        @endforeach
                    </div>
                @else
                    <div class="bg-[#F8FBFF] border border-[#D7E5FA] rounded-[8px] px-[14px] py-[18px] text-center">
                        <p class="text-[12px] text-[#6B7280]">
                            Dokumentasi kondisi awal belum tersedia.
                        </p>
                    </div>
                @endif
            </section>

            {{-- Form Pengajuan dalam satu card --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[5px]">
                    Form Klaim Kerusakan
                </h2>

                <p class="text-[12px] text-[#6B7280] mb-[16px]">
                    Isi detail kerusakan berdasarkan kondisi barang saat kembali.
                </p>

                {{-- Jenis kerusakan --}}
                <div>
                    <label class="block text-[13px] font-bold mb-[8px]">
                        Jenis Kerusakan
                        <span class="text-[#E3455D]">*</span>
                    </label>

                    <select name="damage_type"
                            required
                            class="w-full h-[42px] rounded-[8px] border border-[#C3DAFE] px-[12px] text-[13px] outline-none focus:border-[#34699A]">
                        <option value="">Pilih jenis kerusakan</option>
                        <option value="Barang rusak ringan">Barang rusak ringan</option>
                        <option value="Barang rusak berat">Barang rusak berat</option>
                        <option value="Kelengkapan hilang">Kelengkapan hilang</option>
                        <option value="Barang tidak berfungsi">Barang tidak berfungsi</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                {{-- Divider --}}
                <div class="border-t border-[#D7E5FA] pt-[16px] mt-[16px]">
                    <label class="block text-[13px] font-bold mb-[8px]">
                        Bagian Rusak / Hilang
                        <span class="text-[#E3455D]">*</span>
                    </label>

                    <input type="text"
                           name="damage_part"
                           required
                           placeholder="Contoh: Lensa, kabel charger, bagian kaki tripod"
                           class="w-full h-[42px] rounded-[8px] border border-[#C3DAFE] px-[12px] text-[13px] outline-none focus:border-[#34699A]">
                </div>

                {{-- Divider --}}
                <div class="border-t border-[#D7E5FA] pt-[16px] mt-[16px]">
                    <label class="block text-[13px] font-bold mb-[8px]">
                        Biaya Kerusakan
                        <span class="text-[#E3455D]">*</span>
                    </label>

                    <input type="number"
                           name="repair_fee"
                           min="0"
                           required
                           placeholder="Masukkan nominal biaya kerusakan"
                           class="w-full h-[42px] rounded-[8px] border border-[#C3DAFE] px-[12px] text-[13px] outline-none focus:border-[#34699A]">
                </div>

                {{-- Divider --}}
                <div class="border-t border-[#D7E5FA] pt-[16px] mt-[16px]">
                    <label class="block text-[13px] font-bold mb-[8px]">
                        Deskripsi Kerusakan
                        <span class="text-[#E3455D]">*</span>
                    </label>

                    <textarea name="description"
                              rows="4"
                              required
                              placeholder="Jelaskan kondisi kerusakan secara singkat dan jelas."
                              class="w-full rounded-[8px] border border-[#C3DAFE] px-[12px] py-[12px] text-[13px] outline-none focus:border-[#34699A]"></textarea>
                </div>

                {{-- Checklist kelengkapan --}}
                <div class="border-t border-[#D7E5FA] pt-[16px] mt-[16px]">
                    <label class="block text-[13px] font-bold mb-[8px]">
                        Checklist Kelengkapan Barang
                        <span class="text-[#E3455D]">*</span>
                    </label>

                    <p class="text-[12px] text-[#6B7280] leading-[20px] mb-[12px]">
                        Checklist ini diambil dari kelengkapan barang yang dibuat pemilik saat menambahkan barang.
                    </p>

                    @if(count($kelengkapanBarang) > 0)
                        <div class="space-y-[9px]">
                            @foreach($kelengkapanBarang as $kelengkapan)
                                <label class="flex items-center gap-[9px] text-[13px]">
                                    <input type="checkbox"
                                           name="returned_checklist[]"
                                           value="{{ $kelengkapan }}"
                                           class="shrink-0">
                                    <span>
                                        {{ $kelengkapan }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-[#F8FBFF] border border-[#D7E5FA] rounded-[8px] px-[14px] py-[12px]">
                            <p class="text-[12px] text-[#6B7280] leading-[20px]">
                                Data kelengkapan barang belum tersedia. Kamu tetap bisa lanjut mengajukan kerusakan melalui form ini.
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Upload bukti --}}
                <div class="border-t border-[#D7E5FA] pt-[16px] mt-[16px]">
                    <label class="block text-[13px] font-bold mb-[8px]">
                        Upload Foto Bukti Kerusakan
                        <span class="text-[#E3455D]">*</span>
                    </label>

                    <p class="text-[12px] text-[#6B7280] leading-[20px] mb-[12px]">
                        Upload minimal 3 foto. Maksimal 10MB per file. Format JPG, JPEG, PNG, atau PDF.
                    </p>

                    <label class="min-h-[150px] border-2 border-dashed border-[#9DBFEA] bg-[#F8FBFF] rounded-[10px] flex flex-col items-center justify-center px-[14px] py-[18px] cursor-pointer">
                        <img src="{{ asset('assets/icons/icon-upload-blue.png') }}"
                             class="w-[36px] h-[36px] object-contain mb-[10px]"
                             alt="Upload">

                        <p class="text-[13px] font-bold text-[#34699A]">
                            Klik untuk upload bukti
                        </p>

                        <p class="text-[12px] text-[#6B7280] mt-[4px] text-center">
                            Minimal 3 foto, maksimal 10MB per file
                        </p>

                        <input type="file"
                               name="foto_bukti[]"
                               id="foto_bukti"
                               multiple
                               required
                               accept=".jpg,.jpeg,.png,.pdf"
                               class="hidden">
                    </label>

                    <p id="uploadError"
                       class="hidden text-[12px] text-[#E3455D] font-semibold mt-[10px]">
                        Minimal upload 3 file bukti.
                    </p>

                    <div id="previewContainer"
                         class="grid grid-cols-3 gap-[8px] mt-[12px]">
                    </div>
                </div>
            </section>
        </section>

        {{-- Kanan --}}
        <aside class="space-y-[18px]">

            {{-- Rangkuman --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[14px]">
                    Ringkasan Klaim
                </h2>

                <div class="space-y-[11px] text-[13px]">
                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Status Transaksi
                        </span>

                        <span class="font-semibold text-[#6B4BC3]">
                            Pengembalian
                        </span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Penyewa
                        </span>

                        <span class="font-semibold text-right">
                            {{ optional($tenant)->name ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Deposit Ditahan
                        </span>

                        <span class="font-semibold">
                            Rp500.000
                        </span>
                    </div>
                </div>

                <div class="mt-[14px] bg-[#EAF3FF] text-[#34699A] rounded-[8px] px-[14px] py-[12px] flex items-start gap-[10px]">
                    <img src="{{ asset('assets/icons/icon-info-blue.png') }}"
                         class="w-[18px] h-[18px] object-contain mt-[2px]"
                         alt="Info">

                    <p class="text-[12px] font-semibold leading-[20px]">
                        Jika biaya kerusakan lebih besar dari deposit, penyewa akan diarahkan untuk membayar tagihan tambahan.
                    </p>
                </div>
            </section>

            {{-- Info PayLater --}}
            @if($isPaylater)
                <section class="bg-[#FFF8E6] border border-[#F6D36A] rounded-[10px] px-[16px] sm:px-[20px] py-[14px] flex items-start gap-[12px]">
                    <img src="{{ asset('assets/icons/icon-paylater.png') }}"
                         class="w-[24px] h-[24px] object-contain shrink-0"
                         alt="PayLater">

                    <div>
                        <h2 class="text-[14px] font-bold text-[#7A5200]">
                            Transaksi menggunakan PayLater
                        </h2>

                        <p class="text-[12px] text-[#7A5200] leading-[20px] mt-[4px]">
                            Cicilan utama tetap berjalan. Tempo berikutnya: {{ $nextDueDate }}.
                        </p>
                    </div>
                </section>
            @endif

            {{-- Action --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <button type="button"
                        onclick="openConfirmModal()"
                        class="w-full h-[42px] rounded-[8px] bg-[#E3455D] text-white text-[13px] font-semibold">
                    Ajukan Klaim Kerusakan
                </button>

                <a href="{{ route('riwayat.transaksi.pemilik') }}"
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

        <h3 class="text-[15px] font-bold text-[#E3455D] mb-[8px]">
            Ajukan klaim kerusakan?
        </h3>

        <p class="text-[12px] text-[#696969] leading-[20px] mb-[22px]">
            Pastikan data kerusakan dan foto bukti sudah benar. Klaim akan dikirim ke penyewa untuk ditinjau.
        </p>

        <div class="grid grid-cols-2 gap-[10px]">
            <button type="button"
                    onclick="closeConfirmModal()"
                    class="h-[36px] rounded-[6px] border border-[#34699A] text-[#34699A] text-[12px] font-semibold">
                Batal
            </button>

            <button type="button"
                    onclick="submitMainForm()"
                    class="h-[36px] rounded-[6px] bg-[#E3455D] text-white text-[12px] font-semibold">
                Ya, Ajukan
            </button>
        </div>
    </div>
</div>

{{-- Modal Preview Image --}}
<div id="imagePreviewModal"
     class="fixed inset-0 bg-black/70 hidden items-center justify-center z-[10000] px-[20px]">
    <div class="relative w-full max-w-[560px]">
        <button type="button"
                onclick="closeImagePreview()"
                class="absolute top-[-42px] right-0 text-white text-[28px] font-bold">
            ×
        </button>

        <img id="imagePreviewTarget"
             src=""
             class="w-full max-h-[80vh] object-contain rounded-[10px] bg-white"
             alt="Preview">
    </div>
</div>

{{-- Modal Semua Foto Sebelum --}}
<div id="beforeModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[9998] px-[20px]">
    <div class="bg-white rounded-[12px] w-full max-w-[680px] max-h-[80vh] overflow-y-auto px-[18px] sm:px-[24px] py-[22px]">
        <div class="flex items-center justify-between gap-[12px] mb-[16px]">
            <h3 class="text-[16px] font-bold">
                Foto Kondisi Sebelum
            </h3>

            <button type="button"
                    onclick="closeBeforeModal()"
                    class="text-[24px] font-bold text-[#6B7280]">
                ×
            </button>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-[10px]">
            @foreach($beforeDocuments as $document)
                @php
                    $documentPath = $document->file_path
                        ?? $document->image
                        ?? $document->path
                        ?? null;
                @endphp

                <button type="button"
                        onclick="openImagePreview('{{ documentUrlPengajuanKerusakanView($documentPath) }}')"
                        class="h-[130px] rounded-[8px] overflow-hidden border border-[#D7E5FA] bg-[#F8FBFF]">
                    <img src="{{ documentUrlPengajuanKerusakanView($documentPath) }}"
                         class="w-full h-full object-cover"
                         alt="Foto Sebelum">
                </button>
            @endforeach
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