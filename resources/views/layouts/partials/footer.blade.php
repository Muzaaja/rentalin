<footer class="site-footer">

<div class="footer-container">

    <div class="footer-grid">

        <div class="footer-brand">

            <a href="{{ route('home') }}" class="logo">

                <img
                    src="{{ asset('assets/img/logo/logo.png') }}"
                    alt="Rentalin Logo"
                    class="logo-img"
                >

            </a>

            <p class="footer-desc">
                Platform sewa menyewa barang yang aman,
                mudah, dan terpercaya untuk kebutuhan harian,
                bisnis, maupun komunitas.
            </p>

        </div>

        <div class="footer-links-col">

            <h4 class="footer-title">
                Quick Links
            </h4>

            <ul class="footer-list">

                <li>
                    <a href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                <li>
                    <a href="{{ route('store') }}">
                        Toko
                    </a>
                </li>

                <li>
                    <a href="{{ route('riwayat.transaksi.penyewa') }}">
                        Riwayat
                    </a>
                </li>

            </ul>

        </div>

        <div class="footer-contact-col">

            <h4 class="footer-title">
                Hubungi Kami
            </h4>

            <ul class="footer-list contact-list">

                <li>
                    <span class="contact-icon">
                        📞
                    </span>

                    +62 123 456 987
                </li>

                <li>
                    <span class="contact-icon">
                        ✉️
                    </span>

                    support@rentalin.com
                </li>

                <li>
                    <span class="contact-icon">
                        📍
                    </span>

                    Jl. Cibubur No. 123
                </li>

            </ul>

        </div>

    </div>

    <div class="footer-bottom">

        <p>
            © {{ date('Y') }} Rentalin.
            All rights reserved.
        </p>

        <div class="social-icons">

            <a href="#" class="icon-ig">
                📷
            </a>

            <a href="#" class="icon-wa">
                💬
            </a>

            <a href="#" class="icon-fb">
                📘
            </a>

        </div>

    </div>

</div>

</footer>