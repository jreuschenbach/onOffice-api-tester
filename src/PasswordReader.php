<?php

namespace jr\ooapi;

/**
 * Class PasswordReader
 *
 * read password from stdin
 *
 * @package jr\ooapi
 */

class PasswordReader
{
    public function read($prompt): string
    {
        echo $prompt;
        $stream = popen("read -s; echo \$REPLY","r");
        $input = fgets($stream,100);
        pclose($stream);
        echo PHP_EOL;
        return trim($input);
    }
}