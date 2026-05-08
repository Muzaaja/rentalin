<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi Penyewa</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .shadow-card{
            box-shadow: 0 2px 8px rgba(15,23,42,0.04);
        }
    </style>
</head>

<body class="bg-[#F5F7FA] text-[#1F2937]">

    <!-- NAVBAR -->
    <nav class="h-[74px] bg-white border-b border-[#E5E7EB] px-7 flex items-center justify-between">

        <div class="flex items-center gap-10">

            <!-- LOGO -->
            <img 
                src="assets/img/logo/logo 2.png"
                alt="logo"
                class="h-[42px]"
            >

            <!-- SEARCH -->
            <div class="relative">

                <input 
                    type="text"
                    placeholder="Search"
                    class="w-[560px] h-[42px] rounded-full border border-[#E5E7EB] bg-[#FAFAFA] pl-12 text-[13px] outline-none"
                >

                <span class="absolute left-5 top-[11px] text-gray-400 text-[14px]">
                    🔍
                </span>

            </div>

        </div>

        <!-- RIGHT -->
        <div class="flex items-center gap-6">

            <button class="text-[18px]">🔔</button>
            <button class="text-[18px]">💬</button>
            <button class="text-[18px]">🛒</button>

            <div class="w-px h-8 bg-[#D1D5DB]"></div>

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-full bg-[#2F6DB3] flex items-center justify-center text-white text-[14px]">
                    🏪
                </div>

                <span class="text-[14px] font-medium">
                    Toko
                </span>

            </div>

            <img 
                src="assets/img/profile/user-photo-profile.png"
                class="w-11 h-11 rounded-lg object-cover"
            >

        </div>

    </nav>

    <!-- CONTENT -->
    <main class="max-w-[1180px] mx-auto px-7 pt-10 pb-20">

        <!-- TITLE -->
        <h1 class="text-[22px] font-bold text-black mb-8">
            Riwayat Transaksi
        </h1>

        <!-- ROLE -->
        <div class="mb-8">

            <button class="h-[34px] px-4 rounded-lg bg-[#DCEBFF] text-[#34699A] text-[13px] font-medium flex items-center gap-2">
                👤 Penyewa
            </button>

        </div>

        <!-- FILTER -->
        <div class="flex items-center justify-between gap-4 mb-7">

            <button class="min-w-[110px] h-[38px] rounded-full bg-[#0077A8] text-white text-[13px] font-medium">
                Semua
            </button>

            <button class="min-w-[110px] h-[38px] rounded-full border border-[#5A97D1] text-[#0077A8] bg-white text-[13px] font-medium">
                Diproses
            </button>

            <button class="min-w-[110px] h-[38px] rounded-full border border-[#5A97D1] text-[#0077A8] bg-white text-[13px] font-medium">
                Disewa
            </button>

            <button class="min-w-[140px] h-[38px] rounded-full border border-[#5A97D1] text-[#0077A8] bg-white text-[13px] font-medium">
                Pengembalian
            </button>

            <button class="min-w-[110px] h-[38px] rounded-full border border-[#5A97D1] text-[#0077A8] bg-white text-[13px] font-medium">
                Selesai
            </button>

            <button class="min-w-[120px] h-[38px] rounded-full border border-[#5A97D1] text-[#0077A8] bg-white text-[13px] font-medium">
                Bermasalah
            </button>

        </div>

        <!-- CARD 1 -->
        <div class="bg-white border border-[#D7E6FF] rounded-xl px-7 py-5 shadow-card mb-4">

            <!-- HEADER -->
            <div class="flex items-center justify-between border-b border-[#DCEBFF] pb-3">

                <div class="flex items-center gap-3">

                    <span class="text-[12px]">🎙️</span>

                    <span class="text-[14px] font-semibold">
                        Zenvy Market
                    </span>

                </div>

                <span class="h-[31px] px-5 rounded-full bg-[#F8C7CE] text-[#C44B5C] text-[13px] font-semibold flex items-center">
                    Belum Dikembalikan
                </span>

            </div>

            <!-- BODY -->
            <div class="flex justify-between py-5">

                <div class="flex gap-4">

                    <img 
                        src="assets/img/produk/drum.png"
                        class="w-[86px] h-[86px] rounded-lg object-cover"
                    >

                    <div>

                        <h3 class="text-[15px] font-semibold mb-2">
                            Drum
                        </h3>

                        <p class="text-[13px] text-[#8B8B8B] mb-1">
                            Spare
                        </p>

                        <p class="text-[13px] text-[#7B7B7B]">
                            10 Buah
                        </p>

                    </div>

                </div>

                <div class="flex items-center">

                    <span class="text-[15px] font-semibold text-[#34699A]">
                        100.000
                    </span>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="border-t border-[#DCEBFF] pt-4 flex justify-between items-end">

                <div></div>

                <div class="text-right">

                    <p class="text-[12px] text-[#8B8B8B]">
                        Total Pesanan
                    </p>

                    <h3 class="text-[18px] font-bold text-[#34699A] mt-1">
                        1.000.000
                    </h3>

                    <button class="mt-4 h-[42px] px-10 rounded-lg bg-[#34699A] text-white text-[13px] font-medium">
                        Detail Transaksi
                    </button>

                </div>

            </div>

        </div>

        <!-- CARD 2 -->
        <div class="bg-white border border-[#D7E6FF] rounded-xl px-7 py-5 shadow-card">

            <!-- HEADER -->
            <div class="flex items-center justify-between border-b border-[#DCEBFF] pb-3">

                <div class="flex items-center gap-3">

                    <span class="text-[12px]">🔵</span>

                    <span class="text-[14px] font-semibold">
                        IBOX
                    </span>

                </div>

                <span class="h-[31px] px-5 rounded-full bg-[#F8C7CE] text-[#C44B5C] text-[13px] font-semibold flex items-center">
                    Kerusakan
                </span>

            </div>

            <!-- BODY -->
            <div class="flex justify-between py-5">

                <div class="flex gap-4">

                    <img 
                        src="assets/img/produk/apple-watch.png"
                        class="w-[86px] h-[86px] rounded-lg object-cover"
                    >

                    <div>

                        <h3 class="text-[15px] font-semibold mb-2">
                            I Watch
                        </h3>

                        <p class="text-[13px] text-[#8B8B8B] mb-1">
                            Gen 4
                        </p>

                        <p class="text-[13px] text-[#7B7B7B]">
                            1 Buah
                        </p>

                    </div>

                </div>

                <div class="flex items-center">

                    <span class="text-[15px] font-semibold text-[#34699A]">
                        100.000
                    </span>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="border-t border-[#DCEBFF] pt-4 flex justify-between items-end">

                <div></div>

                <div class="text-right">

                    <p class="text-[12px] text-[#8B8B8B]">
                        Total Pesanan
                    </p>

                    <h3 class="text-[18px] font-bold text-[#34699A] mt-1">
                        100.000
                    </h3>

                    <button class="mt-4 h-[42px] px-10 rounded-lg bg-[#34699A] text-white text-[13px] font-medium">
                        Detail Transaksi
                    </button>

                </div>

            </div>

        </div>

        <!-- PAGINATION -->
        <div class="flex justify-center items-center gap-4 mt-14">

            <button class="w-[38px] h-[38px] rounded-lg border border-[#0077A8] text-[#0077A8] text-[18px]">
                ‹
            </button>

            <button class="w-[38px] h-[38px] rounded-lg border border-[#0077A8] text-[#0077A8] text-[14px] font-semibold">
                1
            </button>

            <button class="w-[38px] h-[38px] rounded-lg bg-[#0077A8] text-white text-[14px] font-semibold">
                2
            </button>

        </div>

    </main>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-[#E5E7EB]">

        <div class="max-w-[1180px] mx-auto px-7 py-14">

            <div class="grid grid-cols-3 gap-16">

                <!-- LEFT -->
                <div>

                    <img 
                        src="assets/img/logo/logo 2.png"
                        class="h-[42px] mb-6"
                    >

                    <p class="text-[14px] leading-7 text-[#3B3B3B] max-w-[280px]">
                        Platform sewa menyewa barang yang aman, mudah, dan terpercaya
                    </p>

                </div>

                <!-- CENTER -->
                <div>

                    <h3 class="text-[18px] font-semibold mb-5">
                        Quick Links
                    </h3>

                    <div class="space-y-4 text-[15px] text-[#7B7B7B]">

                        <p>Home</p>
                        <p>Riwayat</p>
                        <p>Kontak</p>

                    </div>

                </div>

                <!-- RIGHT -->
                <div>

                    <h3 class="text-[18px] font-semibold mb-5">
                        Hubungi Kami
                    </h3>

                    <div class="space-y-4 text-[15px] text-[#7B7B7B]">

                        <p>📞 +62 123 456 987</p>
                        <p>✉️ support@rentalin.com</p>
                        <p>📍 Jl. Cibubur No. 123</p>

                    </div>

                </div>

            </div>

            <!-- BOTTOM -->
            <div class="border-t border-[#D1D5DB] mt-12 pt-7 flex justify-between items-center">

                <p class="text-[14px]">
                    © 2026 Rentalin. All rights reserved
                </p>

                <div class="flex gap-5 text-[18px]">

                    <span>📷</span>
                    <span>💬</span>
                    <span>📘</span>

                </div>

            </div>

        </div>

    </footer>

</body>
</html>