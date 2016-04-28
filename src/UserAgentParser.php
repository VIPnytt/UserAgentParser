<?php
namespace vipnytt;

use vipnytt\UserAgentParser\Exceptions\FormatException;

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
     */
    public function __construct($userAgent)
    {
        mb_detect_encoding($userAgent);
        $this->userAgent = trim($userAgent);
        $this->checkFormat();
        $this->explode();
    }

    /**
     * Validate the UserAgent format
     *
     * @throws FormatException
     */
    protected function checkFormat()
    {
        if (preg_match('/\s/', $this->userAgent)) {
            throw new FormatException("Format not supported. Please use `name/version` or just `name`, eg. `MyUserAgent/1.0` and `MyUserAgent`.");
        }
    }

    /**
     * Parses all possible User-Agent groups to an array
     *
     * @return array
     */
    private function explode()
    {
        $groups = [$this->userAgent];

        $groups[] = $this->stripVersion();
        while (mb_stripos(end($groups), '-') !== false) {
            $current = end($groups);
            $groups[] = mb_substr($current, 0, mb_strripos($current, '-'));
        }
        foreach ($groups as $group) {
            if (!in_array($group, $this->groups)) {
                $this->groups[] = $group;
            }
        }
    }

    /**
     * Strip version number
     *
     * @return string
     */
    public function stripVersion()
    {
        if (mb_stripos($this->userAgent, '/') !== false) {
            return mb_split('/', $this->userAgent, 2)[0];
        }
        return $this->userAgent;
    }

    /**
     * Find matching User-Agent
     * Selects the best matching from an array, or false if none matches
     *
     * @param array $array
     * @return string|false
     */
    public function match($array)
    {
        $array = array_map('mb_strtolower', $array);
        foreach ($this->groups as $userAgent) {
            if (in_array(mb_strtolower($userAgent), $array)) {
                return $userAgent;
            }
        }
        return false;
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
