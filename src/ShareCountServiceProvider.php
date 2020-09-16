<?php

namespace Sagautam5\SocialShareCount;

use Illuminate\Support\ServiceProvider;

class ShareCountServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/share_count.php', 'share_count'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/share_count.php' => config_path('share_count.php'),
        ], 'share-count');
    }
}
