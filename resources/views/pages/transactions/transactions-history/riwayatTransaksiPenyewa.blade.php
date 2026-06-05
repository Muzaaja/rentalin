<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi Penyewa</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>

@php
    use Carbon\Carbon;

    function formatRupiahPenyewa($angka) {
        return 'Rp' . number_format($angka ?? 0, 0, ',', '.');
    }

    function labelStatusPenyewa($status) {
        return match ($status) {
            'pesanan_masuk' => 'Pesanan Masuk',
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'pembayaran_berhasil' => 'Pembayaran Berhasil',
            'diproses' => 'Diproses',
            'dikirim' => 'Dikirim',
            'menunggu_penerimaan' => 'Menunggu Penerimaan',
            'disewa' => 'Disewa',
            'pengembalian' => 'Pengembalian',
            'belum_dikembalikan' => 'Belum Dikembalikan',
            'kerusakan' => 'Kerusakan',
            'dibatalkan' => 'Dibatalkan',
            'selesai' => 'Selesai',
            default => 'Diproses',
        };
    }

    function warnaStatusPenyewa($status) {
        return match ($status) {
            'selesai' => 'bg-[#CFF3D9] text-[#348B55]',
            'pengembalian' => 'bg-[#FFF0C2] text-[#D38A00]',
            'dibatalkan', 'belum_dikembalikan', 'kerusakan' => 'bg-[#FFD6DE] text-[#E3455D]',
            default => 'bg-[#DDEBFF] text-[#2D85C4]',
        };
    }

    function pesanPenyewa($status) {
        return match ($status) {
            'menunggu_pembayaran' => 'Selesaikan pembayaran agar pesanan dapat diproses oleh pemilik.',
            'pembayaran_berhasil' => 'Pembayaran berhasil. Dana ditahan sementara oleh sistem sampai transaksi selesai.',
            'diproses' => 'Pesanan sedang diproses oleh pemilik. Hubungi pemilik untuk koordinasi serah terima atau pengiriman.',
            'dikirim' => 'Barang sedang dikirim. Pantau pengiriman melalui informasi resi atau koordinasi melalui chat.',
            'menunggu_penerimaan' => 'Jika barang sudah diterima, lakukan konfirmasi penerimaan dan unggah dokumentasi kondisi barang.',
            'disewa' => 'Barang sedang dalam masa sewa. Anda dapat memperpanjang sewa atau menghubungi pemilik jika perlu koordinasi.',
            'pengembalian' => 'Barang sudah ditandai dikembalikan. Tunggu pemilik memeriksa kondisi barang.',
            'selesai' => 'Transaksi telah selesai. Anda dapat memberikan penilaian atau menyewa kembali barang ini.',
            'dibatalkan' => 'Pesanan dibatalkan. Dana akan dikembalikan sesuai kebijakan pembatalan.',
            'belum_dikembalikan' => 'Masa sewa telah berakhir dan barang belum dikembalikan. Segera kembalikan barang.',
            'kerusakan' => 'Terdapat klaim kerusakan. Klaim wajib disetujui agar transaksi dapat diselesaikan.',
            default => 'Lihat detail transaksi untuk informasi lebih lengkap.',
        };
    }

    function labelPembayaranRental($payment) {
        if (!$payment) {
            return 'Belum ada pembayaran';
        }

        if (($payment->payment_type ?? 'full') === 'paylater') {
            $plan = $payment->installment_plan ?? '-';
            $paid = $payment->installment_paid ?? 0;

            return 'Paylater - Cicilan ' . $plan . 'x • Terbayar ' . $paid . '/' . $plan;
        }

        return 'Bayar Penuh';
    }

    function tempoBerikutnyaRental($payment) {
        if (!$payment || !$payment->next_due_date) {
            return '-';
        }

        return Carbon::parse($payment->next_due_date)->format('d M Y');
    }
@endphp

<body class="bg-[#F5F7FA] text-[#1E1E1E] [font-family:'Plus_Jakarta_Sans',sans-serif]">

@include('layouts.partials.navbar')

<main class="w-full max-w-[435px] sm:max-w-[940px] lg:max-w-[1220px] mx-auto px-[20px] sm:px-[44px] lg:px-[66px] pt-[28px] pb-[70px]">
    <h1 class="text-[22px] sm:text-[24px] font-bold mb-[20px]">
        Riwayat Transaksi
    </h1>

    @if(session('success'))
        <div class="mb-[18px] bg-[#E8F8EF] border border-[#B7E8C8] text-[#118642] px-[14px] py-[12px] rounded-[8px] text-[13px] font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-[22px]">
        <span class="inline-flex items-center h-[30px] px-[14px] rounded-[8px] bg-[#DDEBFF] text-[#34699A] text-[13px] font-semibold">
            <img src="{{ asset('assets/icons/icon-user-blue.png') }}"
                 class="w-[16px] h-[16px] object-contain mr-[6px]"
                 alt="Penyewa">
            Penyewa
        </span>
    </div>

    <div class="flex items-center gap-[14px] sm:justify-between overflow-x-auto pb-[8px] mb-[16px]">
        @foreach($filters as $key => $label)
            <a href="{{ route('riwayat.transaksi.penyewa', ['status' => $key]) }}"
               class="shrink-0 min-w-[108px] h-[38px] px-[18px] rounded-full border border-[#7BAFE3] text-[13px] font-medium flex items-center justify-center
               {{ $statusAktif === $key ? 'bg-[#34699A] text-white border-[#34699A]' : 'bg-white text-[#2F6EA5]' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <a href="#"
       class="w-full bg-[#DDEBFF] border border-[#BFD7FF] rounded-[10px] px-[18px] py-[16px] mb-[16px] flex items-center justify-between">
        <div class="flex items-center gap-[14px]">
            <img src="{{ asset('assets/icons/icon-guide.png') }}"
                 class="w-[28px] h-[28px] object-contain"
                 alt="Panduan">

            <div>
                <h2 class="text-[15px] font-bold">
                    Panduan Proses Transaksi
                </h2>

                <p class="text-[12px] text-[#6B7280] mt-[4px]">
                    Lihat cara transaksi dari awal hingga selesai.
                </p>
            </div>
        </div>

        <img src="{{ asset('assets/icons/icon-arrow-right.png') }}"
             class="w-[18px] h-[18px] object-contain"
             alt="Arrow">
    </a>

    <div class="space-y-[14px]">
        @forelse($rentals as $rental)
            @php
                $status = $rental->status;
                $isDanger = in_array($status, ['dibatalkan', 'belum_dikembalikan', 'kerusakan']);

                $durasi = ($rental->start_date && $rental->end_date)
                    ? Carbon::parse($rental->start_date)->diffInDays(Carbon::parse($rental->end_date))
                    : 0;
            @endphp

            <div class="bg-white border border-[#D7E5FA] rounded-[10px] px-[12px] sm:px-[18px] py-[14px] shadow-[0px_2px_8px_rgba(15,23,42,0.06)]">
                <div class="flex items-center justify-between border-b border-[#C3DAFE] pb-[12px] gap-[12px]">
                    <div class="flex items-center gap-[8px] min-w-0">
                        <img src="{{ asset('assets/profile/' . (optional($rental->owner)->avatar ?? 'profile-toko.png')) }}"
                             class="w-[24px] h-[24px] rounded-full object-cover flex-shrink-0"
                             alt="Toko">

                        <p class="text-[13px] font-semibold truncate">
                            {{ optional($rental->owner)->name ?? '-' }}
                        </p>
                    </div>

                    <span class="h-[28px] px-[15px] rounded-full text-[12px] font-semibold flex items-center justify-center shrink-0 {{ warnaStatusPenyewa($status) }}">
                        {{ labelStatusPenyewa($status) }}
                    </span>
                </div>

                <div class="flex items-center justify-between gap-[14px] py-[14px]">
                    <div class="flex gap-[12px] min-w-0">
                        <img src="{{ asset('assets/products/' . (optional($rental->item)->image ?? 'default-product.png')) }}"
                             class="w-[74px] h-[74px] sm:w-[82px] sm:h-[82px] rounded-[7px] object-cover flex-shrink-0"
                             alt="{{ optional($rental->item)->name }}">

                        <div class="min-w-0">
                            <h3 class="text-[14px] sm:text-[15px] font-bold leading-[21px] line-clamp-2">
                                {{ optional($rental->item)->name ?? '-' }}
                            </h3>

                            <div class="flex flex-wrap gap-[6px] mt-[5px]">
                                <span class="text-[10px] text-[#8A8A8A] border border-[#D7DCE3] rounded-[4px] px-[6px] py-[2px]">
                                    Jumlah: 1 Buah
                                </span>
                            </div>

                            <p class="text-[10px] text-[#8A8A8A] border border-[#D7DCE3] rounded-[4px] px-[6px] py-[2px] inline-block mt-[5px]">
                                ID Transaksi: {{ $rental->rental_code }}
                            </p>

                            <p class="text-[11px] text-[#6B7280] mt-[6px]">
                                {{ $rental->start_date }} - {{ $rental->end_date }} • {{ $durasi }} hari
                            </p>

                            <p class="text-[11px] text-[#6B7280] mt-[4px]">
                                Pembayaran: {{ labelPembayaranRental($rental->payment) }}
                            </p>

                            @if(optional($rental->payment)->payment_type === 'paylater')
                                <p class="text-[11px] text-[#D38A00] mt-[3px]">
                                    Tempo berikutnya:
                                    {{ tempoBerikutnyaRental($rental->payment) }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="text-right shrink-0">
                        <p class="text-[12px] text-[#6B7280]">
                            Total Pesanan
                        </p>

                        <p class="text-[16px] sm:text-[17px] font-bold text-[#34699A] mt-[4px]">
                            {{ formatRupiahPenyewa($rental->total_price) }}
                        </p>
                    </div>
                </div>

                <div class="border-t border-[#C3DAFE] pt-[12px] flex flex-wrap justify-end gap-[8px]">
                    @if($status === 'menunggu_pembayaran')
                        <a href="#"
                            class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold inline-flex items-center justify-center">
                            Bayar Sekarang
                        </a>

                        <a href="#"
                            class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#E3455D] border border-[#E3455D] text-[12px] sm:text-[13px] font-semibold inline-flex items-center justify-center">
                            Batalkan Pesanan
                        </a>
                    @endif

                    @if(in_array($status, ['pembayaran_berhasil', 'diproses', 'dikirim', 'menunggu_penerimaan']))
                        <a href="{{ route('transaksi.formKonfirmasiPenerimaan', $rental->id) }}"
                            class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold inline-flex items-center justify-center">
                            Konfirmasi Penerimaan
                        </a>

                        <a href="#"
                        class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#E3455D] border border-[#E3455D] text-[12px] sm:text-[13px] font-semibold inline-flex items-center justify-center">
                            Batalkan Pesanan
                        </a>

                        <a href="#"
                        class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold inline-flex items-center justify-center">
                            Hubungi Pemilik
                        </a>
                    @endif

                    @if($status === 'disewa')
                        <a href="{{ route('transaksi.formPerpanjanganSewa', $rental->id) }}"
                           class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white text-[12px] sm:text-[13px] font-semibold flex items-center">
                            Perpanjang Sewa
                        </a>

                        <a href="{{ route('transaksi.formPesananDikembalikan', $rental->id) }}"
                           class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white text-[12px] sm:text-[13px] font-semibold flex items-center">
                            Pesanan Dikembalikan
                        </a>

                        <a href="{{ route('transaksi.detail', $rental->id) }}"
                           class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center">
                            Detail Transaksi
                        </a>
                    @endif

                    @if($status === 'pengembalian')
                        <a href="{{ route('transaksi.detail', $rental->id) }}"
                           class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white text-[12px] sm:text-[13px] font-semibold flex items-center">
                            Detail Transaksi
                        </a>

                        <a href="#"
                            class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold inline-flex items-center justify-center">
                            Hubungi Pemilik
                        </a>
                    @endif

                    @if($status === 'selesai')
                        <a href="#"
                            class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white border border-[#34699A] text-[12px] sm:text-[13px] font-semibold inline-flex items-center justify-center">
                            Nilai
                        </a>

                        <a href="#"
                            class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold inline-flex items-center justify-center">
                            Sewa Kembali
                        </a>

                        <a href="{{ route('transaksi.detail', $rental->id) }}"
                           class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center">
                            Detail Transaksi
                        </a>
                    @endif

                    @if($status === 'belum_dikembalikan')
                        <a href="{{ route('transaksi.formPesananDikembalikan', $rental->id) }}"
                           class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white text-[12px] sm:text-[13px] font-semibold flex items-center">
                            Pesanan Dikembalikan
                        </a>

                        <button type="button"
                                class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold">
                            Hubungi Pemilik
                        </button>
                    @endif

                    @if($status === 'kerusakan')
                        <a href="{{ route('transaksi.lihatKlaim', $rental->id) }}"
                           class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white text-[12px] sm:text-[13px] font-semibold flex items-center">
                            Lihat Klaim
                        </a>

                        <a href="{{ route('transaksi.detail', $rental->id) }}"
                           class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-white text-[#34699A] border border-[#34699A] text-[12px] sm:text-[13px] font-semibold flex items-center">
                            Detail Transaksi
                        </a>
                    @endif

                    @if($status === 'dibatalkan')
                        <a href="{{ route('transaksi.detail', $rental->id) }}"
                           class="h-[36px] px-[13px] sm:px-[16px] rounded-[7px] bg-[#34699A] text-white text-[12px] sm:text-[13px] font-semibold flex items-center">
                            Detail Transaksi
                        </a>
                    @endif
                </div>

                <div class="mt-[12px] rounded-[8px] px-[12px] py-[10px] flex items-start gap-[8px] {{ $isDanger ? 'bg-[#FFECEF] text-[#E3455D]' : 'bg-[#EAF3FF] text-[#34699A]' }}">
                    <img src="{{ asset($isDanger ? 'assets/icons/icon-warning-red.png' : 'assets/icons/icon-info-blue.png') }}"
                         class="w-[18px] h-[18px] object-contain mt-[1px] flex-shrink-0"
                         alt="Info">

                    <p class="text-[12px] leading-[20px] font-medium">
                        {{ pesanPenyewa($status) }}
                    </p>
                </div>
            </div>
        @empty
            <div class="bg-white border border-[#D7E5FA] rounded-[10px] px-[18px] py-[28px] text-center">
                <p class="text-[14px] text-[#6B7280]">
                    Belum ada transaksi pada status ini.
                </p>
            </div>
        @endforelse
    </div>

    <div class="mt-[36px]">
        {{ $rentals->links() }}
    </div>
</main>

@include('layouts.partials.footer')

</body>
</html>