<?php
/**
 * vipnytt/UserAgentParser
 *
 * @link https://github.com/VIPnytt/UserAgentParser
 * @license https://github.com/VIPnytt/UserAgentParser/blob/master/LICENSE The MIT License (MIT)
 */

namespace vipnytt\UserAgentParser\Tests;

use PHPUnit\Framework\TestCase;
use vipnytt\UserAgentParser\Exceptions;

/**
 * Class ExceptionTest
 *
 * @package vipnytt\UserAgentParser\Tests
 */
class ExceptionTest extends TestCase
{
    /**
     * @throws Exceptions\FormatException
     */
    public function testFormat()
    {
        $this->expectException(\InvalidArgumentException::class);
        throw new Exceptions\FormatException();
    }

    /**
     * @throws Exceptions\ProductException
     */
    public function testProduct()
    {
        $this->expectException(Exceptions\FormatException::class);
        throw new Exceptions\ProductException();
    }

    /**
     * @throws Exceptions\VersionException
     */
    public function testVersion()
    {
        $this->expectException(Exceptions\FormatException::class);
        throw new Exceptions\VersionException();
    }

    /**
     * @throws Exceptions\UserAgentParserException
     */
    public function testUserAgentParser()
    {
        $this->expectException(\Exception::class);
        throw new Exceptions\UserAgentParserException();
    }
}
