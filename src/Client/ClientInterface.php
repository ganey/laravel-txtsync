<?php

namespace NotificationChannels\TxtSync\Client;

interface ClientInterface
{
    /** @return \Psr\Http\Message\ResponseInterface */
    public function send(string $to, string $message);
}
