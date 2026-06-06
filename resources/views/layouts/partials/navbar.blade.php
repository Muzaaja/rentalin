@php
    $navbarUnreadCount = $navbarUnreadCount ?? 0;
    $navbarNotifications = $navbarNotifications ?? collect();
@endphp

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

        <div class="notification-wrapper">

    <button
        type="button"
        id="notificationBtn"
        class="icon-btn icon-bell"
    >
        🔔

        @if($navbarUnreadCount > 0)

            <span class="badge">
                {{ $navbarUnreadCount }}
            </span>

        @endif

    </button>

    <div
        class="notification-popup"
        id="notificationPopup"
    >

        <div class="notification-header">

            <h3>Notifikasi</h3>

        </div>

        <div class="notification-list">

            @forelse($navbarNotifications as $notification)

                <div class="notif-item">

                    <div class="notif-icon">

                        @if($notification->type == 'rental')
                            📦
                        @elseif($notification->type == 'payment')
                            💳
                        @elseif($notification->type == 'chat')
                            💬
                        @else
                            🔔
                        @endif

                    </div>

                    <div class="notif-content">

                        <strong>
                            {{ $notification->title }}
                        </strong>

                        <div>
                            {{ $notification->message }}
                        </div>

                        <small>
                            {{ $notification->created_at->diffForHumans() }}
                        </small>

                    </div>

                </div>

            @empty

                <div class="empty-notif">
                    Tidak ada notifikasi
                </div>

            @endforelse

        </div>

    </div>

    </div>

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

    <button
        class="profile-trigger"
        id="profileTrigger"
        type="button"
    >

        <img
            src="{{ asset('assets/img/profile/user-photo-profile.png') }}"
            alt="Profile"
            class="profile-img"
        >

        <span class="profile-name">
            {{ Auth::user()->name }}
        </span>

    </button>

    <div
        class="profile-popup"
        id="profilePopup"
    >

        <a href="{{ route('profile.edit') }}">
            👤 Profil
        </a>

        <a href="{{ route('riwayat.transaksi.penyewa') }}">
            🕘 Riwayat
        </a>

        <a href="#">
            💳 Cicilan
        </a>

        <a href="{{ route('profile.edit') }}">
            ⚙ Pengaturan
        </a>

        <hr>

        <form
            action="{{ route('logout') }}"
            method="POST"
        >
            @csrf

            <button
                type="submit"
                class="logout-btn"
            >
                🚪 Keluar
            </button>

        </form>

    </div>

</div>

    @endauth

</div>
<script>
const trigger =
document.getElementById('profileTrigger');

const popup =
document.getElementById('profilePopup');

if(trigger){

    trigger.addEventListener('click', function(e){

        e.stopPropagation();

        popup.classList.toggle('show');

    });

    document.addEventListener('click', function(){

        popup.classList.remove('show');

    });

}
</script>

<script>

const notificationBtn =
document.getElementById('notificationBtn');

const notificationPopup =
document.getElementById('notificationPopup');

if(notificationBtn){

    notificationBtn.addEventListener('click', function(e){

        e.stopPropagation();

        notificationPopup.classList.toggle('show');

    });

    document.addEventListener('click', function(){

        notificationPopup.classList.remove('show');

    });

}

</script>
</nav>