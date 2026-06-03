<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewakan Barang - P2P Rental</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Nunito+Sans:wght@800&family=Poppins:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>
<body>

    <nav class="navbar">
    <div class="nav-left">
        <!-- Mengarah ke Homepage -->
        <a href="homepage-user.html" class="logo" style="text-decoration: none;">
            <img src="{{ asset('assets/img/logo/logo 2.png') }}" alt="Rentalin Logo" class="logo-img">
        </a>
    </div>
    <div class="search-bar">
        <span class="search-icon">🔍</span>
        <input type="text" placeholder="Search">
    </div>
    <div class="nav-right">
        <div class="icon-group">
            <button class="icon-btn icon-bell">🔔</button>
            <!-- Mengarah ke Chat -->
            <button class="icon-btn icon-chat" onclick="window.location.href='chat.html';">💬</button>
            <!-- Mengarah ke Riwayat Penyewa -->
            <button class="icon-btn icon-cart" onclick="window.location.href='riwayat_transaksi_penyewa.html';">🛒</button>
        </div>
        <div class="nav-divider"></div>
        <!-- Mengarah ke Toko -->
        <button class="toko-btn" onclick="window.location.href='page_toko.html';">
            <div class="toko-icon-wrapper">🏪</div>
            <span>Toko</span>
        </button>
        <!-- Mengarah ke Profile -->
        <div class="profile-group" onclick="window.location.href='profile.html';" style="cursor: pointer;">
            <img src="{{ asset('assets/img/profile/user-photo-profile.png') }}" alt="Profile" class="profile-img">
            <span class="profile-name">Nugra Hasahatan</span>
        </div>
    </div>
    </nav>

    <main class="page-container">
        
        <div class="page-header">
            <button class="back-btn">←</button>
            <h1>Sewakan barang</h1>
        </div>

<div class="form-card">

<form
    method="POST"
    action="{{ isset($item)
        ? route('items.update',$item->id)
        : route('items.store') }}"
    enctype="multipart/form-data">

    @csrf

    @if(isset($item))
        @method('PUT')
    @endif

    <section class="form-section">

        <h2>Unggah foto barang</h2>

        <input
            type="file"
            name="image"
            class="input-box">

        @if(isset($item) && $item->image)
            <br><br>

            <img
                src="{{ asset('storage/'.$item->image) }}"
                width="200">
        @endif

    </section>

    <section class="form-section">

        <h2>Pilih kategori barang</h2>

        <select
            name="category_id"
            class="select-box">

            @foreach($categories as $category)

                <option
                    value="{{ $category->id }}"
                    @selected(
                        old(
                            'category_id',
                            $item->category_id ?? ''
                        ) == $category->id
                    )>

                    {{ $category->name }}

                </option>

            @endforeach

        </select>

    </section>

    <section class="form-section">

        <h2>Judul dan deskripsi barang</h2>

        <div class="input-stack">

            <input
                type="text"
                name="name"
                class="input-box"
                value="{{ old('name',$item->name ?? '') }}"
                placeholder="Masukkan judul">

            <textarea
                name="description"
                class="textarea-box"
                placeholder="Masukkan deskripsi">{{ old('description',$item->description ?? '') }}</textarea>

        </div>

    </section>

    <section class="form-section">

        <h2>Harga dan stok</h2>

        <div class="input-stack">

            <input
                type="number"
                name="price_per_day"
                class="input-box"
                value="{{ old('price_per_day',$item->price_per_day ?? '') }}"
                placeholder="Masukkan tarif sewa">

            <input
                type="number"
                name="stock"
                class="input-box"
                value="{{ old('stock',$item->stock ?? 1) }}"
                placeholder="Jumlah stok">

        </div>

    </section>

    <div class="form-actions">

        <button
            type="submit"
            class="btn-submit">

            {{ isset($item)
                ? 'Perbarui Barang'
                : 'Sewakan' }}

        </button>

    </div>

</form>
</div>

    </main>

    <footer class="site-footer">
    <div class="footer-container">
        <div class="footer-grid">
            <div class="footer-brand">
                <!-- Mengarah ke Homepage -->
                <a href="homepage-user.html" class="logo" style="text-decoration: none;">
                    <img src="{{ asset('assets/img/logo/logo 2.png') }}" alt="Rentalin Logo" class="logo-img">
                </a>
                <p class="footer-desc">Platform sewa menyewa barang yang aman, mudah, dan terpercaya</p>
            </div>
            
            <div class="footer-links-col">
                <h4 class="footer-title">Quick Links</h4>
                <ul class="footer-list">
                    <!-- Mengarah ke Homepage -->
                    <li><a href="homepage-user.html">Home</a></li>
                    <!-- Mengarah ke Riwayat Pemilik -->
                    <li><a href="riwayat_transaksi_pemilik.html">Riwayat</a></li>
                    <!-- Tautan kosong/placeholder -->
                    <li><a href="#">Kontak</a></li>
                </ul>
            </div>
            
            <div class="footer-contact-col">
                <h4 class="footer-title">Hubungi Kami</h4>
                <ul class="footer-list contact-list">
                    <li><span class="contact-icon icon-phone">📞</span> +62 123 456 987</li>
                    <li><span class="contact-icon icon-email">✉️</span> support@rentalin.com</li>
                    <li><span class="contact-icon icon-location">📍</span> Jl. Cibubur No. 123</li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>© 2026 Rentalin. All rights reserved</p>
            <div class="social-icons">
                <a href="#" class="icon-ig">📷</a> 
                <a href="#" class="icon-wa">💬</a> 
                <a href="#" class="icon-fb">📘</a> 
            </div>
        </div>
    </div>
    </footer>
</body>
</html>