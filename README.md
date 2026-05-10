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

## Main API

```php
use Step2dev\LazySeoStructuredData\Facades\Schema;

$schema = Schema::make('Article', [
    'title' => 'Laravel SEO Tools',
    'description' => 'SEO toolkit for Laravel.',
    'author' => 'Step2Dev',
    'url' => 'https://example.com/blog/seo',
]);
```

Render JSON-LD directly:

```php
echo Schema::render('Article', [
    'title' => 'Laravel SEO Tools',
]);
```

Render a graph:

```php
$graph = Schema::graph([
    Schema::make('Organization', ['name' => 'Step2Dev']),
    Schema::make('WebSite', ['name' => 'step2.dev']),
    Schema::make('Article', ['title' => 'Laravel SEO Tools']),
]);

echo Schema::renderGraph($graph);
```

Render an already built schema:

```php
echo Schema::renderSchema($schema);
```

## Helpers

The package keeps only three helpers:

```php
seo_schema('Article', ['title' => 'Laravel SEO Tools']);

seo_schema_graph([
    seo_schema('Organization', ['name' => 'Step2Dev']),
    seo_schema('WebSite', ['name' => 'step2.dev']),
]);

seo_jsonld_render($schema);
```

## Blade component

```blade
<x-lazy-seo-structured-data::json-ld
    type="Article"
    :data="[
        'title' => 'Laravel SEO Tools',
        'author' => 'Step2Dev',
    ]"
/>
```

Graph:

```blade
<x-lazy-seo-structured-data::json-ld :graph="$schemas" />
```

## Supported Schema.org types

The public schema names below match real Schema.org types.

| Public type | Schema.org URL |
|---|---|
| `Article` | `https://schema.org/Article` |
| `BlogPosting` | `https://schema.org/BlogPosting` |
| `FAQPage` | `https://schema.org/FAQPage` |
| `Recipe` | `https://schema.org/Recipe` |
| `Product` | `https://schema.org/Product` |
| `Organization` | `https://schema.org/Organization` |
| `Person` | `https://schema.org/Person` |
| `LocalBusiness` | `https://schema.org/LocalBusiness` |
| `BreadcrumbList` | `https://schema.org/BreadcrumbList` |
| `ItemList` | `https://schema.org/ItemList` |
| `Event` | `https://schema.org/Event` |
| `WebSite` | `https://schema.org/WebSite` |
| `WebPage` | `https://schema.org/WebPage` |
| `CollectionPage` | `https://schema.org/CollectionPage` |

Input is case-insensitive and tolerant to separators, so `WebPage`, `webPage`, `web_page`, and `web-page` resolve to the same type. Short aliases like `faq`, `breadcrumbs`, and `list` are intentionally not part of the public API.

List available types from CLI:

```bash
php artisan lazy-seo-structured-data:types
```

## Examples

Breadcrumbs:

```php
Schema::breadcrumbList([
    ['name' => 'Home', 'url' => 'https://example.com'],
    ['name' => 'Blog', 'url' => 'https://example.com/blog'],
]);
```

FAQ:

```php
Schema::faqPage([
    ['question' => 'What is JSON-LD?', 'answer' => 'Structured data format.'],
]);
```

Product:

```php
Schema::product([
    'name' => 'Laravel SEO Package',
    'brand' => 'Step2Dev',
    'price' => '49.00',
    'price_currency' => 'USD',
]);
```

## Custom schema types

Runtime registration:

```php
use Step2dev\LazySeoStructuredData\Facades\Schema;

Schema::register('Course', function (array $data): array {
    return [
        '@context' => 'https://schema.org',
        '@type' => 'Course',
        'name' => $data['name'] ?? null,
        'description' => $data['description'] ?? null,
    ];
});

Schema::render('Course', [
    'name' => 'Laravel Package Development',
]);
```

Config registration:

```php
'custom_types' => [
    'Course' => App\Support\Seo\CourseSchema::class,
],
```

The class must be invokable:

```php
final class CourseSchema
{
    public function __invoke(array $data): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Course',
            'name' => $data['name'] ?? null,
        ];
    }
}
```

## Unknown type behavior

Default behavior falls back to `WebPage` for unknown schema types.

```php
'unknown_type_behavior' => 'fallback', // fallback|exception
```

For stricter projects:

```php
'unknown_type_behavior' => 'exception',
```

## JSON output

```php
'json' => [
    'pretty' => true,
    'unescaped_unicode' => true,
    'unescaped_slashes' => true,
],
```

## Internal structure

```text
src/Builders     Schema builders grouped by responsibility
src/Services     Public orchestration service
src/Support      Registry, cleaner, resolver, graph and JSON-LD renderer
src/Commands     Artisan tooling
```

`SchemaService` is the public API. Builders generate arrays. `JsonLdRenderer` renders final JSON-LD scripts. Custom schemas are handled by `CustomSchemaRegistry`.

## Testing

```bash
composer test
composer analyse
composer format
```
