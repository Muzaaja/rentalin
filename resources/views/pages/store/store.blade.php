<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko - Barang Saya</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Nunito+Sans:wght@800&family=Poppins:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

    <nav class="navbar">
    <div class="nav-left">
        <!-- Mengarah ke Homepage -->
        <a href="homepage-user.html" class="logo" style="text-decoration: none;">
            <img src="assets/img/logo/logo 2.png" alt="Rentalin Logo" class="logo-img">
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
            <img src="assets/img/profile/user-photo-profile.png" alt="Profile" class="profile-img">
            <span class="profile-name">Nugra Hasahatan</span>
        </div>
    </div>
    </nav>

    <main class="page-container">
        
        <div class="page-header">
            <button class="back-btn">←</button>
            <h1>Toko</h1>
        </div>

        <div class="store-card">
            <h2>Barang saya</h2>

            <div class="search-barang-container">
                <div class="search-barang">
                    <span class="search-icon">🔍</span>
                    <input type="text" placeholder="cari barang">
                </div>
            </div>

            <div class="categories">
                <button class="category-item">
                    <span class="cat-icon cat-gadget">📱</span>
                    <span>Elektronik & Gadget</span>
                </button>
                <button class="category-item">
                    <span class="cat-icon cat-event">🎉</span>
                    <span>Pesta & Event</span>
                </button>
                <button class="category-item">
                    <span class="cat-icon cat-rumah">🛋️</span>
                    <span>Rumah Tangga</span>
                </button>
                <button class="category-item">
                    <span class="cat-icon cat-hobi">🏀</span>
                    <span>Hobi & Olahraga</span>
                </button>
                <button class="category-item">
                    <span class="cat-icon cat-fashion">👗</span>
                    <span>Fashion & Aksesoris</span>
                </button>
            </div>

            <div class="product-grid">
                
                <div class="product-card" onclick="window.location.href='page_detail_barang.html';" style="cursor: pointer;">
                    <img src="https://via.placeholder.com/67" alt="Tank" class="product-img">
                    <div class="product-info">
                        <h3>Tank M103 Counter Sovi...</h3>
                        <p class="category">Hobi & Olahraga</p>
                        <p class="price">Rp 5.000.000 /hari</p>
                    </div>
                    <div class="product-actions">
                        <span class="badge badge-warning">Disewa</span>
                        <span class="status-text">Oleh kapten amerika (2 hari tersisa)</span>
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-edit" onclick="event.stopPropagation(); window.location.href='page_create_edit_barang.html';"><span class="icon icon-edit">📝</span> Edit</button>
                    </div>
                </div>

                <div class="product-card" onclick="window.location.href='page_detail_barang.html';" style="cursor: pointer;">
                    <img src="https://via.placeholder.com/67" alt="Iphone" class="product-img">
                    <div class="product-info">
                        <h3>Iphone buat bukber</h3>
                        <p class="category">Elektronik & Gadget</p>
                        <p class="price">Rp 150.000 /hari</p>
                    </div>
                    <div class="product-actions">
                        <span class="badge badge-success">Aktif</span>
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-neutral" onclick="event.stopPropagation();">Nonaktif</button>
                        <button class="btn btn-edit" onclick="event.stopPropagation(); window.location.href='page_create_edit_barang.html';"><span class="icon icon-edit">📝</span> Edit</button>
                        <button class="btn btn-danger" onclick="event.stopPropagation();"><span class="icon icon-trash">🗑️</span> Hapus</button>
                    </div>
                </div>

                <div class="product-card" onclick="window.location.href='page_detail_barang.html';" style="cursor: pointer;">
                    <img src="https://via.placeholder.com/67" alt="ODM" class="product-img">
                    <div class="product-info">
                        <h3>ODM Gear Bantai Titan</h3>
                        <p class="category">Hobi & Olahraga</p>
                        <p class="price">Rp 5.000.000 /hari</p>
                    </div>
                    <div class="product-actions">
                        <span class="badge badge-neutral">Nonaktif</span>
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-success" onclick="event.stopPropagation();">Aktif</button>
                        <button class="btn btn-edit" onclick="event.stopPropagation(); window.location.href='page_create_edit_barang.html';"><span class="icon">📝</span> Edit</button>
                        <button class="btn btn-danger" onclick="event.stopPropagation();"><span class="icon icon-trash">🗑️</span> Hapus</button>
                    </div>
                </div>

            </div>

            <div class="add-button-container">
                <button class="btn-add" onclick="window.location.href='page_create_edit_barang.html';">+ Sewakan barang</button>
            </div>

        </div>
    </main>

    <footer class="site-footer">
    <div class="footer-container">
        <div class="footer-grid">
            <div class="footer-brand">
                <!-- Mengarah ke Homepage -->
                <a href="homepage-user.html" class="logo" style="text-decoration: none;">
                    <img src="assets/img/logo/logo 2.png" alt="Rentalin Logo" class="logo-img">
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