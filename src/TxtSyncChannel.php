<?php

namespace NotificationChannels\TxtSync;

use NotificationChannels\TxtSync\Exceptions\CouldNotSendNotification;
use NotificationChannels\TxtSync\Events\MessageWasSent;
use NotificationChannels\TxtSync\Events\SendingMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\TxtSync\Client\ClientInterface as TxtSyncClient;

class TxtSyncChannel
{
    private $txtSyncClient;

    public function __construct(TxtSyncClient $client)
    {
        $this->txtSyncClient = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\TxtSync\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('txtsync')) {
            return;
        }
        $message = $notification->toTxtSync($notifiable);
        if (is_string($message)) {
            $message = new TxtSyncMessage($message);
        }

        $response = $this->txtSyncClient->send($to, $message->getContent());

        if ($response->getStatusCode() !== 200) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response->getBody()->getContents());
        }
    }
}
