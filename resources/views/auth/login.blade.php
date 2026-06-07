<x-guest-layout>
    <main class="auth-wrapper">

        {{-- LEFT PANEL --}}
        <section class="auth-left">

            <div class="auth-left-content">

                <a href="{{ route('home') }}" class="auth-logo">
                    <img
                        src="{{ asset('assets/img/logo/logo.png') }}"
                        alt="Rentalin"
                        class="logo-img">
                </a>

                <h1 class="auth-headline">
                    Layanan Sewa Menyewa Terpercaya
                </h1>

                <p class="auth-description">
                    Bergabunglah dengan ribuan pengguna lainnya.
                    Transaksi aman, barang terjamin, dan proses yang transparan.
                    Sewa barang impian Anda sekarang!
                </p>

                <div class="auth-members">

                    <div class="member-avatars">
                        <img src="https://i.pravatar.cc/100?img=1" alt="">
                        <img src="https://i.pravatar.cc/100?img=11" alt="">
                        <img src="https://i.pravatar.cc/100?img=12" alt="">
                    </div>

                    <div class="member-text">
                        <h4>Lebih dari 20rb+ Anggota</h4>
                        <p>Dipercaya oleh layanan pramutamu kami</p>
                    </div>

                </div>

            </div>

        </section>

        {{-- RIGHT PANEL --}}
        <section class="auth-right">

            <div class="auth-card">

                <h2 class="auth-title">
                    Log In
                </h2>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- EMAIL --}}
                    <div class="form-group">

                        <label for="email">
                            Email
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email"
                            required
                            autofocus
                            autocomplete="username">

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-2" />

                    </div>

                    {{-- PASSWORD --}}
                    <div class="form-group">

                        <label for="password">
                            Password
                        </label>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Masukkan password"
                            required
                            autocomplete="current-password">

                        <x-input-error
                            :messages="$errors->get('password')"
                            class="mt-2" />

                    </div>

                    {{-- REMEMBER --}}
                    <div style="margin-bottom:20px;">

                        <label style="display:flex;align-items:center;gap:8px;">
                            <input
                                type="checkbox"
                                name="remember">

                            <span>
                                Ingat saya
                            </span>
                        </label>

                    </div>

                    {{-- FORGOT PASSWORD --}}
                    @if (Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="forgot-password">

                            Lupa Password?

                        </a>

                    @endif

                    {{-- LOGIN BUTTON --}}
                    <button
                        type="submit"
                        class="btn-full">

                        Log In

                    </button>

                </form>

                {{-- DIVIDER --}}
                <div class="auth-divider">
                    <span>
                        ATAU LANJUTKAN DENGAN
                    </span>
                </div>

                {{-- GOOGLE --}}
                <hr>

            <a href="{{ route('google.login') }}"
            class="btn btn-danger w-100">
            
            Login dengan Google
            
            </a>

                {{-- FOOTER --}}
                <div class="auth-footer">

                    Belum punya akun?

                    <a href="{{ route('register') }}">
                        Daftar sekarang
                    </a>

                </div>

            </div>

        </section>

    </main>
</x-guest-layout>
