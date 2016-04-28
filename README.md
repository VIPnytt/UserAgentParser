[![Build Status](https://travis-ci.org/VIPnytt/UserAgentParser.svg?branch=master)](https://travis-ci.org/VIPnytt/UserAgentParser)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/VIPnytt/UserAgentParser/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/VIPnytt/UserAgentParser/?branch=master)
[![Code Climate](https://codeclimate.com/github/VIPnytt/UserAgentParser/badges/gpa.svg)](https://codeclimate.com/github/VIPnytt/UserAgentParser)
[![Test Coverage](https://codeclimate.com/github/VIPnytt/UserAgentParser/badges/coverage.svg)](https://codeclimate.com/github/VIPnytt/UserAgentParser/coverage)
[![License](https://poser.pugx.org/VIPnytt/UserAgentParser/license)](https://github.com/VIPnytt/UserAgentParser/blob/master/LICENSE)
[![Packagist](https://img.shields.io/packagist/v/vipnytt/useragentparser.svg)](https://packagist.org/packages/vipnytt/useragentparser)
[![Chat](https://badges.gitter.im/VIPnytt/UserAgentParser.svg)](https://gitter.im/VIPnytt/UserAgentParser)

# User-Agent parser for robot rule sets
Parser and group determiner optimalized for ``robots.txt``, ``X-Robots-tag`` and ``Robots-meta-tag`` usage cases.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/1386c14c-546c-4c42-ac55-91ea3a3a1ae1/big.png)](https://insight.sensiolabs.com/projects/1386c14c-546c-4c42-ac55-91ea3a3a1ae1)

#### Requirements:
- PHP [5.6+](http://php.net/supported-versions.php)
- PHP [mbstring](http://php.net/manual/en/book.mbstring.php) extension

## Installation
The library is available for install via [Composer](https://getcomposer.org). Just add this to your `composer.json` file:
```json
{
    "require": {
        "vipnytt/useragentparser": "~0.2"
    }
}
```
Then run `composer update`.

## Features
- Stripping of the version tag.
- List any _rule groups_ the User-Agent belongs to.
- Determine the correct group of records by finding the group with the most specific User-agent that still matches.

### When to use it?
- When parsing `robots.txt` rule sets, for robots online.
- When parsing the ``X-Robots-Tag`` HTTP-header.
- When parsing ``Robots meta tags`` in HTML documents

Note: _Full User-agent strings, like them sent by eg. web-browsers, or found in your log files, are not compatible, this is by design._
Supported User-agent string formats are ``UserAgentName/version`` with or without the version tag. Eg. ``MyWebCrawler/2.0`` or just ``MyWebCrawler``.


## Getting Started

### Strip the version tag.
```php
use vipnytt\UserAgentParser;

$parser = new UserAgentParser('googlebot/2.1');
var_dump($parser->stripVersion());
/* googlebot */
```

### List different groups the User-agent belongs to
```php
use vipnytt\UserAgentParser;

$parser = new UserAgentParser('googlebot-news/2.1');
var_dump($parser->export());
/*
 * googlebot-news/2.1
 * googlebot-news
 * googlebot
 */
```

### Determine the correct group
Determine the correct group of records by finding the group with the most specific User-agent that still matches your rule sets
```php
use vipnytt\UserAgentParser;

$parser = new UserAgentParser('googlebot-news');
var_dump($parser->match(['googlebot/2.1', 'googlebot-images', 'googlebot']));
/* googlebot */
```
