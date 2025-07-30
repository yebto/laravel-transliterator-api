<?php
namespace Yebto\TransliteratorAPI;

use Illuminate\Support\ServiceProvider;

class TransliteratorAPIServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/transliterator.php', 'transliterator');

        $this->app->singleton('transliteratorapi', fn () => new TransliteratorAPI());
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/transliterator.php' => config_path('transliterator.php'),
        ], 'transliterator-config');
    }
}
