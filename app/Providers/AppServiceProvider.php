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
        
    View::composer('*', function ($view) {

    Rental::observe(RentalObserver::class);

    Payment::observe(PaymentObserver::class);

    if (app()->environment('production')) {
        URL::forceScheme('https');
    }

    if(Auth::check()) {

        $notifications = Notification::where(
            'user_id',
            Auth::id()
        )
        ->latest()
        ->take(5)
        ->get();

        $unreadCount = Notification::where(
            'user_id',
            Auth::id()
        )
        ->where('is_read', false)
        ->count();

        $view->with(
            'navbarNotifications',
            $notifications
        );

        $view->with(
            'navbarUnreadCount',
            $unreadCount
        );
    }
    
});
    }
}
