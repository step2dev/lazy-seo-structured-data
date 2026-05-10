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

The package has one clean flow:

```php
use Step2dev\LazySeoStructuredData\Facades\Schema;

$schema = Schema::make('article', [
    'title' => 'Laravel SEO Tools',
    'description' => 'SEO toolkit for Laravel.',
    'author' => 'Step2Dev',
    'url' => 'https://example.com/blog/seo',
]);
```

Render JSON-LD directly:

```php
echo Schema::render('article', [
    'title' => 'Laravel SEO Tools',
]);
```

Render a graph:

```php
$graph = Schema::graph([
    Schema::make('organization', ['name' => 'Step2Dev']),
    Schema::make('website', ['name' => 'step2.dev']),
    Schema::make('article', ['title' => 'Laravel SEO Tools']),
]);

echo Schema::renderGraph($graph);
```

## Helpers

```php
seo_schema('article', ['title' => 'Laravel SEO Tools']);
seo_schema_graph([
    seo_schema('organization', ['name' => 'Step2Dev']),
    seo_schema('website', ['name' => 'step2.dev']),
]);

seo_jsonld('article', ['title' => 'Laravel SEO Tools']);
seo_jsonld_render($schema);
seo_jsonld_graph([$organizationSchema, $websiteSchema]);
```

## Blade component

Preferred component:

```blade
<x-lazy-seo-structured-data::json-ld
    type="article"
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

Legacy aliases are still available by default:

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

## Supported schema types

| Type | Aliases | Schema.org type |
|---|---|---|
| `webpage` | `web_page` | `WebPage` |
| `collectionpage` | `collection_page` | `CollectionPage` |
| `website` | `web_site` | `WebSite` |
| `article` | - | `Article` |
| `blogposting` | `blog_post` | `BlogPosting` |
| `faq` | `faq_page` | `FAQPage` |
| `recipe` | - | `Recipe` |
| `product` | - | `Product` |
| `organization` | - | `Organization` |
| `person` | - | `Person` |
| `localbusiness` | `local_business` | `LocalBusiness` |
| `breadcrumbs` | `breadcrumb_list` | `BreadcrumbList` |
| `itemlist` | `item_list`, `list` | `ItemList` |
| `event` | - | `Event` |

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

Schema::register('course', function (array $data): array {
    return [
        '@context' => 'https://schema.org',
        '@type' => 'Course',
        'name' => $data['name'] ?? null,
        'description' => $data['description'] ?? null,
    ];
});

Schema::render('course', [
    'name' => 'Laravel Package Development',
]);
```

Config registration:

```php
'custom_types' => [
    'course' => App\Support\Seo\CourseSchema::class,
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

## Strict unknown type mode

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
src/Services     Public orchestration services
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

## License

MIT
