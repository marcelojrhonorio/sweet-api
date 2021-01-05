<?php

namespace App\Providers;

use App\Models\CustomerPasswordReset;
use Illuminate\Support\ServiceProvider;
use App\Observers\CustomerPasswordResetObserver;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        CustomerPasswordReset::observe(CustomerPasswordResetObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('\App\Repositories\Contract\ResourcesCampaignsInterface', 'App\Repositories\ResourcesCampaignsRepository');

        $this->app->singleton(
            'mailer',
            function ($app) {
                return $app->loadComponent('mail', 'Illuminate\Mail\MailServiceProvider', 'mailer');
            }
        );

        $this->app->alias('mailer', \Illuminate\Contracts\Mail\Mailer::class);

        $this->app->make('queue');
    }
}
