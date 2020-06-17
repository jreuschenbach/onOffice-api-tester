<?php


namespace jr\ooapi\cli;

/**
 * Class CliArguments
 *
 * Read arguments from argv
 *
 * @package jr\ooapi
 *
 */

class CliArguments
{
    public function getByFlag($flag, $argv)
    {
        foreach ($argv as $index => $argument)
        {
            if ($flag === $argument && array_key_exists($index + 1, $argv))
            {
                return $argv[$index +1];
            }
        }
    }
}