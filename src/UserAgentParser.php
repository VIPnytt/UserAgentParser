<?php
namespace vipnytt;

use vipnytt\UserAgentParser\Exceptions\FormatException;
use vipnytt\UserAgentParser\Exceptions\ProductException;
use vipnytt\UserAgentParser\Exceptions\VersionException;

/**
 * Class UserAgentParser
 *
 * @link https://tools.ietf.org/html/rfc7231#section-5.5.3
 * @link https://tools.ietf.org/html/rfc7230
 *
 * @package vipnytt
 */
class UserAgentParser
{
    /**
     * RFC 7231 - Section 5.5.3 - User-agent
     */
    const RFC_README = 'https://tools.ietf.org/html/rfc7231#section-5.5.3';

    /**
     * PREG pattern for valid characters
     */
    const PREG_PATTERN = '/[^\x21-\x7E]/';

    /**
     * Product
     * @var string
     */
    private $product;

    /**
     * Version
     * @var int|string|null
     */
    private $version;

    /**
     * Constructor
     *
     * @param string $product
     * @param int|string|null $version
     */
    public function __construct($product, $version = null)
    {
        $this->product = $product;
        $this->version = $version;
        if (strpos($this->product, '/') !== false) {
            $this->split();
        }
        $this->blacklistCheck();
        $this->validateProduct();
        $this->validateVersion();
    }

    /**
     * Split Product and Version
     *
     * @return bool
     */
    private function split()
    {
        if (count($parts = explode('/', trim($this->product . '/' . $this->version, '/'), 2)) === 2) {
            $this->product = $parts[0];
            $this->version = $parts[1];
        }
        return true;
    }

    /**
     * @throws ProductException
     */
    private function blacklistCheck()
    {
        foreach (
            [
                'mozilla',
                'compatible',
                '(',
                ')',
                ' ',
            ] as $string
        ) {
            if (stripos($this->product, $string) !== false) {
                throw new FormatException('Invalid User-agent format (`' . trim($this->product . '/' . $this->version, '/') . '`). Examples of valid User-agents: `MyCustomBot`, `MyFetcher-news`, `MyCrawler/2.1` and `MyBot-images/1.2`. See also ' . self::RFC_README);
            }
        }
    }

    /**
     * Validate the Product format
     * @link https://tools.ietf.org/html/rfc7230#section-3.2.4
     *
     * @return bool
     * @throws ProductException
     */
    private function validateProduct()
    {
        $old = $this->product;
        if ($old !== ($this->product = preg_replace(self::PREG_PATTERN, '', $this->product))) {
            trigger_error("Product name contains invalid characters. Truncated to `$this->product`.", E_USER_WARNING);
        }
        if (empty($this->product)) {
            throw new ProductException('Product string cannot be empty.');
        }
        return true;
    }

    /**
     * Validate the Version and it's format
     *
     * @return bool
     * @throws VersionException
     */
    private function validateVersion()
    {
        if (
            $this->version !== null &&
            (
                empty($this->version) ||
                preg_match('/[^0-9.]/', $this->version) ||
                version_compare($this->version, '0.0.1', '>=') === false
            )
        ) {
            throw new VersionException('Invalid version format (`' . $this->version . '`). See http://semver.org/ for guidelines. In addition, dev/alpha/beta/rc tags is disallowed. See also ' . self::RFC_README);
        }
        $this->version = trim($this->version, '.0');
        return true;
    }

    /**
     * Get User-agent
     *
     * @return string
     */
    public function getUserAgent()
    {
        return trim($this->getProduct() . '/' . $this->getVersion(), '/');
    }

    /**
     * Get product
     *
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Get version
     *
     * @return string|null
     */
    public function getVersion()
    {
        return empty($this->version) ? null : $this->version;
    }

    /**
     * Find the best matching User-agent
     *
     * @param string[] $userAgents
     * @return string|false
     */
    public function getMostSpecific(array $userAgents)
    {
        $array = [];
        foreach ($userAgents as $string) {
            // Strip non-US-ASCII characters
            $array[$string] = strtolower(preg_replace(self::PREG_PATTERN, '', $string));
        }
        foreach (array_map('strtolower', $this->getUserAgents()) as $generated) {
            if (($result = array_search($generated, $array)) !== false) {
                // Match found
                return $result;
            }
        }
        return false;
    }

    /**
     * Get an array of all possible User-agent combinations
     *
     * @return array
     */
    public function getUserAgents()
    {
        return array_merge(
            preg_filter('/^/', $this->product . '/', $this->getVersions()),
            $this->getProducts()
        );
    }

    /**
     * Get versions
     *
     * @return array
     */
    public function getVersions()
    {
        while (
            substr_count($this->version, '.'
            ) < 2) {
            $this->version .= '.0';
        }
        // Remove part by part of the version.
        $result = array_merge(
            [$this->version],
            $this->explode($this->version, '.')
        );
        asort($result);
        usort($result, function ($a, $b) {
            return strlen($b) - strlen($a);
        });
        return $this->filterDuplicates($result);
    }

    /**
     * Explode
     *
     * @param string $string
     * @param string $delimiter
     * @return array
     */
    private function explode($string, $delimiter)
    {
        $result = [];
        while (($pos = strrpos($string, $delimiter)) !== false) {
            $result[] = ($string = substr($string, 0, $pos));
        }
        return $result;
    }

    /**
     * Filter duplicates from an array
     *
     * @param string[] $array
     * @return array
     */
    private function filterDuplicates($array)
    {
        $result = [];
        foreach ($array as $value) {
            if (!in_array($array, $result)) {
                $result[] = $value;
            }
        }
        return array_filter($result);
    }

    /**
     * Get products
     *
     * @return array
     */
    public function getProducts()
    {
        $result = array_merge(
            [
                $this->product,
                preg_replace('/[^A-Za-z0-9]/', '', $this->product), // in case of special characters
            ],
            $this->explode($this->product, '-')
        );
        return $this->filterDuplicates($result);
    }
}
