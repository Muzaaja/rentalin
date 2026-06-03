<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Kerusakan</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="bg-[#F5F7FA] text-[#1E1E1E] [font-family:'Plus_Jakarta_Sans',sans-serif]">

<!-- ================= NAVBAR DESKTOP / TABLET ================= -->
<nav class="hidden sm:flex w-full h-[58px] bg-white border-b border-[#E7EAF0] px-[18px] items-center justify-between">

    <div class="flex items-center gap-8">

        <!-- LOGO -->
        <div class="flex items-center leading-none">
            <div class="bg-[#34699A] text-white text-[19px] font-extrabold px-[12px] py-[6px] rounded-[10px] tracking-[0.3px]">
                Rental
            </div>

            <div class="text-[#F2C94C] text-[19px] font-extrabold ml-[2px]">
                in
            </div>
        </div>

        <!-- SEARCH -->
        <div class="relative hidden lg:block">
            <input
                type="text"
                placeholder="Search"
                class="w-[430px] h-[36px] rounded-full border border-[#D7DCE3] bg-white pl-10 pr-4 text-[12px] outline-none placeholder:text-[#9AA3AF]"
            >

            <img
                src="{{ asset('assets/icons/icon-search.png') }}"
                alt="Search"
                class="absolute left-4 top-[10px] w-[15px] h-[15px] object-contain"
            >
        </div>

    </div>

    <!-- RIGHT -->
    <div class="flex items-center gap-[18px]">

        <button class="w-[24px] h-[24px] flex items-center justify-center">
            <img src="{{ asset('assets/icons/icon-bell.png') }}" alt="Notifikasi" class="w-[18px] h-[18px] object-contain">
        </button>

        <button class="w-[24px] h-[24px] flex items-center justify-center">
            <img src="{{ asset('assets/icons/icon-chat.png') }}" alt="Chat" class="w-[18px] h-[18px] object-contain">
        </button>

        <button class="w-[24px] h-[24px] flex items-center justify-center">
            <img src="{{ asset('assets/icons/icon-cart.png') }}" alt="Keranjang" class="w-[18px] h-[18px] object-contain">
        </button>

        <div class="w-px h-[28px] bg-[#D8DDE6]"></div>

        <div class="flex items-center gap-2">
            <div class="w-[34px] h-[34px] rounded-full bg-[#34699A] flex items-center justify-center">
                <img
                    src="{{ asset('assets/icons/icon-store.png') }}"
                    alt="Toko"
                    class="w-[18px] h-[18px] object-contain"
                >
            </div>

            <span class="text-[13px] font-semibold">
                Toko
            </span>
        </div>

        <img
            src="{{ asset('assets/profile/profile-toko.png') }}"
            class="w-[38px] h-[38px] rounded-[10px] object-cover"
            alt="Profile Toko"
        >
    </div>

</nav>

<!-- ================= NAVBAR MOBILE ================= -->
<nav class="sm:hidden w-full bg-white border-b border-[#E7EAF0] px-[20px] pt-[18px] pb-[14px]">

    <div class="flex items-center justify-between mb-[16px]">
        <span class="text-[18px] font-semibold">9:41</span>

        <div class="flex items-center gap-[5px]">
            <img src="{{ asset('assets/icons/icon-signal.png') }}" alt="Signal" class="w-[18px] h-[18px] object-contain">
            <img src="{{ asset('assets/icons/icon-wifi.png') }}" alt="Wifi" class="w-[18px] h-[18px] object-contain">
            <img src="{{ asset('assets/icons/icon-battery.png') }}" alt="Battery" class="w-[22px] h-[18px] object-contain">
        </div>
    </div>

</nav>

<!-- ================= CONTENT ================= -->
<main class="w-full max-w-[435px] sm:max-w-[940px] lg:max-w-[1220px] mx-auto px-[20px] sm:px-[44px] lg:px-[66px] pt-[22px] sm:pt-[38px] pb-[48px] lg:pb-[70px]">

    <!-- TITLE -->
    <div class="flex items-center gap-[14px] mb-[28px] sm:mb-[34px]">

        <button class="w-[34px] h-[34px] rounded-full border border-[#1E1E1E] flex items-center justify-center flex-shrink-0">
            <img
                src="{{ asset('assets/icons/icon-back.png') }}"
                alt="Kembali"
                class="w-[16px] h-[16px] object-contain"
            >
        </button>

        <h1 class="text-[24px] sm:text-[26px] font-bold">
            Pengajuan Kerusakan
        </h1>

    </div>

    <!-- STEP PROGRESS -->
    <div class="w-full mb-[30px] sm:mb-[38px]">

        <div class="grid grid-cols-[auto_1fr_auto_1fr_auto] items-start w-full">

            <!-- STEP 1 ACTIVE -->
            <div class="flex flex-col items-center">
                <div class="w-[28px] h-[28px] rounded-full bg-[#34699A] text-white text-[13px] font-semibold flex items-center justify-center">
                    1
                </div>

                <p class="text-[10px] sm:text-[12px] text-[#696969] mt-[10px] whitespace-nowrap">
                    Pelaporan Kerusakan
                </p>
            </div>

            <div class="h-px bg-[#34699A] mt-[14px] mx-[10px] sm:mx-[28px]"></div>

            <!-- STEP 2 -->
            <div class="flex flex-col items-center">
                <div class="w-[28px] h-[28px] rounded-full bg-[#E5E7EB] text-[#777] text-[13px] font-semibold flex items-center justify-center">
                    2
                </div>

                <p class="text-[10px] sm:text-[12px] text-[#696969] mt-[10px] whitespace-nowrap">
                    Masa Tinjauan Klaim
                </p>
            </div>

            <div class="h-px bg-[#B8C0CC] mt-[14px] mx-[10px] sm:mx-[28px]"></div>

            <!-- STEP 3 -->
            <div class="flex flex-col items-center">
                <div class="w-[28px] h-[28px] rounded-full bg-[#E5E7EB] text-[#777] text-[13px] font-semibold flex items-center justify-center">
                    3
                </div>

                <p class="text-[10px] sm:text-[12px] text-[#34699A] mt-[10px] whitespace-nowrap">
                    Keputusan Penyewa
                </p>
            </div>

        </div>

    </div>

    <!-- CONTENT GRID -->
    <!-- Mobile 435px: 1 kolom | Tablet & Desktop: 2 kolom -->
    <div class="grid grid-cols-1 sm:grid-cols-[360px_1fr] lg:grid-cols-[410px_1fr] gap-[28px] items-start">

        <!-- ================= RINGKASAN BARANG ================= -->
        <section class="bg-white border border-[#E5EAF0] rounded-[8px] px-[14px] sm:px-[22px] py-[20px] sm:py-[22px] shadow-[0px_2px_6px_rgba(0,0,0,0.10)]">

            <h2 class="text-[18px] font-bold mb-[26px]">
                Ringkasan Barang
            </h2>

            <!-- PRODUCT -->
            <div class="flex items-center gap-[14px] sm:gap-[18px] mb-[22px]">

                <img
                    src="{{ asset('assets/products/kompor-listrik.png') }}"
                    alt="Kompor Listrik Portable"
                    class="w-[82px] h-[70px] sm:w-[100px] sm:h-[86px] rounded-[6px] object-cover flex-shrink-0"
                >

                <div class="min-w-0">
                    <h3 class="text-[18px] font-bold leading-[24px]">
                        Kompor Listrik Portable
                    </h3>

                    <div class="flex items-center gap-[8px] sm:gap-[10px] mt-[12px] text-[13px] flex-wrap">
                        <span class="text-[#696969]">
                            Disewa dari:
                        </span>

                        <img
                            src="{{ asset('assets/icons/icon-store-small.png') }}"
                            class="w-[18px] h-[18px] object-contain flex-shrink-0"
                            alt="Store"
                        >

                        <span class="font-semibold">
                            Vynelle Market
                        </span>
                    </div>
                </div>

            </div>

            <!-- DETAIL -->
            <div class="border-t border-[#C3DAFE] pt-[18px] space-y-[24px] sm:space-y-[28px]">

                <div class="flex items-center justify-between gap-[20px]">
                    <div class="flex items-center gap-[12px] text-[#696969]">
                        <img
                            src="{{ asset('assets/icons/icon-transaction.png') }}"
                            class="w-[18px] h-[18px] object-contain"
                            alt="ID Transaksi"
                        >

                        <span class="text-[13px]">
                            ID Transaksi
                        </span>
                    </div>

                    <p class="text-[13px] font-semibold text-right">
                        TRX-20260901-0042
                    </p>
                </div>

                <div class="flex items-start justify-between gap-[20px]">
                    <div class="flex items-center gap-[12px] text-[#696969]">
                        <img
                            src="{{ asset('assets/icons/icon-calendar.png') }}"
                            class="w-[18px] h-[18px] object-contain"
                            alt="Periode Sewa"
                        >

                        <span class="text-[13px]">
                            Periode Sewa
                        </span>
                    </div>

                    <p class="text-[13px] font-semibold text-right leading-[22px]">
                        8 Mei 2026 - 12 Mei 2026<br>
                        <span class="text-[#696969] font-normal">
                            (4 hari)
                        </span>
                    </p>
                </div>

                <div class="flex items-start justify-between gap-[20px]">
                    <div class="flex items-center gap-[12px] text-[#696969]">
                        <img
                            src="{{ asset('assets/icons/icon-delivery.png') }}"
                            class="w-[18px] h-[18px] object-contain"
                            alt="Metode Pengiriman"
                        >

                        <span class="text-[13px]">
                            Metode Pengiriman
                        </span>
                    </div>

                    <p class="text-[13px] font-semibold text-right leading-[20px]">
                        COD (Bayar di tempat)
                    </p>
                </div>

                <div class="flex items-start justify-between gap-[20px]">
                    <div class="flex items-center gap-[12px] text-[#696969]">
                        <img
                            src="{{ asset('assets/icons/icon-location.png') }}"
                            class="w-[18px] h-[18px] object-contain"
                            alt="Alamat Pengiriman"
                        >

                        <span class="text-[13px]">
                            Alamat Pengiriman
                        </span>
                    </div>

                    <p class="text-[13px] font-semibold text-right leading-[22px]">
                        Jl. Raya Soreang No.KM. 17,<br>
                        Pamekaran
                    </p>
                </div>

                <div class="flex items-center justify-between gap-[20px]">
                    <div class="flex items-center gap-[12px] text-[#696969]">
                        <img
                            src="{{ asset('assets/icons/icon-deposit.png') }}"
                            class="w-[18px] h-[18px] object-contain"
                            alt="Deposit"
                        >

                        <span class="text-[13px]">
                            Deposit
                        </span>
                    </div>

                    <p class="text-[13px] font-semibold text-right">
                        Rp20.000
                    </p>
                </div>

            </div>

            <div class="border-t border-[#C3DAFE] mt-[28px] pt-[18px] flex items-center justify-between">
                <p class="text-[14px] text-[#696969] font-medium">
                    Total Pembayaran
                </p>

                <p class="text-[18px] font-bold text-[#34699A]">
                    Rp320.000
                </p>
            </div>

        </section>

        <!-- ================= FORM PENGAJUAN KERUSAKAN ================= -->
        <section class="bg-white border border-[#E5EAF0] rounded-[8px] px-[14px] sm:px-[26px] py-[22px] shadow-[0px_2px_6px_rgba(0,0,0,0.10)]">

            <h2 class="text-[18px] font-bold mb-[20px]">
                Form Pengajuan Kerusakan
            </h2>

            <!-- FORM GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-[18px]">

                <!-- JENIS KERUSAKAN -->
                <div>
                    <label class="block text-[14px] font-bold mb-[10px]">
                        Jenis Kerusakan
                    </label>

                    <select
                        class="w-full h-[46px] border border-[#D7DCE3] rounded-[12px] px-[14px] text-[13px] text-[#8A8A8A] outline-none shadow-[0px_2px_5px_rgba(0,0,0,0.10)] bg-white"
                    >
                        <option>Pilih jenis kerusakan</option>
                        <option>Kerusakan fisik</option>
                        <option>Kerusakan fungsi</option>
                        <option>Kelengkapan hilang</option>
                    </select>
                </div>

                <!-- BAGIAN RUSAK -->
                <div>
                    <label class="block text-[14px] font-bold mb-[10px]">
                        Bagian yang Rusak
                    </label>

                    <input
                        type="text"
                        placeholder="contoh: roda kiri depan"
                        class="w-full h-[46px] border border-[#D7DCE3] rounded-[12px] px-[14px] text-[13px] outline-none shadow-[0px_2px_5px_rgba(0,0,0,0.10)]"
                    >
                </div>

                <!-- DESKRIPSI KERUSAKAN -->
                <div>
                    <label class="block text-[14px] font-bold mb-[10px]">
                        Deskripsi Kerusakan
                    </label>

                    <textarea
                        placeholder="Jelaskan kerusakan yang terjadi"
                        class="w-full h-[110px] border border-[#D7DCE3] rounded-[12px] px-[14px] py-[14px] text-[13px] outline-none resize-none shadow-[0px_2px_5px_rgba(0,0,0,0.10)]"
                    ></textarea>
                </div>

                <!-- BIAYA PERBAIKAN -->
                <div>
                    <label class="block text-[14px] font-bold mb-[8px]">
                        Biaya Perbaikan
                    </label>

                    <p class="text-[12px] text-[#1E1E1E] mb-[12px] leading-[18px]">
                        Masukkan nominal biaya perbaikan sesuai kerusakan
                    </p>

                    <input
                        type="text"
                        placeholder="Masukkan nominal"
                        class="w-full h-[46px] border border-[#D7DCE3] rounded-[12px] px-[14px] text-[13px] outline-none shadow-[0px_2px_5px_rgba(0,0,0,0.10)]"
                    >
                </div>

            </div>

            <!-- BUKTI KERUSAKAN -->
            <div class="border-t border-[#C3DAFE] mt-[24px] pt-[22px]">

                <h2 class="text-[18px] font-bold">
                    Bukti Kerusakan
                </h2>

                <p class="text-[13px] mt-[8px] mb-[24px] leading-[21px]">
                    Unggah bukti kerusakan barang secara jelas untuk mendukung pengajuan klaim.
                </p>

                <!-- UPLOAD FOTO BUKTI -->
                <label class="w-full max-w-[460px] h-[180px] mx-auto border-2 border-dashed border-[#34699A] rounded-[8px] bg-[#D9D9D9] flex flex-col items-center justify-center cursor-pointer">
                    <img 
                        src="{{ asset('assets/icons/icon-upload-image.png') }}"
                        class="w-[34px] h-[34px] object-contain mb-[12px]"
                        alt="Upload"
                    >

                    <p class="text-[16px] font-semibold text-[#000000] leading-none">
                        Upload Foto Bukti
                    </p>

                    <p class="text-[12px] text-[#8A8A8A] italic mt-[7px]">
                        JPEG, PNG, or PDF (Max 10MB)
                    </p>

                    <input type="file" class="hidden" multiple>
                </label>

            </div>

            <!-- INFO MESSAGE -->
            <div class="mt-[22px] bg-[#DBEAFE] text-[#34699A] rounded-[8px] px-[14px] py-[12px] text-[13px] font-semibold flex items-start gap-[10px]">
                <img
                    src="{{ asset('assets/icons/icon-info.png') }}"
                    class="w-[18px] h-[18px] object-contain mt-[1px] flex-shrink-0"
                    alt="Info"
                >

                <p class="leading-[21px]">
                    Setelah klaim diajukan, penyewa akan menerima notifikasi dan diberi waktu untuk menyetujui atau mengajukan banding.
                </p>
            </div>

            <!-- BUTTON -->
            <div class="flex flex-col sm:flex-row justify-end gap-[12px] mt-[24px]">

                <button class="w-full sm:w-auto h-[44px] px-[38px] rounded-[8px] border border-[#34699A] bg-white text-[#34699A] text-[15px] font-semibold">
                    Batalkan
                </button>

                <button class="w-full sm:w-auto h-[44px] px-[38px] rounded-[8px] bg-[#34699A] text-white text-[15px] font-semibold">
                    Ajukan Klaim
                </button>

            </div>

        </section>

    </div>

</main>

<!-- ================= FOOTER DESKTOP / TABLET ================= -->
<footer class="hidden sm:block bg-white border-t border-[#E5EAF0]">

    <div class="max-w-[940px] lg:max-w-[1220px] mx-auto px-[44px] lg:px-[66px] py-[36px] lg:py-[42px]">

        <div class="grid grid-cols-3 gap-[30px] lg:gap-[40px]">

            <div>
                <div class="flex items-center leading-none mb-[20px]">
                    <div class="bg-[#34699A] text-white text-[19px] font-extrabold px-[12px] py-[6px] rounded-[10px]">
                        Rental
                    </div>

                    <div class="text-[#F2C94C] text-[19px] font-extrabold ml-[2px]">
                        in
                    </div>
                </div>

                <p class="text-[13px] leading-[28px] text-[#444] max-w-[260px]">
                    Platform sewa menyewa barang yang aman, mudah, dan terpercaya
                </p>
            </div>

            <div>
                <h3 class="text-[15px] font-semibold mb-[16px]">
                    Quick Links
                </h3>

                <div class="space-y-[10px] text-[13px] text-[#7B8491]">
                    <p>Home</p>
                    <p>Riwayat</p>
                    <p>Kontak</p>
                </div>
            </div>

            <div>
                <h3 class="text-[15px] font-semibold mb-[16px]">
                    Hubungi Kami
                </h3>

                <div class="space-y-[10px] text-[13px] text-[#7B8491]">

                    <p class="flex items-center gap-[8px]">
                        <img src="{{ asset('assets/icons/icon-phone.png') }}" alt="Telepon" class="w-[16px] h-[16px] object-contain">
                        +62 123 456 987
                    </p>

                    <p class="flex items-center gap-[8px]">
                        <img src="{{ asset('assets/icons/icon-email.png') }}" alt="Email" class="w-[16px] h-[16px] object-contain">
                        support@rentalin.com
                    </p>

                    <p class="flex items-center gap-[8px]">
                        <img src="{{ asset('assets/icons/icon-pin.png') }}" alt="Alamat" class="w-[16px] h-[16px] object-contain">
                        Jl. Cibubur No. 123
                    </p>

                </div>
            </div>

        </div>

        <div class="border-t border-[#D7DCE3] mt-[36px] pt-[20px] flex items-center justify-between">

            <p class="text-[13px]">
                © 2026 Rentalin. All rights reserved
            </p>

            <div class="flex items-center gap-[14px]">
                <img src="{{ asset('assets/icons/icon-instagram.png') }}" alt="Instagram" class="w-[18px] h-[18px] object-contain">
                <img src="{{ asset('assets/icons/icon-whatsapp.png') }}" alt="WhatsApp" class="w-[18px] h-[18px] object-contain">
                <img src="{{ asset('assets/icons/icon-facebook.png') }}" alt="Facebook" class="w-[18px] h-[18px] object-contain">
            </div>

        </div>

    </div>

</footer>

<!-- ================= FOOTER MOBILE ================= -->
<footer class="sm:hidden bg-white pt-[14px] pb-[26px] px-[22px]">

    <div class="flex items-center leading-none mb-[12px]">
        <div class="bg-[#34699A] text-white text-[20px] font-extrabold px-[9px] py-[4px] rounded-[6px]">
            Rental
        </div>

        <div class="text-[#F2C94C] text-[20px] font-extrabold ml-[2px]">
            in
        </div>
    </div>

    <p class="text-[16px] leading-[24px] text-[#111] font-medium mb-[12px]">
        Platform sewa menyewa barang yang aman, mudah, dan terpercaya
    </p>

    <div class="border-t border-[#111] pt-[9px] mb-[12px]">
        <h3 class="text-[15px] font-bold mb-[10px]">
            Quick Links
        </h3>

        <div class="space-y-[12px] text-[16px] text-[#8A8A8A]">
            <p>Home</p>
            <p>Riwayat</p>
            <p>Kontak</p>
        </div>
    </div>

    <div class="mb-[14px]">
        <h3 class="text-[15px] font-bold mb-[10px]">
            Hubungi Kami
        </h3>

        <div class="space-y-[12px] text-[16px] text-[#8A8A8A]">

            <p class="flex items-center gap-[10px]">
                <img src="{{ asset('assets/icons/icon-phone.png') }}" alt="Telepon" class="w-[18px] h-[18px] object-contain">
                +62 123 456 987
            </p>

            <p class="flex items-center gap-[10px]">
                <img src="{{ asset('assets/icons/icon-email.png') }}" alt="Email" class="w-[18px] h-[18px] object-contain">
                support@rentalin.com
            </p>

            <p class="flex items-center gap-[10px]">
                <img src="{{ asset('assets/icons/icon-pin.png') }}" alt="Alamat" class="w-[18px] h-[18px] object-contain">
                Jl. Cibubur No. 123
            </p>

        </div>
    </div>

    <div class="border-t border-[#111] pt-[13px] flex items-center justify-between">
        <p class="text-[15px] font-medium leading-[20px] max-w-[230px]">
            © 2026 Rentalin. All rights reserved
        </p>

        <div class="flex items-center gap-[14px]">
            <img src="{{ asset('assets/icons/icon-instagram.png') }}" alt="Instagram" class="w-[20px] h-[20px] object-contain">
            <img src="{{ asset('assets/icons/icon-whatsapp.png') }}" alt="WhatsApp" class="w-[20px] h-[20px] object-contain">
            <img src="{{ asset('assets/icons/icon-facebook.png') }}" alt="Facebook" class="w-[20px] h-[20px] object-contain">
        </div>
    </div>

</footer>

</body>
</html>