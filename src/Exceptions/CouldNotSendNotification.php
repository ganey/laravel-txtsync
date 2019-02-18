<?php

namespace NotificationChannels\TxtSync\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static(sprintf("The notification failed to send: %s", $response));
    }
}
