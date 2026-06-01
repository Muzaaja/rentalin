<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpanjangan Sewa Berhasil</title>

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

            <svg
                class="absolute left-4 top-[10px] w-[15px] h-[15px] text-[#9AA3AF]"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"
                />
            </svg>
        </div>

    </div>

    <!-- RIGHT -->
    <div class="flex items-center gap-[18px]">
        <button class="text-[17px]">🔔</button>
        <button class="text-[17px]">💬</button>
        <button class="text-[17px]">🛒</button>

        <div class="w-px h-[28px] bg-[#D8DDE6]"></div>

        <div class="flex items-center gap-2">
            <div class="w-[34px] h-[34px] rounded-full bg-[#34699A] text-white flex items-center justify-center text-[13px]">
                🏪
            </div>

            <span class="text-[13px] font-semibold">
                Toko
            </span>
        </div>

        <img
            src="https://i.pravatar.cc/100"
            class="w-[38px] h-[38px] rounded-[10px] object-cover"
            alt="Profile"
        >
    </div>

</nav>

<!-- ================= NAVBAR MOBILE ================= -->
<nav class="sm:hidden w-full bg-white border-b border-[#E7EAF0] px-[20px] pt-[18px] pb-[14px]">

    <div class="flex items-center justify-between mb-[16px]">
        <span class="text-[18px] font-semibold">9:41</span>

        <div class="flex items-center gap-[6px] text-[17px]">
            <span>▮▮▮</span>
            <span>⌁</span>
            <span>▰</span>
        </div>
    </div>

    <div class="flex items-center gap-[14px]">
        <div class="relative flex-1">
            <input
                type="text"
                placeholder="Search"
                class="w-full h-[34px] rounded-full border border-[#1E1E1E] bg-white pl-[42px] pr-4 text-[12px] outline-none placeholder:text-[#777]"
            >

            <svg
                class="absolute left-[14px] top-[9px] w-[16px] h-[16px] text-[#696969]"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"
                />
            </svg>
        </div>

        <button class="text-[18px]">🔔</button>
    </div>

</nav>

<!-- ================= CONTENT ================= -->
<main class="w-full max-w-[435px] sm:max-w-[1050px] lg:max-w-[1320px] mx-auto px-[20px] sm:px-[44px] lg:px-[66px] pt-[24px] sm:pt-[42px] pb-[56px] lg:pb-[120px]">

    <!-- TITLE -->
    <div class="flex items-center gap-[12px] mb-[26px] sm:mb-[36px]">

        <button class="w-[32px] h-[32px] rounded-full border border-[#1E1E1E] flex items-center justify-center text-[24px] leading-none">
            ‹
        </button>

        <h1 class="text-[22px] sm:text-[24px] font-bold">
            Perpanjangan Sewa
        </h1>

    </div>

    <!-- WRAPPER CONTENT -->
    <div class="sm:px-[44px]">

        <!-- ================= STEP PROGRESS ================= -->
        <div class="w-full mb-[28px] sm:mb-[34px]">

            <div class="grid grid-cols-[auto_1fr_auto_1fr_auto] items-start w-full">

                <!-- STEP 1 -->
                <div class="flex flex-col items-center">
                    <div class="w-[28px] h-[28px] rounded-full bg-[#E5E7EB] text-[#555] text-[13px] font-semibold flex items-center justify-center">
                        1
                    </div>

                    <p class="text-[11px] sm:text-[13px] text-[#696969] mt-[12px] whitespace-nowrap">
                        Pilih Durasi
                    </p>
                </div>

                <div class="h-px bg-[#34699A] mt-[14px] mx-[10px] sm:mx-[28px]"></div>

                <!-- STEP 2 -->
                <div class="flex flex-col items-center">
                    <div class="w-[28px] h-[28px] rounded-full bg-[#E5E7EB] text-[#555] text-[13px] font-semibold flex items-center justify-center">
                        2
                    </div>

                    <p class="text-[11px] sm:text-[13px] text-[#696969] mt-[12px] whitespace-nowrap">
                        Pembayaran
                    </p>
                </div>

                <div class="h-px bg-[#34699A] mt-[14px] mx-[10px] sm:mx-[28px]"></div>

                <!-- STEP 3 ACTIVE -->
                <div class="flex flex-col items-center">
                    <div class="w-[28px] h-[28px] rounded-full bg-[#34699A] text-white text-[13px] font-semibold flex items-center justify-center">
                        3
                    </div>

                    <p class="text-[11px] sm:text-[13px] text-[#34699A] mt-[12px] font-semibold whitespace-nowrap">
                        Selesai
                    </p>
                </div>

            </div>

        </div>

        <!-- ================= SUCCESS ALERT ================= -->
        <section class="bg-[#E7F8EF] rounded-[8px] px-[18px] sm:px-[70px] py-[20px] sm:py-[24px] mb-[24px]">

            <div class="flex flex-col sm:flex-row sm:items-center gap-[16px] sm:gap-[28px]">

                <div class="w-[52px] h-[52px] rounded-full bg-[#27AE60] text-white flex items-center justify-center text-[30px] font-bold flex-shrink-0">
                    ✓
                </div>

                <div>
                    <h2 class="text-[22px] sm:text-[28px] font-bold text-[#1E1E1E]">
                        Perpanjangan Sewa Berhasil!
                    </h2>

                    <p class="text-[13px] sm:text-[14px] text-[#555] mt-[10px] leading-[22px]">
                        Sewa Anda telah diperpanjang. Durasi sewa dan ketersediaan barang telah diperbarui secara otomatis
                    </p>

                    <div class="flex items-center gap-[12px] mt-[14px] flex-wrap">
                        <span class="h-[24px] px-[12px] rounded-[4px] bg-[#CFF3D9] text-[#348B55] text-[11px] font-semibold flex items-center">
                            ID Transaksi
                        </span>

                        <span class="text-[13px] sm:text-[14px] font-bold text-[#1E1E1E]">
                            TRX-2026-08-00123
                        </span>

                        <button class="text-[#34699A] text-[18px] leading-none">
                            ⧉
                        </button>
                    </div>
                </div>

            </div>

        </section>

        <!-- ================= SUMMARY GRID ================= -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-[14px] mb-[24px]">

            <!-- RINGKASAN BARANG -->
            <section class="bg-white border border-[#E5EAF0] rounded-[8px] px-[16px] sm:px-[20px] py-[16px] sm:py-[18px] shadow-[0px_2px_4px_0px_rgba(0,0,0,0.14)]">

                <h2 class="text-[16px] sm:text-[18px] font-bold mb-[18px]">
                    Ringkasan Barang
                </h2>

                <!-- PRODUCT BOX -->
                <div class="border border-[#C3DAFE] bg-[#F8FBFF] rounded-[6px] px-[12px] py-[10px] mb-[18px]">

                    <div class="flex items-center justify-between gap-[12px]">

                        <div class="flex items-center gap-[12px] min-w-0">
                            <img
                                src="https://images.unsplash.com/photo-1579586337278-3befd40fd17a?q=80&w=300"
                                class="w-[64px] h-[64px] rounded-[6px] object-cover flex-shrink-0"
                                alt="Kompor Listrik Portable"
                            >

                            <div class="min-w-0">
                                <h3 class="text-[13px] sm:text-[16px] font-bold leading-[20px]">
                                    Kompor Listrik Portable
                                </h3>

                                <p class="text-[11px] sm:text-[12px] text-[#696969] mt-[8px]">
                                    1 Buah &nbsp;&nbsp; • &nbsp;&nbsp; Sewa dari Lunara Store
                                </p>
                            </div>
                        </div>

                        <div class="h-[20px] px-[10px] rounded-full bg-[#C3DAFE] text-[#2D85C4] text-[10px] font-semibold flex items-center flex-shrink-0">
                            Disewa
                        </div>

                    </div>

                </div>

                <!-- DETAIL BARANG -->
                <div class="space-y-[14px]">

                    <div class="flex justify-between items-center text-[13px] sm:text-[14px]">
                        <span class="text-[#696969]">Tanggal mulai sewa</span>
                        <span class="font-semibold text-[#1E1E1E]">8 Mei 2026</span>
                    </div>

                    <div class="flex justify-between items-center text-[13px] sm:text-[14px]">
                        <span class="text-[#696969]">Tanggal berakhir baru</span>
                        <span class="font-semibold text-[#27AE60]">13 Mei 2026</span>
                    </div>

                    <div class="flex justify-between items-center text-[13px] sm:text-[14px]">
                        <span class="text-[#696969]">Total durasi sewa</span>
                        <span class="font-semibold text-[#1E1E1E]">5 hari</span>
                    </div>

                    <div class="flex justify-between items-center text-[13px] sm:text-[14px]">
                        <span class="text-[#696969]">Harga sewa</span>
                        <span class="font-semibold text-[#1E1E1E]">Rp65.000/hari</span>
                    </div>

                </div>

            </section>

            <!-- DETAIL PEMBAYARAN -->
            <section class="bg-white border border-[#E5EAF0] rounded-[8px] px-[16px] sm:px-[20px] py-[16px] sm:py-[18px] shadow-[0px_2px_4px_0px_rgba(0,0,0,0.14)]">

                <h2 class="text-[16px] sm:text-[18px] font-bold mb-[28px]">
                    Detail Pembayaran
                </h2>

                <div class="space-y-[18px] pb-[18px] border-b border-[#DDE8F5]">

                    <div class="flex justify-between items-center text-[13px] sm:text-[14px]">
                        <span class="text-[#696969]">Harga sewa</span>
                        <span class="font-semibold text-[#1E1E1E]">Rp65.000</span>
                    </div>

                    <div class="flex justify-between items-center text-[13px] sm:text-[14px]">
                        <span class="text-[#696969]">Durasi tambahan</span>
                        <span class="font-semibold text-[#1E1E1E]">1 hari</span>
                    </div>

                </div>

                <div class="space-y-[18px] py-[18px] border-b border-[#DDE8F5]">

                    <div class="flex justify-between items-center text-[13px] sm:text-[14px]">
                        <span class="text-[#696969]">Subtotal</span>
                        <span class="font-semibold text-[#1E1E1E]">Rp65.000</span>
                    </div>

                    <div class="flex justify-between items-center text-[13px] sm:text-[14px]">
                        <span class="text-[#696969]">Deposit (jaminan)</span>
                        <span class="font-semibold text-[#1E1E1E]">Rp20.000</span>
                    </div>

                </div>

                <div class="flex justify-between items-center text-[13px] sm:text-[14px] pt-[18px]">
                    <span class="font-bold text-[#1E1E1E]">Total Pembayaran</span>
                    <span class="font-bold text-[#34699A]">Rp85.000</span>
                </div>

            </section>

        </div>

        <!-- ================= EXTENSION INFO ================= -->
        <section class="w-full bg-[#E7F8EF] rounded-[8px] px-[18px] sm:px-[24px] py-[18px] sm:py-[18px] mb-[24px]">

            <div class="flex items-center gap-[16px]">

                <div class="w-[58px] h-[58px] sm:w-[70px] sm:h-[70px] flex items-center justify-center flex-shrink-0">
                    <img
                    src="{{ asset('assets/icons/icon-calendar-success.png') }}"
                    alt="Perpanjangan"
                    class="w-full h-full object-contain"
                    >
                </div>

                <div>
                    <h3 class="text-[16px] sm:text-[18px] font-semibold text-[#219653]">
                        Perpanjangan
                    </h3>

                    <p class="text-[12px] sm:text-[16px] text-[#219653] mt-[8px] sm:mt-[14px]">
                        <span class="font-bold">+ 1 hari</span> (dari 12 Mei 2026)
                    </p>
                </div>

            </div>

        </section>

        <!-- ================= NEXT STEP ================= -->
        <section class="bg-white border border-[#E5EAF0] rounded-[8px] px-[16px] sm:px-[22px] py-[18px] sm:py-[20px] shadow-[0px_2px_4px_0px_rgba(0,0,0,0.14)] mb-[24px]">

            <h2 class="text-[16px] sm:text-[18px] font-bold mb-[20px]">
                Apa yang terjadi selanjutnya?
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-[22px]">

                <!-- ITEM 1 -->
                <div class="flex items-center gap-[16px]">

                    <div class="w-[58px] h-[58px] rounded-full bg-[#EAF3FF] flex items-center justify-center text-[#34699A] text-[26px] flex-shrink-0">
                        🗓️
                    </div>

                    <div>
                        <h3 class="text-[13px] sm:text-[14px] font-bold">
                            Durasi sewa diperbarui
                        </h3>

                        <p class="text-[12px] sm:text-[13px] text-[#696969] mt-[8px] leading-[20px]">
                            Tanggal berakhir sewa Anda sekarang 13 Mei 2026.
                        </p>
                    </div>

                </div>

                <!-- ITEM 2 -->
                <div class="flex items-center gap-[16px]">

                    <div class="w-[58px] h-[58px] rounded-full bg-[#EAF3FF] flex items-center justify-center text-[#34699A] text-[26px] flex-shrink-0">
                        🗓️
                    </div>

                    <div>
                        <h3 class="text-[13px] sm:text-[14px] font-bold">
                            Tidak perlu konfirmasi pemilik
                        </h3>

                        <p class="text-[12px] sm:text-[13px] text-[#696969] mt-[8px] leading-[20px]">
                            Sistem telah otomatis memperbarui durasi dan ketersediaan barang.
                        </p>
                    </div>

                </div>

                <!-- ITEM 3 -->
                <div class="flex items-center gap-[16px]">

                    <div class="w-[58px] h-[58px] rounded-full bg-[#EAF3FF] flex items-center justify-center text-[#34699A] text-[26px] flex-shrink-0">
                        🗓️
                    </div>

                    <div>
                        <h3 class="text-[13px] sm:text-[14px] font-bold">
                            Notifikasi telah dikirim
                        </h3>

                        <p class="text-[12px] sm:text-[13px] text-[#696969] mt-[8px] leading-[20px]">
                            Pemilik telah menerima notifikasi perpanjangan sewa Anda.
                        </p>
                    </div>

                </div>

            </div>

        </section>

        <!-- ================= INFO MESSAGE ================= -->
        <div class="bg-[#EAF3FF] text-[#34699A] rounded-[6px] px-[14px] sm:px-[18px] py-[12px] text-[12px] sm:text-[13px] font-semibold flex items-start gap-[10px] mb-[52px]">
            <span class="text-[16px] leading-none">ℹ️</span>

            <p>
                Jika ada pertanyaan atau kendala terkait penyewaan, silakan hubungi melalui fitur chat.
            </p>
        </div>

        <!-- ================= ACTION BUTTON ================= -->
        <div class="flex flex-col sm:flex-row justify-end gap-[14px]">

            <button class="w-full sm:w-[220px] h-[42px] rounded-[6px] border border-[#34699A] bg-white text-[#34699A] text-[14px] font-semibold">
                Lihat Detail Transaksi
            </button>

            <button class="w-full sm:w-[220px] h-[42px] rounded-[6px] bg-[#34699A] text-white text-[14px] font-semibold">
                Selesai
            </button>

        </div>

    </div>

</main>

<!-- ================= FOOTER DESKTOP / TABLET ================= -->
<footer class="hidden sm:block bg-white border-t border-[#E5EAF0]">

    <div class="max-w-[1050px] lg:max-w-[1320px] mx-auto px-[44px] lg:px-[66px] py-[36px] lg:py-[42px]">

        <div class="grid grid-cols-2 lg:grid-cols-3 gap-[30px] lg:gap-[40px]">

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
                    <p>📞 +62 123 456 987</p>
                    <p>✉️ support@rentalin.com</p>
                    <p>📍 Jl. Cibubur No. 123</p>
                </div>
            </div>

        </div>

        <div class="border-t border-[#D7DCE3] mt-[36px] pt-[20px] flex items-center justify-between">

            <p class="text-[13px]">
                © 2026 Rentalin. All rights reserved
            </p>

            <div class="flex items-center gap-[14px] text-[17px]">
                <span>📷</span>
                <span>💬</span>
                <span>📘</span>
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
            <p>📞 &nbsp; +62 123 456 987</p>
            <p>✉️ &nbsp; support@rentalin.com</p>
            <p>📍 &nbsp; Jl. Cibubur No. 123</p>
        </div>
    </div>

    <div class="border-t border-[#111] pt-[13px] flex items-center justify-between">
        <p class="text-[15px] font-medium leading-[20px] max-w-[230px]">
            © 2026 Rentalin. All rights reserved
        </p>

        <div class="flex items-center gap-[14px] text-[20px]">
            <span>📷</span>
            <span>💬</span>
            <span>📘</span>
        </div>
    </div>

</footer>

</body>
</html>