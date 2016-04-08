<?php
namespace vipnytt\UserAgentParser\Tests;

use vipnytt\UserAgentParser;

/**
 * Class ExceptionMBStringTest
 *
 * @package vipnytt\UserAgentParser\Tests
 */
class ExceptionMBStringTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if exception is thrown when extension `mbstring` is not loaded
     */
    public function testExceptionMBString()
    {
        if (!extension_loaded('mbstring')) {
            $this->expectException('\Exception');
            new UserAgentParser('SitemapParser');
        }
    }
}
