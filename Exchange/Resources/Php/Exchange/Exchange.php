<?php

namespace Resources\Php\Exchange;

abstract class Exchange {

    public string $apiKey = "";
    public string $apiSecret = "";

    public string $apiUrl = "";

    public array $endPoints = [];

    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;

        $this->apiUrl = $this->getEndPoints()['api'];

        $newEndPoints = [];
        $ignoreList = ['api', 'api1', 'api2', 'api3'];
        foreach ($this->getEndPoints() as $key => $value) {
            if (!in_array($key, $ignoreList)) {
                $newEndPoints[$key] = $this->apiUrl . $value;
            } else {
                $newEndPoints[$key] = $value;
            }
        }

        $this->setEndPoints($newEndPoints);
    }

    abstract function getEndPoints(): array;
    public function setEndPoints(array $endPoints): bool {
        $this->endPoints = $endPoints;

        if ($this->endPoints === $endPoints) {
            return true;
        }

        return false;
    }

    public function buyOrder(string $symbol, float  $quantity, float $price, string $type = "LIMIT", array $flags = []) {
        return $this->placeOrder($symbol, 'BUY', $type, $quantity, $price, $flags);
    }

    public function sellOrder(string $symbol, float  $quantity, float $price, string $type = "LIMIT", array $flags = []) {
        return $this->placeOrder($symbol, 'SELL', $type, $quantity, $price, $flags);
    }
    
    public function cancelOrder(string $symbol, int $orderId): bool {
        return $this->sendRequest($this->getEndPoints()["spot-trading"] . "order", ["symbol" => $symbol, "orderId" => $orderId], true, "DELETE");
    }

    public function fetchOrder(string $symbol, int $orderId): array {
        return $this->sendRequest($this->getEndPoints()["spot-trading"] . "order", ["symbol" => $symbol, "orderId" => $orderId], true);
    }

    public function orderStatus(string $symbol, int $orderId): string {
		return $this->sendRequest($this->getEndPoints()["spot-trading"] . "order", ["symbol" => $symbol, "orderId" => $orderId], true)['status'];
	}
    
    public function fetchOpenOrders(string $symbol): array {
        return $this->sendRequest($this->getEndPoints()["spot-trading"] . "openOrders", ["symbol" => $symbol], true);
    }
    
    public function fetchOrders(string $symbol): array {
        return $this->sendRequest($this->getEndPoints()["spot-trading"] . "allOrders", ["symbol" => $symbol], true);
    }

    public function fetchTicker(string $symbol): array {
        $ticker = $this->sendRequest($this->getEndPoints()["spot-trading"] . "ticker", ["symbol" => $symbol]);
        return $ticker;
    }

    public function placeOrder(string $symbol, string $side, string $type, float $quantity, float|null $price = null, array $params = []) {
        $endpoint = $this->getEndPoints()["spot-trading"] . "order";

        $params = array_merge([
          'symbol' => $symbol,
          'side' => $side,
          'type' => $type,
          'quantity' => $quantity,
          "recvWindow" => 60000,
          'timeInForce' => "GTC"
        ], $params);
    
        if ($price) {
          $params['price'] = $price;
        }
    
        return $this->sendRequest($endpoint, $params, true, 'POST');
    }

    public function sendRequest($endpoint, $params = [], $include_sig = false, $method = 'GET') {
        if ($method === 'POST' or $include_sig === true) {
            $params['timestamp'] = (time() * 1000);
        }
        
        $query = http_build_query($params);
        $url = $endpoint . '?' . $query;
        $signature = hash_hmac('sha256', $query, $this->apiSecret);

        if ($method === 'POST' or $include_sig === true) {
            $url .= '&signature=' . $signature;
        }
    
        $headers = [
          'X-MBX-APIKEY: ' . $this->apiKey,
          'Content-Type: application/x-www-form-urlencoded',
          'Signature: ' . $signature
        ];
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }   
}