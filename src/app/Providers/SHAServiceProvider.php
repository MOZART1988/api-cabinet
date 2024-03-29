<?php


namespace App\Providers;


use App\Helpers\Hash\SHAHasher;
use Illuminate\Support\ServiceProvider;

class SHAServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('hash', function() {
            return new SHAHasher();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array('hash');
    }
}