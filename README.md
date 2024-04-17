# BEdita I18n Google plugin

[![Github Actions](https://github.com/bedita/i18n-google/workflows/php/badge.svg)](https://github.com/bedita/i18n-google/actions?query=workflow%3Aphp)
[![codecov](https://codecov.io/gh/bedita/i18n-google/branch/main/graph/badge.svg)](https://codecov.io/gh/bedita/i18n-google)
[![phpstan](https://img.shields.io/badge/PHPStan-level%205-brightgreen.svg)](https://phpstan.org)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bedita/i18n-google/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/bedita/i18n-google/?branch=main)
[![image](https://img.shields.io/packagist/v/bedita/i18n-google.svg?label=stable)](https://packagist.org/packages/bedita/i18n-google)
[![image](https://img.shields.io/github/license/bedita/i18n-google.svg)](https://github.com/bedita/i18n-google/blob/main/LICENSE.LGPL)

## Installation

You can install this plugin into your application using [composer](https://getcomposer.org).

The recommended way to install composer packages is:

```
composer require bedita/i18n-google
```

Note: php version supported is >= 7.4.

## Google Cloud Translation

This plugin uses [Google Cloud Translation for PHP](https://cloud.google.com/php/docs/reference/cloud-translate/latest) to translate texts, via [google-cloud-php-translate](https://github.com/googleapis/google-cloud-php-translate).

Usage example:
```php
use BEdita\I18n\Google\Core\Translator;

$translator = new Translator();
$translator->setup(['auth_key' => 'your-auth-key']);
$result = $translator->translate(['Hello world!'], 'en', 'it');
// $result is an array, i.e ['translation' => ['Ciao mondo!']]
```
