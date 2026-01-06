<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        View::composer('layouts.navigation-top', function ($view) {
            if (Auth::check()) {
                /** @var \App\Models\User $user */ //
                $user = Auth::user();
                $query = $user->unreadNotifications();
                $notificationCount = $query->count();
                if (request()->has('show_all_notifications')) {
                    $unreadNotifications = $query->get();
                } else {
                    $unreadNotifications = $query->take(5)->get();
                }
            } else {
                $unreadNotifications = collect();
                $notificationCount = 0;
            }
            $view->with('unreadNotifications', $unreadNotifications)
                 ->with('notificationCount', $notificationCount);
        });
        Carbon::setLocale(config('app.locale'));
    }
}
