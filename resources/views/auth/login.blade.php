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
                <button
                    type="button"
                    class="btn-google">

                    <svg viewBox="0 0 48 48">
                        <path fill="#FFC107"
                            d="M43.611 20.083H42V20H24v8h11.303C33.655 32.657 29.199 36 24 36c-6.627 0-12-5.373-12-12S17.373 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.28 4 24 4C12.955 4 4 12.955 4 24s8.955 20 20 20s20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
                        <path fill="#FF3D00"
                            d="M6.306 14.691l6.571 4.819C14.655 16.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.28 4 24 4C16.318 4 9.656 8.337 6.306 14.691z"/>
                        <path fill="#4CAF50"
                            d="M24 44c5.177 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.143 35.091 26.715 36 24 36c-5.178 0-9.625-3.316-11.288-7.946l-6.52 5.025C9.505 39.556 16.227 44 24 44z"/>
                        <path fill="#1976D2"
                            d="M43.611 20.083H42V20H24v8h11.303c-.793 2.327-2.292 4.308-4.084 5.571l6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
                    </svg>

                    Google

                </button>

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
