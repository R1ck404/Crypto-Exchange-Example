<?php
namespace Resources\Php\Exchange\Sockets;

class BinanceSocket {
    public function run() {
        $ws = (new ExchangeSocket("stream.binance.com", 9443));
        $ws->connect("btcusdt@kline_1m");
    }
}

?>