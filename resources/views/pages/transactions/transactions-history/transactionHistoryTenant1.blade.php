<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi Penyewa</title>

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
<main class="w-full max-w-[435px] sm:max-w-[940px] lg:max-w-[1220px] mx-auto px-[20px] sm:px-[44px] lg:px-[66px] pt-[22px] sm:pt-[28px] pb-[42px] lg:pb-[70px]">

    <h1 class="text-[22px] font-bold mb-[16px]">
        Riwayat Transaksi
    </h1>

    <div class="mb-[18px] sm:mb-[22px]">
        <button class="h-[30px] px-[12px] sm:px-[14px] rounded-[8px] bg-[#DBEAFE] text-[#34699A] text-[16px] font-medium">
            👤 Penyewa
        </button>
    </div>

    <!-- ================= FILTER STATUS ================= -->
    <div class="flex items-center gap-[12px] sm:gap-[16px] lg:gap-[18px] lg:justify-between overflow-x-auto lg:overflow-visible pb-[12px] lg:pb-0 mb-[4px] lg:mb-[16px] flex-nowrap lg:flex-wrap [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">

        <button class="shrink-0 min-w-[92px] sm:min-w-[108px] h-[36px] lg:h-[38px] rounded-full bg-[#34699A] text-white text-[16px] sm:text-[14px] font-medium">
            Semua
        </button>

        <button class="shrink-0 min-w-[104px] sm:min-w-[108px] h-[36px] lg:h-[38px] rounded-full border border-[#34699A] bg-white text-[#34699A] text-[16px] sm:text-[14px] font-medium">
            Diproses
        </button>

        <button class="shrink-0 min-w-[94px] sm:min-w-[108px] h-[36px] lg:h-[38px] rounded-full border border-[#34699A] bg-white text-[#34699A] text-[16px] sm:text-[14px] font-medium">
            Disewa
        </button>

        <button class="shrink-0 min-w-[138px] sm:min-w-[135px] h-[36px] lg:h-[38px] rounded-full border border-[#34699A] bg-white text-[#34699A] text-[16px] sm:text-[14px] font-medium">
            Pengembalian
        </button>

        <button class="shrink-0 min-w-[98px] sm:min-w-[108px] h-[36px] lg:h-[38px] rounded-full border border-[#34699A] bg-white text-[#34699A] text-[16px] sm:text-[14px] font-medium">
            Selesai
        </button>

        <button class="shrink-0 min-w-[128px] sm:min-w-[128px] h-[36px] lg:h-[38px] rounded-full border border-[#34699A] bg-white text-[#34699A] text-[16px] sm:text-[14px] font-medium">
            Bermasalah
        </button>

    </div>

    <!-- ================= PANDUAN ================= -->
    <button class="w-full bg-[#DBEAFE] border border-[#C3DAFE] rounded-[8px] px-[14px] sm:px-[16px] lg:px-[18px] py-[13px] lg:py-[14px] mb-[12px] lg:mb-[14px] flex items-center justify-between hover:bg-[#C3DAFE]/70 transition">

        <div class="flex items-center gap-[10px] sm:gap-[12px] lg:gap-[14px]">
            <div class="text-[23px] lg:text-[27px] text-[#34699A]">
                📖
            </div>

            <div class="text-left">
                <h2 class="text-[14px] font-bold text-[#000000]">
                    Panduan Proses Transaksi
                </h2>

                <p class="text-[12px] text-[#696969] mt-[3px] lg:mt-[2px]">
                    Lihat cara transaksi dari awal hingga selesai.
                </p>
            </div>
        </div>

        <div class="text-[30px] lg:text-[28px] leading-none font-bold text-[#1E1E1E]">
            ›
        </div>

    </button>

    <!-- ================= CARD LIST ================= -->
    <div class="space-y-[12px]">

        <!-- ================= CARD 1 ================= -->
        <div class="bg-white border border-[#C3DAFE] rounded-[8px] px-[10px] sm:px-[14px] lg:px-[18px] py-[11px] lg:py-[12px] shadow-[0px_2px_4px_0px_rgba(119,155,187,0.25)]">

            <div class="flex items-center justify-between border-b border-[#C3DAFE] pb-[9px] lg:pb-[10px]">
                <div class="flex items-center gap-[8px]">
                    <span class="text-[12px]">🚙</span>
                    <span class="text-[12px] font-semibold">Vynelle Market</span>
                </div>

                <div class="h-[27px] lg:h-[28px] px-[13px] lg:px-[16px] rounded-full bg-[#C3DAFE] text-[#0076A8] text-[12px] font-medium flex items-center">
                    Diproses
                </div>
            </div>

            <div class="grid grid-cols-[72px_1fr_112px] sm:grid-cols-[110px_1fr_180px] gap-[8px] sm:gap-[16px] py-[13px] lg:py-[12px] items-center">

                <img
                    src="https://images.unsplash.com/photo-1546776310-eef45dd6d63c?q=80&w=300"
                    class="w-[72px] h-[70px] sm:w-[100px] sm:h-[82px] rounded-[6px] sm:rounded-[7px] object-cover"
                    alt="Tank"
                >

                <div class="min-w-0">
                    <h3 class="text-[13px] sm:text-[15px] lg:text-[16px] font-semibold leading-[18px] lg:leading-[20px] max-w-[520px]">
                        Tank M103 Counter Soviet Tahun 1960 Sekali Tembak Rata
                    </h3>

                    <div class="flex flex-wrap gap-[4px] lg:gap-[6px] mt-[5px] lg:mt-[6px]">
                        <span class="text-[9px] sm:text-[11px] lg:text-[12px] text-[#696969] border border-[#E3E4E4] bg-[#F9FAFB] rounded-[4px] px-[4px] lg:px-[6px]">
                            QTY: 1 Buah
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-[4px] lg:gap-[6px] mt-[4px] lg:mt-[6px]">
                        <span class="text-[9px] sm:text-[11px] lg:text-[12px] text-[#696969] border border-[#E3E4E4] bg-[#F9FAFB] rounded-[4px] px-[4px] lg:px-[6px]">
                            ID Transaksi: TRX-20260901-0042
                        </span>
                    </div>

                    <p class="text-[10px] sm:text-[11px] lg:text-[12px] text-[#696969] mt-[5px] leading-[14px] lg:leading-normal">
                        🗓️ 5 Sep 2026 - 8 Sep 2026 • 3 hari
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-[12px] text-[#696969] leading-[16px]">
                        Total Pesanan
                    </p>

                    <h3 class="text-[16px] lg:text-[18px] font-bold text-[#34699A] mt-[2px]">
                        Rp5.000.000
                    </h3>
                </div>

            </div>

            <div class="border-t border-[#C3DAFE] pt-[11px] sm:pt-[12px] grid grid-cols-3 sm:flex sm:justify-end gap-[5px] sm:gap-[10px]">

                <button class="h-[36px] sm:h-[34px] sm:px-[20px] rounded-[8px] bg-[#34699A] text-white text-[12px] font-medium leading-[1.35]">
                    Konfirmasi Penerimaan
                </button>

                <button class="h-[36px] sm:h-[34px] sm:px-[20px] rounded-[8px] border border-[#FF566A] bg-white text-[#FF566A] text-[12px] font-medium leading-[1.35]">
                    Batalkan Pesanan
                </button>

                <button class="h-[36px] sm:h-[34px] sm:px-[20px] rounded-[8px] border border-[#34699A] bg-white text-[#34699A] text-[12px] font-medium leading-[1.35]">
                    Hubungi Pemilik
                </button>

            </div>

            <div class="mt-[10px] bg-[#DBEAFE] text-[#34699A] rounded-[8px] px-[10px] lg:px-[12px] py-[9px] lg:py-[8px] text-[11px] lg:text-[12px] font-medium lg:font-semibold flex items-start gap-[8px] leading-[17px] lg:leading-normal">
                <span class="text-[16px] leading-none">ℹ️</span>
                <p>
                    Klik Konfirmasi Penerimaan jika barang sudah diterima. Hubungi pemilik untuk janjian serah terima atau menanyakan posisi paket.
                </p>
            </div>

        </div>

        <!-- ================= CARD 2 ================= -->
        <div class="bg-white border border-[#C3DAFE] rounded-[8px] px-[10px] sm:px-[14px] lg:px-[18px] py-[11px] lg:py-[12px] shadow-[0px_2px_4px_0px_rgba(119,155,187,0.25)]">

            <div class="flex items-center justify-between border-b border-[#C3DAFE] pb-[9px] lg:pb-[10px]">
                <div class="flex items-center gap-[8px]">
                    <span class="text-[12px]">🚙</span>
                    <span class="text-[12px] font-semibold">Vynelle Market</span>
                </div>

                <div class="h-[27px] lg:h-[28px] px-[13px] lg:px-[16px] rounded-full bg-[#CFF3D9] text-[#348B55] text-[12px] font-medium flex items-center">
                    Selesai
                </div>
            </div>

            <div class="grid grid-cols-[72px_1fr_112px] sm:grid-cols-[110px_1fr_180px] gap-[8px] sm:gap-[16px] py-[13px] lg:py-[12px] items-center">

                <img
                    src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?q=80&w=300"
                    class="w-[72px] h-[70px] sm:w-[100px] sm:h-[82px] rounded-[6px] sm:rounded-[7px] object-cover"
                    alt="iPhone"
                >

                <div class="min-w-0">
                    <h3 class="text-[13px] sm:text-[15px] lg:text-[16px] font-semibold leading-[18px] lg:leading-[20px] max-w-[520px]">
                        Iphone 17 Pro Max
                    </h3>

                    <div class="flex flex-wrap gap-[4px] lg:gap-[6px] mt-[5px] lg:mt-[6px]">
                        <span class="text-[9px] sm:text-[11px] lg:text-[12px] text-[#696969] border border-[#E3E4E4] bg-[#F9FAFB] rounded-[4px] px-[4px] lg:px-[6px]">
                            Varian: 100 TB
                        </span>

                        <span class="text-[9px] sm:text-[11px] lg:text-[12px] text-[#696969] border border-[#E3E4E4] bg-[#F9FAFB] rounded-[4px] px-[4px] lg:px-[6px]">
                            Jumlah: 1 Buah
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-[4px] lg:gap-[6px] mt-[4px] lg:mt-[6px]">
                        <span class="text-[9px] sm:text-[11px] lg:text-[12px] text-[#696969] border border-[#E3E4E4] bg-[#F9FAFB] rounded-[4px] px-[4px] lg:px-[6px]">
                            ID Transaksi: TRX-20260828-0187
                        </span>
                    </div>

                    <p class="text-[10px] sm:text-[11px] lg:text-[12px] text-[#696969] mt-[5px] leading-[14px] lg:leading-normal">
                        🗓️ 28 Agu 2026 - 30 Agu 2026 • 2 hari
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-[12px] text-[#696969] leading-[16px]">
                        Total Pesanan
                    </p>

                    <h3 class="text-[16px] lg:text-[18px] font-bold text-[#34699A] mt-[2px]">
                        Rp400.000
                    </h3>
                </div>

            </div>

            <div class="border-t border-[#C3DAFE] pt-[11px] sm:pt-[12px] grid grid-cols-3 sm:flex sm:justify-end gap-[5px] sm:gap-[10px]">

                <button class="h-[36px] sm:h-[34px] sm:px-[34px] rounded-[8px] bg-[#34699A] text-white text-[12px] font-medium">
                    Nilai
                </button>

                <button class="h-[36px] sm:h-[34px] sm:px-[24px] rounded-[8px] border border-[#34699A] bg-white text-[#34699A] text-[12px] font-medium">
                    Sewa Kembali
                </button>

                <button class="h-[36px] sm:h-[34px] sm:px-[24px] rounded-[8px] border border-[#34699A] bg-white text-[#34699A] text-[12px] font-medium">
                    Detail Transaksi
                </button>

            </div>

            <div class="mt-[10px] bg-[#DBEAFE] text-[#34699A] rounded-[8px] px-[10px] lg:px-[12px] py-[9px] lg:py-[8px] text-[11px] lg:text-[12px] font-medium lg:font-semibold flex items-start gap-[8px] leading-[17px] lg:leading-normal">
                <span class="text-[16px] leading-none">ℹ️</span>
                <p>Beri penilaian untuk pengalaman sewa Anda.</p>
            </div>

        </div>

        <!-- ================= CARD 3 ================= -->
        <div class="bg-white border border-[#C3DAFE] rounded-[8px] px-[10px] sm:px-[14px] lg:px-[18px] py-[11px] lg:py-[12px] shadow-[0px_2px_4px_0px_rgba(119,155,187,0.25)]">

            <div class="flex items-center justify-between border-b border-[#C3DAFE] pb-[9px] lg:pb-[10px]">
                <div class="flex items-center gap-[8px]">
                    <span class="text-[12px]">🚙</span>
                    <span class="text-[12px] font-semibold">Vynelle Market</span>
                </div>

                <div class="h-[27px] lg:h-[28px] px-[13px] lg:px-[16px] rounded-full bg-[#DDEBFF] text-[#2D85C4] text-[12px] font-medium flex items-center">
                    Disewa
                </div>
            </div>

            <div class="grid grid-cols-[72px_1fr_112px] sm:grid-cols-[110px_1fr_180px] gap-[8px] sm:gap-[16px] py-[13px] lg:py-[12px] items-center">

                <img
                    src="https://images.unsplash.com/photo-1586201375761-83865001e31c?q=80&w=300"
                    class="w-[72px] h-[70px] sm:w-[100px] sm:h-[82px] rounded-[6px] sm:rounded-[7px] object-cover"
                    alt="Kompor"
                >

                <div class="min-w-0">
                    <h3 class="text-[13px] sm:text-[15px] lg:text-[16px] font-semibold leading-[18px] lg:leading-[20px] max-w-[520px]">
                        Kompor Listrik Portable
                    </h3>

                    <div class="flex flex-wrap gap-[4px] lg:gap-[6px] mt-[5px] lg:mt-[6px]">
                        <span class="text-[9px] sm:text-[11px] lg:text-[12px] text-[#696969] border border-[#E3E4E4] bg-[#F9FAFB] rounded-[4px] px-[4px] lg:px-[6px]">
                            Jumlah: 1 Buah
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-[4px] lg:gap-[6px] mt-[4px] lg:mt-[6px]">
                        <span class="text-[9px] sm:text-[11px] lg:text-[12px] text-[#696969] border border-[#E3E4E4] bg-[#F9FAFB] rounded-[4px] px-[4px] lg:px-[6px]">
                            ID Transaksi: TRX-20260801-0042
                        </span>
                    </div>

                    <p class="text-[10px] sm:text-[11px] lg:text-[12px] text-[#696969] mt-[5px] leading-[14px] lg:leading-normal">
                        🗓️ 8 Mei 2026 - 12 Mei 2026 • 3 hari
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-[12px] text-[#696969] leading-[16px]">
                        Total Pesanan
                    </p>

                    <h3 class="text-[16px] lg:text-[18px] font-bold text-[#34699A] mt-[2px]">
                        Rp65.000
                    </h3>
                </div>

            </div>

            <div class="border-t border-[#C3DAFE] pt-[11px] sm:pt-[12px] grid grid-cols-3 sm:flex sm:justify-end gap-[5px] sm:gap-[10px]">

                <button class="h-[36px] sm:h-[34px] sm:px-[20px] rounded-[8px] bg-[#34699A] text-white text-[12px] font-medium leading-[1.35]">
                    Perpanjang Sewa
                </button>

                <button class="h-[36px] sm:h-[34px] sm:px-[20px] rounded-[8px] border border-[#34699A] bg-white text-[#34699A] text-[12px] font-medium leading-[1.35]">
                    Detail Transaksi
                </button>

                <button class="h-[36px] sm:h-[34px] sm:px-[20px] rounded-[8px] border border-[#34699A] bg-white text-[#34699A] text-[12px] font-medium leading-[1.35]">
                    Hubungi Pemilik
                </button>

            </div>

            <div class="mt-[10px] bg-[#DBEAFE] text-[#34699A] rounded-[8px] px-[10px] lg:px-[12px] py-[9px] lg:py-[8px] text-[11px] lg:text-[12px] font-medium lg:font-semibold flex items-start gap-[8px] leading-[17px] lg:leading-normal">
                <span class="text-[16px] leading-none">ℹ️</span>
                <p>
                    Klik Perpanjang Sewa jika ingin menambah durasi sewa. Hubungi Pemilik untuk koordinasi selama masa sewa.
                </p>
            </div>

        </div>

        <!-- ================= CARD 4 ================= -->
        <div class="bg-white border border-[#C3DAFE] rounded-[8px] px-[10px] sm:px-[14px] lg:px-[18px] py-[11px] lg:py-[12px] shadow-[0px_2px_4px_0px_rgba(119,155,187,0.25)]">

            <div class="flex items-center justify-between border-b border-[#C3DAFE] pb-[9px] lg:pb-[10px]">
                <div class="flex items-center gap-[8px]">
                    <span class="text-[12px]">🎧</span>
                    <span class="text-[12px] font-semibold">Vynelle Market</span>
                </div>

                <div class="h-[27px] lg:h-[28px] px-[13px] lg:px-[16px] rounded-full bg-[#FFF0C2] text-[#D38A00] text-[12px] font-medium flex items-center">
                    Pengembalian
                </div>
            </div>

            <div class="grid grid-cols-[72px_1fr_112px] sm:grid-cols-[110px_1fr_180px] gap-[8px] sm:gap-[16px] py-[13px] lg:py-[12px] items-center">

                <img
                    src="https://images.unsplash.com/photo-1517336714739-489689fd1ca8?q=80&w=300"
                    class="w-[72px] h-[70px] sm:w-[100px] sm:h-[82px] rounded-[6px] sm:rounded-[7px] object-cover"
                    alt="Macbook"
                >

                <div class="min-w-0">
                    <h3 class="text-[13px] sm:text-[15px] lg:text-[16px] font-semibold leading-[18px] lg:leading-[20px] max-w-[520px]">
                        Macbook Pro
                    </h3>

                    <div class="flex flex-wrap gap-[4px] lg:gap-[6px] mt-[5px] lg:mt-[6px]">
                        <span class="text-[9px] sm:text-[11px] lg:text-[12px] text-[#696969] border border-[#E3E4E4] bg-[#F9FAFB] rounded-[4px] px-[4px] lg:px-[6px]">
                            Jumlah: 1 Buah
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-[4px] lg:gap-[6px] mt-[4px] lg:mt-[6px]">
                        <span class="text-[9px] sm:text-[11px] lg:text-[12px] text-[#696969] border border-[#E3E4E4] bg-[#F9FAFB] rounded-[4px] px-[4px] lg:px-[6px]">
                            ID Transaksi: TRX-20260801-0042
                        </span>
                    </div>

                    <p class="text-[10px] sm:text-[11px] lg:text-[12px] text-[#696969] mt-[5px] leading-[14px] lg:leading-normal">
                        🗓️ 10 Mei 2026 - 13 Mei 2026 • 3 hari
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-[12px] text-[#696969] leading-[16px]">
                        Total Pesanan
                    </p>

                    <h3 class="text-[16px] lg:text-[18px] font-bold text-[#34699A] mt-[2px]">
                        Rp500.000
                    </h3>
                </div>

            </div>

            <div class="border-t border-[#C3DAFE] pt-[11px] sm:pt-[12px] grid grid-cols-3 sm:flex sm:justify-end gap-[5px] sm:gap-[10px]">

                <button class="h-[36px] sm:h-[34px] sm:px-[24px] rounded-[8px] bg-[#34699A] text-white text-[12px] font-medium leading-[1.35]">
                    Pesanan Dikembalikan
                </button>

                <button class="h-[36px] sm:h-[34px] sm:px-[24px] rounded-[8px] border border-[#34699A] bg-white text-[#34699A] text-[12px] font-medium leading-[1.35]">
                    Detail Transaksi
                </button>

                <button class="h-[36px] sm:h-[34px] sm:px-[24px] rounded-[8px] border border-[#34699A] bg-white text-[#34699A] text-[12px] font-medium leading-[1.35]">
                    Hubungi Pemilik
                </button>

            </div>

            <div class="mt-[10px] bg-[#DBEAFE] text-[#34699A] rounded-[8px] px-[10px] lg:px-[12px] py-[9px] lg:py-[8px] text-[11px] lg:text-[12px] font-medium lg:font-semibold flex items-start gap-[8px] leading-[17px] lg:leading-normal">
                <span class="text-[16px] leading-none">ℹ️</span>
                <p>
                    Klik Pesanan Dikembalikan setelah barang diserahkan kembali ke pemilik.
                </p>
            </div>

        </div>

        <!-- ================= CARD 5 ================= -->
        <div class="bg-white border border-[#C3DAFE] rounded-[8px] px-[10px] sm:px-[14px] lg:px-[18px] py-[11px] lg:py-[12px] shadow-[0px_2px_4px_0px_rgba(119,155,187,0.25)]">

            <div class="flex items-center justify-between border-b border-[#C3DAFE] pb-[9px] lg:pb-[10px]">
                <div class="flex items-center gap-[8px]">
                    <span class="text-[12px]">👗</span>
                    <span class="text-[12px] font-semibold">Vynelle Market</span>
                </div>

                <div class="h-[27px] lg:h-[28px] px-[13px] lg:px-[16px] rounded-full bg-[#FFD3DC] text-[#D94B63] text-[12px] font-medium flex items-center">
                    Dibatalkan
                </div>
            </div>

            <div class="grid grid-cols-[72px_1fr_112px] sm:grid-cols-[110px_1fr_180px] gap-[8px] sm:gap-[16px] py-[13px] lg:py-[12px] items-center">

                <img
                    src="https://images.unsplash.com/photo-1583391733956-6c78276477e2?q=80&w=300"
                    class="w-[72px] h-[70px] sm:w-[100px] sm:h-[82px] rounded-[6px] sm:rounded-[7px] object-cover"
                    alt="Kebaya"
                >

                <div class="min-w-0">
                    <h3 class="text-[13px] sm:text-[15px] lg:text-[16px] font-semibold leading-[18px] lg:leading-[20px] max-w-[520px]">
                        Kebaya One set
                    </h3>

                    <div class="flex flex-wrap gap-[4px] lg:gap-[6px] mt-[5px] lg:mt-[6px]">
                        <span class="text-[9px] sm:text-[11px] lg:text-[12px] text-[#696969] border border-[#E3E4E4] bg-[#F9FAFB] rounded-[4px] px-[4px] lg:px-[6px]">
                            Varian: Navy
                        </span>

                        <span class="text-[9px] sm:text-[11px] lg:text-[12px] text-[#696969] border border-[#E3E4E4] bg-[#F9FAFB] rounded-[4px] px-[4px] lg:px-[6px]">
                            Jumlah: 1 Buah
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-[4px] lg:gap-[6px] mt-[4px] lg:mt-[6px]">
                        <span class="text-[9px] sm:text-[11px] lg:text-[12px] text-[#696969] border border-[#E3E4E4] bg-[#F9FAFB] rounded-[4px] px-[4px] lg:px-[6px]">
                            ID Transaksi: TRX-20260828-0187
                        </span>
                    </div>

                    <p class="text-[10px] sm:text-[11px] lg:text-[12px] text-[#696969] mt-[5px] leading-[14px] lg:leading-normal">
                        🗓️ 8 Mei 2026 - 10 Mei 2026 • 2 hari
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-[12px] text-[#696969] leading-[16px]">
                        Total Pesanan
                    </p>

                    <h3 class="text-[16px] lg:text-[18px] font-bold text-[#34699A] mt-[2px]">
                        Rp200.000
                    </h3>
                </div>

            </div>

            <div class="border-t border-[#C3DAFE] pt-[11px] sm:pt-[12px] flex justify-end gap-[5px] sm:gap-[10px] flex-wrap">

                <button class="h-[36px] sm:h-[34px] px-[16px] sm:px-[24px] rounded-[8px] bg-[#34699A] text-white text-[12px] font-medium">
                    Detail Transaksi
                </button>

            </div>

            <div class="mt-[10px] bg-[#FFECEF] text-[#FF4D5E] rounded-[8px] px-[10px] lg:px-[12px] py-[9px] lg:py-[8px] text-[11px] lg:text-[12px] font-medium lg:font-semibold flex items-start gap-[8px] leading-[17px] lg:leading-normal">
                <span class="text-[16px] leading-none">⚠️</span>
                <p>
                    Pesanan dibatalkan. Pengembalian dana diproses sesuai kebijakan pembatalan.
                </p>
            </div>

        </div>

    </div>

    <!-- ================= PAGINATION ================= -->
    <div class="flex justify-center items-center gap-[16px] sm:gap-[14px] mt-[26px] sm:mt-[28px]">

        <button
            disabled
            class="w-[42px] h-[42px] sm:w-[38px] sm:h-[38px] rounded-[7px] sm:rounded-[6px] border border-[#D7DCE3] bg-[#EEF1F5] text-[#A7B0BC] text-[30px] sm:text-[20px] leading-none font-medium sm:font-semibold cursor-not-allowed flex items-center justify-center"
        >
            ‹
        </button>

        <button class="w-[42px] h-[42px] sm:w-[38px] sm:h-[38px] rounded-[7px] sm:rounded-[6px] bg-[#34699A] text-white text-[20px] sm:text-[14px] font-medium sm:font-semibold">
            1
        </button>

        <button class="w-[42px] h-[42px] sm:w-[38px] sm:h-[38px] rounded-[7px] sm:rounded-[6px] border border-[#34699A] sm:border-[#7BAFE3] bg-white text-[#34699A] sm:text-[#2F6EA5] text-[20px] sm:text-[14px] font-medium sm:font-semibold">
            2
        </button>

        <button class="w-[42px] h-[42px] sm:w-[38px] sm:h-[38px] rounded-[7px] sm:rounded-[6px] border border-[#34699A] sm:border-[#7BAFE3] bg-white text-[#34699A] sm:text-[#2F6EA5] text-[30px] sm:text-[20px] leading-none font-medium sm:font-semibold flex items-center justify-center">
            ›
        </button>

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