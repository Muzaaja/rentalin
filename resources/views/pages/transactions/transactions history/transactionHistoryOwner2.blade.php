<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi Pemilik - Bermasalah</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .shadow-card{
            box-shadow: 0 2px 10px rgba(15,23,42,0.03);
        }
    </style>
</head>

<body class="bg-[#F5F7FA] text-[#1F2937]">

<!-- NAVBAR -->
<nav class="h-[58px] bg-white border-b border-[#E5E7EB] px-5 flex items-center justify-between">

    <div class="flex items-center gap-8">

        <!-- LOGO -->
        <div class="flex items-center text-[19px] font-bold leading-none">

            <span class="bg-[#2F6DB3] text-white px-3 py-[5px] rounded-xl">
                Rental
            </span>

            <span class="text-[#F3C84B] ml-1">
                in
            </span>

        </div>

        <!-- SEARCH -->
        <div class="relative hidden md:block">

            <input
                type="text"
                placeholder="Search"
                class="w-[370px] h-[33px] rounded-full border border-[#E5E7EB] bg-white pl-10 pr-4 text-[11px] outline-none"
            >

            <svg class="w-4 h-4 absolute left-4 top-[9px] text-gray-400"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>

        </div>

    </div>

    <!-- RIGHT -->
    <div class="flex items-center gap-5">

        <button class="text-[14px]">🔔</button>
        <button class="text-[14px]">💬</button>
        <button class="text-[14px]">🛒</button>

        <div class="w-px h-7 bg-[#D1D5DB]"></div>

        <div class="flex items-center gap-3">

            <div class="w-9 h-9 rounded-full bg-[#2F6DB3] text-white flex items-center justify-center text-[13px]">
                🏪
            </div>

            <span class="text-[13px] font-medium">
                Toko
            </span>

        </div>

        <img
            src="https://i.pravatar.cc/100"
            class="w-10 h-10 rounded-lg object-cover"
        >

    </div>

</nav>

<!-- CONTENT -->
<main class="max-w-[1180px] mx-auto px-7 pt-9 pb-20">

    <!-- TITLE -->
    <h1 class="text-[20px] font-bold mb-6">
        Riwayat Transaksi
    </h1>

    <!-- ROLE -->
    <div class="mb-6">

        <button class="h-[31px] px-4 rounded-lg bg-[#DCEBFF] text-[#2F6DB3] text-[11px] font-semibold">
            👤 Pemilik
        </button>

    </div>

    <!-- FILTER -->
    <div class="w-full mb-7">

        <div class="flex gap-4 w-full">

            <button class="flex-1 h-[33px] rounded-full bg-[#0076A8] text-white text-[11px] font-medium">
                Semua
            </button>

            <button class="flex-1 h-[33px] rounded-full border border-[#8BB9E8] bg-white text-[#2F6DB3] text-[11px] font-medium">
                Pesanan Masuk
            </button>

            <button class="flex-1 h-[33px] rounded-full border border-[#8BB9E8] bg-white text-[#2F6DB3] text-[11px] font-medium">
                Disewa
            </button>

            <button class="flex-1 h-[33px] rounded-full border border-[#8BB9E8] bg-white text-[#2F6DB3] text-[11px] font-medium">
                Pengembalian
            </button>

            <button class="flex-1 h-[33px] rounded-full border border-[#8BB9E8] bg-white text-[#2F6DB3] text-[11px] font-medium">
                Selesai
            </button>

            <button class="flex-1 h-[33px] rounded-full border border-[#8BB9E8] bg-white text-[#2F6DB3] text-[11px] font-medium">
                Bermasalah
            </button>

        </div>

    </div>

    <!-- CARD LIST -->
    <div class="space-y-4">

        <!-- CARD 1 -->
        <div class="bg-white border border-[#D9E7FA] rounded-xl px-6 py-4 shadow-card">

            <!-- HEADER -->
            <div class="flex items-center justify-between border-b border-[#DCEBFF] pb-3">

                <div class="flex items-center gap-3">

                    <img
                        src="https://i.pravatar.cc/100?img=15"
                        class="w-7 h-7 rounded-full object-cover"
                    >

                    <span class="text-[13px] font-semibold">
                        Nugra Hasahattan
                    </span>

                </div>

                <span class="h-[27px] px-5 rounded-full bg-[#F9C8CE] text-[#D34A5C] text-[11px] font-semibold flex items-center">
                    Belum Dikembalikan
                </span>

            </div>

            <!-- BODY -->
            <div class="flex justify-between py-5">

                <div class="flex gap-4">

                    <img
                        src="https://images.unsplash.com/photo-1622279457486-62dcc4a431d6?q=80&w=300"
                        class="w-[82px] h-[82px] rounded-lg object-cover"
                    >

                    <div>

                        <h3 class="text-[14px] font-semibold">
                            Raket Tenis
                        </h3>

                        <p class="text-[11px] text-gray-400 mt-2">
                            Putih
                        </p>

                        <p class="text-[11px] text-gray-500 mt-1">
                            1 Buah
                        </p>

                    </div>

                </div>

                <div class="text-right pt-5">

                    <h3 class="text-[18px] font-bold text-[#34699A]">
                        20.000
                    </h3>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="border-t border-[#DCEBFF] pt-4">

                <div class="flex justify-end">

                    <div class="text-right">

                        <p class="text-[10px] text-gray-400">
                            Total Pesanan
                        </p>

                        <h3 class="text-[16px] font-bold text-[#34699A] mt-1">
                            20.000
                        </h3>

                    </div>

                </div>

                <!-- BUTTON -->
                <div class="flex justify-end gap-3 mt-4">

                    <button class="h-[35px] w-[172px] rounded-lg bg-[#34699A] text-white text-[11px] font-medium">
                        Detail Transaksi
                    </button>

                    <button class="h-[35px] w-[172px] rounded-lg bg-[#34699A] text-white text-[11px] font-medium">
                        Hubungi Pemilik
                    </button>

                </div>

            </div>

        </div>

        <!-- CARD 2 -->
        <div class="bg-white border border-[#D9E7FA] rounded-xl px-6 py-4 shadow-card">

            <!-- HEADER -->
            <div class="flex items-center justify-between border-b border-[#DCEBFF] pb-3">

                <div class="flex items-center gap-3">

                    <img
                        src="https://i.pravatar.cc/100?img=18"
                        class="w-7 h-7 rounded-full object-cover"
                    >

                    <span class="text-[13px] font-semibold">
                        Nugra Hasahattan
                    </span>

                </div>

                <span class="h-[27px] px-5 rounded-full bg-[#F9C8CE] text-[#D34A5C] text-[11px] font-semibold flex items-center">
                    Kerusakan
                </span>

            </div>

            <!-- BODY -->
            <div class="flex justify-between py-5">

                <div class="flex gap-4">

                    <img
                        src="https://images.unsplash.com/photo-1696446701796-da61225697cc?q=80&w=300"
                        class="w-[82px] h-[82px] rounded-lg object-cover"
                    >

                    <div>

                        <h3 class="text-[14px] font-semibold">
                            Iphone 16 Pro Max
                        </h3>

                        <p class="text-[11px] text-gray-400 mt-2">
                            1000TB
                        </p>

                        <p class="text-[11px] text-gray-500 mt-1">
                            1 Buah
                        </p>

                    </div>

                </div>

                <div class="text-right pt-5">

                    <h3 class="text-[18px] font-bold text-[#34699A]">
                        115.000
                    </h3>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="border-t border-[#DCEBFF] pt-4">

                <div class="flex justify-end">

                    <div class="text-right">

                        <p class="text-[10px] text-gray-400">
                            Total Pesanan
                        </p>

                        <h3 class="text-[16px] font-bold text-[#34699A] mt-1">
                            125.000
                        </h3>

                    </div>

                </div>

                <!-- BUTTON -->
                <div class="flex justify-end gap-3 mt-4">

                    <button class="h-[35px] w-[172px] rounded-lg bg-[#34699A] text-white text-[11px] font-medium">
                        Detail Transaksi
                    </button>

                    <button class="h-[35px] w-[172px] rounded-lg bg-[#34699A] text-white text-[11px] font-medium">
                        Hubungi Pemilik
                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- PAGINATION -->
    <div class="flex justify-center items-center gap-4 mt-12">

        <button class="w-9 h-9 rounded-lg border border-[#0B82B7] bg-white text-[#0B82B7] text-[14px]">
            ‹
        </button>

        <button class="w-9 h-9 rounded-lg border border-[#0B82B7] bg-white text-[#0B82B7] text-[13px] font-medium">
            1
        </button>

        <button class="w-9 h-9 rounded-lg bg-[#0076A8] text-white text-[13px] font-medium">
            2
        </button>

    </div>

</main>

<!-- FOOTER -->
<footer class="bg-white border-t border-[#E5E7EB] mt-10">

    <div class="max-w-[1180px] mx-auto px-7 py-12">

        <div class="grid grid-cols-3 gap-16">

            <!-- BRAND -->
            <div>

                <div class="flex items-center text-[19px] font-bold leading-none mb-5">

                    <span class="bg-[#2F6DB3] text-white px-3 py-[5px] rounded-xl">
                        Rental
                    </span>

                    <span class="text-[#F3C84B] ml-1">
                        in
                    </span>

                </div>

                <p class="text-[13px] leading-7 text-gray-700 max-w-[250px]">
                    Platform sewa menyewa barang yang aman, mudah, dan terpercaya
                </p>

            </div>

            <!-- LINKS -->
            <div>

                <h3 class="text-[15px] font-semibold mb-5">
                    Quick Links
                </h3>

                <div class="space-y-3 text-[13px] text-gray-500">

                    <p>Home</p>
                    <p>Riwayat</p>
                    <p>Kontak</p>

                </div>

            </div>

            <!-- CONTACT -->
            <div>

                <h3 class="text-[15px] font-semibold mb-5">
                    Hubungi Kami
                </h3>

                <div class="space-y-3 text-[13px] text-gray-500">

                    <p>📞 +62 123 456 987</p>
                    <p>✉️ support@rentalin.com</p>
                    <p>📍 Jl. Cibubur No. 123</p>

                </div>

            </div>

        </div>

        <!-- BOTTOM -->
        <div class="border-t border-[#D1D5DB] mt-10 pt-6 flex items-center justify-between">

            <p class="text-[13px]">
                © 2026 Rentalin. All rights reserved
            </p>

            <div class="flex gap-4 text-[17px]">

                <span>📷</span>
                <span>💬</span>
                <span>📘</span>

            </div>

        </div>

    </div>

</footer>

</body>
</html>