<div class="bg-white rounded-xl shadow-card p-8">

    <div class="text-center">

        <img
            src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : asset('images/default-avatar.png') }}"
            class="w-28 h-28 rounded-full mx-auto">

        <h2 class="mt-4 text-xl font-semibold">
            {{ Auth::user()->name }}
        </h2>

    </div>

    <div class="mt-8 space-y-4">

        <a href="{{ route('profile.index') }}"
            class="block border border-rentalin-primary rounded-lg px-4 py-3">

            Profile
        </a>

        <a href="#"
            class="block bg-rentalin-primary text-white rounded-lg px-4 py-3">

            History
        </a>

        <a href="#"
            class="block bg-rentalin-primary text-white rounded-lg px-4 py-3">

            Settings
        </a>

    </div>

</div>