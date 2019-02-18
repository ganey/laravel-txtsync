<?php

namespace NotificationChannels\TxtSync\Credentials;

use NotificationChannels\TxtSync\Exceptions\InvalidCredentials;

class Credentials implements CredentialsInterface
{
    private $clientKey;

    private $clientSecret;

    private $apiKey;

    public function __construct(string $ClientKey, string $ClientSecret, string $ApiKey)
    {
        if (!$ClientKey || !$ClientSecret || !$ApiKey) {
            throw new InvalidCredentials();
        }
        $this->clientKey = $ClientKey;
        $this->clientSecret = $ClientSecret;
        $this->apiKey = $ApiKey;
    }

    public function authorizationHeader()
    {
        return 'Basic ' . $this->getEncodedAuth();
    }

    public function apiKey()
    {
        return $this->apiKey;
    }

    private function getEncodedAuth()
    {
        return base64_encode($this->clientKey . ':' . $this->clientSecret);
    }

}
