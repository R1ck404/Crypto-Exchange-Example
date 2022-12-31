<?php

namespace Resources\Php\Exchange\exchanges;

use Resources\Php\Exchange\Exchange;

class Binance extends Exchange {

    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->setEndPoints([
            "api" => "https://api.binance.com",
            "api1" => "https://api1.binance.com",
            "api2" => "https://api2.binance.com",
            "api3" => "https://api3.binance.com",

            "spot-trading" => "/api/v3/",
            "futures" => "/sapi/v1/futures/",
            "futures-algo" => "/sapi/v1/algo/futures/",
            "fiat" => "/sapi/v1/fiat/",
            "margin" => "/sapi/v1/margin/",
            "nft" => "/sapi/v1/nft/",

            "market" => "/api/v3/",
            "wallet" => "/sapi/v1/",
            "sub-account" => "/sapi/v1/sub-account/",

            "mining" => "/sapi/v1/mining/",
            "staking" => "/sapi/v1/staking/",
            "saving" => "/sapi/v1/lending/"
        ]);

        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;

        parent::__construct($apiKey, $apiSecret);
    }

    public function getEndPoints(): array
    {
        return $this->endPoints;
    }
}

?>