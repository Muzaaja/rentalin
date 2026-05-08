<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpanjangan Sewa</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .shadow-card {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        .duration-active {
            border: 1.5px solid #93C5FD;
            background: #EFF6FF;
        }
    </style>
</head>

<body class="bg-[#F5F7FB] text-gray-800">

    <!-- NAVBAR -->
    <nav class="bg-white border-b border-gray-200 h-[58px] px-5 flex items-center justify-between">

        <div class="flex items-center gap-8">

            <!-- LOGO -->
            <div class="text-[20px] font-bold leading-none">
                <span class="bg-[#2F6DB3] text-white px-3 py-1 rounded-xl">
                    Rental
                </span>
                <span class="text-[#F3C84B]">in</span>
            </div>

            <!-- SEARCH -->
            <div class="relative hidden md:block">
                <input
                    type="text"
                    placeholder="Search"
                    class="w-[550px] h-[36px] rounded-full border border-gray-200 bg-[#FAFAFA] pl-10 pr-4 text-[13px] outline-none">

                <svg class="w-4 h-4 absolute left-4 top-[10px] text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

        </div>

        <!-- RIGHT -->
        <div class="flex items-center gap-5 text-[14px]">

            <button>🔔</button>
            <button>💬</button>
            <button>🛒</button>

            <div class="w-px h-7 bg-gray-300"></div>

            <div class="w-9 h-9 rounded-full bg-[#2F6DB3] text-white flex items-center justify-center text-sm">
                🏪
            </div>

            <span class="font-medium">Toko</span>

            <img
                src="https://i.pravatar.cc/100"
                class="w-10 h-10 rounded-lg object-cover">

        </div>

    </nav>

    <!-- CONTENT -->
    <main class="max-w-[930px] mx-auto py-8 px-4">

        <!-- TITLE -->
        <div class="flex items-center gap-4 mb-6">

            <button class="w-10 h-10 rounded-full border border-gray-300 bg-white flex items-center justify-center text-lg">
                ←
            </button>

            <h1 class="text-[24px] font-bold">
                Perpanjangan Sewa
            </h1>

        </div>

        <!-- CARD BARANG -->
        <section class="bg-white rounded-xl border border-gray-200 shadow-card p-6">

            <div class="flex justify-between items-center mb-5">

                <h2 class="text-[16px] font-bold">
                    Barang yang Disewa
                </h2>

                <div class="flex items-center gap-2 text-[12px]">

                    <span class="text-gray-500">
                        Disewakan oleh
                    </span>

                    <div class="w-6 h-6 bg-blue-100 rounded-md"></div>

                    <span class="font-semibold text-[14px]">
                        IBOX
                    </span>

                </div>

            </div>

            <!-- ITEM -->
            <div class="border border-blue-100 rounded-xl p-4 flex justify-between items-center">

                <div class="flex items-center gap-4">

                    <img
                        src="https://images.unsplash.com/photo-1586201375761-83865001e31c?q=80&w=300"
                        class="w-16 h-16 rounded-lg object-cover">

                    <div>

                        <h3 class="text-[14px] font-bold">
                            Kompor Listrik Portable
                        </h3>

                        <p class="text-[12px] text-gray-500 mt-1">
                            1 Buah
                        </p>

                    </div>

                </div>

                <div class="text-right">

                    <p class="text-[11px] text-gray-400">
                        Harga sewa
                    </p>

                    <h3 class="text-[14px] font-semibold text-[#2F6DB3]">
                        Rp65.000/hari
                    </h3>

                </div>

            </div>

            <!-- DETAIL -->
            <div class="mt-5 space-y-2 text-[14px]">

                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal mulai sewa</span>
                    <span class="text-[#2F6DB3]">8 Mei 2026</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal berakhir (sekarang)</span>
                    <span class="text-orange-500">12 Mei 2026</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Sisa waktu sewa</span>
                    <span class="text-red-500 font-medium">6 jam lagi</span>
                </div>

            </div>

        </section>

        <!-- DURASI -->
        <section class="bg-white rounded-xl border border-gray-200 shadow-card p-6 mt-4">

            <h2 class="text-[16px] font-bold">
                Pilih Durasi Perpanjangan
            </h2>

            <p class="text-[13px] text-gray-500 mt-1 mb-5">
                Pilih paket cepat atau atur tanggal secara manual:
            </p>

            <!-- GRID -->
            <div class="grid grid-cols-2 gap-4">

                <!-- ACTIVE -->
                <div class="duration-active rounded-xl p-4 cursor-pointer">

                    <h3 class="text-[14px] font-semibold text-[#2F6DB3]">
                        +1 hari
                    </h3>

                    <p class="text-[13px] text-gray-500 mt-1">
                        Sampai 13 Mei 2026
                    </p>

                    <div class="mt-4 text-[14px] font-semibold text-[#2F6DB3]">
                        Rp65.000/hari
                    </div>

                </div>

                <!-- ITEM -->
                <div class="border border-blue-100 rounded-xl p-4 cursor-pointer">

                    <h3 class="text-[14px] font-semibold text-[#2F6DB3]">
                        +3 hari
                    </h3>

                    <p class="text-[13px] text-gray-500 mt-1">
                        Sampai 15 Mei 2026
                    </p>

                    <div class="mt-4 text-[14px] font-semibold text-[#2F6DB3]">
                        Rp195.000/hari
                    </div>

                </div>

                <!-- ITEM -->
                <div class="border border-blue-100 rounded-xl p-4 cursor-pointer">

                    <h3 class="text-[14px] font-semibold text-[#2F6DB3]">
                        +7 hari
                    </h3>

                    <p class="text-[13px] text-gray-500 mt-1">
                        Sampai 19 Mei 2026
                    </p>

                    <div class="mt-4 text-[14px] font-semibold text-[#2F6DB3]">
                        Rp455.000/hari
                    </div>

                </div>

                <!-- ITEM -->
                <div class="border border-blue-100 rounded-xl p-4 cursor-pointer">

                    <h3 class="text-[14px] font-semibold text-[#2F6DB3]">
                        +14 hari
                    </h3>

                    <p class="text-[13px] text-gray-500 mt-1">
                        Sampai 26 Mei 2026
                    </p>

                    <div class="mt-4 text-[14px] font-semibold text-[#2F6DB3]">
                        Rp910.000/hari
                    </div>

                </div>

            </div>

            <!-- INPUT -->
            <div class="mt-6">

                <p class="text-[13px] text-gray-500 mb-3">
                    Atau atur tanggal manual:
                </p>

                <div class="grid grid-cols-2 gap-4">

                    <div>

                        <label class="block text-[13px] font-medium mb-2">
                            Perpanjang sampai
                        </label>

                        <input
                            type="date"
                            class="w-full h-[42px] rounded-xl border border-gray-200 px-4 text-[13px] outline-none">

                    </div>

                    <div>

                        <label class="block text-[13px] font-medium mb-2">
                            Total durasi tambahan
                        </label>

                        <input
                            type="text"
                            value="1 hari"
                            class="w-full h-[42px] rounded-xl border border-gray-200 px-4 text-[13px] outline-none">

                    </div>

                </div>

            </div>

        </section>

        <!-- CATATAN -->
        <section class="bg-white rounded-xl border border-gray-200 shadow-card p-6 mt-4">

            <h2 class="text-[16px] font-bold mb-4">
                Catatan (Opsional)
            </h2>

            <textarea
                rows="4"
                placeholder="Contoh: Saya perlu tambahan waktu karena acara mendadak. Terima kasih."
                class="w-full border border-gray-200 rounded-xl p-4 text-[13px] outline-none resize-none"></textarea>

        </section>

        <!-- RINGKASAN -->
        <section class="bg-white rounded-xl border border-gray-200 shadow-card p-6 mt-4">

            <h2 class="text-[16px] font-bold mb-5">
                Ringkasan Pembayaran
            </h2>

            <div class="space-y-3 text-[14px]">

                <div class="flex justify-between">
                    <span class="text-gray-500">Harga sewa</span>
                    <span>Rp65.000/hari</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Durasi tambahan</span>
                    <span>1 hari</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Subtotal</span>
                    <span>Rp65.000</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Biaya platform (2%)</span>
                    <span>Rp1.300</span>
                </div>

                <div class="border-t pt-4 flex justify-between font-bold text-[16px]">
                    <span>Total Pembayaran</span>
                    <span class="text-[#2F6DB3]">Rp66.300</span>
                </div>

            </div>

            <!-- PAYMENT -->
            <div class="mt-7">

                <h3 class="text-[11px] uppercase tracking-widest text-gray-400 font-bold mb-4">
                    Metode Pembayaran
                </h3>

                <div class="space-y-3">

                    <!-- ACTIVE -->
                    <label class="border border-[#2F6DB3] bg-blue-50 rounded-xl p-4 flex items-center justify-between cursor-pointer">

                        <div class="flex items-center gap-3">

                            <input type="radio" checked>

                            <div>

                                <div class="font-semibold text-[14px]">
                                    Transfer Bank
                                </div>

                                <div class="text-[12px] text-gray-500">
                                    BCA, Mandiri, BNI, BRI
                                </div>

                            </div>

                        </div>

                        <span class="bg-white px-2 py-1 rounded text-[11px] text-[#2F6DB3]">
                            VA
                        </span>

                    </label>
                    
                    <!-- ITEM -->
                    <label class="border border-gray-200 rounded-xl p-4 flex items-center justify-between cursor-pointer">

                        <div class="flex items-center gap-3">

                            <input type="radio">

                            <div>

                                <div class="font-semibold text-[14px]">
                                    GoPay / OVO / Dana
                                </div>

                                <div class="text-[12px] text-gray-500">
                                    Pembayaran instan
                                </div>

                            </div>

                        </div>

                        <span class="bg-gray-100 px-2 py-1 rounded text-[11px] text-gray-500">
                            e-W
                        </span>

                    </label>

                </div>

            </div>

        </section>

        <!-- INFO -->
        <div class="mt-4 bg-blue-50 border border-blue-100 rounded-xl px-4 py-3 text-[13px] text-[#2F6DB3]">
            ℹ️ Perpanjangan perlu disetujui pemilik. Jika pemilik tidak merespons dalam 2 jam, perpanjangan otomatis disetujui.
        </div>

        <!-- BUTTON -->
        <div class="flex justify-end gap-3 mt-6">

            <button class="px-6 h-[42px] rounded-xl border border-gray-300 bg-white text-[14px] font-medium">
                Batal
            </button>

            <button class="px-7 h-[42px] rounded-xl bg-[#2F6DB3] text-white text-[14px] font-medium">
                Ajukan Perpanjangan →
            </button>

        </div>

    </main>

</body>

</html>