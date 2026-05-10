# Lazy SEO Structured Data

[![Latest Version on Packagist](https://img.shields.io/packagist/v/step2dev/lazy-seo-structured-data.svg?style=flat-square)](https://packagist.org/packages/step2dev/lazy-seo-structured-data)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/step2dev/lazy-seo-structured-data/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/step2dev/lazy-seo-structured-data/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/step2dev/lazy-seo-structured-data.svg?style=flat-square)](https://packagist.org/packages/step2dev/lazy-seo-structured-data)

Lightweight Laravel package for Schema.org structured data and JSON-LD rendering.

## Requirements

- PHP 8.2+
- Laravel 11, 12 or 13

## Installation

```bash
composer require step2dev/lazy-seo-structured-data
```

Publish the config:

```bash
php artisan vendor:publish --tag="lazy-seo-structured-data-config"
```

Optionally publish the views:

```bash
php artisan vendor:publish --tag="lazy-seo-structured-data-views"
```

## Basic usage

```php
use Step2dev\LazySeoStructuredData\Services\SchemaService;

$schema = app(SchemaService::class)->make('article', [
    'title' => 'Laravel SEO Tools',
    'description' => 'SEO toolkit for Laravel.',
    'author' => 'Step2Dev',
    'url' => 'https://example.com/blog/seo',
]);
```

Render JSON-LD through Blade:

```blade
<x-lazy-seo-jsonld type="article" :data="[
    'title' => 'Laravel SEO Tools',
    'description' => 'SEO toolkit for Laravel.',
    'author' => 'Step2Dev',
]" />
```

Or use helpers:

```php
seo_schema('article', []);
seo_jsonld('article', []);
```

## Article schema

```php
$schema = seo_schema('article', [
    'title' => 'Top Laravel Security Issues',
    'description' => 'Common Laravel security mistakes and fixes.',
    'author' => 'Step2Dev',
    'date_published' => '2026-05-10',
    'date_modified' => '2026-05-11',
    'url' => 'https://example.com/blog/laravel-security',
]);
```

## Breadcrumbs schema

```php
$schema = seo_schema('breadcrumbs', [
    'items' => [
        ['name' => 'Home', 'url' => 'https://example.com'],
        ['name' => 'Blog', 'url' => 'https://example.com/blog'],
        ['name' => 'Article', 'url' => 'https://example.com/blog/article'],
    ],
]);
```

## FAQ schema

```php
$schema = seo_schema('faq', [
    'items' => [
        [
            'question' => 'What is JSON-LD?',
            'answer' => 'JSON-LD is a structured data format used by search engines.',
        ],
    ],
]);
```

## Product schema

```php
$schema = seo_schema('product', [
    'name' => 'Laravel SEO Package',
    'description' => 'SEO toolkit for Laravel applications.',
    'sku' => 'SEO-001',
    'brand' => 'Step2Dev',
    'price' => '49.00',
    'price_currency' => 'USD',
]);
```

## Organization schema

```php
$schema = seo_schema('organization', [
    'name' => 'Step2Dev',
    'url' => 'https://step2.dev',
    'logo' => 'https://step2.dev/logo.png',
    'same_as' => [
        'https://github.com/step2dev',
    ],
]);
```

## Rendering multiple schemas with `@graph`

For real pages, prefer one JSON-LD script with `@graph` when you need multiple schemas.

```php
use Step2dev\LazySeoStructuredData\Services\SchemaService;

$schema = app(SchemaService::class);

$graph = $schema->graph([
    $schema->make('organization', [
        'name' => 'Step2Dev',
        'url' => 'https://step2.dev',
    ]),
    $schema->make('website', [
        'name' => 'step2.dev',
        'url' => 'https://step2.dev',
    ]),
    $schema->make('article', [
        'title' => 'Laravel SEO Tools',
        'author' => 'Step2Dev',
    ]),
]);
```

Blade:

```blade
<x-lazy-seo-jsonld :graph="$graph" />
```

Helper:

```php
seo_jsonld_graph($graph);
```

## Strict unknown type handling

By default, unknown schema types fall back to `WebPage`.

```php
'unknown_type_behavior' => 'fallback',
```

For stricter projects, switch to exceptions:

```php
'unknown_type_behavior' => 'exception',
```

Then this will throw an `InvalidArgumentException`:

```php
seo_schema('wrong-type');
```

## JSON output options

```php
'json' => [
    'pretty' => true,
    'unescaped_unicode' => true,
    'unescaped_slashes' => true,
],
```

These options are used by `SchemaService::toJson()` and all rendered JSON-LD scripts.

## Supported types

- `WebPage`
- `CollectionPage`
- `Article`
- `BlogPosting`
- `Product`
- `Organization`
- `Person`
- `LocalBusiness`
- `WebSite`
- `BreadcrumbList`
- `FAQPage`
- `ItemList`
- `Event`
- `Recipe`

## Legacy Blade aliases

Legacy aliases are enabled by default:

```blade
<x-lazy-seo-jsonld />
<x-lazy-seo-schema />
<x-lazy-seo::json-ld />
<x-lazy-seo::schema />
```

Disable them in config:

```php
'components' => [
    'register_legacy_aliases' => false,
],
```

The package-specific aliases remain available:

```blade
<x-lazy-seo-structured-data-jsonld />
<x-lazy-seo-structured-data-schema />
```

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
