<?php

namespace Resources\Php\User;

use Resources\Php\User\{User};
use Resources\Php\Database\DatabaseConnector;
use Resources\Php\User\Security\Decryptor;
use Resources\Php\User\Security\Encryptor;

class UserManager {
    public array $connected_users = [];

    public function removeUser(string $username): bool {
        unset($this->connected_users[$username]);
        return true;
    }

    public function addUser(string $username): bool {
        $pdo = (new DatabaseConnector())->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch();

        if ($user !== false) {
            $exchange = $user['exchange'] ?? "";
            $apiKey = $user['apiKey'] ?? "";
            $apiSecret = $user['apiSecret'] ?? "";

            $user = new User($username, $exchange, $apiKey, $apiSecret);
            $this->connected_users[$username] = $user;
            return true;
        }
    
        return false;
    }

    public function getUser(string $username): User|null {
        $pdo = (new DatabaseConnector())->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch();

        if ($user !== false) {
            $exchange = $user['exchange'] ?? "";
            $apiKey = $user['apiKey'] ?? "";
            $apiSecret = $user['apiSecret'] ?? "";

            $user = new User($username, $exchange, $apiKey, $apiSecret);
            return $user;
        }

        return null;
    }

    public function userOnline(string $username): bool {
        return isset($this->connected_users[$username]);
    }

    public function userExists(string $username, string $password): bool {
        $pdo = (new DatabaseConnector())->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch();

        if ($user === false)
            return false;

        $decrypted_password = Decryptor::decrypt($user["password"]);
        echo $decrypted_password;
        if ($decrypted_password === $password) {
            return true;
        } else
            return false;
    }

    public function createUser(string $username, string $password): bool {
        $encryptedPassword = Encryptor::encrypt($password);
        $pdo = (new DatabaseConnector())->getConnection();

        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password);");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $encryptedPassword);
        $stmt->execute();

        return true;
    }

    public function deleteUser(string $username, string $password): bool {
        return true;
    }
}
