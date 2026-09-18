<?php

namespace App\Providers;

use App\Content\ContentRepository;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ContentRepository::class);
    }

    public function boot(): void
    {
        Carbon::setLocale(config('app.locale'));
    }
}
