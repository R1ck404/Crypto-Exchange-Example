<?php

namespace Resources\Php\Database;

use PDO;

class DatabaseConnector {

    private ?PDO $database = null;

    private string $host = 'host'; //the host.
    private string $db = 'database'; //the database name.
    private string $user = 'user'; //the username.
    private string $password = 'password'; //the user's password.
    private string $charset = 'utf8mb4'; //dont change.

    public function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $this->database = new PDO($dsn, $this->user, $this->password, $options);
    }

    public function getConnection(): PDO {
        return $this->database;
    }
}