<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
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
        $this->configureModelSecurity();
        $this->configureUrlSecurity();
    }

    /**
     * Configure Eloquent model security settings.
     *
     * - preventLazyLoading: Forces eager loading, preventing N+1 query issues
     *   and unintentional data exposure through lazy-loaded relationships.
     * - preventSilentlyDiscardingAttributes: Throws exception when trying to fill
     *   attributes not in $fillable, catching mass assignment issues early.
     * - shouldBeStrict: Enables all strict mode checks in non-production.
     */
    private function configureModelSecurity(): void
    {
        // In production: only prevent silent attribute discarding (non-breaking)
        // In development: enable all strict mode checks for early bug detection
        if ($this->app->environment('production')) {
            Model::preventSilentlyDiscardingAttributes();
        } else {
            Model::shouldBeStrict();
        }
    }

    /**
     * Configure URL and HTTPS security settings.
     *
     * Forces HTTPS scheme for all generated URLs when in production,
     * ensuring links in emails, redirects, and API responses use HTTPS.
     */
    private function configureUrlSecurity(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
