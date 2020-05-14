<?php

namespace jr\ooapi;
use jr\ooapi\interfaces\Encrypter;

class EncrypterOpenSSL implements Encrypter
{
    const METHOD = 'aes128';

    /** @var string */
    private $password = '';

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function encrypt($unencryptedString): string
    {
        $ivlen = openssl_cipher_iv_length(self::METHOD);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $cipher = openssl_encrypt($unencryptedString, self::METHOD, $this->password,0, $iv);

        return $cipher.':'.base64_encode($iv);
    }

    public function decrypt($encryptedString): string
    {
        $cipherAndIv = explode(':', $encryptedString);
        $cipher = $cipherAndIv[0];
        $iv = base64_decode($cipherAndIv[1]);

        return openssl_decrypt($cipher, self::METHOD, $this->password, 0, $iv);
    }
}