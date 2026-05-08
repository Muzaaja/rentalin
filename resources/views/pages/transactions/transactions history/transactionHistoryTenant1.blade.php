<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body{
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .card-shadow{
            box-shadow: 0px 2px 8px rgba(15, 23, 42, 0.03);
        }
    </style>
</head>

<body class="bg-[#F5F7FA] text-[#1E1E1E]">

<!-- ================= NAVBAR ================= -->
<nav class="w-full h-[58px] bg-white border-b border-[#E7EAF0] px-[18px] flex items-center justify-between">

    <!-- LEFT -->
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
        >

    </div>

</nav>

<!-- ================= CONTENT ================= -->
<main class="max-w-[1220px] mx-auto px-[66px] pt-[28px] pb-[90px]">

    <!-- TITLE -->
    <h1 class="text-[22px] font-bold mb-[22px]">
        Riwayat Transaksi
    </h1>

    <!-- ROLE -->
    <div class="mb-[24px]">

        <button class="h-[30px] px-[14px] rounded-[8px] bg-[#DDEBFF] text-[#34699A] text-[12px] font-semibold">
            👤 Penyewa
        </button>

    </div>

    <!-- FILTER -->
    <div class="flex items-center justify-between gap-[18px] mb-[16px] flex-wrap">

        <!-- ACTIVE -->
        <button class="min-w-[108px] h-[38px] rounded-full bg-[#0077A8] text-white text-[13px] font-medium">
            Semua
        </button>

        <!-- NORMAL -->
        <button class="min-w-[108px] h-[38px] rounded-full border border-[#7BAFE3] bg-white text-[#2F6EA5] text-[13px] font-medium">
            Diproses
        </button>

        <button class="min-w-[108px] h-[38px] rounded-full border border-[#7BAFE3] bg-white text-[#2F6EA5] text-[13px] font-medium">
            Disewa
        </button>

        <button class="min-w-[135px] h-[38px] rounded-full border border-[#7BAFE3] bg-white text-[#2F6EA5] text-[13px] font-medium">
            Pengembalian
        </button>

        <button class="min-w-[108px] h-[38px] rounded-full border border-[#7BAFE3] bg-white text-[#2F6EA5] text-[13px] font-medium">
            Selesai
        </button>

        <button class="min-w-[128px] h-[38px] rounded-full border border-[#7BAFE3] bg-white text-[#2F6EA5] text-[13px] font-medium">
            Bermasalah
        </button>

    </div>

    <!-- CARD LIST -->
<div class="space-y-[12px]">

    <!-- ================= CARD 1 ================= -->
    <div class="bg-white border border-[#D7E5FA] rounded-[10px] px-[22px] py-[14px]">

        <!-- HEADER -->
        <div class="flex items-center justify-between border-b border-[#DDE8F5] pb-[12px]">

            <div class="flex items-center gap-[8px]">
                <span class="text-[11px]">🛒</span>

                <span class="text-[12px] font-semibold text-[#1E1E1E]">
                    Vynelle Market
                </span>
            </div>

            <div class="h-[26px] px-[16px] rounded-full bg-[#CFF3D9] text-[#348B55] text-[11px] font-semibold flex items-center">
                Selesai
            </div>

        </div>

        <!-- BODY -->
        <div class="flex justify-between py-[16px]">

            <div class="flex gap-[14px]">

                <img
                    src="https://images.unsplash.com/photo-1546776310-eef45dd6d63c?q=80&w=300"
                    class="w-[72px] h-[72px] rounded-[6px] object-cover"
                >

                <div>

                    <h3 class="text-[13px] font-semibold leading-[20px] max-w-[430px]">
                        Tank M103 Counter Soviet Tahun 1960 Sekali Tembak Rata
                    </h3>

                    <p class="text-[11px] text-[#8A94A3] mt-[2px]">
                        M10
                    </p>

                    <p class="text-[11px] text-[#6E7682] mt-[2px]">
                        1 Buah
                    </p>

                </div>

            </div>

            <div class="flex flex-col justify-end items-end">

                <span class="text-[13px] font-semibold text-[#34699A]">
                    5.000.000
                </span>

            </div>

        </div>

        <!-- FOOTER -->
        <div class="border-t border-[#DDE8F5] pt-[12px]">

            <div class="flex justify-end">

                <div class="text-right">

                    <p class="text-[10px] text-[#8A94A3]">
                        Total Pesanan
                    </p>

                    <h3 class="text-[15px] font-bold text-[#34699A] mt-[2px]">
                        5.000.000
                    </h3>

                </div>

            </div>

            <div class="flex justify-end gap-[10px] mt-[14px] flex-wrap">

                <button class="h-[34px] px-[18px] rounded-[6px] bg-[#34699A] text-white text-[11px] font-medium">
                    Sewa Kembali
                </button>

                <button class="h-[34px] px-[18px] rounded-[6px] bg-[#34699A] text-white text-[11px] font-medium">
                    Detail Transaksi
                </button>

                <button class="h-[34px] px-[18px] rounded-[6px] bg-[#34699A] text-white text-[11px] font-medium">
                    Nilai
                </button>

            </div>

        </div>

    </div>

    <!-- ================= CARD 2 ================= -->
    <div class="bg-white border border-[#D7E5FA] rounded-[10px] px-[22px] py-[14px]">

        <div class="flex items-center justify-between border-b border-[#DDE8F5] pb-[12px]">

            <div class="flex items-center gap-[8px]">
                <span class="text-[11px]">🛒</span>

                <span class="text-[12px] font-semibold">
                    Velisse Shop
                </span>
            </div>

            <div class="h-[26px] px-[16px] rounded-full bg-[#DDEBFF] text-[#2D85C4] text-[11px] font-semibold flex items-center">
                Diproses
            </div>

        </div>

        <div class="flex justify-between py-[16px]">

            <div class="flex gap-[14px]">

                <img
                    src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?q=80&w=300"
                    class="w-[72px] h-[72px] rounded-[6px] object-cover"
                >

                <div>

                    <h3 class="text-[13px] font-semibold">
                        Iphone 17 Pro Max
                    </h3>

                    <p class="text-[11px] text-[#8A94A3] mt-[2px]">
                        100 TB
                    </p>

                    <p class="text-[11px] text-[#6E7682] mt-[2px]">
                        2 Buah
                    </p>

                </div>

            </div>

            <div class="flex flex-col justify-end items-end">

                <span class="text-[13px] font-semibold text-[#34699A]">
                    100.000
                </span>

            </div>

        </div>

        <div class="border-t border-[#DDE8F5] pt-[12px]">

            <div class="flex justify-end">

                <div class="text-right">

                    <p class="text-[10px] text-[#8A94A3]">
                        Total Pesanan
                    </p>

                    <h3 class="text-[15px] font-bold text-[#34699A] mt-[2px]">
                        200.000
                    </h3>

                </div>

            </div>

            <div class="flex justify-end gap-[10px] mt-[14px] flex-wrap">

                <button class="h-[34px] px-[18px] rounded-[6px] bg-[#34699A] text-white text-[11px] font-medium">
                    Konfirmasi Penerimaan
                </button>

                <button class="h-[34px] px-[18px] rounded-[6px] bg-[#34699A] text-white text-[11px] font-medium">
                    Batalkan Pesanan
                </button>

                <button class="h-[34px] px-[18px] rounded-[6px] bg-[#34699A] text-white text-[11px] font-medium">
                    Hubungi Pemilik
                </button>

            </div>

        </div>

    </div>

    <!-- ================= CARD 3 ================= -->
    <div class="bg-white border border-[#D7E5FA] rounded-[10px] px-[22px] py-[14px]">

        <div class="flex items-center justify-between border-b border-[#DDE8F5] pb-[12px]">

            <div class="flex items-center gap-[8px]">
                <span class="text-[11px]">🛒</span>

                <span class="text-[12px] font-semibold">
                    Lunara Store
                </span>
            </div>

            <div class="h-[26px] px-[16px] rounded-full bg-[#DDEBFF] text-[#2D85C4] text-[11px] font-semibold flex items-center">
                Disewa
            </div>

        </div>

        <div class="flex justify-between py-[16px]">

            <div class="flex gap-[14px]">

                <img
                    src="https://images.unsplash.com/photo-1586201375761-83865001e31c?q=80&w=300"
                    class="w-[72px] h-[72px] rounded-[6px] object-cover"
                >

                <div>

                    <h3 class="text-[13px] font-semibold">
                        Kompor Listrik Portable
                    </h3>

                    <p class="text-[11px] text-[#8A94A3] mt-[2px]">
                        -
                    </p>

                    <p class="text-[11px] text-[#6E7682] mt-[2px]">
                        1 Buah
                    </p>

                </div>

            </div>

            <div class="flex flex-col justify-end items-end">

                <span class="text-[13px] font-semibold text-[#34699A]">
                    65.000
                </span>

            </div>

        </div>

        <div class="border-t border-[#DDE8F5] pt-[12px]">

            <div class="flex justify-end">

                <div class="text-right">

                    <p class="text-[10px] text-[#8A94A3]">
                        Total Pesanan
                    </p>

                    <h3 class="text-[15px] font-bold text-[#34699A] mt-[2px]">
                        65.000
                    </h3>

                </div>

            </div>

            <div class="flex justify-end gap-[10px] mt-[14px] flex-wrap">

                <button class="h-[34px] px-[18px] rounded-[6px] bg-[#34699A] text-white text-[11px] font-medium">
                    Perpanjang Sewa
                </button>

                <button class="h-[34px] px-[18px] rounded-[6px] bg-[#34699A] text-white text-[11px] font-medium">
                    Detail Transaksi
                </button>

                <button class="h-[34px] px-[18px] rounded-[6px] bg-[#34699A] text-white text-[11px] font-medium">
                    Hubungi Pemilik
                </button>

            </div>

        </div>

    </div>

    <!-- ================= CARD 4 ================= -->
    <div class="bg-white border border-[#D7E5FA] rounded-[10px] px-[22px] py-[14px]">

        <div class="flex items-center justify-between border-b border-[#DDE8F5] pb-[12px]">

            <div class="flex items-center gap-[8px]">
                <span class="text-[11px]">🛒</span>

                <span class="text-[12px] font-semibold">
                    Seliora Store
                </span>
            </div>

            <div class="h-[26px] px-[16px] rounded-full bg-[#FFF0C2] text-[#D38A00] text-[11px] font-semibold flex items-center">
                Pengembalian
            </div>

        </div>

        <div class="flex justify-between py-[16px]">

            <div class="flex gap-[14px]">

                <img
                    src="https://images.unsplash.com/photo-1517336714739-489689fd1ca8?q=80&w=300"
                    class="w-[72px] h-[72px] rounded-[6px] object-cover"
                >

                <div>

                    <h3 class="text-[13px] font-semibold">
                        Macbook Pro
                    </h3>

                    <p class="text-[11px] text-[#8A94A3] mt-[2px]">
                        M4
                    </p>

                    <p class="text-[11px] text-[#6E7682] mt-[2px]">
                        1 Buah
                    </p>

                </div>

            </div>

            <div class="flex flex-col justify-end items-end">

                <span class="text-[13px] font-semibold text-[#34699A]">
                    500.000
                </span>

            </div>

        </div>

        <div class="border-t border-[#DDE8F5] pt-[12px]">

            <div class="flex justify-end">

                <div class="text-right">

                    <p class="text-[10px] text-[#8A94A3]">
                        Total Pesanan
                    </p>

                    <h3 class="text-[15px] font-bold text-[#34699A] mt-[2px]">
                        500.000
                    </h3>

                </div>

            </div>

            <div class="flex justify-end gap-[10px] mt-[14px] flex-wrap">

                <button class="h-[34px] px-[18px] rounded-[6px] bg-[#34699A] text-white text-[11px] font-medium">
                    Pesanan Dikembalikan
                </button>

                <button class="h-[34px] px-[18px] rounded-[6px] bg-[#34699A] text-white text-[11px] font-medium">
                    Detail Transaksi
                </button>

                <button class="h-[34px] px-[18px] rounded-[6px] bg-[#34699A] text-white text-[11px] font-medium">
                    Hubungi Pemilik
                </button>

            </div>

        </div>

    </div>

    <!-- ================= CARD 5 ================= -->
    <div class="bg-white border border-[#D7E5FA] rounded-[10px] px-[22px] py-[14px]">

        <div class="flex items-center justify-between border-b border-[#DDE8F5] pb-[12px]">

            <div class="flex items-center gap-[8px]">
                <span class="text-[11px]">🛒</span>

                <span class="text-[12px] font-semibold">
                    Vynelle Market
                </span>
            </div>

            <div class="h-[26px] px-[16px] rounded-full bg-[#CFF3D9] text-[#348B55] text-[11px] font-semibold flex items-center">
                Selesai
            </div>

        </div>

        <div class="flex justify-between py-[16px]">

            <div class="flex gap-[14px]">

                <img
                    src="https://images.unsplash.com/photo-1583391733956-6c78276477e2?q=80&w=300"
                    class="w-[72px] h-[72px] rounded-[6px] object-cover"
                >

                <div>

                    <h3 class="text-[13px] font-semibold">
                        Kebaya One Set
                    </h3>

                    <p class="text-[11px] text-[#8A94A3] mt-[2px]">
                        Navy
                    </p>

                    <p class="text-[11px] text-[#6E7682] mt-[2px]">
                        4 Buah
                    </p>

                </div>

            </div>

            <div class="flex flex-col justify-end items-end">

                <span class="text-[13px] font-semibold text-[#34699A]">
                    100.000
                </span>

            </div>

        </div>

        <div class="border-t border-[#DDE8F5] pt-[12px]">

            <div class="flex justify-end">

                <div class="text-right">

                    <p class="text-[10px] text-[#8A94A3]">
                        Total Pesanan
                    </p>

                    <h3 class="text-[15px] font-bold text-[#34699A] mt-[2px]">
                        400.000
                    </h3>

                </div>

            </div>

            <div class="flex justify-end gap-[10px] mt-[14px] flex-wrap">

                <button class="h-[34px] px-[18px] rounded-[6px] bg-[#34699A] text-white text-[11px] font-medium">
                    Detail Transaksi
                </button>

            </div>

        </div>

    </div>

</div>

    <!-- PAGINATION -->
    <div class="flex justify-center items-center gap-[12px] mt-[48px]">

        <button class="w-[36px] h-[36px] rounded-[6px] bg-[#0077A8] text-white text-[13px] font-semibold">
            1
        </button>

        <button class="w-[36px] h-[36px] rounded-[6px] border border-[#7BAFE3] text-[#2F6EA5] text-[13px] font-semibold bg-white">
            2
        </button>

        <button class="w-[36px] h-[36px] rounded-[6px] border border-[#7BAFE3] text-[#2F6EA5] text-[16px] font-semibold bg-white">
            ›
        </button>

    </div>

</main>

<!-- ================= FOOTER ================= -->
<footer class="bg-white border-t border-[#E5EAF0]">

    <div class="max-w-[1220px] mx-auto px-[66px] py-[42px]">

        <div class="grid grid-cols-3 gap-[40px]">

            <!-- LEFT -->
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

            <!-- CENTER -->
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

            <!-- RIGHT -->
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

        <!-- BOTTOM -->
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

</body>
</html>