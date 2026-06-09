<?php

namespace App\Providers;

use App\Models\Notification;
use App\Models\Rental;
use App\Models\Payment;

use App\Observers\RentalObserver;
use App\Observers\PaymentObserver;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Daftarkan Observer langsung di dalam fungsi boot (Dieksekusi 1 kali)
        Rental::observe(RentalObserver::class);
        Payment::observe(PaymentObserver::class);

        // 2. Paksa HTTPS jika diakses melalui Ngrok atau koneksi aman (Di luar View Composer)
        if (request()->secure() || str_contains(request()->getHost(), 'ngrok-free')) {
            URL::forceScheme('https');
        }

        // Paksa HTTPS di production (Railway pakai proxy)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // 3. View Composer HANYA untuk mengirim data ke tampilan (Dieksekusi setiap view dirender)
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $notifications = Notification::where('user_id', Auth::id())
                    ->latest()
                    ->take(5)
                    ->get();

                $unreadCount = Notification::where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->count();

                $view->with('navbarNotifications', $notifications);
                $view->with('navbarUnreadCount', $unreadCount);
            }
        });
    }
}