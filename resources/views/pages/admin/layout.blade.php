<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Rentalin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="text-gray-800 bg-[#F9FAFB]" style="font-family: 'Inter', sans-serif;">

    <div class="flex h-screen w-full overflow-hidden">

        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col justify-between flex-shrink-0 h-full">
            <div>
                <div class="h-[72px] flex items-center px-6 border-b border-gray-100 gap-2">
                    <span class="text-xl font-bold text-[#34699A] tracking-wider font-serif">RENTALIN</span>
                    <span class="bg-blue-50 text-[#34699A] text-[10px] font-bold px-2 py-0.5 rounded-full border border-blue-100">ADMIN</span>
                </div>

                <nav class="p-4 space-y-1.5 mt-2">
                    <p class="text-[11px] font-bold text-gray-400 px-3 uppercase tracking-wider mb-2">Menu Verifikasi</p>
                    
                    <a href="{{ route('admin.kyc_user.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::routeIs('admin.kyc_user.*') ? 'bg-[#34699A] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Verifikasi User
                    </a>

                    <a href="{{ route('admin.kyc_toko.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition {{ Request::routeIs('admin.kyc_toko.*') ? 'bg-[#34699A] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Verifikasi Toko
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-gray-100 flex items-center gap-3 bg-gray-50/50">
                <div class="w-9 h-9 rounded-full bg-[#34699A] text-white flex items-center justify-center text-xs font-bold shadow-sm">
                    AD
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-gray-900 truncate">Administrator</p>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-[10px] text-red-500 hover:text-red-700 font-medium flex items-center gap-1 mt-0.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden relative">
            <main class="flex-1 overflow-y-auto p-8">
                @if(session('success'))
                    <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
            
            @yield('panel')
        </div>

    </div>

    @yield('modals')
    @stack('scripts')
</body>
</html>