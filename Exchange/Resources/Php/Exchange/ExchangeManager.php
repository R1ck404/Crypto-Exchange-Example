<?php

namespace Resources\Php\Exchange;

use Resources\Php\Exchange\exchanges\Binance;

class ExchangeManager {
    private string $selectedExchange = 'binance';

    public function getExchange(string $exchange, string $apiKey, string $apiSecret): Exchange {
        //TODO: exchange selection
        return new Binance($apiKey, $apiSecret);
    }
}
?>