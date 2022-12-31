<?php
namespace Resources\Php\Exchange\Sockets;
use Socket;

class ExchangeSocket {

    private string $host = "";
    private int $port = 0;
    private $socket = null;
    private $connection = null;

    public function __construct(string $host, int $port) {
        $this->host = $host;
        $this->port = $port;
    }

    public function connect(string $socketData): bool {
        
        $this->socket = stream_socket_client("tls://" . $this->host . ":" . $this->port, $error, $errnum, 30, STREAM_CLIENT_CONNECT, stream_context_create(null));
        fwrite($this->socket, "GET /stream?streams=" . $socketData . " HTTP/1.1\r\nHost: " . $this->host . ":" . $this->port . "\r\nAccept: */*\r\nConnection: Upgrade\r\nUpgrade: websocket\r\nSec-WebSocket-Version: 13\r\nSec-WebSocket-Key: ".rand(0,999)."\r\n\r\n");
        echo "connected";

        return $this->connection ?? false;
    }

    public function disconnect() {
        socket_close($this->socket);

        exit();
    }

    public function isConnected(): bool|null {
        return !feof($this->socket);
    }

    public function read(): string|false {
        $read = fgets($this->socket, 512);

        return $read;
        //return socket_read($this->socket, 1924);
    }
}

?>