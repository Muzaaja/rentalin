<!DOCTYPE html>
<html lang="id">
<head>
    {{-- konfigurasi halaman dan asset --}}
    <meta charset="UTF-8">
    <title>Pengajuan Kerusakan</title>
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

    // relasi transaksi
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

{{-- konten utama --}}
<main class="w-full max-w-[1220px] mx-auto px-[16px] sm:px-[28px] md:px-[44px] lg:px-[66px] pt-[28px] pb-[70px]">

    {{-- header halaman --}}
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
            <div class="bg-white border border-[#BFD8F4] rounded-[12px] w-full max-w-[320px] px-[24px] py-[28px] text-center shadow-[0px_8px_24px_rgba(0,0,0,0.18)]">

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

    {{-- pesan error validasi --}}
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

    {{-- form utama --}}
    <form id="mainConfirmForm"
          action="{{ route('transaksi.simpanPengajuanKerusakan', $rental->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="grid grid-cols-1 md:grid-cols-[1fr_0.78fr] gap-[18px]">

        @csrf

        {{-- kolom kiri --}}
        <section class="space-y-[18px]">

            {{-- informasi penting --}}
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

            {{-- ringkasan barang --}}
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

            {{-- foto kondisi sebelum --}}
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

            {{-- form pengajuan dalam satu kartu --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[5px]">
                    Form Klaim Kerusakan
                </h2>

                <p class="text-[12px] text-[#6B7280] mb-[16px]">
                    Isi detail kerusakan berdasarkan kondisi barang saat kembali.
                </p>

                {{-- jenis kerusakan --}}
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

                {{-- garis pemisah --}}
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

                {{-- garis pemisah --}}
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

                {{-- garis pemisah --}}
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

                {{-- checklist kelengkapan --}}
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

                {{-- upload bukti --}}
                <div class="border-t border-[#D7E5FA] pt-[16px] mt-[16px]">
                    <label class="block text-[13px] font-bold mb-[8px]">
                        Upload Foto Bukti Kerusakan
                        <span class="text-[#E3455D]">*</span>
                    </label>

                    <p class="text-[12px] text-[#6B7280] leading-[20px] mb-[12px]">
                        Upload minimal 3 foto dan maksimal 5 foto. Ukuran setiap foto maksimal 10MB. Format file harus JPEG atau PNG.
                    </p>

                    <label class="min-h-[150px] border-2 border-dashed border-[#9DBFEA] bg-[#F8FBFF] rounded-[10px] flex flex-col items-center justify-center px-[14px] py-[18px] cursor-pointer">
                        <img src="{{ asset('assets/icons/icon-upload-image.png') }}"
                             class="w-[36px] h-[36px] object-contain mb-[10px]"
                             alt="Upload">

                        <p class="text-[13px] font-bold text-[#34699A]">
                            Klik untuk upload bukti
                        </p>

                        <p class="text-[12px] text-[#6B7280] mt-[4px] text-center">
                            Minimal 3 foto, maksimal 5 foto, 10MB/foto
                        </p>

                        <input type="file"
                               name="foto_bukti[]"
                               id="foto_bukti"
                               multiple
                               required
                               accept="image/jpeg,image/png"
                               class="hidden js-upload-input"
                               data-min-files="3"
                               data-max-files="5">
                    </label>

                    <div class="mt-[10px] flex items-center justify-between gap-[12px]">
                        <p class="text-[12px] text-[#6B7280]">
                            Minimal 3 foto, maksimal 5 foto.
                        </p>
                        <p class="js-upload-counter text-[12px] font-semibold text-[#34699A]">
                            0/5 foto
                        </p>
                    </div>

                    <p class="js-upload-error hidden text-[12px] text-[#E3455D] font-semibold mt-[10px]"></p>

                    <div class="js-preview-wrapper hidden grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-[10px] mt-[14px]">
                    </div>
                </div>
            </section>
        </section>

        {{-- kolom kanan --}}
        <aside class="space-y-[18px]">

            {{-- rangkuman --}}
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

            {{-- info paylater --}}
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

            {{-- tombol aksi --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <button type="button"
                        onclick="openConfirmModal()"
                        class="w-full h-[42px] rounded-[8px] bg-[#E3455D] text-white text-[13px] font-semibold">
                    Ajukan Klaim Kerusakan
                </button>

                <a href="{{ route('riwayat.transaksi.pemilik') }}"
                   class="w-full h-[42px] rounded-[8px] border border-[#34699A] text-[#34699A] hover:bg-[#EAF3FF] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[13px] font-semibold flex items-center justify-center mt-[10px]">
                    Batal
                </a>
            </section>
        </aside>
    </form>
</main>

{{-- footer --}}
@include('layouts.partials.footer')

{{-- popup konfirmasi --}}
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
                    class="h-[36px] rounded-[6px] border border-[#34699A] text-[#34699A] hover:bg-[#EAF3FF] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold">
                Batal
            </button>

            <button type="button"
                    onclick="submitMainForm()"
                    class="h-[36px] rounded-[6px] bg-[#E3455D] text-white hover:bg-[#28527A] focus:outline-none focus:ring-2 focus:ring-[#7BAFE3] focus:ring-offset-2 transition text-[12px] font-semibold">
                Ya, Ajukan
            </button>
        </div>
    </div>
</div>

{{-- popup pratinjau gambar --}}
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

{{-- popup semua foto sebelum --}}
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