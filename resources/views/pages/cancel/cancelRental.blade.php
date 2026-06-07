<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembatalan Pesanan</title>
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

    $startDate = $rental->start_date
        ? Carbon::parse($rental->start_date)->format('d M Y')
        : '-';

    $endDate = $rental->end_date
        ? Carbon::parse($rental->end_date)->format('d M Y')
        : '-';

    $durasi = ($rental->start_date && $rental->end_date)
        ? Carbon::parse($rental->start_date)->diffInDays(Carbon::parse($rental->end_date))
        : 0;

    $totalHarga = $refund['total_harga'] ?? ($rental->total_price ?? 0);
    $deposit = $refund['deposit'] ?? 0;
    $potonganPembatalan = $refund['potongan_pembatalan'] ?? 0;
    $refundAmount = $refund['refund_amount'] ?? 0;
    $keteranganRefund = $refund['keterangan'] ?? '-';

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
                Batalkan Pesanan
            </h1>

            <p class="text-[13px] text-[#6B7280] mt-[3px]">
                Periksa informasi refund dan pilih alasan pembatalan.
            </p>
        </div>
    </div>

    @if(session('error'))
        <div class="mb-[18px] bg-[#FFECEF] border border-[#F4B8C2] text-[#E3455D] px-[14px] py-[12px] rounded-[8px] text-[13px] font-semibold">
            {{ session('error') }}
        </div>
    @endif

    <form id="mainConfirmForm"
          action="{{ route('transaksi.simpanBatalkanPesanan', $rental->id) }}"
          method="POST"
          class="grid grid-cols-1 lg:grid-cols-[1fr_0.78fr] gap-[18px]">

        @csrf
        @method('PUT')

        {{-- Kiri --}}
        <section class="space-y-[18px]">

            {{-- Warning --}}
            <section class="bg-[#FFF3C4] border border-[#F6D36A] rounded-[10px] px-[16px] sm:px-[20px] py-[14px] flex items-start gap-[12px]">
                <img src="{{ asset('assets/icons/icon-warning-yellow.png') }}"
                     class="w-[28px] h-[28px] object-contain shrink-0"
                     alt="Peringatan">

                <div>
                    <h2 class="text-[15px] font-bold text-[#7A5200]">
                        Pastikan ingin membatalkan pesanan
                    </h2>

                    <p class="text-[12px] text-[#7A5200] leading-[20px] mt-[4px]">
                        Pembatalan hanya dapat dilakukan sebelum barang dikirim atau diserahkan oleh pemilik.
                    </p>
                </div>
            </section>

            {{-- Ringkasan Barang --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[14px]">
                    Ringkasan Pesanan
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

                            <span class="h-[24px] px-[10px] rounded-full text-[10px] font-semibold bg-[#FFECEF] text-[#E3455D] shrink-0">
                                Pembatalan
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

                            {{ $startDate }} - {{ $endDate }} • {{ $durasi }} hari
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
                            Status Saat Ini
                        </span>

                        <span class="font-semibold text-right">
                            {{ $rental->status === 'menunggu_pembayaran' ? 'Menunggu Pembayaran' : 'Diproses' }}
                        </span>
                    </div>
                </div>
            </section>

            {{-- Alasan Pembatalan --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[5px]">
                    Alasan Pembatalan
                </h2>

                <p class="text-[12px] text-[#6B7280] mb-[16px]">
                    Pilih alasan pembatalan agar sistem dapat mencatat penyebab pesanan dibatalkan.
                </p>

                <div class="mb-[16px]">
                    <label class="block text-[13px] font-bold mb-[8px]">
                        Pilih Alasan
                        <span class="text-[#E3455D]">*</span>
                    </label>

                    <select name="reason"
                            id="reason"
                            required
                            class="w-full h-[42px] rounded-[8px] border border-[#C3DAFE] px-[12px] text-[13px] outline-none focus:border-[#34699A]">
                        <option value="">Pilih alasan pembatalan</option>
                        <option value="Salah memilih tanggal sewa">Salah memilih tanggal sewa</option>
                        <option value="Ingin mengganti metode pembayaran">Ingin mengganti metode pembayaran</option>
                        <option value="Tidak jadi menyewa">Tidak jadi menyewa</option>
                        <option value="Menemukan barang lain">Menemukan barang lain</option>
                        <option value="Pemilik sulit dihubungi">Pemilik sulit dihubungi</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[13px] font-bold mb-[8px]">
                        Catatan Tambahan
                    </label>

                    <textarea name="note"
                              rows="4"
                              placeholder="Tambahkan catatan jika diperlukan."
                              class="w-full rounded-[8px] border border-[#C3DAFE] px-[12px] py-[12px] text-[13px] outline-none focus:border-[#34699A]"></textarea>
                </div>
            </section>
        </section>

        {{-- Kanan --}}
        <aside class="space-y-[18px]">

            {{-- Refund --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[14px]">
                    Simulasi Refund
                </h2>

                <div class="space-y-[11px] text-[13px]">
                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Biaya Sewa
                        </span>

                        <span class="font-semibold">
                            Rp{{ number_format($totalHarga, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Potongan Pembatalan
                        </span>

                        <span class="font-semibold text-[#E3455D]">
                            - Rp{{ number_format($potonganPembatalan, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-[12px]">
                        <span class="text-[#6B7280]">
                            Deposit
                        </span>

                        <span class="font-semibold">
                            Rp{{ number_format($deposit, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="border-t border-[#D7E5FA] pt-[11px] flex justify-between gap-[12px]">
                        <span class="font-bold">
                            Total Refund
                        </span>

                        <span class="font-bold text-[#34699A]">
                            Rp{{ number_format($refundAmount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="mt-[14px] bg-[#EAF3FF] text-[#34699A] rounded-[8px] px-[14px] py-[12px] flex items-start gap-[10px]">
                    <img src="{{ asset('assets/icons/icon-info-blue.png') }}"
                         class="w-[18px] h-[18px] object-contain mt-[2px]"
                         alt="Info">

                    <p class="text-[12px] font-semibold leading-[20px]">
                        {{ $keteranganRefund }}
                    </p>
                </div>
            </section>

            {{-- Kebijakan --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <h2 class="text-[16px] font-bold mb-[14px]">
                    Kebijakan Pembatalan
                </h2>

                <div class="space-y-[10px] text-[12px] text-[#6B7280] leading-[20px]">
                    <p>
                        Pesanan yang belum dibayar dapat dibatalkan tanpa proses refund.
                    </p>

                    <p>
                        Pesanan yang sudah dibayar dapat dikenakan potongan pembatalan sesuai kebijakan Rentalin.
                    </p>

                    <p>
                        Setelah pembatalan dikonfirmasi, status transaksi akan berubah menjadi Dibatalkan.
                    </p>
                </div>
            </section>

            {{-- Action --}}
            <section class="bg-white border border-[#D7E5FA] rounded-[10px] px-[16px] sm:px-[22px] py-[18px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <div class="flex flex-col gap-[10px]">
                    <button type="button"
                            onclick="openConfirmModal()"
                            class="w-full h-[42px] rounded-[8px] bg-[#E3455D] text-white text-[13px] font-semibold">
                        Konfirmasi Pembatalan
                    </button>

                    <a href="{{ route('riwayat.transaksi.penyewa') }}"
                       class="w-full h-[42px] rounded-[8px] border border-[#34699A] text-[#34699A] text-[13px] font-semibold flex items-center justify-center">
                        Kembali
                    </a>
                </div>
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
            Batalkan pesanan?
        </h3>

        <p class="text-[12px] text-[#696969] leading-[20px] mb-[22px]">
            Setelah dikonfirmasi, pesanan akan dibatalkan dan tidak dapat diproses kembali.
        </p>

        <div class="grid grid-cols-2 gap-[10px]">
            <button type="button"
                    onclick="closeConfirmModal()"
                    class="h-[36px] rounded-[6px] border border-[#34699A] text-[#34699A] text-[12px] font-semibold">
                Tidak
            </button>

            <button type="button"
                    onclick="submitMainForm()"
                    class="h-[36px] rounded-[6px] bg-[#E3455D] text-white text-[12px] font-semibold">
                Ya, Batalkan
            </button>
        </div>
    </div>
</div>

<script>
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
</script>

</body>
</html>