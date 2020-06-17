<?php

use PHPUnit\Framework\TestCase;
use jr\ooapi\cli\CliArguments;

/**
 * Class CliArgumentsTest
 *
 * @covers \jr\ooapi\cli\CliArguments
 */

class CliArgumentsTest extends TestCase
{
    public function testNoArguments()
    {
        $cliArguments = new CliArguments();
        $this->assertNull($cliArguments->getByFlag("-f", []));
    }

    public function testSingleArgument()
    {
        $cliArguments = new CliArguments();
        $this->assertEquals('value', $cliArguments->getByFlag('-v', ['calledScript', '-v', 'value']));
    }

    public function testMultipleArguments()
    {
        $argv = ['credentials.php', '-t', 'token', '-s', 'secret', '-f', 'file'];
        $cliArguments = new CliArguments();
        $this->assertEquals('token', $cliArguments->getByFlag('-t', $argv));
        $this->assertEquals('secret', $cliArguments->getByFlag('-s', $argv));
        $this->assertEquals('file', $cliArguments->getByFlag('-f', $argv));
    }
}
