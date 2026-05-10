# Lazy SEO Structured Data

Laravel package for generating clean Schema.org JSON-LD structured data.

## Installation

```bash
composer require step2dev/lazy-seo-structured-data
```

Publish config when needed:

```bash
php artisan vendor:publish --tag=lazy-seo-structured-data-config
```

## Basic usage

```php
use Step2dev\LazySeoStructuredData\Facades\Schema;

$schema = Schema::make('Article', [
    'headline' => 'Laravel SEO structured data',
    'description' => 'JSON-LD structured data for Laravel.',
    'author' => 'Step2Dev',
    'url' => 'https://example.com/blog/structured-data',
]);
```

Render JSON-LD:

```php
{!! Schema::render('Article', [
    'headline' => 'Laravel SEO structured data',
]) !!}
```

Render an `@graph`:

```php
{!! Schema::renderGraph([
    Schema::make('Organization', [
        'name' => 'Step2Dev',
        'url' => 'https://step2.dev',
    ]),
    Schema::make('WebSite', [
        'name' => 'Step2.dev',
        'url' => 'https://step2.dev',
    ]),
    Schema::make('Article', [
        'headline' => 'Laravel SEO structured data',
    ]),
]) !!}
```

## Blade component

```blade
<x-lazy-seo-structured-data::json-ld
    type="Article"
    :data="[
        'headline' => 'Laravel SEO structured data',
        'description' => 'JSON-LD structured data for Laravel.',
    ]"
/>
```

Graph:

```blade
<x-lazy-seo-structured-data::json-ld :graph="$schemas" />
```

## Helpers

```php
seo_schema('Article', ['headline' => 'Title']);
seo_schema_graph([$schemaA, $schemaB]);
seo_jsonld_render($schema);
```

## Supported Schema.org types

The public type names intentionally follow real Schema.org names. Shorthand legacy aliases such as `faq`, `breadcrumbs`, or `list` are not supported.

| Type | Rich result | Required | Recommended |
|---|---:|---|---|
| `Article` | yes | - | `headline`, `description`, `image`, `datePublished`, `dateModified`, `author`, `publisher`, `mainEntityOfPage` |
| `BlogPosting` | yes | - | `headline`, `description`, `image`, `datePublished`, `dateModified`, `author`, `publisher`, `mainEntityOfPage` |
| `FAQPage` | no | `mainEntity` | `mainEntity.name`, `mainEntity.acceptedAnswer`, `mainEntity.acceptedAnswer.text` |
| `Recipe` | yes | `name`, `image` | `author`, `datePublished`, `description`, `prepTime`, `cookTime`, `totalTime`, `recipeYield`, `recipeIngredient`, `recipeInstructions` |
| `Product` | yes | `name` | `image`, `description`, `sku`, `brand`, `offers`, `aggregateRating`, `review` |
| `Offer` | embedded | `price`, `priceCurrency`, `availability`, `url` | `itemCondition`, `priceValidUntil`, `seller` |
| `Organization` | yes | - | `name`, `url`, `logo`, `sameAs` |
| `Person` | no | - | `name`, `url`, `image`, `sameAs`, `jobTitle` |
| `LocalBusiness` | yes | - | `name`, `image`, `url`, `telephone`, `address`, `openingHoursSpecification`, `priceRange` |
| `BreadcrumbList` | yes | `itemListElement` | `itemListElement.position`, `itemListElement.name`, `itemListElement.item` |
| `ItemList` | no | `itemListElement` | `itemListElement.position`, `itemListElement.name`, `itemListElement.url` |
| `Event` | yes | `name`, `startDate`, `location` | `description`, `image`, `endDate`, `eventStatus`, `eventAttendanceMode`, `offers`, `performer`, `organizer` |
| `WebSite` | yes | - | `name`, `url`, `potentialAction` |
| `WebPage` | no | - | `name`, `description`, `url`, `inLanguage`, `isPartOf`, `breadcrumb` |
| `CollectionPage` | no | - | `name`, `description`, `url`, `mainEntity`, `breadcrumb` |

`required` means practical rich-result eligibility where Google defines it or a minimum useful builder baseline. Schema.org itself is a vocabulary, not a strict validator.

## Inspect fields

```php
Schema::metadata('Product');
Schema::fields('Event');
```

CLI:

```bash
php artisan lazy-seo-structured-data:types
php artisan lazy-seo-structured-data:types Product
php artisan lazy-seo-structured-data:types Product --json
```

## Custom schema types

Runtime:

```php
Schema::register('Course', function (array $data): array {
    return [
        '@context' => 'https://schema.org',
        '@type' => 'Course',
        'name' => $data['name'] ?? null,
        'description' => $data['description'] ?? null,
    ];
});
```

Config:

```php
'custom_types' => [
    'Course' => App\Support\Seo\CourseSchema::class,
],
```

## Strict unknown types

```php
'unknown_type_behavior' => 'exception',
```

Default is `fallback`, which renders `WebPage` for unknown types.

## Testing

```bash
composer test
composer analyse
composer format
```
