<?php
namespace vipnytt\UserAgentParser\Tests;

use vipnytt\UserAgentParser;

/**
 * Class ExportTest
 *
 * @package vipnytt\UserAgentParser\Tests
 */
class ExportTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider generateDataForTest
     * @param string $userAgent
     * @param array $result
     */
    public function testExport($userAgent, $result)
    {
        $parser = new UserAgentParser($userAgent);
        $this->assertInstanceOf('vipnytt\UserAgentParser', $parser);
        $this->assertTrue($parser->export() == $result);
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
                    'googlebot-news/2.1',
                    'googlebot-news',
                    'googlebot',
                ]
            ]
        ];
    }
}
