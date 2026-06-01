<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pengembalian Pemilik - P2P Rental</title>

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
<main class="w-full max-w-[435px] sm:max-w-[940px] lg:max-w-[1220px] mx-auto px-[20px] sm:px-[44px] lg:px-[66px] pt-[22px] sm:pt-[38px] pb-[48px] lg:pb-[70px]">

    <!-- TITLE -->
    <div class="flex items-center gap-[14px] mb-[28px] sm:mb-[34px]">

        <button class="w-[34px] h-[34px] rounded-full border border-[#1E1E1E] flex items-center justify-center text-[24px] leading-none flex-shrink-0">
            ‹
        </button>

        <h1 class="text-[24px] sm:text-[26px] font-bold">
            Konfirmasi Pengembalian
        </h1>

    </div>

    <!-- CONTENT GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-[410px_1fr] gap-[28px] items-start">

        <!-- ================= RINGKASAN BARANG ================= -->
        <section class="bg-white border border-[#E5EAF0] rounded-[8px] px-[14px] sm:px-[22px] py-[20px] sm:py-[22px] shadow-[0px_2px_6px_rgba(0,0,0,0.10)]">

            <h2 class="text-[18px] font-bold mb-[26px]">
                Ringkasan Barang
            </h2>

            <div class="flex items-center gap-[14px] sm:gap-[18px] mb-[22px]">

                <img
                    src="{{ asset('assets/products/kompor-listrik.png') }}"
                    alt="Kompor Listrik Portable"
                    class="w-[82px] h-[70px] sm:w-[100px] sm:h-[86px] rounded-[6px] object-cover flex-shrink-0"                >

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

            <div class="border-t border-[#C3DAFE] pt-[18px] space-y-[24px] sm:space-y-[28px]">

                <div class="flex items-center justify-between gap-[20px]">
                    <div class="flex items-center gap-[12px] text-[#696969]">
                        <img
                            src="{{ asset('assets/icons/icon-transaction.png') }}"
                            class="w-[18px] h-[18px] object-contain"
                            alt="ID"
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
                            alt="Periode"
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
                            alt="Metode"
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
                            alt="Alamat"
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

            </div>

            <div class="border-t border-[#C3DAFE] mt-[28px] pt-[18px] flex items-center justify-between">
                <p class="text-[14px] text-[#696969] font-medium">
                    Total Pembayaran
                </p>

                <p class="text-[18px] font-bold text-[#34699A]">
                    Rp5.000.000
                </p>
            </div>

        </section>

        <!-- ================= FORM KONFIRMASI ================= -->
        <section class="bg-white border border-[#E5EAF0] rounded-[8px] px-[14px] sm:px-[26px] py-[22px] shadow-[0px_2px_6px_rgba(0,0,0,0.10)]">

            <h2 class="text-[18px] font-bold">
                Bukti Pengembalian
            </h2>

            <p class="text-[13px] mt-[8px] mb-[24px] leading-[21px]">
                Upload minimal 3 foto yang memperlihatkan kondisi barang saat dikembalikan.
            </p>

            <!-- UPLOAD FOTO BUKTI -->
            <label class="w-full max-w-[460px] h-[180px] mx-auto border-2 border-dashed border-[#34699A] rounded-[8px] bg-[#D9D9D9] flex flex-col items-center justify-center cursor-pointer">
                <img 
                    src="{{ asset('assets/icons/icon-upload-image.png') }}" class="w-[34px] h-[34px] object-contain mb-[12px]" alt="Upload">

                <p class="text-[16px] font-semibold text-[#000000] leading-none">
                    Upload Foto Bukti
                </p>

                <p class="text-[12px] text-[#8A8A8A] italic mt-[7px]">
                    JPEG, PNG, or PDF (Max 10MB)
                </p>

                <input type="file" class="hidden" multiple>
            </label>

            <!-- KELENGKAPAN -->
            <div class="border-t border-[#C3DAFE] mt-[24px] pt-[22px]">
                <h2 class="text-[18px] font-bold">
                    Kelengkapan Barang
                </h2>

                <p class="text-[13px] mt-[6px] mb-[14px] leading-[20px]">
                    Checklist sesuai dengan kondisi barang saat diterima kembali.
                </p>

                <div class="space-y-[10px] text-[14px]">

                    <label class="flex items-center gap-[10px]">
                        <input type="checkbox" class="w-[16px] h-[16px] accent-[#34699A]">
                        Unit kompor listrik portable
                    </label>

                    <label class="flex items-center gap-[10px]">
                        <input type="checkbox" class="w-[16px] h-[16px] accent-[#34699A]">
                        Kabel power
                    </label>

                    <label class="flex items-center gap-[10px]">
                        <input type="checkbox" class="w-[16px] h-[16px] accent-[#34699A]">
                        Panel tombol / pengatur suhu
                    </label>

                    <label class="flex items-center gap-[10px]">
                        <input type="checkbox" class="w-[16px] h-[16px] accent-[#34699A]">
                        Permukaan pemanas
                    </label>

                    <label class="flex items-center gap-[10px]">
                        <input type="checkbox" class="w-[16px] h-[16px] accent-[#34699A]">
                        Kipas/ventilasi bawah atau samping
                    </label>

                </div>
            </div>

            <!-- KONDISI BARANG -->
            <div class="border-t border-[#C3DAFE] mt-[24px] pt-[22px]">
                <h2 class="text-[18px] font-bold">
                    Kondisi Barang
                </h2>

                <p class="text-[13px] mt-[6px] mb-[14px] leading-[20px]">
                    Pilih kondisi barang saat diterima kembali:
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-[14px] text-[14px]">

                    <!-- BARANG AMAN -->
                    <label class="flex items-start gap-[10px] cursor-pointer">
                        <input
                        type="radio"
                        name="kondisi_pengembalian"
                        checked
                        class="w-[16px] h-[16px] accent-[#34699A] mt-[3px] flex-shrink-0"
                        >

                        <div>
                            <p class="font-medium text-[#1E1E1E]">
                                Barang aman
                            </p>

                            <p class="text-[11px] text-[#8A8A8A] mt-[3px] leading-[16px]">
                                Barang dalam kondisi baik dan lengkap.
                            </p>
                        </div>
                    </label>

                    <!-- ADA KERUSAKAN -->
                    <label class="flex items-start gap-[10px] cursor-pointer">
                        <input
                        type="radio"
                        name="kondisi_pengembalian"
                        class="w-[16px] h-[16px] accent-[#34699A] mt-[3px] flex-shrink-0"
                        >

                        <div>
                            <p class="font-medium text-[#1E1E1E]">
                                Ada kerusakan
                            </p>

                            <p class="text-[11px] text-[#8A8A8A] mt-[3px] leading-[16px]">
                                Terdapat kerusakan atau catatan pada barang.
                            </p>
                        </div>
                    </label>

                </div>
            </div>

            <!-- INFO MESSAGE -->
            <div class="mt-[22px] bg-[#DBEAFE] text-[#34699A] rounded-[8px] px-[14px] py-[12px] text-[13px] font-semibold flex items-start gap-[10px]">
                <img
                    src="{{ asset('assets/icons/icon-info.png') }}"
                    class="w-[18px] h-[18px] object-contain mt-[1px] flex-shrink-0"
                    alt="Info"
                >

                <p class="leading-[21px]">
                    Setelah konfirmasi pengembalian berhasil, status transaksi akan diperbarui. Jika terdapat kerusakan, Anda dapat melanjutkan proses pengajuan klaim.
                </p>
            </div>

            <!-- BUTTON -->
            <div class="flex justify-end mt-[24px]">
                <button class="w-full sm:w-auto h-[44px] px-[28px] rounded-[8px] bg-[#34699A] text-white text-[15px] font-semibold">
                    Konfirmasi Pengembalian
                </button>
            </div>

        </section>

    </div>

</main>

<!-- ================= FOOTER DESKTOP / TABLET ================= -->
<footer class="hidden sm:block bg-white border-t border-[#E5EAF0]">

    <div class="max-w-[940px] lg:max-w-[1220px] mx-auto px-[44px] lg:px-[66px] py-[36px] lg:py-[42px]">

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