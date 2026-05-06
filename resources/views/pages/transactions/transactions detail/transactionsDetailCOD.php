<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi (COD) - P2P Rental</title>
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

    <main class="page-container tx-container">
        
        <div class="page-header">
            <button class="back-btn">←</button>
            <h1>Detail Transaksi</h1>
        </div>

        <div class="tx-grid">
            
            <div class="tx-col">
                
                <div class="tx-card">
                    <h3 class="tx-card-title">Status Pesanan</h3>
                    <div class="status-boxes-grid">
                        <div class="status-box span-full">
                            <p class="status-label">Nomor Pesanan</p>
                            <p class="status-value highlight-blue">#FD-2347-KCDN</p>
                        </div>
                        <div class="status-box">
                            <p class="status-label">Tanggal Pesanan</p>
                            <p class="status-value highlight-blue">1 April 2026</p>
                        </div>
                        <div class="status-box">
                            <p class="status-label">Jadwal Penyewaan</p>
                            <p class="status-value highlight-blue">2 April 2026 - 6 April 2026</p>
                        </div>
                        <div class="status-box">
                            <p class="status-label">Tanggal Pengembalian</p>
                            <p class="status-value highlight-blue">6 April 2026</p>
                        </div>
                        <div class="status-box">
                            <p class="status-label">Sisa Waktu</p>
                            <p class="status-value highlight-blue">2 Hari lagi</p>
                        </div>
                    </div>
                </div>

                <div class="tx-card">
                    <div class="tx-store-info">
                        <span class="tx-card-title" style="margin: 0;">Detail Produk</span>
                        <div class="tx-store-badge">
                            <div class="store-avatar"></div>
                            <span>Vinelle Market</span>
                        </div>
                    </div>
                    
                    <div class="tx-product-brief">
                        <img src="https://via.placeholder.com/80" alt="Tank M103" class="tx-product-img">
                        <div class="tx-product-text">
                            <h4>Tank M103 Counter Soviet Tahun 1960 Sekali Tembak Rata</h4>
                            <p>2 Hari</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="tx-col">
                
                <div class="tx-card">
                    <h3 class="tx-card-title">Rincian Pembayaran</h3>
                    <div class="kv-list">
                        <div class="kv-row">
                            <span class="kv-label">Metode Pembayaran</span>
                            <span class="kv-value highlight-blue">COD</span>
                        </div>
                        <div class="kv-row">
                            <span class="kv-label">Harga Sewa</span>
                            <span class="kv-value highlight-blue">Rp5.000.000/hari</span>
                        </div>
                        <div class="kv-row">
                            <span class="kv-label">Deposit</span>
                            <span class="kv-value highlight-blue">Rp500.000</span>
                        </div>
                        <div class="kv-row">
                            <span class="kv-label">Denda Keterlambatan</span>
                            <span class="kv-value highlight-blue">Rp100.000/hari</span>
                        </div>
                    </div>
                    
                    <hr class="tx-divider">
                    
                    <div class="kv-row tx-total-row">
                        <span class="kv-label" style="color: #000;">Total Pesanan</span>
                        <span class="kv-value highlight-blue">Rp5.500.000</span>
                    </div>
                </div>

                <div class="tx-card">
                    <h3 class="tx-card-title">Info Pengiriman</h3>
                    <div class="info-delivery-cod">
                        <p class="cod-main-text">Metode Pengiriman : COD (Serah terima langsung)</p>
                        <p class="cod-sub-text">*Detail lokasi & waktu diatur melalui chat</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="tx-actions">
            <button class="btn-tx btn-tx-primary">Sewa Kembali</button>
            <button class="btn-tx btn-tx-primary">Hubungi Pemilik</button>
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