<?php namespace PageBoost\FacebookLaravel;

use Illuminate\Support\ServiceProvider;

class FacebookServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        $this->package('pageboost/facebook-laravel');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('facebook-laravel', function ($app) {
            $config = $app['config']->get('facebook-laravel::config');

            return new LaravelFacebook($config, $app['session'], $app['log']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('facebook-laravel');
    }
}
