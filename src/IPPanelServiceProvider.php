<?php

namespace Mirvan\IPPanel;

use Illuminate\Support\ServiceProvider;
use NotificationChannels\IPPanel\Exceptions\InvalidConfiguration;

class IPPanelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(IPPanelChannel::class)
            ->needs(IPPanel::class)
            ->give(function () {
                if (is_null($productToken = config('services.ippanel.api_key'))) {
                    throw InvalidConfiguration::configurationNotSet();
                }

                return new IPPanel($productToken);
            });
    }

    public function register()
    {
        $this->app->singleton('IPPanel', function ($app) {
            if (is_null($productToken = config('services.ippanel.api_key'))) {
                throw InvalidConfiguration::configurationNotSet();
            }

            return new IPPanel($productToken);
        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['ippanel'];
    }
}
