<?php
namespace vipnytt\UserAgentParser\Tests;

use vipnytt\UserAgentParser;

/**
 * Class MatchNotFoundTest
 *
 * @package vipnytt\UserAgentParser\Tests
 */
class MatchNotFoundTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider generateDataForTest
     * @param string $userAgent
     * @param array $array
     */
    public function testMatchNotFound($userAgent, $array)
    {
        $parser = new UserAgentParser($userAgent);
        $this->assertInstanceOf('vipnytt\UserAgentParser', $parser);
        $this->assertFalse($parser->match($array));
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
                'googlebot',
                [
                    'googlebot-news',
                    'googlebot-images',
                    'googlebot/2.0',
                ]
            ]
        ];
    }
}
