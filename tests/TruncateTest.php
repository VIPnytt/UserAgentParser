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
 * Class TruncateTest
 *
 * @package vipnytt\UserAgentParser\Tests
 */
class TruncateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @requires PHPUnit 5.2
     * @dataProvider generateDataForTest
     * @param string $product
     */
    public function testTruncate($product)
    {
        $this->expectException(\PHPUnit_Framework_Error_Warning::class);
        new UserAgentParser($product);
    }

    /**
     * Generate test data
     * @return array
     */
    public function generateDataForTest()
    {
        return [
            [
                'mybot 2.0',
            ],
            [
                'my crawler',
            ],
        ];
    }
}
