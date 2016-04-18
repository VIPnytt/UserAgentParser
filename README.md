[![Build Status](https://travis-ci.org/VIPnytt/UserAgentParser.svg?branch=master)](https://travis-ci.org/VIPnytt/UserAgentParser)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/VIPnytt/UserAgentParser/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/VIPnytt/UserAgentParser/?branch=master)
[![Code Climate](https://codeclimate.com/github/VIPnytt/UserAgentParser/badges/gpa.svg)](https://codeclimate.com/github/VIPnytt/UserAgentParser)
[![Test Coverage](https://codeclimate.com/github/VIPnytt/UserAgentParser/badges/coverage.svg)](https://codeclimate.com/github/VIPnytt/UserAgentParser/coverage)
[![License](https://poser.pugx.org/VIPnytt/UserAgentParser/license)](https://github.com/VIPnytt/UserAgentParser/blob/master/LICENSE)
[![Packagist](https://img.shields.io/packagist/v/vipnytt/useragentparser.svg)](https://packagist.org/packages/vipnytt/useragentparser)
[![Chat](https://badges.gitter.im/VIPnytt/UserAgentParser.svg)](https://gitter.im/VIPnytt/UserAgentParser)

# User-Agent string parser
PHP class to parse User-Agent strings sent by web-crawlers.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/1386c14c-546c-4c42-ac55-91ea3a3a1ae1/big.png)](https://insight.sensiolabs.com/projects/1386c14c-546c-4c42-ac55-91ea3a3a1ae1)

## Installation
The library is available for install via [Composer](https://getcomposer.org). Just add this to your `composer.json` file:
```json
{
    "require": {
        "vipnytt/useragentparser": "0.2.*"
    }
}
```
Then run `composer update`.

## Features
- Strip the version tag.
- Find different groups the User-Agent belongs to.
- Determine the correct group of records by finding the group with the most specific user-agent that still matches.

### When do I need it?
- Parsing of `robots.txt`, the rules for robots online.
- Parsing of the _X-Robots-Tag_ HTTP-header.
- Parsing of _Robots meta tags_ in HTML documents

Note: _The library is not compatible with User-Agent strings sent by eg. web-browsers. Contributions are of course welcome._


## Getting Started

### Strip the version tag.
```php
use vipnytt\UserAgentParser;

$parser = new UserAgentParser('googlebot/2.1');
var_dump($parser->stripVersion());
/* googlebot */
```

### Find different groups the User-Agent belongs to
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
Determine the correct group of records by finding the group with the most specific user-agent that still matches
```php
use vipnytt\UserAgentParser;

$parser = new UserAgentParser('googlebot-news');
var_dump($parser->match(['googlebot/2.1', 'googlebot-images', 'googlebot']));
/* googlebot */
```
