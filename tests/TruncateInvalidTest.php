<?php
/**
 * vipnytt/UserAgentParser
 *
 * @link https://github.com/VIPnytt/UserAgentParser
 * @license https://github.com/VIPnytt/UserAgentParser/blob/master/LICENSE The MIT License (MIT)
 */

namespace vipnytt\UserAgentParser\Tests;

use vipnytt\UserAgentParser;

/**
 * Class TruncateInvalidTest
 *
 * @package vipnytt\UserAgentParser\Tests
 */
class TruncateInvalidTest extends \PHPUnit_Framework_TestCase
{
    /**
     * PHPUnit >= 5.0
     *
     * @requires PHPUnit 5
     * @dataProvider generateDataForTest
     * @param string $product
     * @param int|string|null $version
     */
    public function testTruncateInvalid($product, $version)
    {
        $this->expectException(\PHPUnit_Framework_Error_Warning::class);
        new UserAgentParser($product, $version);
    }

    /**
     * PHPUnit >= 4.0
     *
     * @dataProvider generateDataForTest
     * @param string $product
     * @param int|string|null $version
     * @expectedException \PHPUnit_Framework_Error_Warning
     */
    public function testTruncateInvalidDeprecated($product, $version)
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
                'MyÇustomWebCrawler',
                '2.0',
            ],
            [
                'MyCøstomWebCræwler',
                '2.0',
            ],
        ];
    }
}