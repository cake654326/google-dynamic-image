<?php

namespace ContentCrackers\GoogleDynamicImage;
use Illuminate\Support\ServiceProvider;

class GoogleDynamicImageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/google-dynamic-image.php' => config_path('google-dynamic-image.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app['googledynamicimage'] = $this->app->share(function($app)
        {
            $googledynamicimage = $this->app->make(GoogleDynamicImage::class);
            return $googledynamicimage;
        });
    }

    public function provides()
    {
        return ['googledynamicimage'];
    }
}
