<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tinjau Klaim Kerusakan</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body{
            font-family: 'Plus Jakarta Sans', sans-serif;
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
            alt="Profile"
        >
    </div>

</nav>

<!-- ================= CONTENT ================= -->
<main class="max-w-[1220px] mx-auto px-[66px] pt-[34px] pb-[90px]">

    <!-- PAGE HEADER -->
    <div class="flex items-start gap-[12px] mb-[28px]">
        <button class="w-[34px] h-[34px] rounded-full border border-[#1E1E1E] flex items-center justify-center text-[18px] mt-[2px]">
            ←
        </button>

        <div>
            <h1 class="text-[22px] font-bold leading-none">
                Tinjau Klaim Kerusakan
            </h1>

            <p class="text-[14px] text-[#5F6773] mt-[10px]">
                Pemilik melaporkan adanya kerusakan setelah barang dikembalikan. Tinjau detail klaim dan pilih tindakan Anda.
            </p>
        </div>
    </div>

    <!-- WARNING ALERT -->
    <div class="w-full bg-[#FFF2C7] rounded-[8px] px-[26px] py-[18px] flex items-center gap-[20px] mb-[36px]">
        <div class="w-[52px] h-[52px] rounded-full flex items-center justify-center text-[30px] text-[#F39C12] flex-shrink-0">
            ⚠
        </div>

        <div>
            <h2 class="text-[18px] font-bold">
                Klaim kerusakan menunggu respon Anda
            </h2>

            <div class="flex items-center gap-[10px] mt-[10px] text-[14px]">
                <span class="font-semibold text-[#404856]">Batas respons:</span>
                <span class="font-bold text-[#FF8A00]">14 Mei 2026, 23.59 WIB</span>
            </div>
        </div>
    </div>

    <!-- INFORMASI BARANG -->
    <section class="bg-white border border-[#E5EAF0] rounded-[8px] shadow-[0px_2px_6px_rgba(0,0,0,0.06)] px-[28px] py-[20px] mb-[26px]">
        <div class="flex items-center justify-between mb-[18px]">
            <h2 class="text-[16px] font-bold">
                Informasi Barang
            </h2>

            <div class="h-[28px] px-[16px] rounded-full bg-[#FFD6DB] text-[#D94B63] text-[12px] font-semibold flex items-center">
                Kerusakan
            </div>
        </div>

        <div class="grid grid-cols-[1.3fr_0.9fr] gap-[26px] items-start">

            <!-- LEFT -->
            <div class="flex gap-[18px]">
                <img
                    src="https://images.unsplash.com/photo-1580910051074-3eb694886505?q=80&w=300"
                    class="w-[108px] h-[108px] rounded-[8px] object-cover border border-[#E7EAF0]"
                    alt="Kompor Listrik Portable"
                >

                <div class="flex-1 pt-[4px]">
                    <div class="flex items-center gap-[10px] mb-[10px]">
                        <span class="text-[17px]">🏷️</span>
                        <h3 class="text-[20px] font-bold">
                            Kompor Listrik Portable
                        </h3>
                    </div>

                    <div class="inline-flex h-[22px] px-[8px] rounded-[4px] bg-[#F2F4F7] text-[#8A94A3] text-[11px] items-center mb-[14px]">
                        QTY: 1 Buah
                    </div>

                    <div class="space-y-[12px] text-[14px]">
                        <div class="flex items-center gap-[10px]">
                            <span class="text-[16px]">🏪</span>
                            <span class="font-semibold">Lunara Store</span>
                            <span class="text-[14px]">🛒</span>
                        </div>

                        <div class="flex items-center gap-[10px]">
                            <span class="text-[16px]">🧾</span>
                            <span class="text-[#707888]">ID Transaksi</span>
                            <span class="font-semibold ml-[4px]">TRX-2026-08-00123</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="grid grid-cols-1 gap-[14px] text-[14px]">
                <div class="flex items-start gap-[10px]">
                    <span class="text-[16px] mt-[1px]">📅</span>
                    <div>
                        <p class="text-[#707888]">Periode Sewa</p>
                        <p class="font-semibold mt-[2px]">12 Mei 2026 - 13 Mei 2026</p>
                    </div>
                </div>

                <div class="flex items-start gap-[10px]">
                    <span class="text-[16px] mt-[1px]">📆</span>
                    <div>
                        <p class="text-[#707888]">Tanggal Dikembalikan</p>
                        <p class="font-semibold mt-[2px]">13 Mei 2026</p>
                    </div>
                </div>

                <div class="flex items-start gap-[10px]">
                    <span class="text-[16px] mt-[1px]">💰</span>
                    <div>
                        <p class="text-[#707888]">Deposit</p>
                        <p class="font-semibold mt-[2px]">Rp20.000</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- LAPORAN KERUSAKAN -->
    <section class="bg-white border border-[#E5EAF0] rounded-[8px] shadow-[0px_2px_6px_rgba(0,0,0,0.06)] px-[28px] py-[20px] mb-[26px]">

        <h2 class="text-[16px] font-bold mb-[18px]">
            Laporan Kerusakan
        </h2>

        <!-- TOP INFO -->
        <div class="grid grid-cols-3 gap-[28px] pb-[20px] border-b border-[#DADFE7]">

            <div class="space-y-[16px]">
                <div>
                    <p class="text-[14px] text-[#707888]">Diajukan pada</p>
                    <p class="text-[16px] font-semibold mt-[4px]">14 Mei 2026</p>
                </div>

                <div>
                    <p class="text-[14px] text-[#707888]">Jenis Kerusakan</p>
                    <p class="text-[16px] font-semibold mt-[4px]">Kerusakan fisik</p>
                </div>
            </div>

            <div class="space-y-[16px] border-l border-[#E3E7ED] pl-[26px]">
                <div>
                    <p class="text-[14px] text-[#707888]">Bagian rusak</p>
                    <p class="text-[16px] font-semibold mt-[4px]">Body samping retak</p>
                </div>

                <div>
                    <p class="text-[14px] text-[#707888]">Biaya perbaikan</p>
                    <p class="text-[16px] font-semibold mt-[4px]">Rp700.000</p>
                </div>
            </div>

            <div class="space-y-[16px] border-l border-[#E3E7ED] pl-[26px]">
                <div>
                    <p class="text-[14px] text-[#707888]">Batas respons</p>
                    <p class="text-[16px] font-semibold mt-[4px]">17 Mei 2026, 23.59 WIB</p>
                </div>
            </div>

        </div>

        <!-- DESKRIPSI -->
        <div class="pt-[18px]">
            <h3 class="text-[15px] font-bold mb-[10px]">
                Deskripsi Kerusakan
            </h3>

            <p class="text-[15px] text-[#333B47] leading-[28px]">
                Layar Apple Watch mengalami retak pada bagian pojok kanan bawah akibat benturan keras. Ditemukan saat inspeksi akhir setelah penyewa mengembalikan barang. Perlu penggantian layar.
            </p>
        </div>

        <!-- FOTO BUKTI -->
        <div class="pt-[24px]">
            <h3 class="text-[15px] font-bold mb-[18px]">
                Foto Bukti Kerusakan
            </h3>

            <div class="grid grid-cols-3 gap-[22px]">
                <div class="h-[190px] rounded-[8px] bg-[#D9D9D9]"></div>
                <div class="h-[190px] rounded-[8px] bg-[#D9D9D9]"></div>
                <div class="h-[190px] rounded-[8px] bg-[#D9D9D9]"></div>
            </div>
        </div>

        <!-- RINCIAN BIAYA -->
        <div class="pt-[24px]">
            <h3 class="text-[15px] font-bold mb-[14px]">
                Rincian Biaya
            </h3>

            <div class="space-y-[10px] text-[15px]">
                <div class="flex justify-between">
                    <span class="text-[#707888]">Deposit penyewa</span>
                    <span class="font-semibold">Rp500.000</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-[#707888]">Biaya kerusakan</span>
                    <span class="font-semibold text-[#E64C4C]">- Rp700.000</span>
                </div>
            </div>

            <div class="border-t border-[#DADFE7] mt-[12px] pt-[14px] flex justify-between text-[16px]">
                <span class="font-bold">Sisa tagihan Anda</span>
                <span class="font-bold text-[#34699A]">Rp200.000</span>
            </div>
        </div>

    </section>

    <!-- ACTIONS -->
    <div class="grid grid-cols-[1fr_1fr] gap-[18px]">

        <!-- PILIH TINDAKAN -->
        <section class="bg-white border border-[#E5EAF0] rounded-[8px] shadow-[0px_2px_6px_rgba(0,0,0,0.06)] px-[26px] py-[20px]">
            <h2 class="text-[16px] font-bold mb-[10px]">
                Pilih Tindakan
            </h2>

            <p class="text-[14px] text-[#707888] mb-[18px]">
                Tinjau bukti di atas lalu pilih tindakan:
            </p>

            <div class="space-y-[14px]">

                <!-- SETUJUI -->
                <button class="w-full border border-[#6FCF97] bg-[#E8F7EE] rounded-[8px] px-[18px] py-[16px] flex items-center justify-between text-left">
                    <div class="flex items-center gap-[16px]">
                        <div class="w-[44px] h-[44px] rounded-full bg-[#27AE60] text-white flex items-center justify-center text-[24px] flex-shrink-0">
                            ✓
                        </div>

                        <div>
                            <h3 class="text-[16px] font-bold text-[#219653]">
                                Setujui Klaim
                            </h3>

                            <p class="text-[14px] text-[#4D5A68] mt-[4px] leading-[22px]">
                                Biaya perbaikan akan dipotong dari deposit.
                            </p>
                        </div>
                    </div>

                    <span class="text-[28px] text-[#219653]">›</span>
                </button>

                <!-- BANDING -->
                <button class="w-full border border-[#E1C542] bg-[#FFF8D9] rounded-[8px] px-[18px] py-[16px] flex items-center justify-between text-left">
                    <div class="flex items-center gap-[16px]">
                        <div class="w-[44px] h-[44px] rounded-full bg-[#E1C542] text-white flex items-center justify-center text-[22px] flex-shrink-0">
                            ⚖
                        </div>

                        <div>
                            <h3 class="text-[16px] font-bold text-[#B59600]">
                                Ajukan Banding
                            </h3>

                            <p class="text-[14px] text-[#4D5A68] mt-[4px] leading-[22px]">
                                Tolak klaim dan lanjutkan diskusi melalui chat
                            </p>
                        </div>
                    </div>

                    <span class="text-[28px] text-[#B59600]">›</span>
                </button>

            </div>
        </section>

        <!-- SETELAH MEMILIH -->
        <section class="bg-white border border-[#E5EAF0] rounded-[8px] shadow-[0px_2px_6px_rgba(0,0,0,0.06)] px-[26px] py-[20px]">
            <h2 class="text-[16px] font-bold mb-[22px]">
                Setelah Anda Memilih
            </h2>

            <div class="space-y-[18px]">
                <div class="flex items-start gap-[14px]">
                    <div class="w-[38px] h-[38px] rounded-full bg-[#34699A] text-white text-[18px] font-bold flex items-center justify-center flex-shrink-0">
                        1
                    </div>
                    <p class="text-[15px] text-[#4D5562] leading-[25px] pt-[4px]">
                        Jika setuju, dana dipotong dari deposit.
                    </p>
                </div>

                <div class="flex items-start gap-[14px]">
                    <div class="w-[38px] h-[38px] rounded-full bg-[#34699A] text-white text-[18px] font-bold flex items-center justify-center flex-shrink-0">
                        2
                    </div>
                    <p class="text-[15px] text-[#4D5562] leading-[25px] pt-[4px]">
                        Jika banding, diskusi dilanjutkan melalui chat.
                    </p>
                </div>

                <div class="flex items-start gap-[14px]">
                    <div class="w-[38px] h-[38px] rounded-full bg-[#34699A] text-white text-[18px] font-bold flex items-center justify-center flex-shrink-0">
                        3
                    </div>
                    <p class="text-[15px] text-[#4D5562] leading-[25px] pt-[4px]">
                        Jika klaim melebihi deposit, sistem dapat membuat tagihan tertunggak.
                    </p>
                </div>
            </div>
        </section>

    </div>

</main>

<!-- ================= FOOTER ================= -->
<footer class="bg-white border-t border-[#E5EAF0] mt-[30px]">
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