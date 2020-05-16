<?php

namespace jr\ooapi\interfaces;

/**
 * Interface Encrypter
 *
 * interface to encrypt/decrypt string-values
 *
 * @package jr\ooapi\interfaces
 */

interface Encrypter
{
    /**
     * implement encryption / return encrypted string
     *
     * @param $unencryptedString
     * @return string
     */

    public function encrypt($unencryptedString): string;


    /**
     * implement decryption / return decrypted string
     *
     * @param $encryptedString
     * @return string
     */

    public function decrypt($encryptedString): string;
}