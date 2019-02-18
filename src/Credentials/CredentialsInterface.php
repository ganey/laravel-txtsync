<?php

namespace NotificationChannels\TxtSync\Credentials;

interface CredentialsInterface {
    public function authorizationHeader();

    public function apiKey();
}
