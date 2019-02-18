# Laravel TxtSync SMS

This is an unofficial integration of the TxtSync SMS API for Laravel 5/6.

- Plans & pricing on the [official site](https://txtsync.com/)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/laravel-txtsync.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/laravel-txtsync)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/laravel-txtsync/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/laravel-txtsync)
[![StyleCI](https://styleci.io/repos/:style_ci_id/shield)](https://styleci.io/repos/:style_ci_id)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/:sensio_labs_id.svg?style=flat-square)](https://insight.sensiolabs.com/projects/:sensio_labs_id)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/laravel-txtsync.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/laravel-txtsync)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/laravel-txtsync/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/laravel-txtsync/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/laravel-txtsync.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/laravel-txtsync)

This package makes it easy to send SMS notifications using [TxtSync](https://txtsync.com) with Laravel 5.5 or greater for models with the `Notifiable` trait.


## Contents

- [Installation](#installation)
	- [Setting up the TxtSync service](#setting-up-the-TxtSync-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install the package via composer:

composer require laravel-notification-channels/txtsync
In Laravel 5.5+ the service provider will automatically get registered. In older versions of the framework just add the service provider in config/app.php file:

    'providers' => [
        ...
        NotificationChannels\TxtSync\TxtSyncServiceProvider::class,
    ],

### Setting up the TxtSync service

Add your TxtSync client key, client secret, api key and default sender id to your config/services.php:

    // config/services.php
    ...
    'txtsync' => [
        'client'  => env('TXTSYNC_KEY'),
        'secret' => env('TXTSYNC_SECRET'),
        'api_key' => env('TXTSYNC_APIKEY'),
        'sender_id' => env('TXTSYNC_SENDERID'),
    ],
    ...

## Usage

You can use the channel in your via() method inside the notification:

    use Illuminate\Notifications\Notification;
    use NotificationChannels\TxtSync\TxtSyncMessage;
    use NotificationChannels\TxtSync\TxtSyncChannel;
    
    class OrderDispatched extends Notification
    {
        public function via($notifiable)
        {
            return [TxtSyncChannel::class];
        }
    
        public function toTxtSync($notifiable)
        {
            return (new TxtSyncMessage())
                ->content("Your order {$notifiable->id} has been dispatched!");
        }
    }

For classes with the `Notifiable` trait, a `routeNotificationForTxtSync` method is required to find the telephone number to send the SMS.

e.g on a User model:

    use \Illuminate\Notifications\Notifiable;
    
    ....
    public function routeNotificationForTxtSync()
    {
        return $this->telephone ?? false;
    }
    ...


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email git@ganey.co.uk instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Michael Gane](https://github.com/ganey)
- [Warren Doyle](https://github.com/wdoyle)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
