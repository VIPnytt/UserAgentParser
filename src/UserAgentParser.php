<?php
namespace vipnytt;

use Exception;

/**
 * Class UserAgentParser
 *
 * @package vipnytt
 */
class UserAgentParser
{
    private $userAgent;
    private $groups = [];

    /**
     * Constructor
     *
     * @param string $userAgent
     * @throws Exception
     */
    public function __construct($userAgent)
    {
        if (!extension_loaded('mbstring')) {
            throw new Exception('The extension `mbstring` must be installed and loaded for this library');
        }
        mb_detect_encoding($userAgent);

        $this->userAgent = mb_strtolower(trim($userAgent));
        $this->explode();
    }

    /**
     * Parses all possible User-Agent groups to an array
     *
     * @return array
     */
    private function explode()
    {
        $this->groups = [$this->userAgent];
        $this->groups[] = $this->stripVersion();
        while (mb_strpos(end($this->groups), '-') !== false) {
            $current = end($this->groups);
            $this->groups[] = mb_substr($current, 0, mb_strrpos($current, '-'));
        }
        $this->groups = array_unique($this->groups);
    }

    /**
     * Strip version number
     *
     * @return string
     */
    public function stripVersion()
    {
        if (mb_strpos($this->userAgent, '/') !== false) {
            return mb_split('/', $this->userAgent, 2)[0];
        }
        return $this->userAgent;
    }

    /**
     * Find matching User-Agent
     * Selects the best matching from an array, or $fallback if none matches
     *
     * @param array $array
     * @param string|null $fallback
     * @return string|false
     */
    public function match($array, $fallback = null)
    {
        foreach ($this->groups as $userAgent) {
            if (in_array($userAgent, array_map('mb_strtolower', $array))) {
                return $userAgent;
            }
        }
        return isset($fallback) ? $fallback : false;
    }

    /**
     * Export all User-Agents as an array
     *
     * @return array
     */
    public function export()
    {
        return $this->groups;
    }
}
