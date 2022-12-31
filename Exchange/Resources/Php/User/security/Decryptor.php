<?php

namespace Resources\Php\User\Security;

class Decryptor {
    public static function decrypt(string $toDecrypt): string {
        // Store the cipher method
        $ciphering = "AES-128-CTR";
        
        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        
        // Non-NULL Initialization Vector for decryption
        $decryption_iv = 'd6OiYJh39aUjzzZr';

        // Store the decryption key
        $decryption_key = "CryptoPlatform";

        // Use openssl_decrypt() function to decrypt the data
        $decryption = openssl_decrypt($toDecrypt, $ciphering, $decryption_key, $options, $decryption_iv);

        return $decryption;
    }
}
?>