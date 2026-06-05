<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tinjau Klaim Kerusakan</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

@php
    use Carbon\Carbon;

    function rupiahKlaim($angka) {
        return 'Rp' . number_format($angka ?? 0, 0, ',', '.');
    }

    $claim = $rental->damageClaim;

    $repairFee = $claim->repair_fee ?? $rental->damage_fee ?? 0;

    /*
    Deposit belum ada di tabel.
    Untuk sementara dibuat default Rp500.000 agar sesuai kebutuhan tampilan.
    Nanti kalau sudah ada kolom deposit, bagian ini tinggal diganti dari database.
    */
    $deposit = 500000;

    $sisaTagihan = max($repairFee - $deposit, 0);

    $damageDocuments = $rental->documents
        ? $rental->documents->where('process', 'damage_claim')
        : collect();

    $startDate = $rental->start_date ? Carbon::parse($rental->start_date)->translatedFormat('d M Y') : '-';
    $endDate = $rental->end_date ? Carbon::parse($rental->end_date)->translatedFormat('d M Y') : '-';

    $tanggalDiajukan = $claim && $claim->created_at
        ? $claim->created_at->translatedFormat('d M Y')
        : now()->translatedFormat('d M Y');

    $batasRespons = $claim && $claim->created_at
        ? $claim->created_at->copy()->addDays(3)->translatedFormat('d M Y, H.i') . ' WIB'
        : now()->addDays(3)->translatedFormat('d M Y, H.i') . ' WIB';
@endphp

<body class="bg-[#F5F7FA] text-[#1E1E1E] [font-family:'Plus_Jakarta_Sans',sans-serif]">

<!-- NAVBAR DESKTOP -->
<nav class="hidden sm:flex w-full h-[58px] bg-white border-b border-[#E7EAF0] px-[18px] items-center justify-between">
    <div class="flex items-center gap-8">
        <div class="flex items-center leading-none">
            <div class="bg-[#34699A] text-white text-[19px] font-extrabold px-[12px] py-[6px] rounded-[10px] tracking-[0.3px]">
                Rental
            </div>
            <div class="text-[#F2C94C] text-[19px] font-extrabold ml-[2px]">
                in
            </div>
        </div>

        <div class="relative hidden lg:block">
            <input type="text"
                   placeholder="Search"
                   class="w-[430px] h-[36px] rounded-full border border-[#D7DCE3] bg-white pl-10 pr-4 text-[12px] outline-none placeholder:text-[#9AA3AF]">
            <img src="{{ asset('assets/icons/icon-search.png') }}"
                 class="absolute left-4 top-[10px] w-[15px] h-[15px] object-contain"
                 alt="Search">
        </div>
    </div>

    <div class="flex items-center gap-[18px]">
        <img src="{{ asset('assets/icons/icon-bell.png') }}" class="w-[18px] h-[18px] object-contain" alt="Notif">
        <img src="{{ asset('assets/icons/icon-chat.png') }}" class="w-[18px] h-[18px] object-contain" alt="Chat">
        <img src="{{ asset('assets/icons/icon-cart.png') }}" class="w-[18px] h-[18px] object-contain" alt="Cart">

        <div class="w-px h-[28px] bg-[#D8DDE6]"></div>

        <span class="text-[13px] font-semibold">Penyewa</span>

        <img src="{{ asset('assets/profile/profile-user.png') }}"
             class="w-[38px] h-[38px] rounded-[10px] object-cover"
             alt="Profile">
    </div>
</nav>

<main class="w-full max-w-[435px] sm:max-w-[980px] mx-auto px-[20px] sm:px-[48px] py-[32px]">

    <!-- HEADER -->
    <div class="flex items-start gap-[14px] mb-[28px]">
        <a href="{{ route('riwayat.transaksi.penyewa') }}"
           class="w-[34px] h-[34px] rounded-full border border-[#1E1E1E] flex items-center justify-center shrink-0 mt-[2px]">
            <img src="{{ asset('assets/icons/icon-back.png') }}"
                 class="w-[18px] h-[18px] object-contain"
                 alt="Back">
        </a>

        <div>
            <h1 class="text-[24px] font-bold">Tinjau Klaim Kerusakan</h1>
            <p class="text-[13px] text-[#6B7280] mt-[5px] leading-[20px]">
                Pemilik melaporkan adanya kerusakan setelah barang dikembalikan. Tinjau detail klaim sebelum menyetujui.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-[18px] bg-[#E8F8EF] border border-[#B7E8C8] text-[#118642] px-[14px] py-[12px] rounded-[8px] text-[13px] font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-[18px] bg-[#FFECEF] border border-[#F4B8C2] text-[#E3455D] px-[14px] py-[12px] rounded-[8px] text-[13px] font-semibold">
            {{ session('error') }}
        </div>
    @endif

    <!-- WARNING -->
    <section class="bg-[#FFF3C4] rounded-[8px] px-[22px] py-[20px] mb-[28px] flex items-center gap-[20px]">
        <div class="w-[56px] h-[56px] flex items-center justify-center shrink-0">
            <img src="{{ asset('assets/icons/icon-warning-yellow.png') }}"
                 class="w-[46px] h-[46px] object-contain"
                 alt="Warning">
        </div>

        <div>
            <h2 class="text-[20px] font-bold">
                Klaim kerusakan perlu disetujui
            </h2>

            <p class="text-[13px] mt-[8px]">
                <span class="font-semibold">Batas respons:</span>
                <span class="text-[#F59E0B] font-bold ml-[8px]">
                    {{ $batasRespons }}
                </span>
            </p>
        </div>
    </section>

    <!-- INFORMASI BARANG -->
    <section class="bg-white border border-[#E2E8F0] rounded-[8px] shadow-sm px-[22px] py-[18px] mb-[24px]">
        <div class="flex items-center justify-between mb-[20px]">
            <h2 class="text-[16px] font-bold">Informasi Barang</h2>

            <span class="h-[28px] px-[18px] rounded-full bg-[#FFD6DE] text-[#E3455D] text-[12px] font-bold flex items-center">
                Kerusakan
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-[1fr_300px] gap-[24px]">
            <div class="flex gap-[18px]">
                <img src="{{ asset('assets/products/' . optional($rental->item)->image) }}"
                     class="w-[120px] h-[120px] rounded-[7px] object-cover bg-[#D9D9D9]"
                     alt="{{ optional($rental->item)->name }}">

                <div class="space-y-[12px]">
                    <div>
                        <p class="text-[15px] font-bold">
                            {{ optional($rental->item)->name ?? '-' }}
                        </p>

                        <span class="inline-block text-[10px] text-[#8A8A8A] border border-[#D7DCE3] rounded-[4px] px-[6px] py-[2px] mt-[6px]">
                            QTY: 1 Buah
                        </span>
                    </div>

                    <div class="flex items-center gap-[8px] text-[13px]">
                        <img src="{{ asset('assets/icons/icon-store-gray.png') }}"
                             class="w-[18px] h-[18px] object-contain"
                             alt="Store">
                        <span class="font-semibold">
                            {{ optional($rental->owner)->name ?? '-' }}
                        </span>
                    </div>

                    <div class="flex items-center gap-[8px] text-[13px]">
                        <img src="{{ asset('assets/icons/icon-document-gray.png') }}"
                             class="w-[18px] h-[18px] object-contain"
                             alt="ID">
                        <span class="text-[#6B7280]">ID Transaksi</span>
                        <span class="font-semibold">{{ $rental->rental_code }}</span>
                    </div>
                </div>
            </div>

            <div class="space-y-[13px] text-[13px]">
                <div class="flex gap-[10px]">
                    <img src="{{ asset('assets/icons/icon-calendar-gray.png') }}"
                         class="w-[20px] h-[20px] object-contain mt-[2px]"
                         alt="Periode">

                    <div>
                        <p class="text-[#6B7280]">Periode Sewa</p>
                        <p class="font-semibold">{{ $startDate }} - {{ $endDate }}</p>
                    </div>
                </div>

                <div class="flex gap-[10px]">
                    <img src="{{ asset('assets/icons/icon-return-gray.png') }}"
                         class="w-[20px] h-[20px] object-contain mt-[2px]"
                         alt="Return">

                    <div>
                        <p class="text-[#6B7280]">Tanggal Dikembalikan</p>
                        <p class="font-semibold">{{ $endDate }}</p>
                    </div>
                </div>

                <div class="flex gap-[10px]">
                    <img src="{{ asset('assets/icons/icon-wallet-gray.png') }}"
                         class="w-[20px] h-[20px] object-contain mt-[2px]"
                         alt="Deposit">

                    <div>
                        <p class="text-[#6B7280]">Deposit</p>
                        <p class="font-semibold">{{ rupiahKlaim($deposit) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- LAPORAN KERUSAKAN -->
    <section class="bg-white border border-[#E2E8F0] rounded-[8px] shadow-sm px-[22px] py-[20px] mb-[24px]">
        <h2 class="text-[16px] font-bold mb-[20px]">Laporan Kerusakan</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-[18px] mb-[20px]">
            <div class="md:border-r border-[#E2E8F0]">
                <p class="text-[12px] text-[#6B7280]">Diajukan pada</p>
                <p class="text-[13px] font-bold mt-[4px]">{{ $tanggalDiajukan }}</p>

                <p class="text-[12px] text-[#6B7280] mt-[18px]">Jenis Kerusakan</p>
                <p class="text-[13px] font-bold mt-[4px]">
                    {{ $claim->damage_type ?? 'Kerusakan fisik' }}
                </p>
            </div>

            <div class="md:border-r border-[#E2E8F0]">
                <p class="text-[12px] text-[#6B7280]">Bagian rusak</p>
                <p class="text-[13px] font-bold mt-[4px]">
                    {{ $claim->damage_part ?? '-' }}
                </p>

                <p class="text-[12px] text-[#6B7280] mt-[18px]">Biaya perbaikan</p>
                <p class="text-[13px] font-bold mt-[4px]">
                    {{ rupiahKlaim($repairFee) }}
                </p>
            </div>

            <div>
                <p class="text-[12px] text-[#6B7280]">Batas respons</p>
                <p class="text-[13px] font-bold mt-[4px]">{{ $batasRespons }}</p>

                <p class="text-[12px] text-[#6B7280] mt-[18px]">Status klaim</p>
                <p class="text-[13px] font-bold mt-[4px]">
                    {{ $claim && $claim->status === 'accepted' ? 'Disetujui' : 'Menunggu persetujuan' }}
                </p>
            </div>
        </div>

        <div class="border-t border-[#D1D5DB] pt-[18px]">
            <h3 class="text-[13px] font-bold mb-[10px]">Deskripsi Kerusakan</h3>

            <p class="text-[13px] leading-[22px] text-[#333333]">
                {{ $claim->description ?? $rental->damage_description ?? 'Belum ada deskripsi kerusakan.' }}
            </p>
        </div>

        <div class="mt-[24px]">
            <h3 class="text-[13px] font-bold mb-[14px]">Foto Bukti Kerusakan</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-[18px]">
                @forelse($damageDocuments as $document)
                    <div class="h-[150px] rounded-[7px] overflow-hidden bg-[#D9D9D9]">
                        <img src="{{ asset('storage/' . $document->image) }}"
                             class="w-full h-full object-cover"
                             alt="Bukti Kerusakan">
                    </div>
                @empty
                    <div class="h-[150px] rounded-[7px] bg-[#D9D9D9]"></div>
                    <div class="h-[150px] rounded-[7px] bg-[#D9D9D9]"></div>
                    <div class="h-[150px] rounded-[7px] bg-[#D9D9D9]"></div>
                @endforelse
            </div>
        </div>

        <div class="mt-[26px]">
            <h3 class="text-[13px] font-bold mb-[14px]">Rincian Biaya</h3>

            <div class="space-y-[10px] text-[13px]">
                <div class="flex justify-between">
                    <span class="text-[#6B7280]">Deposit penyewa</span>
                    <span class="font-semibold">{{ rupiahKlaim($deposit) }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-[#6B7280]">Biaya kerusakan</span>
                    <span class="font-semibold text-[#E3455D]">
                        - {{ rupiahKlaim($repairFee) }}
                    </span>
                </div>

                <div class="border-t border-[#D1D5DB] pt-[12px] flex justify-between">
                    <span class="font-bold">Sisa tagihan Anda</span>
                    <span class="font-bold text-[#34699A]">
                        {{ rupiahKlaim($sisaTagihan) }}
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- TINDAKAN -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-[18px]">
        <section class="bg-white border border-[#E2E8F0] rounded-[8px] shadow-sm px-[22px] py-[20px]">
            <h2 class="text-[16px] font-bold mb-[8px]">Tindakan Anda</h2>

            <p class="text-[13px] text-[#6B7280] mb-[16px] leading-[20px]">
                Sesuai alur transaksi Rentalin, klaim kerusakan dari pemilik wajib disetujui agar transaksi dapat diselesaikan.
            </p>

            @if($claim && $claim->status === 'accepted')
                <div class="border border-[#A8E6BF] bg-[#E8F8EF] rounded-[8px] px-[18px] py-[16px] flex gap-[14px]">
                    <div class="w-[44px] h-[44px] rounded-full bg-[#2FA866] flex items-center justify-center text-white text-[22px] font-bold">
                        ✓
                    </div>

                    <div>
                        <h3 class="text-[15px] font-bold text-[#2FA866]">Klaim Sudah Disetujui</h3>
                        <p class="text-[13px] text-[#4B5563] mt-[5px] leading-[20px]">
                            Klaim kerusakan telah disetujui dan transaksi sudah diselesaikan.
                        </p>
                    </div>
                </div>
            @else
                <form action="{{ route('transaksi.setujuiKlaim', $rental->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <button type="submit"
                            class="w-full border border-[#2FA866] bg-[#E8F8EF] rounded-[8px] px-[18px] py-[16px] flex items-center justify-between text-left hover:bg-[#DDF5E8]">
                        <div class="flex items-center gap-[14px]">
                            <div class="w-[44px] h-[44px] rounded-full bg-[#2FA866] flex items-center justify-center text-white text-[22px] font-bold">
                                ✓
                            </div>

                            <div>
                                <h3 class="text-[15px] font-bold text-[#2FA866]">Setujui Klaim</h3>
                                <p class="text-[13px] text-[#4B5563] mt-[5px] leading-[20px]">
                                    Biaya kerusakan akan diproses sesuai nominal klaim.
                                </p>
                            </div>
                        </div>

                        <span class="text-[#2FA866] text-[26px] leading-none">›</span>
                    </button>
                </form>
            @endif
        </section>

        <section class="bg-white border border-[#E2E8F0] rounded-[8px] shadow-sm px-[22px] py-[20px]">
            <h2 class="text-[16px] font-bold mb-[18px]">Setelah Anda Menyetujui</h2>

            <div class="space-y-[18px]">
                <div class="flex gap-[14px]">
                    <div class="w-[34px] h-[34px] rounded-full bg-[#34699A] text-white flex items-center justify-center font-bold shrink-0">
                        1
                    </div>
                    <p class="text-[13px] text-[#4B5563] leading-[20px]">
                        Klaim kerusakan tercatat sebagai disetujui.
                    </p>
                </div>

                <div class="flex gap-[14px]">
                    <div class="w-[34px] h-[34px] rounded-full bg-[#34699A] text-white flex items-center justify-center font-bold shrink-0">
                        2
                    </div>
                    <p class="text-[13px] text-[#4B5563] leading-[20px]">
                        Biaya kerusakan diproses dari deposit. Jika melebihi deposit, sistem mencatat sisa tagihan.
                    </p>
                </div>

                <div class="flex gap-[14px]">
                    <div class="w-[34px] h-[34px] rounded-full bg-[#34699A] text-white flex items-center justify-center font-bold shrink-0">
                        3
                    </div>
                    <p class="text-[13px] text-[#4B5563] leading-[20px]">
                        Status transaksi berubah menjadi selesai dan barang kembali tersedia.
                    </p>
                </div>
            </div>
        </section>
    </div>

</main>

<!-- FOOTER -->
<footer class="bg-white mt-[60px] border-t border-[#E5E7EB]">
    <div class="max-w-[980px] mx-auto px-[20px] sm:px-[48px] py-[34px]">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-[24px]">
            <div>
                <div class="flex items-center leading-none mb-[14px]">
                    <div class="bg-[#34699A] text-white text-[20px] font-extrabold px-[10px] py-[5px] rounded-[8px]">
                        Rental
                    </div>
                    <div class="text-[#F2C94C] text-[20px] font-extrabold ml-[2px]">
                        in
                    </div>
                </div>

                <p class="text-[13px] leading-[22px]">
                    Platform sewa menyewa barang yang aman, mudah, dan terpercaya
                </p>
            </div>

            <div>
                <h3 class="text-[14px] font-bold mb-[10px]">Quick Links</h3>
                <p class="text-[13px] text-[#6B7280] mb-[8px]">Home</p>
                <p class="text-[13px] text-[#6B7280] mb-[8px]">Riwayat</p>
                <p class="text-[13px] text-[#6B7280]">Kontak</p>
            </div>

            <div>
                <h3 class="text-[14px] font-bold mb-[10px]">Hubungi Kami</h3>
                <p class="text-[13px] text-[#6B7280] mb-[8px]">+62 123 456 987</p>
                <p class="text-[13px] text-[#6B7280] mb-[8px]">support@rentalin.com</p>
                <p class="text-[13px] text-[#6B7280]">Jl. Cibubur No. 123</p>
            </div>
        </div>

        <div class="border-t border-[#1E1E1E] mt-[28px] pt-[18px] text-[13px] font-semibold">
            © 2026 Rentalin. All rights reserved
        </div>
    </div>
</footer>

</body>
</html>