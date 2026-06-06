<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
