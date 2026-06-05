<nav class="navbar">

<div class="nav-left">

    <a href="{{ route('home') }}" class="logo">
        <img
            src="{{ asset('assets/img/logo/logo.png') }}"
            alt="Rentalin Logo"
            class="logo-img"
        >
    </a>

</div>

<div class="search-bar">

    <span class="search-icon">🔍</span>

    <form action="{{ route('store') }}" method="GET">
        <input
            type="text"
            name="search"
            placeholder="Cari barang yang ingin disewa..."
            value="{{ request('search') }}"
        >
    </form>

</div>

<div class="nav-right">

    <div class="icon-group">

        <a href="#" class="icon-btn icon-bell">
            🔔
            <span class="badge">3</span>
        </a>

        <a href="{{ route('chat') }}" class="icon-btn icon-chat">
            💬
            <span class="badge">2</span>
        </a>

        <a href="{{ route('riwayat.transaksi.penyewa') }}" class="icon-btn icon-cart">
            🛒
        </a>

    </div>

    <div class="nav-divider"></div>

    <a href="{{ route('store.bukaToko') }}" class="toko-btn">

        <div class="toko-icon-wrapper">
            🏪
        </div>

        <span>Toko</span>

    </a>

    @auth

    <div class="profile-dropdown">

        <div class="profile-group">

            <img
                src="{{ asset('assets/img/profile/user-photo-profile.png') }}"
                alt="Profile"
                class="profile-img"
            >

            <span class="profile-name">
                {{ Auth::user()->name }}
            </span>

        </div>


    </div>

    @endauth

</div>

</nav>