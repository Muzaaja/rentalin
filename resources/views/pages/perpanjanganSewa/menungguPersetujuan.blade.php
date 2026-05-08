<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Perpanjangan Sewa</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .shadow-card{
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
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

                <span class="text-[#F3C84B]">
                    in
                </span>
            </div>

            <!-- SEARCH -->
            <div class="relative hidden md:block">

                <input 
                    type="text"
                    placeholder="Search"
                    class="w-[500px] h-[36px] rounded-full border border-gray-200 bg-[#FAFAFA] pl-10 pr-4 text-[13px] outline-none"
                >

                <svg class="w-4 h-4 absolute left-4 top-[10px] text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

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
        <div class="flex items-center gap-5 text-[14px]">

            <button>🔔</button>
            <button>💬</button>
            <button>🛒</button>

            <div class="w-px h-7 bg-gray-300"></div>

            <div class="w-9 h-9 rounded-full bg-[#2F6DB3] text-white flex items-center justify-center text-sm">
                🏪
            </div>

            <span class="font-medium">
                Toko
            </span>

            <img 
                src="https://i.pravatar.cc/100"
                class="w-10 h-10 rounded-lg object-cover"
            >

        </div>

    </nav>

    <!-- CONTENT -->
    <main class="max-w-[930px] mx-auto py-6 px-4">

        <!-- HEADER -->
        <div class="flex items-start justify-between mb-6">

            <div class="flex items-start gap-4">

                <!-- BACK -->
                <button class="w-[52px] h-[52px] rounded-2xl border border-gray-200 bg-white flex items-center justify-center text-[22px] text-gray-500">
                    ←
                </button>

                <div>

                    <h1 class="text-[22px] font-bold leading-tight">
                        Perpanjangan Sewa
                    </h1>

                    <p class="text-[14px] text-gray-400 mt-1">
                        Tambah durasi sewa sebelum masa sewa berakhir
                    </p>

                </div>

            </div>

            <!-- STATUS -->
            <div class="bg-blue-50 text-[#2F6DB3] px-4 py-2 rounded-full text-[13px] font-medium flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-[#2F6DB3]"></div>
                Diproses
            </div>

        </div>

        <!-- ALERT -->
        <section class="border border-[#8FB6FF] bg-[#EAF2FF] rounded-[24px] px-8 py-7 mb-5">

            <div class="flex items-center gap-4">

                <!-- ICON -->
                <div class="w-14 h-14 rounded-2xl bg-white border border-blue-100 flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="w-7 h-7 text-[#2F6DB3]"
                        fill="none"
                        viewBox="0 0 24 24" 
                        stroke="currentColor">

                        <path stroke-linecap="round" 
                            stroke-linejoin="round" 
                            stroke-width="2" 
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />

                    </svg>

                </div>

                <div>

                    <h2 class="text-[18px] font-bold text-[#2F6DB3]">
                        Permintaan sedang diproses
                    </h2>

                    <p class="text-[14px] text-[#4A6FAF] mt-1">
                        Pemilik sedang meninjau permintaan perpanjangan sewa Anda
                    </p>

                </div>

            </div>

        </section>

        <!-- CARD -->
        <section class="bg-white border border-gray-200 rounded-[24px] shadow-card p-7">

            <!-- DETAIL -->
            <div class="space-y-4">

                <!-- ITEM -->
                <div class="flex justify-between items-center border-b border-gray-100 pb-4">

                    <span class="text-[14px] text-gray-400">
                        Status
                    </span>

                    <div class="bg-blue-50 text-[#2F6DB3] px-4 py-1.5 rounded-full text-[13px] font-semibold">
                        Diproses
                    </div>

                </div>

                <!-- ITEM -->
                <div class="flex justify-between items-center border-b border-gray-100 pb-4">

                    <span class="text-[14px] text-gray-400">
                        Durasi tambahan
                    </span>

                    <span class="text-[14px] font-semibold">
                        +1 hari
                    </span>

                </div>

                <!-- ITEM -->
                <div class="flex justify-between items-center border-b border-gray-100 pb-4">

                    <span class="text-[14px] text-gray-400">
                        Tanggal baru berakhir
                    </span>

                    <span class="text-[14px] font-semibold">
                        13 Agustus 2024
                    </span>

                </div>

                <!-- ITEM -->
                <div class="flex justify-between items-center pb-1">

                    <span class="text-[14px] text-gray-400">
                        Total dibayar
                    </span>

                    <span class="text-[16px] font-bold text-[#123C74]">
                        Rp 25.500
                    </span>

                </div>

            </div>

            <!-- TIMER -->
            <div class="border-t border-gray-100 mt-7 pt-8 text-center">

                <p class="text-[14px] text-gray-300">
                    Batas persetujuan pemilik:
                </p>

                <div class="text-[22px] font-bold text-[#2F6DB3] mt-2 tracking-wide">
                    01:59:26
                </div>

            </div>

        </section>

    </main>

</body>
</html>