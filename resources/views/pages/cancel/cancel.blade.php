<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel/Refund - P2P Rental</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Nunito+Sans:wght@800&family=Poppins:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
</head>
<body>

    <nav class="navbar">
    <div class="nav-left">
        <!-- Mengarah ke Homepage -->
        <a href="homepage-user.html" class="logo" style="text-decoration: none;">
        <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Rentalin Logo" class="logo-img">        </a>
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

    <main class="page-container checkout-container">
        
        <div class="page-header">
            <button class="back-btn">←</button>
            <h1>Cancel</h1>
        </div>

        <div class="checkout-layout">
            
            <div class="checkout-left">
                <div class="checkout-card">
                    
                    <div class="co-item-header">
                        <img src="https://via.placeholder.com/92" alt="Tank" class="co-item-img">
                        <div class="co-item-title-box">
                            <h2>Tank M103 Counter Soviet Tahun 1960 Sekali Tembak Rata</h2>
                            <p class="co-owner">Disewakan oleh: <strong>Robert Oppie</strong></p>
                        </div>
                    </div>

                    <div class="co-details-list" style="margin-top: 15px;">
                        <div class="co-detail-row">
                            <span class="co-label">Jadwal sewa</span>
                            <span class="co-sep">:</span>
                            <span class="co-value">1 april 2026 - 5 april 2026</span>
                        </div>
                        <div class="co-detail-row">
                            <span class="co-label">Durasi</span>
                            <span class="co-sep">:</span>
                            <span class="co-value">5 hari</span>
                        </div>
                        <div class="co-detail-row">
                            <span class="co-label">Metode penyerahan</span>
                            <span class="co-sep">:</span>
                            <span class="co-value">COD</span>
                        </div>
                    </div>

                    <hr class="co-divider">

                    <div class="cancel-policy-section">
                        <h3 class="cancel-section-title">Kebijakan pembatalan</h3>
                        <p class="cancel-policy-text">
                            - Jika dibatalkan lebih dari 1 hari sebelum waktu mulai sewa: Refund sewa 50%<br>
                            - Jika dibatalkan kurang dari 1 hari sebelum waktu mulai sewa: Refund sewa 0%
                        </p>
                    </div>

                    <div class="cancel-reason-section">
                        <h3 class="cancel-section-title">Alasan Pembatalan<span class="text-bintang">*</span></h3>
                        <textarea class="cancel-textarea" placeholder="Tulis alasan pembatalan"></textarea>
                    </div>

                </div>
            </div>

            <div class="checkout-right">
                <div class="checkout-card co-summary-card">
                    <h3>Refund</h3>
                    
                    <div class="co-summary-row">
                        <span class="co-sum-label">Biaya sewa (Rp 5.000.000 x 5 hari)</span>
                        <span class="co-sum-value">25.000.000</span>
                    </div>
                    <div class="co-summary-row">
                        <span class="co-sum-label">Kebijakan Pembatalan (50% > 1 hari)</span>
                        <span class="co-sum-value">-12.500.000</span>
                    </div>
                    <div class="co-summary-row">
                        <span class="co-sum-label">Uang deposit (jaminan)</span>
                        <span class="co-sum-value">500.000</span>
                    </div>
                    
                    <hr class="co-divider">
                    
                    <div class="co-summary-row co-total-row">
                        <span class="co-total-label">Total:</span>
                        <span class="co-total-value">13.000.000</span>
                    </div>
                </div>

                <button class="btn-co-pay">Konfirmasi Pembatalan</button>
            </div>

        </div>

    </main>

</body>
</html>