<?php

namespace App\Providers;

use App\Models\GuestBook;
use App\Models\PstOfficer;
use App\Observers\GuestBookObserver;
use App\Observers\PstOfficerObserver;
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
        PstOfficer::observe(PstOfficerObserver::class);
        GuestBook::observe(GuestBookObserver::class);
    }
}
