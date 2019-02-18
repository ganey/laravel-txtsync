<?php

namespace NotificationChannels\TxtSync\Client;

use GuzzleHttp\Client as GuzzleClient;
use NotificationChannels\TxtSync\Credentials\CredentialsInterface;
use NotificationChannels\TxtSync\Exceptions\DefaultSenderIdMissing;
use Psr\Http\Message\ResponseInterface;

class Client implements ClientInterface
{
    private $httpClient;

    private $senderId;

    private $credentials;

    public function __construct(CredentialsInterface $credentials, string $defaultSenderId)
    {
        if (!$defaultSenderId) {
            throw new DefaultSenderIdMissing();
        }

        $this->credentials = $credentials;

        $this->httpClient = new GuzzleClient([
            'base_uri' => 'https://api.txtsync.com',
            'auth' => $credentials->authorizationHeader(),
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => $credentials->authorizationHeader(),
                'x-api-key' => $credentials->apiKey(),
            ],
        ]);

        $this->senderId = $defaultSenderId;
    }

    public function getSenderId(): string
    {
        return $this->senderId;
    }

    public function withSenderId(string $senderId): Client
    {
        $new = clone $this;
        $new->senderId = $senderId;

        return $new;
    }

    public function send(string $to, string $message): ResponseInterface
    {
        return $this->httpClient->request('POST', '/sms/send', [
            'form_params' => [
                'From' => $this->senderId,
                'To' => $to,
                'Message' => $message,
            ],
        ]);
    }
}
