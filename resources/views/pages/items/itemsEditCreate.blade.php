<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewakan Barang - P2P Rental</title>
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
            <h1>Sewakan barang</h1>
        </div>

        <div class="form-card">
            
            <section class="form-section">
                <h2>Unggah foto barang</h2>
                <div class="photo-grid">
                    <img src="https://via.placeholder.com/100" alt="Foto 1" class="photo-item">
                    <img src="https://via.placeholder.com/100" alt="Foto 2" class="photo-item">
                    <img src="https://via.placeholder.com/100" alt="Foto 3" class="photo-item">
                    <button class="photo-add"><span class="icon-plus">+</span></button>
                    <div class="photo-empty"><span class="icon-plus">+</span></div>
                    <div class="photo-empty"><span class="icon-plus">+</span></div>
                    <div class="photo-empty"><span class="icon-plus">+</span></div>
                </div>
            </section>

            <section class="form-section">
                <h2>Pilih kategori barang</h2>
                <div class="categories-grid">
                    <button class="category-item active">
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
            </section>

            <section class="form-section">
                <h2>Judul dan deskripsi barang</h2>
                <div class="input-stack">
                    <input type="text" class="input-box" placeholder="Masukkan judul">
                    <textarea class="textarea-box" placeholder="Masukkan deskripsi"></textarea>
                </div>
            </section>

            <section class="form-section">
                <h2>Harga dan jaminan keamanan</h2>
                <div class="price-layout">
                    <div class="input-group">
                        <input type="text" class="input-box" placeholder="Masukkan tarif sewa">
                        <span class="input-suffix">/hari</span>
                        
                        <div class="deposit-area">
                            <label class="radio-label">
                                <input type="radio" name="deposit" checked>
                                <span class="radio-custom"></span>
                                Terapkan deposit
                            </label>
                            <input type="text" class="input-box input-sm disabled" placeholder="Nominal deposit" disabled>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <input type="text" class="input-box" placeholder="Masukkan persentase denda">
                        <span class="input-suffix">/hari</span>
                        <p class="input-hint">Denda dihitung (tarif sewa x % denda) per hari keterlambatan.</p>
                    </div>
                </div>
            </section>

            <section class="form-section">
                <h2>Kebijakan pembatalan</h2>
                <p class="section-desc">Tentukan persentase pengembalian uang sewa jika penyewa membatalkan sebelum serah terima.</p>
                
                <div class="rule-card">
                    <div class="rule-header">
                        <span class="rule-title">Aturan 1</span>
                        <button class="btn-delete">🗑️</button>
                    </div>
                    <div class="rule-body">
                        <div class="rule-line">
                            <span>Jika dibatalkan lebih dari</span>
                            <input type="text" class="input-box input-micro" value="1">
                            <span>hari sebelum waktu sewa dimulai,</span>
                        </div>
                        <div class="rule-line">
                            <span>Penyewa mendapat refund sewa sebesar:</span>
                            <input type="text" class="input-box input-micro" value="50">
                            <span>%</span>
                        </div>
                    </div>
                </div>
                
                <button class="btn-add-rule"><span class="icon-plus">+</span> Tambah aturan</button>
                <p class="rule-footer">*Pembatalan di bawah batas waktu terendah mengakibatkan refund 0% (hangus).</p>
            </section>

            <section class="form-section">
                <h2>Serah terima barang</h2>
                <p class="section-desc">Pilih lokasi ketersediaan barang untuk pengambilan atau pengiriman.</p>
                
                <div class="radio-stack">
                    <label class="radio-label">
                        <input type="radio" name="delivery" checked>
                        <span class="radio-custom"></span>
                        COD
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="delivery">
                        <span class="radio-custom"></span>
                        Dikirim melalui kurir
                    </label>
                </div>
                
                <select class="select-box">
                    <option value="">Pilih kecamatan</option>
                    <option value="cibiru">Cibiru</option>
                </select>
            </section>

            <div class="form-actions">
                <button class="btn-submit">Sewakan</button>
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