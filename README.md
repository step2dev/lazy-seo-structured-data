# Lazy SEO Structured Data

[![Latest Version on Packagist](https://img.shields.io/packagist/v/step2dev/lazy-seo-structured-data.svg?style=flat-square)](https://packagist.org/packages/step2dev/lazy-seo-structured-data)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/step2dev/lazy-seo-structured-data/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/step2dev/lazy-seo-structured-data/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/step2dev/lazy-seo-structured-data.svg?style=flat-square)](https://packagist.org/packages/step2dev/lazy-seo-structured-data)

Lightweight Laravel package for Schema.org structured data and JSON-LD rendering.

## Installation

You can install the package via composer:

```bash
composer require step2dev/lazy-seo-structured-data
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="lazy-seo-structured-data-config"
```

Optionally, you can publish the views using:

```bash
php artisan vendor:publish --tag="lazy-seo-structured-data-views"
```

## Usage

```php
use Step2dev\LazySeoStructuredData\Services\SchemaService;

$schema = app(SchemaService::class)->make('article', [
    'title' => 'Laravel SEO Tools',
    'description' => 'SEO toolkit for Laravel.',
    'author' => 'Step2Dev',
]);
```

Render JSON-LD through Blade:

```blade
<x-lazy-seo-jsonld type="article" :data="$schema" />
```

Or use helpers:

```php
seo_schema('article', []);
seo_jsonld('article', []);
```

Supported types: `WebPage`, `Article`, `BlogPosting`, `Product`, `Organization`, `LocalBusiness`, `WebSite`, `BreadcrumbList`, `FAQPage`.

## Testing

```bash
composer test
composer analyse
composer format
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

Please report security vulnerabilities privately to the maintainer instead of opening a public issue.

## Credits

- [CrazyBoy49z](https://github.com/CrazyBoy49z)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
