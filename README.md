# Lazy SEO Structured Data

Lightweight Laravel package for Schema.org structured data and JSON-LD rendering.

## Install

```bash
composer require step2dev/lazy-seo-structured-data
php artisan vendor:publish --tag=lazy-seo-structured-data-config
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

```blade
<x-lazy-seo-jsonld type="article" :data="$schema" />
```

Helpers:

```php
seo_schema('article', []);
seo_jsonld('article', []);
```

Supported types: `WebPage`, `Article`, `BlogPosting`, `Product`, `Organization`, `LocalBusiness`, `WebSite`, `BreadcrumbList`, `FAQPage`.
