<?php
namespace vipnytt\UserAgentParser\Tests;

use vipnytt\UserAgentParser;

/**
 * Class MatchTest
 *
 * @package vipnytt\UserAgentParser\Tests
 */
class MatchTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider generateDataForTest
     * @param string $userAgent
     * @param array $array
     */
    public function testMatch($userAgent, $array)
    {
        $parser = new UserAgentParser($userAgent);
        $this->assertInstanceOf('vipnytt\UserAgentParser', $parser);
        $this->assertNotFalse($parser->match($array));
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
                'googlebot-news/2.1',
                [
                    'googlebot-news',
                    'googlebot-images',
                    'googlebot-news/2.0',
                    'googlebot',
                ]
            ]
        ];
    }
}
