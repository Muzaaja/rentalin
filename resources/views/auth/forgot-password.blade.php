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
                    Lupa Password
                </h2>

                <p
                    style="
                        color:#7b7b7b;
                        margin-top:-10px;
                        margin-bottom:30px;
                        line-height:1.6;
                    ">

                    Masukkan email yang terdaftar pada akun Anda.
                    Kami akan mengirimkan tautan untuk mengatur ulang password.

                </p>

                @if(session('status'))

                    <div
                        style="
                            background:#e8f7ee;
                            color:#0f7a38;
                            padding:12px;
                            border-radius:8px;
                            margin-bottom:20px;
                            font-size:14px;
                        ">

                        {{ session('status') }}

                    </div>

                @endif

                <form
                    method="POST"
                    action="{{ route('password.email') }}">

                    @csrf

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

                            autofocus>

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-2" />

                    </div>

                    <button
                        type="submit"
                        class="btn-full"
                        style="margin-top:15px;">

                        Kirim Link Reset Password

                    </button>

                </form>

                <div
                    class="auth-footer"
                    style="margin-top:30px;">

                    Sudah ingat password?

                    <a href="{{ route('login') }}">
                        Kembali ke Login
                    </a>

                </div>

            </div>

        </section>

    </main>

</x-guest-layout>