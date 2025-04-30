<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Article;
use App\Models\AccessLog;
use App\Observers\ArticleObserver;
use App\Observers\AccessLogObserver;

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
        Article::observe([
            ArticleObserver::class,
        ]);

        AccessLog::observe([
            AccessLogObserver::class,
        ]);
        //
    }
}
