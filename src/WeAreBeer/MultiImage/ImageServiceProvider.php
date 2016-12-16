<?php

namespace WeAreBeer\MultiImage;

use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/config.php',
            config_path('multi_image.php')
        ], 'multiImage');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            ImageTypes::class,
            function () {
                return new ImageTypes(
                    config('multi_image.image_sizes')
                );
            }
        );
    }
}
