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

## Debug output

Use `Schema::debug()` during development to inspect generated JSON-LD, metadata, and missing common fields.

```php
$debug = Schema::debug('Product', [
    'name' => 'Laravel SEO Package',
]);

$debug['schema'];
$debug['json'];
$debug['metadata'];
$debug['fields'];
$debug['missing_required'];
$debug['missing_recommended'];
```

Example result shape:

```php
[
    'schema' => [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => 'Laravel SEO Package',
    ],
    'json' => '{...}',
    'metadata' => [...],
    'fields' => [
        'required' => ['name'],
        'recommended' => ['image', 'description', 'sku', 'brand', 'offers'],
        'optional' => [...],
    ],
    'missing_required' => [],
    'missing_recommended' => ['image', 'description', 'sku', 'brand', 'offers'],
]
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

## Typed examples

### Article

```php
Schema::make('Article', [
    'headline' => 'Laravel SEO structured data',
    'description' => 'Generate clean JSON-LD in Laravel.',
    'image' => 'https://example.com/article.jpg',
    'datePublished' => '2026-05-10T12:00:00+03:00',
    'dateModified' => '2026-05-11T12:00:00+03:00',
    'author' => [
        'name' => 'Step2Dev',
        'url' => 'https://step2.dev',
    ],
    'publisher' => [
        'name' => 'Step2Dev',
        'url' => 'https://step2.dev',
        'logo' => 'https://step2.dev/logo.png',
    ],
    'url' => 'https://example.com/blog/structured-data',
]);
```

### Product with Offer, Brand, AggregateRating and Review

```php
Schema::make('Product', [
    'name' => 'Laravel SEO Package',
    'image' => ['https://example.com/product.jpg'],
    'description' => 'Structured data package for Laravel.',
    'sku' => 'LSD-001',
    'brand' => [
        'name' => 'Step2Dev',
        'url' => 'https://step2.dev',
    ],
    'offers' => [
        'url' => 'https://example.com/products/structured-data',
        'price' => '49.00',
        'priceCurrency' => 'USD',
        'availability' => 'https://schema.org/InStock',
        'itemCondition' => 'https://schema.org/NewCondition',
    ],
    'aggregateRating' => [
        'ratingValue' => '4.9',
        'reviewCount' => 128,
    ],
    'review' => [
        'author' => 'Yurii',
        'reviewBody' => 'Clean and useful package.',
        'reviewRating' => [
            'ratingValue' => '5',
            'bestRating' => '5',
        ],
    ],
]);
```

### WebSite with SearchAction

```php
Schema::make('WebSite', [
    'name' => 'Step2.dev',
    'url' => 'https://step2.dev',
    'search_url' => 'https://step2.dev/search?q={search_term_string}',
]);
```

Or build `SearchAction` directly:

```php
Schema::make('SearchAction', [
    'target' => 'https://step2.dev/search?q={search_term_string}',
]);

Schema::searchAction('https://step2.dev/search?q={search_term_string}');
```

### Event with Place

```php
Schema::make('Event', [
    'name' => 'Laravel Meetup',
    'description' => 'Laravel package development session.',
    'startDate' => '2026-05-20T18:00:00+03:00',
    'endDate' => '2026-05-20T20:00:00+03:00',
    'location' => [
        'name' => 'Main Hall',
        'address' => [
            'streetAddress' => 'Khreshchatyk 1',
            'addressLocality' => 'Kyiv',
            'addressCountry' => 'UA',
        ],
        'geo' => [
            'latitude' => 50.4501,
            'longitude' => 30.5234,
        ],
    ],
    'organizer' => [
        'type' => 'Organization',
        'name' => 'Step2Dev',
        'url' => 'https://step2.dev',
    ],
]);
```

### Virtual Event

```php
Schema::make('Event', [
    'name' => 'Online Laravel Workshop',
    'startDate' => '2026-05-20T18:00:00+03:00',
    'eventAttendanceMode' => 'https://schema.org/OnlineEventAttendanceMode',
    'location' => [
        'type' => 'VirtualLocation',
        'url' => 'https://example.com/live',
    ],
]);
```

### Organization with ContactPoint and PostalAddress

```php
Schema::make('Organization', [
    'name' => 'Step2Dev',
    'url' => 'https://step2.dev',
    'logo' => 'https://step2.dev/logo.png',
    'sameAs' => [
        'https://github.com/step2dev',
    ],
    'address' => [
        'addressLocality' => 'Kyiv',
        'addressCountry' => 'UA',
    ],
    'contactPoint' => [
        'telephone' => '+380000000000',
        'contactType' => 'support',
        'availableLanguage' => ['uk', 'en'],
    ],
]);
```

### FAQPage

> `FAQPage` is still a valid Schema.org type, but Google FAQ rich results are deprecated.

```php
Schema::make('FAQPage', [
    'items' => [
        [
            'question' => 'Does this package support JSON-LD?',
            'answer' => 'Yes, it renders Schema.org JSON-LD.',
        ],
    ],
]);
```

### BreadcrumbList

```php
Schema::make('BreadcrumbList', [
    'items' => [
        ['name' => 'Home', 'url' => 'https://example.com'],
        ['name' => 'Blog', 'url' => 'https://example.com/blog'],
        ['name' => 'Article', 'url' => 'https://example.com/blog/article'],
    ],
]);
```

## Supported Schema.org types

The public type names intentionally follow real Schema.org names. Shorthand legacy aliases such as `faq`, `breadcrumbs`, or `list` are not supported.

| Type | Role | Required | Recommended |
|---|---|---|---|
| `Article` | page/content | - | `headline`, `description`, `image`, `datePublished`, `dateModified`, `author`, `publisher`, `mainEntityOfPage` |
| `BlogPosting` | page/content | - | `headline`, `description`, `image`, `datePublished`, `dateModified`, `author`, `publisher`, `mainEntityOfPage` |
| `FAQPage` | page/content | `mainEntity` | `mainEntity.name`, `mainEntity.acceptedAnswer`, `mainEntity.acceptedAnswer.text` |
| `Recipe` | page/content | `name`, `image` | `author`, `datePublished`, `description`, `prepTime`, `cookTime`, `totalTime`, `recipeYield`, `recipeIngredient`, `recipeInstructions` |
| `Product` | page/content | `name` | `image`, `description`, `sku`, `brand`, `offers`, `aggregateRating`, `review` |
| `Event` | page/content | `name`, `startDate`, `location` | `description`, `image`, `endDate`, `eventStatus`, `eventAttendanceMode`, `offers`, `performer`, `organizer` |
| `Organization` | identity | - | `name`, `url`, `logo`, `sameAs` |
| `Person` | identity | - | `name`, `url`, `image`, `sameAs`, `jobTitle` |
| `LocalBusiness` | identity/local | - | `name`, `image`, `url`, `telephone`, `address`, `openingHoursSpecification`, `priceRange` |
| `WebSite` | site | - | `name`, `url`, `potentialAction` |
| `WebPage` | page | - | `name`, `description`, `url`, `inLanguage`, `isPartOf`, `breadcrumb` |
| `CollectionPage` | page | - | `name`, `description`, `url`, `mainEntity`, `breadcrumb` |
| `BreadcrumbList` | list | `itemListElement` | `itemListElement.position`, `itemListElement.name`, `itemListElement.item` |
| `ItemList` | list | `itemListElement` | `itemListElement.position`, `itemListElement.name`, `itemListElement.url` |
| `Offer` | nested | `price`, `priceCurrency`, `availability`, `url` | `itemCondition`, `priceValidUntil`, `seller` |
| `SearchAction` | nested | `target`, `query-input` | `target`, `query-input` |
| `Brand` | nested | - | `name`, `url`, `logo`, `sameAs` |
| `ImageObject` | nested | - | `url`, `contentUrl`, `width`, `height` |
| `PostalAddress` | nested | - | `streetAddress`, `addressLocality`, `addressRegion`, `postalCode`, `addressCountry` |
| `ContactPoint` | nested | - | `telephone`, `contactType`, `email`, `areaServed`, `availableLanguage` |
| `AggregateRating` | nested | - | `ratingValue`, `reviewCount`, `ratingCount`, `bestRating`, `worstRating` |
| `Rating` | nested | - | `ratingValue`, `bestRating`, `worstRating` |
| `Review` | nested | - | `author`, `reviewRating`, `reviewBody`, `datePublished` |
| `Question` | nested | `name`, `acceptedAnswer` | `acceptedAnswer.text` |
| `Answer` | nested | `text` | `text` |
| `ListItem` | nested | - | `position`, `name`, `item`, `url` |
| `Place` | nested | - | `name`, `address`, `geo`, `url` |
| `VirtualLocation` | nested | - | `url` |
| `GeoCoordinates` | nested | - | `latitude`, `longitude` |

`required` means practical rich-result eligibility where Google defines it or a minimum useful builder baseline. Schema.org itself is a vocabulary, not a strict validator.

## Inspect fields

```php
Schema::metadata('Product');
Schema::fields('Event');
Schema::debug('Product', ['name' => 'Laravel SEO Package']);
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
