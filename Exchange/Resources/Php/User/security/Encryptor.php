<?php

namespace Resources\Php\User\Security;

class Encryptor {
    public static function encrypt(string $toEncrypt): string {
        // Store the cipher method
        $ciphering = "AES-128-CTR";
        
        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        
        // Non-NULL Initialization Vector for encryption
        $encryption_iv = 'd6OiYJh39aUjzzZr';
        
        // Store the encryption key
        $encryption_key = "CryptoPlatform";
        
        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt($toEncrypt, $ciphering, $encryption_key, $options, $encryption_iv);
        
        return $encryption;
    }
}
?>