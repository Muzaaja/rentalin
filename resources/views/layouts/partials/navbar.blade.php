@php
use App\Models\Notification;

$navbarNotifications = collect();
$navbarUnreadCount = 0;

if (auth()->check()) {
    try {

        if (class_exists(Notification::class)) {

            $navbarNotifications = Notification::where(
                'user_id',
                auth()->id()
            )
            ->latest()
            ->take(5)
            ->get();

            $navbarUnreadCount = Notification::where(
                'user_id',
                auth()->id()
            )
            ->where('is_read', false)
            ->count();

        }

    } catch (\Exception $e) {

        $navbarNotifications = collect();
        $navbarUnreadCount = 0;

    }
}
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

    <form
        action="{{ route('items.katalog') }}"
        method="GET"
        style="display:flex;width:100%;align-items:center;"
    >

        <span class="search-icon">🔍</span>

        <input
            type="text"
            name="search"
            placeholder="Cari barang..."
            value="{{ request('search') }}"
        >

    </form>

</div>

<div class="nav-right">

@auth
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

        @php
            $icon = match($notification->type) {
                'request' => 'request.png',
                'payment' => 'payment.png',
                'extend'  => 'extend.png',
                'return'  => 'return.png',
                'damage'  => 'damage.png',
                'finish'  => 'finish.png',
                'cancel'  => 'cancel.png',
                default   => 'default.png'
            };
        @endphp

        <img
            src="{{ asset('assets/icons/' . $icon) }}"
            alt="{{ $notification->title }}"
            class="notif-icon-img"
        >

    </div>

    <div class="notif-content">

        <strong>{{ $notification->title }}</strong>

        <div class="notif-message">
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

        <a href="{{ route('chat.index') }}" class="icon-btn icon-chat">
            💬
            <span class="badge">2</span>
        </a>

        <a href="{{ route('riwayat.transaksi.penyewa') }}" class="icon-btn icon-cart">
            🛒
        </a>

    </div>

    <div class="nav-divider"></div>

    <a href="{{ route('store') }}" class="toko-btn">

        <div class="toko-icon-wrapper">
            🏪
        </div>

        <span>Toko</span>

    </a>
@endauth

@guest

    <div class="guest-menu">

        <a
            href="{{ route('login') }}"
            class="login-btn">

            Masuk

        </a>

        <a
            href="{{ route('register') }}"
            class="register-btn">

            Daftar

        </a>

    </div>

@endguest

@auth

    <div class="profile-dropdown">

    <button
        class="profile-trigger"
        id="profileTrigger"
        type="button"
    >

        <img
    src="{{ Auth::user()->avatar
        ? asset('storage/' . Auth::user()->avatar)
        : asset('assets/img/profile/user-photo-profile.png') }}"
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

        <a href="{{ route('profile.cicilan.index') }}">
            💳 Cicilan
        </a>

        <a href="{{ route('profile.edit') }}">
            ⚙ Pengaturan
        </a>

        <!-- buat admin biar ada tomblo ke kyc -->
        @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('admin.kyc_user.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                Panel Admin
            </a>
            <hr class="my-1 border-gray-100">
        @endif

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