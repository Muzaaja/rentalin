<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Penyerahan Pemilik - P2P Rental</title>

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