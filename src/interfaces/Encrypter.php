<?php

namespace jr\ooapi\interfaces;

interface Encrypter
{
    public function encrypt($unencryptedString);

    public function decrypt($encryptedString);
}