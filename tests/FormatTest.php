<?php
namespace vipnytt\UserAgentParser\Tests;

use vipnytt\UserAgentParser;
use vipnytt\UserAgentParser\Exceptions\FormatException;

/**
 * Class FormatTest
 *
 * @package vipnytt\UserAgentParser\Tests
 */
class FormatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider generateDataForTest
     * @param string $userAgent
     */
    public function testFormat($userAgent)
    {
        $this->expectException(FormatException::class);
        new UserAgentParser($userAgent);
    }

    /**
     * Generate test data
     * @return array
     */
    public
    function generateDataForTest()
    {
        return [
            [
                'mybot 2.0',
            ],
            [
                'my crawler',
            ],
            [
                'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36',
            ],
        ];
    }
}
