<?php

namespace Resources\Php\User;

use Resources\Php\Exchange\Exchange;
use Resources\Php\Exchange\ExchangeManager;

class User {
    public string $username = '';
    public string $exchange = '';
    public string $apiKey = '';
    public string $apiSecret = '';

    function __construct(string $username, string $exchange, string $apiKey, string $apiSecret)
    {
        $this->username = $username;
        $this->exchange = $exchange;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    function getUsername() : string {
        return $this->username;
    }
    
    function getExchange() : Exchange {
        return (new ExchangeManager())->getExchange($this->exchange, $this->apiKey, $this->apiSecret);
    }

    function getApiKey() : string {
        return $this->apiKey;
    }

    function getApiSecret() : string {
        return $this->apiSecret;
    }
}