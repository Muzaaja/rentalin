<nav class="bg-white border-b shadow-sm">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" class="flex items-center">
                <span class="bg-rentalin-primary text-white px-3 py-1 rounded-lg font-bold text-2xl">
                    Rental
                </span>
                <span class="text-rentalin-secondary font-bold text-2xl ml-1">
                    in
                </span>
            </a>

            {{-- Search --}}
            <div class="hidden md:flex flex-1 mx-10">
                <input
                    type="text"
                    placeholder="Search"
                    class="w-full rounded-full border-gray-300 shadow-sm focus:border-rentalin-primary focus:ring-rentalin-primary">
            </div>

            {{-- Right Menu --}}
            <div class="flex items-center gap-5">

                <button>
                    🔔
                </button>

                <button>
                    💬
                </button>

                <button>
                    🛒
                </button>

                @auth
                <div class="flex items-center gap-3 border-l pl-4">
                    <span class="font-medium">
                        Toko
                    </span>

                    <img
                        src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : asset('images/default-avatar.png') }}"
                        class="w-10 h-10 rounded-full object-cover">
                </div>
                @endauth

            </div>
        </div>
    </div>
</nav>