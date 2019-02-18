<?php

namespace NotificationChannels\TxtSync;

use Illuminate\Support\ServiceProvider;
use NotificationChannels\TxtSync\Client\Client as TxtSyncClient;
use NotificationChannels\TxtSync\Client\ClientInterface as TxtSyncClientInterface;
use NotificationChannels\TxtSync\Credentials\Credentials as TxtSyncCredentials;

class TxtSyncServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(TxtSyncChannel::class)
            ->needs(TxtSyncClientInterface::class)
            ->give(function () {
                $config = config('services.txtsync', [
                    'client' => null,
                    'secret' => null,
                    'api_key' => null,
                    'sender_id' => null,
                ]);

                $credentials = new TxtSyncCredentials($config['client'], $config['secret'], $config['api_key']);

                return new TxtSyncClient(
                    $credentials,
                    $config['sender_id']
                );
            });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
