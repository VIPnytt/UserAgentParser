<?php
/**
 * vipnytt/UserAgentParser
 *
 * @link https://github.com/VIPnytt/UserAgentParser
 * @license https://github.com/VIPnytt/UserAgentParser/blob/master/LICENSE The MIT License (MIT)
 */

namespace vipnytt\UserAgentParser\Tests;

use vipnytt\UserAgentParser;
use vipnytt\UserAgentParser\Exceptions\FormatException;

/**
 * Class InvalidFormatTest
 *
 * @package vipnytt\UserAgentParser\Tests
 */
class InvalidFormatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * PHPUnit >= 5.0
     *
     * @requires PHPUnit 5
     * @dataProvider generateDataForTest
     * @param string $product
     * @param int|string|null $version
     */
    public function testInvalidFormat($product, $version)
    {
        $this->expectException(FormatException::class);
        new UserAgentParser($product, $version);
    }

    /**
     * PHPUnit >= 4.0
     *
     * @dataProvider generateDataForTest
     * @param string $product
     * @param int|string|null $version
     * @expectedException \vipnytt\UserAgentParser\Exceptions\FormatException
     */
    public function testInvalidFormatDeprecated($product, $version)
    {
        new UserAgentParser($product, $version);
    }

    /**
     * Generate test data
     * @return array
     */
    public function generateDataForTest()
    {
        return [
            [
                'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36',
                null,
            ],
            [
                'mybot 2.0',
                null,
            ],
            [
                'my crawler',
                2,
            ],
            [
                'mycrawler/2.1',
                '2.1',
            ],
            [
                'mycrawler/2.1alpha1',
                null,
            ],
            [
                'mycrawler',
                '2.1-alpha',
            ],
            [
                '',
                '2.0',
            ],
        ];
    }
}
