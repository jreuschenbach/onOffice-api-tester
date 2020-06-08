<?php

namespace jr\ooapi\cli;

/**
 * Class PasswordReader
 *
 * read password from stdin
 *
 * @package jr\ooapi\cli
 */

class PasswordReader
{
    public function read($prompt): string
    {
        echo $prompt;
        system('stty -echo');
        $password = trim(fgets(STDIN));
        system('stty echo');
        echo PHP_EOL;
        return trim($password);
    }
}