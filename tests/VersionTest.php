<?php
namespace vipnytt\UserAgentParser\Tests;

use vipnytt\UserAgentParser;

/**
 * Class VersionTest
 *
 * @package vipnytt\UserAgentParser\Tests
 */
class VersionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider generateDataForTest
     * @param string $userAgent
     * @param string $result
     */
    public function testVersion($userAgent, $result)
    {
        $parser = new UserAgentParser($userAgent);
        $this->assertInstanceOf('vipnytt\UserAgentParser', $parser);
        $this->assertTrue($parser->stripVersion() == $result);
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
                'googlebot/2.1',
                'googlebot',
            ],
            [
                'bingbot/2.0',
                'bingbot',
            ],
            [
                'mybot',
                'mybot',
            ]
        ];
    }
}
