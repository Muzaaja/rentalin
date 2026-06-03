<x-guest-layout>
    <main class="auth-wrapper">
        <section class="auth-left">
            <div class="auth-left-content">
                <a href="{{ route('home') }}" class="auth-logo">
                    <img src="{{ asset('assets/img/logo/logo 2.png') }}" alt="Rentalin" class="logo-img">
                </a>

                <h1 class="auth-headline">Rasakan masa depan<br>sewa-menyewa<br>barang-barang<br>premium.</h1>
                <p class="auth-description">Akses barang-barang premium tanpa beban kepemilikan.<br>Bergabunglah dengan pasar kurasi kami untuk penghuni<br>kota modern.</p>

                <div class="auth-members">
                    <div class="member-avatars">
                        <img src="https://i.pravatar.cc/100?img=1" alt="Member 1">
                        <img src="https://i.pravatar.cc/100?img=11" alt="Member 2">
                        <img src="https://i.pravatar.cc/100?img=12" alt="Member 3">
                    </div>
                    <div class="member-text">
                        <h4>Lebih dari 20rb+ Anggota</h4>
                        <p>Dipercaya oleh layanan pramutamu kami</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="auth-right">
            <div class="auth-card">
                <h2 class="auth-title">Sign In</h2>

                <form method="POST" action="{{ route('register') }}" data-auth-form data-toast="Akun berhasil dibuat. Mengarahkan ke dashboard...">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required autofocus autocomplete="name">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email" required autocomplete="username">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Ulangi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Masukkan ulang password" required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <button type="submit" class="btn-full" style="margin-top: 15px;">Sign In</button>
                </form>

                <div class="auth-footer" style="margin-top: 30px;">
                    Sudah punya akun? <a href="{{ route('login') }}">Log In disini</a>
                </div>
            </div>
        </section>
    </main>
</x-guest-layout>
