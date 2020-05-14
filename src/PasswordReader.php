<?php

namespace jr\ooapi;

class PasswordReader
{
    public function read($prompt): string
    {
        echo $prompt;
        $stream = popen("read -s; echo \$REPLY","r");
        $input = fgets($stream,100);
        pclose($stream);
        echo PHP_EOL;
        return $input;
    }
}