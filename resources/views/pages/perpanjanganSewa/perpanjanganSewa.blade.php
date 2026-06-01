<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpanjangan Sewa</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="bg-[#F5F7FA] text-[#1E1E1E] [font-family:'Plus_Jakarta_Sans',sans-serif]">

<!-- ================= NAVBAR DESKTOP / TABLET ================= -->
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

    <!-- WRAPPER: batas kiri dan kanan disamakan -->
    <div class="sm:px-[44px]">

        <!-- ================= STEP PROGRESS ================= -->
        <div class="w-full mb-[28px] sm:mb-[40px]">

            <div class="grid grid-cols-[auto_1fr_auto_1fr_auto] items-start w-full">

                <!-- STEP 1 -->
                <div class="flex flex-col items-center">
                    <div class="w-[28px] h-[28px] rounded-full bg-[#34699A] text-white text-[13px] font-semibold flex items-center justify-center">
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

                <!-- STEP 3 -->
                <div class="flex flex-col items-center">
                    <div class="w-[28px] h-[28px] rounded-full bg-[#E5E7EB] text-[#555] text-[13px] font-semibold flex items-center justify-center">
                        3
                    </div>

                    <p class="text-[11px] sm:text-[13px] text-[#34699A] mt-[12px] whitespace-nowrap">
                        Selesai
                    </p>
                </div>

            </div>

        </div>

        <!-- ================= SECTION 1 ================= -->
        <section class="bg-white border border-[#E5EAF0] rounded-[8px] px-[14px] sm:px-[24px] py-[16px] sm:py-[22px] shadow-[0px_2px_4px_0px_rgba(0,0,0,0.14)] mb-[14px]">

            <div class="flex items-center justify-between gap-[12px] mb-[22px]">
                <h2 class="text-[16px] sm:text-[20px] font-bold">
                    Barang yang Disewa
                </h2>

                <div class="hidden sm:flex items-center gap-[8px] text-[13px] text-[#696969]">
                    <span>Disewakan oleh</span>
                    <span class="text-[18px]">🎧</span>
                    <span class="text-[15px] font-bold text-[#1E1E1E]">IBOX</span>
                </div>
            </div>

            <!-- PRODUCT BOX -->
            <div class="border border-[#C3DAFE] bg-[#F8FBFF] rounded-[4px] px-[12px] sm:px-[18px] py-[12px] sm:py-[14px] mb-[22px]">

                <div class="flex items-center justify-between gap-[10px]">

                    <div class="flex items-center gap-[12px] sm:gap-[18px] min-w-0">
                        <img
                            src="https://images.unsplash.com/photo-1579586337278-3befd40fd17a?q=80&w=300"
                            class="w-[64px] h-[64px] sm:w-[78px] sm:h-[78px] rounded-[6px] object-cover flex-shrink-0"
                            alt="Kompor Listrik Portable"
                        >

                        <div class="min-w-0">
                            <h3 class="text-[12px] sm:text-[18px] font-semibold leading-[22px]">
                                Kompor Listrik Portable
                            </h3>

                            <p class="text-[12px] sm:text-[14px] text-[#696969] mt-[5px]">
                                1 Buah
                            </p>
                        </div>
                    </div>

                    <div class="text-right flex-shrink-0">
                        <p class="text-[11px] sm:text-[13px] text-[#696969]">
                            Harga sewa
                        </p>

                        <h3 class="text-[15px] sm:text-[21px] font-bold text-[#34699A] mt-[6px]">
                            Rp65.000/hari
                        </h3>
                    </div>

                </div>

            </div>

            <!-- RENT INFO -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-[18px] sm:gap-[26px] pt-[8px]">

                <div class="flex items-start gap-[10px] sm:justify-start">
                    <span class="text-[20px] leading-none">
                        🗓️
                    </span>

                    <div>
                        <p class="text-[13px] sm:text-[15px] text-[#696969] font-medium">
                            Tanggal mulai sewa
                        </p>

                        <p class="text-[14px] sm:text-[17px] text-[#34699A] font-semibold mt-[10px]">
                            8 Mei 2026
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-[10px] sm:justify-center">
                    <span class="text-[20px] leading-none">
                        🗓️
                    </span>

                    <div>
                        <p class="text-[13px] sm:text-[15px] text-[#696969] font-medium">
                            Tanggal berakhir (sekarang)
                        </p>

                        <p class="text-[14px] sm:text-[17px] text-[#F2994A] font-semibold mt-[10px]">
                            12 Mei 2026
                        </p>
                    </div>
                </div>

                <div class="flex items-start gap-[10px] sm:justify-end">
                    <span class="text-[20px] leading-none">
                        ⏱️
                    </span>

                    <div>
                        <p class="text-[13px] sm:text-[15px] text-[#696969] font-medium">
                            Sisa waktu sewa
                        </p>

                        <p class="text-[14px] sm:text-[17px] text-[#FF4D5E] font-semibold mt-[10px]">
                            1 hari lagi
                        </p>
                    </div>
                </div>

            </div>

        </section>

        <!-- ================= SECTION 2 ================= -->
        <section class="bg-white border border-[#E5EAF0] rounded-[8px] px-[14px] sm:px-[24px] py-[16px] sm:py-[18px] shadow-[0px_2px_4px_0px_rgba(0,0,0,0.14)] mb-[14px]">

            <h2 class="text-[16px] sm:text-[20px] font-semibold">
                Pilih Durasi Perpanjangan
            </h2>

            <p class="text-[12px] sm:text-[14px] text-[#696969] mt-[6px] mb-[20px]">
                Pilih paket cepat atau atur tanggal secara manual:
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-[12px] sm:gap-[18px] mb-[20px]">

                <button class="text-left min-h-[104px] border border-[#8FB8FF] bg-[#DBEAFE] rounded-[6px] px-[16px] py-[14px]">
                    <h3 class="text-[13px] text-[#34699A] font-bold">
                        +1 hari
                    </h3>

                    <p class="text-[13px] text-[#696969] mt-[7px]">
                        Sampai 13 Mei 2026
                    </p>

                    <p class="text-[13px] text-[#34699A] font-bold mt-[14px]">
                        Rp65.000/hari
                    </p>
                </button>

                <button class="text-left min-h-[104px] border border-[#8FB8FF] bg-white rounded-[6px] px-[16px] py-[14px]">
                    <h3 class="text-[13px] text-[#34699A] font-bold">
                        +3 hari
                    </h3>

                    <p class="text-[13px] text-[#696969] mt-[7px]">
                        Sampai 15 Mei 2026
                    </p>

                    <p class="text-[13px] text-[#34699A] font-bold mt-[14px]">
                        Rp195.000/hari
                    </p>
                </button>

                <button class="text-left min-h-[104px] border border-[#8FB8FF] bg-white rounded-[6px] px-[16px] py-[14px]">
                    <h3 class="text-[13px] text-[#34699A] font-bold">
                        +7 hari
                    </h3>

                    <p class="text-[13px] text-[#696969] mt-[7px]">
                        Sampai 19 Mei 2026
                    </p>

                    <p class="text-[13px] text-[#34699A] font-bold mt-[14px]">
                        Rp455.000/hari
                    </p>
                </button>

                <button class="text-left min-h-[104px] border border-[#8FB8FF] bg-white rounded-[6px] px-[16px] py-[14px]">
                    <h3 class="text-[13px] text-[#34699A] font-bold">
                        +14 hari
                    </h3>

                    <p class="text-[13px] text-[#696969] mt-[7px]">
                        Sampai 26 Mei 2026
                    </p>

                    <p class="text-[13px] text-[#34699A] font-bold mt-[14px]">
                        Rp910.000/hari
                    </p>
                </button>

            </div>

            <!-- MANUAL DATE -->
            <div class="mb-[20px]">
                <p class="text-[13px] text-[#696969] font-semibold mb-[12px]">
                    Atau atur tanggal manual:
                </p>

                <button class="w-full min-h-[74px] border border-[#8FB8FF] bg-[#DBEAFE] rounded-[6px] flex items-center justify-center gap-[14px] px-[14px]">
                    <span class="text-[24px]">🗓️</span>

                    <div class="text-left">
                        <h3 class="text-[13px] sm:text-[14px] text-[#34699A] font-bold">
                            Pilih Tanggal Lainnya
                        </h3>

                        <p class="text-[12px] text-[#696969] mt-[5px]">
                            Atur tanggal selesai sewa secara manual
                        </p>
                    </div>
                </button>
            </div>

            <!-- INFO -->
            <div class="bg-[#EAF3FF] rounded-[6px] px-[14px] py-[12px] w-full sm:max-w-[390px]">

                <div class="flex items-start gap-[8px]">
                    <span class="text-[16px]">ℹ️</span>

                    <div>
                        <p class="text-[12px] text-[#34699A] font-semibold">
                            Hanya tanggal yang tersedia yang dapat dipilih
                        </p>

                        <div class="flex items-center gap-[18px] mt-[8px] text-[12px] text-[#9AA3AF]">
                            <div class="flex items-center gap-[6px]">
                                <span class="w-[10px] h-[10px] rounded-full bg-[#D1D5DB]"></span>
                                <span>Tersedia</span>
                            </div>

                            <div class="flex items-center gap-[6px]">
                                <span class="w-[10px] h-[10px] rounded-full bg-[#E5E7EB]"></span>
                                <span>Tidak tersedia</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </section>

        <!-- ================= SECTION 3 ================= -->
        <section class="bg-white border border-[#E5EAF0] rounded-[8px] px-[14px] sm:px-[24px] py-[16px] sm:py-[18px] shadow-[0px_2px_4px_0px_rgba(0,0,0,0.14)] mb-[14px]">

            <h2 class="text-[16px] sm:text-[20px] font-semibold mb-[14px]">
                Catatan (Opsional)
            </h2>

            <textarea
                placeholder="Masukkan catatan untuk pemilik, contoh: ingin memperpanjang karena masih digunakan"
                class="w-full h-[76px] rounded-[14px] border border-[#E5EAF0] bg-white px-[18px] py-[16px] text-[12px] outline-none resize-none placeholder:text-[#9AA3AF] shadow-[0px_2px_4px_0px_rgba(0,0,0,0.10)]"
            ></textarea>

        </section>

        <!-- ================= SECTION 4 ================= -->
        <section class="bg-white border border-[#E5EAF0] rounded-[8px] px-[14px] sm:px-[24px] py-[16px] sm:py-[18px] shadow-[0px_2px_4px_0px_rgba(0,0,0,0.14)]">

            <h2 class="text-[16px] sm:text-[20px] font-semibold mb-[20px]">
                Ringkasan Pembayaran
            </h2>

            <div class="space-y-[10px] pb-[14px] border-b border-[#DDE8F5]">

                <div class="flex justify-between items-center text-[13px]">
                    <span class="text-[#696969]">Harga sewa</span>
                    <span class="font-semibold text-[#34699A]">Rp65.000</span>
                </div>

                <div class="flex justify-between items-center text-[13px]">
                    <span class="text-[#696969]">Durasi tambahan</span>
                    <span class="font-semibold text-[#34699A]">1 hari</span>
                </div>

                <div class="flex justify-between items-center text-[13px]">
                    <span class="text-[#69699A]">Subtotal</span>
                    <span class="font-semibold text-[#34699A]">Rp65.000</span>
                </div>

                <div class="flex justify-between items-center text-[13px]">
                    <span class="text-[#696969]">Deposit (jaminan)</span>
                    <span class="font-semibold text-[#34699A]">Rp20.000</span>
                </div>

            </div>

            <div class="flex justify-between items-center text-[13px] pt-[12px] pb-[14px] border-b border-[#DDE8F5]">
                <span class="font-bold text-[#1E1E1E]">Total Pembayaran</span>
                <span class="font-bold text-[#34699A]">Rp85.000</span>
            </div>

            <!-- PAYMENT METHOD -->
            <div class="pt-[14px]">

                <h3 class="text-[13px] text-[#696969] font-semibold mb-[12px]">
                    Metode Pembayaran
                </h3>

                <div class="space-y-[12px]">

                    <label class="w-full min-h-[58px] border border-[#C3DAFE] rounded-[6px] px-[14px] py-[10px] flex items-center justify-between cursor-pointer bg-white hover:bg-[#F8FBFF] transition">

                        <div class="flex items-center gap-[12px]">
                            <input
                                type="radio"
                                name="payment"
                                class="accent-[#34699A]"
                            >

                            <div>
                                <h4 class="text-[13px] font-bold text-[#1E1E1E]">
                                    Rentalin Pay Later
                                </h4>

                                <p class="text-[12px] text-[#696969] mt-[2px]">
                                    Bayar nanti sesuai tagihan yang tersedia
                                </p>
                            </div>
                        </div>

                        <div class="w-[34px] h-[24px] bg-[#E5E7EB] text-[#777] text-[11px] font-bold flex items-center justify-center rounded-[2px]">
                            RPL
                        </div>

                    </label>

                    <label class="w-full min-h-[58px] border border-[#C3DAFE] rounded-[6px] px-[14px] py-[10px] flex items-center justify-between cursor-pointer bg-white hover:bg-[#F8FBFF] transition">

                        <div class="flex items-center gap-[12px]">
                            <input
                                type="radio"
                                name="payment"
                                class="accent-[#34699A]"
                                checked
                            >

                            <div>
                                <h4 class="text-[13px] font-bold text-[#1E1E1E]">
                                    QRIS
                                </h4>

                                <p class="text-[12px] text-[#696969] mt-[2px]">
                                    Scan kode QR untuk menyelesaikan pembayaran
                                </p>
                            </div>
                        </div>

                        <div class="w-[34px] h-[24px] bg-[#E5E7EB] text-[#777] text-[11px] font-bold flex items-center justify-center rounded-[2px]">
                            QR
                        </div>

                    </label>

                </div>

            </div>

            <div class="flex justify-end mt-[22px]">
                <button class="w-full sm:w-auto h-[42px] px-[34px] rounded-[8px] bg-[#34699A] text-white text-[13px] font-semibold">
                    Ajukan Perpanjangan
                </button>
            </div>

        </section>

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