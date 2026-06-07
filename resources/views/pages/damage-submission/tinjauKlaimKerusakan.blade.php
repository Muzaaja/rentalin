<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tinjau Klaim Kerusakan</title>
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
    $claim = $rental->damageClaim;
    $documents = $rental->documents ?? collect();

    $damageFee = optional($claim)->repair_fee ?? $rental->damage_fee ?? 0;
    $deposit = 500000;
    $sisaTagihan = max($damageFee - $deposit, 0);

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

    function documentUrlKlaimView($path)
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
        diambil dari dokumentasi awal yang sudah ada di database.
        Prioritas:
        1. owner_shipping
        2. owner_handover
        3. tenant_acceptance

        Foto sesudah:
        diambil dari damage_claim atau owner_return_check.
    */
    $beforeDocuments = $documents
        ->whereIn('process', ['owner_shipping', 'owner_handover', 'tenant_acceptance'])
        ->values();

    $afterDocuments = $documents
        ->whereIn('process', ['damage_claim', 'owner_return_check'])
        ->values();

    $beforePreview = $beforeDocuments->take(3);
    $afterPreview = $afterDocuments->take(3);

    $isPaylater = optional($payment)->payment_type === 'paylater';

    $nextDueDate = optional($payment)->next_due_date
        ? Carbon::parse($payment->next_due_date)->format('d M Y')
        : '-';
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
                Tinjau Klaim Kerusakan
            </h1>

            <p class="text-[13px] text-[#6B7280] mt-[3px]">
                Periksa detail klaim kerusakan dari pemilik.
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
          action="{{ route('transaksi.setujuiKlaim', $rental->id) }}"
          method="POST"
          class="grid grid-cols-1 lg:grid-cols-[1fr_0.78fr] gap-[18px]">

        @csrf
        @method('PUT')

        {{-- Kiri --}}
        <section class="space-y-[18px]">

            {{-- Info wajib setuju --}}
            <section class="bg-[#FFF3C4] border border-[#F6D36A] rounded-[10px] px-[16px] sm:px-[20px] py-[14px] flex items-start gap-[12px]">
                <img src="{{ asset('assets/icons/icon-warning-yellow.png') }}"
                     class="w-[28px] h-[28px] object-contain shrink-0"
                     alt="Peringatan">

                <div>
                    <h2 class="text-[15px] font-bold text-[#7A5200]">
                        Klaim kerusakan wajib disetujui
                    </h2>

                    <p class="text-[12px] text-[#7A5200] leading-[20px] mt-[4px]">
                        Pada alur Rentalin saat ini, penyewa wajib menyetujui klaim kerusakan. Jika terdapat tagihan tambahan, sistem akan mengarahkan ke halaman pembayaran.
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

                    <span class="h-[26px] px-[12px] rounded-full text-[11px] font-semibold bg-[#FFD6DE] text-[#E3455D] shrink-0">
                        Kerusakan
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
                                Pemilik: {{ optional($owner)->name ?? '-' }}
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

            {{-- Detail Klaim --}}
            <section class="bg-white border border-[#FFD6DE] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold text-[#E3455D] mb-[14px]">
                    Detail Klaim Kerusakan
                </h2>

                <div class="space-y-[11px] text-[13px]">
                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Jenis Kerusakan
                        </span>

                        <span class="font-semibold text-right">
                            {{ optional($claim)->damage_type ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Bagian Rusak / Hilang
                        </span>

                        <span class="font-semibold text-right">
                            {{ optional($claim)->damage_part ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Status Klaim
                        </span>

                        <span class="font-semibold text-[#D38A00]">
                            {{ ucfirst(str_replace('_', ' ', optional($claim)->status ?? 'submitted')) }}
                        </span>
                    </div>

                    <div class="border-t border-[#FFD6DE] pt-[11px] flex justify-between gap-[12px]">
                        <span class="font-bold">
                            Biaya Kerusakan
                        </span>

                        <span class="font-bold text-[#E3455D]">
                            Rp{{ number_format($damageFee, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="mt-[14px] bg-[#FFECEF] rounded-[8px] px-[14px] py-[12px]">
                    <p class="text-[12px] font-bold text-[#E3455D] mb-[5px]">
                        Deskripsi Kerusakan
                    </p>

                    <p class="text-[12px] text-[#E3455D] leading-[20px]">
                        {{ optional($claim)->description ?? $rental->damage_description ?? 'Belum ada deskripsi kerusakan.' }}
                    </p>
                </div>
            </section>

            {{-- Foto Sebelum --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <div class="flex items-start justify-between gap-[12px] mb-[14px]">
                    <div>
                        <h2 class="text-[16px] font-bold">
                            Foto Kondisi Sebelum
                        </h2>

                        <p class="text-[12px] text-[#6B7280] mt-[4px]">
                            Diambil dari dokumentasi awal transaksi.
                        </p>
                    </div>

                    @if($beforeDocuments->count() > 3)
                        <button type="button"
                                onclick="openDocumentModal('before')"
                                class="text-[12px] font-semibold text-[#34699A] underline shrink-0">
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
                                    onclick="openImagePreview('{{ documentUrlKlaimView($documentPath) }}')"
                                    class="h-[88px] sm:h-[110px] rounded-[8px] overflow-hidden border border-[#D7E5FA] bg-[#F8FBFF]">
                                <img src="{{ documentUrlKlaimView($documentPath) }}"
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

            {{-- Foto Sesudah --}}
            <section class="bg-white border border-[#FFD6DE] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <div class="flex items-start justify-between gap-[12px] mb-[14px]">
                    <div>
                        <h2 class="text-[16px] font-bold text-[#E3455D]">
                            Foto Bukti Kerusakan
                        </h2>

                        <p class="text-[12px] text-[#6B7280] mt-[4px]">
                            Diunggah pemilik saat pengajuan kerusakan.
                        </p>
                    </div>

                    @if($afterDocuments->count() > 3)
                        <button type="button"
                                onclick="openDocumentModal('after')"
                                class="text-[12px] font-semibold text-[#34699A] underline shrink-0">
                            Lihat Semua
                        </button>
                    @endif
                </div>

                @if($afterPreview->count() > 0)
                    <div class="grid grid-cols-3 gap-[8px]">
                        @foreach($afterPreview as $document)
                            @php
                                $documentPath = $document->file_path
                                    ?? $document->image
                                    ?? $document->path
                                    ?? null;
                            @endphp

                            <button type="button"
                                    onclick="openImagePreview('{{ documentUrlKlaimView($documentPath) }}')"
                                    class="h-[88px] sm:h-[110px] rounded-[8px] overflow-hidden border border-[#FFD6DE] bg-[#FFF8FA]">
                                <img src="{{ documentUrlKlaimView($documentPath) }}"
                                     class="w-full h-full object-cover"
                                     alt="Foto Kerusakan">
                            </button>
                        @endforeach
                    </div>
                @else
                    <div class="bg-[#FFF8FA] border border-[#FFD6DE] rounded-[8px] px-[14px] py-[18px] text-center">
                        <p class="text-[12px] text-[#E3455D]">
                            Foto bukti kerusakan belum tersedia.
                        </p>
                    </div>
                @endif
            </section>
        </section>

        {{-- Kanan --}}
        <aside class="space-y-[18px]">

            {{-- Rincian Biaya --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[14px]">
                    Rincian Biaya
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
                            Deposit Ditahan
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
                            Rp{{ number_format($sisaTagihan, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                @if($sisaTagihan > 0)
                    <div class="mt-[14px] bg-[#FFF3C4] border border-[#F6D36A] rounded-[8px] px-[14px] py-[12px]">
                        <p class="text-[12px] text-[#7A5200] font-semibold leading-[20px]">
                            Karena biaya kerusakan lebih besar dari deposit, Anda perlu membayar sisa tagihan setelah menyetujui klaim.
                        </p>
                    </div>
                @else
                    <div class="mt-[14px] bg-[#E8F8EF] border border-[#B7E8C8] rounded-[8px] px-[14px] py-[12px]">
                        <p class="text-[12px] text-[#118642] font-semibold leading-[20px]">
                            Biaya kerusakan dapat ditutup oleh deposit. Tidak ada tagihan tambahan.
                        </p>
                    </div>
                @endif
            </section>

            {{-- Info PayLater --}}
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
                            Detail cicilan dapat dilihat di halaman Profil.
                        </p>

                        <a href="{{ route('profile.edit') }}#cicilan"
                           class="mt-[8px] inline-flex text-[12px] text-[#34699A] font-semibold underline">
                            Lihat Detail Cicilan
                        </a>
                    </div>
                </section>
            @endif

            {{-- Persetujuan --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[14px]">
                    Persetujuan Klaim
                </h2>

                <label class="flex items-start gap-[10px] cursor-pointer">
                    <input type="checkbox"
                           name="agreement"
                           value="setuju"
                           required
                           class="mt-[4px]">

                    <span class="text-[12px] text-[#6B7280] leading-[20px]">
                        Saya memahami dan menyetujui klaim kerusakan yang diajukan pemilik. Saya bersedia melanjutkan pembayaran tagihan tambahan jika diperlukan.
                    </span>
                </label>

                <div class="mt-[14px] bg-[#EAF3FF] text-[#34699A] rounded-[8px] px-[14px] py-[12px] flex items-start gap-[10px]">
                    <img src="{{ asset('assets/icons/icon-info-blue.png') }}"
                         class="w-[18px] h-[18px] object-contain mt-[2px]"
                         alt="Info">

                    <p class="text-[12px] font-semibold leading-[20px]">
                        Setelah klaim disetujui, sistem akan menentukan apakah transaksi langsung selesai atau perlu pembayaran tambahan.
                    </p>
                </div>
            </section>

            {{-- Action --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <button type="button"
                        onclick="openConfirmModal()"
                        class="w-full h-[42px] rounded-[8px] bg-[#34699A] text-white text-[13px] font-semibold">
                    Setujui Klaim
                </button>

                <a href="{{ route('transaksi.detail', $rental->id) }}"
                   class="w-full h-[42px] rounded-[8px] border border-[#34699A] text-[#34699A] text-[13px] font-semibold flex items-center justify-center mt-[10px]">
                    Kembali
                </a>
            </section>
        </aside>
    </form>
</main>

@include('layouts.partials.footer')

{{-- Modal konfirmasi --}}
<div id="confirmModal"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-[9999] px-[20px]">
    <div class="bg-white rounded-[12px] w-full max-w-[330px] px-[24px] py-[28px] text-center">
        <img src="{{ asset('assets/icons/icon-question.png') }}"
             class="w-[54px] h-[54px] object-contain mx-auto mb-[18px]"
             alt="Konfirmasi">

        <h3 class="text-[15px] font-bold text-[#34699A] mb-[8px]">
            Setujui klaim kerusakan?
        </h3>

        <p class="text-[12px] text-[#696969] leading-[20px] mb-[22px]">
            Setelah disetujui, klaim akan diproses. Jika ada tagihan tambahan, Anda akan diarahkan ke halaman pembayaran.
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
                Ya, Setuju
            </button>
        </div>
    </div>
</div>

{{-- Modal preview gambar --}}
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

{{-- Modal semua dokumentasi --}}
<div id="documentModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[9998] px-[20px]">
    <div class="bg-white rounded-[12px] w-full max-w-[680px] max-h-[80vh] overflow-y-auto px-[18px] sm:px-[24px] py-[22px]">
        <div class="flex items-center justify-between gap-[12px] mb-[16px]">
            <h3 id="documentModalTitle" class="text-[16px] font-bold">
                Dokumentasi
            </h3>

            <button type="button"
                    onclick="closeDocumentModal()"
                    class="text-[24px] font-bold text-[#6B7280]">
                ×
            </button>
        </div>

        <div id="documentModalGrid" class="grid grid-cols-2 sm:grid-cols-3 gap-[10px]"></div>
    </div>
</div>

<script>
    const documentGroups = {
        before: {
            title: 'Foto Kondisi Sebelum',
            items: [
                @foreach($beforeDocuments as $document)
                    @php
                        $documentPath = $document->file_path
                            ?? $document->image
                            ?? $document->path
                            ?? null;
                    @endphp
                    "{{ documentUrlKlaimView($documentPath) }}",
                @endforeach
            ]
        },
        after: {
            title: 'Foto Bukti Kerusakan',
            items: [
                @foreach($afterDocuments as $document)
                    @php
                        $documentPath = $document->file_path
                            ?? $document->image
                            ?? $document->path
                            ?? null;
                    @endphp
                    "{{ documentUrlKlaimView($documentPath) }}",
                @endforeach
            ]
        }
    };

    function openConfirmModal() {
        const form = document.getElementById('mainConfirmForm');

        if (!form.checkValidity()) {
            form.reportValidity();
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

    function openImagePreview(url) {
        const modal = document.getElementById('imagePreviewModal');
        const target = document.getElementById('imagePreviewTarget');

        target.src = url;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeImagePreview() {
        const modal = document.getElementById('imagePreviewModal');
        const target = document.getElementById('imagePreviewTarget');

        target.src = '';
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function openDocumentModal(type) {
        const data = documentGroups[type];

        if (!data) {
            return;
        }

        const modal = document.getElementById('documentModal');
        const title = document.getElementById('documentModalTitle');
        const grid = document.getElementById('documentModalGrid');

        title.innerText = data.title;
        grid.innerHTML = '';

        data.items.forEach(function(url) {
            const button = document.createElement('button');

            button.type = 'button';
            button.className = 'h-[130px] rounded-[8px] overflow-hidden border border-[#D7E5FA] bg-[#F8FBFF]';

            button.innerHTML = `
                <img src="${url}" class="w-full h-full object-cover" alt="Dokumentasi">
            `;

            button.addEventListener('click', function() {
                openImagePreview(url);
            });

            grid.appendChild(button);
        });

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDocumentModal() {
        const modal = document.getElementById('documentModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

</body>
</html>