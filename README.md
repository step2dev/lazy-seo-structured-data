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
php artisan vendor:publish --tag="lazy-seo-structured-data-config"
```

## Usage

```php
use Step2dev\LazySeoStructuredData\Facades\Schema;

$schema = Schema::article([
    'title' => 'Laravel SEO Tools',
    'description' => 'SEO toolkit for Laravel.',
    'author' => 'Step2Dev',
    'url' => 'https://example.com/blog/seo',
]);
```

Generic API:

```php
$schema = Schema::make('article', [
    'title' => 'Laravel SEO Tools',
]);
```

Blade:

```blade
<x-lazy-seo-structured-data-jsonld type="article" :data="[
    'title' => 'Laravel SEO Tools',
    'author' => 'Step2Dev',
]" />
```

Helpers:

```php
seo_schema('article', []);
seo_jsonld('article', []);
seo_jsonld_render($schema);
```

## Graph

```php
$graph = Schema::graph([
    Schema::organization(['name' => 'Step2Dev']),
    Schema::webSite(['name' => 'step2.dev']),
    Schema::article(['title' => 'Laravel SEO Tools']),
]);
```

```blade
<x-lazy-seo-structured-data-jsonld :graph="$graph" />
```

```php
seo_schema_graph([
    seo_schema('organization'),
    seo_schema('website'),
]);

seo_jsonld_graph([
    seo_schema('organization'),
    seo_schema('website'),
]);
```

## Supported schemas

```php
Schema::webPage([...]);
Schema::collectionPage([...]);
Schema::article([...]);
Schema::blogPosting([...]);
Schema::product([...]);
Schema::organization([...]);
Schema::person([...]);
Schema::localBusiness([...]);
Schema::webSite([...]);
Schema::breadcrumbList([...]);
Schema::faqPage([...]);
Schema::itemList([...]);
Schema::event([...]);
Schema::recipe([...]);
```

## Examples

```php
Schema::breadcrumbList([
    ['name' => 'Home', 'url' => 'https://example.com'],
    ['name' => 'Blog', 'url' => 'https://example.com/blog'],
]);

Schema::faqPage([
    ['question' => 'What is JSON-LD?', 'answer' => 'Structured data format.'],
]);

Schema::product([
    'name' => 'Laravel SEO Package',
    'brand' => 'Step2Dev',
    'price' => '49.00',
    'price_currency' => 'USD',
]);
```

## Config

```php
'unknown_type_behavior' => 'fallback', // fallback|exception

'json' => [
    'pretty' => true,
    'unescaped_unicode' => true,
    'unescaped_slashes' => true,
],
```

## Internal structure

```text
src/Builders     Schema builders grouped by responsibility
src/Services     Public orchestration services
src/Support      Cleaner, resolver, graph and JSON-LD renderer
```

`SchemaService` now only resolves and delegates. JSON rendering, graph building, schema cleaning and type resolving are separate classes.

## Legacy Blade aliases

Legacy aliases are enabled by default:

```blade
<x-lazy-seo-jsonld />
<x-lazy-seo-schema />
<x-lazy-seo::json-ld />
<x-lazy-seo::schema />
```

Disable them:

```php
'components' => [
    'register_legacy_aliases' => false,
],
```

## Testing

```bash
composer test
composer analyse
composer format
```

## License

MIT
