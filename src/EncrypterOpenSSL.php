<?php

namespace jr\ooapi;
use jr\ooapi\interfaces\Encrypter;

class EncrypterOpenSSL implements Encrypter
{
    const METHOD = 'aes128';

    public function encrypt($unencryptedString)
    {
        $ivlen = openssl_cipher_iv_length(self::METHOD);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $cipher = openssl_encrypt($unencryptedString, self::METHOD, 'test',0, $iv);

        return $cipher.':'.base64_encode($iv);
    }

    public function decrypt($encryptedString)
    {
        $cipherAndIv = explode(':', $encryptedString);
        $cipher = $cipherAndIv[0];
        $iv = base64_decode($cipherAndIv[1]);

        return openssl_decrypt($cipher, self::METHOD, 'test', 0, $iv);
    }
}