<?php

use Step2dev\LazySeoStructuredData\Services\SchemaService;

it('builds article schema', function (): void {
    $schema = app(SchemaService::class)->make('article', [
        'title' => 'Laravel SEO Tools',
        'description' => 'SEO toolkit for Laravel.',
        'author' => 'Step2Dev',
        'url' => 'https://example.com/blog/seo',
    ]);

    expect($schema)->toMatchArray([
        '@context' => 'https://schema.org',
        '@type' => 'Article',
        'headline' => 'Laravel SEO Tools',
        'description' => 'SEO toolkit for Laravel.',
        'author' => [
            '@type' => 'Person',
            'name' => 'Step2Dev',
        ],
    ]);
});

it('builds breadcrumb list schema', function (): void {
    $schema = app(SchemaService::class)->make('BreadcrumbList', [
        'items' => [
            ['name' => 'Home', 'url' => 'https://example.com'],
            ['name' => 'Blog', 'url' => 'https://example.com/blog'],
        ],
    ]);

    expect($schema['@type'])->toBe('BreadcrumbList')
        ->and($schema['itemListElement'])->toHaveCount(2)
        ->and($schema['itemListElement'][1])->toMatchArray([
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Blog',
            'item' => 'https://example.com/blog',
        ]);
});

it('builds graph schema without nested contexts', function (): void {
    $schema = app(SchemaService::class);

    $graph = $schema->graph([
        $schema->make('organization', ['name' => 'Step2Dev']),
        $schema->make('website', ['name' => 'step2.dev', 'url' => 'https://step2.dev']),
        $schema->make('article', ['title' => 'Laravel SEO Tools']),
    ]);

    expect($graph['@context'])->toBe('https://schema.org')
        ->and($graph['@graph'])->toHaveCount(3)
        ->and($graph['@graph'][0])->not->toHaveKey('@context')
        ->and($graph['@graph'][0]['@type'])->toBe('Organization')
        ->and($graph['@graph'][2]['@type'])->toBe('Article');
});

it('uses configured json flags', function (): void {
    config()->set('lazy-seo-structured-data.json.pretty', false);
    config()->set('lazy-seo-structured-data.json.unescaped_unicode', true);
    config()->set('lazy-seo-structured-data.json.unescaped_slashes', true);

    $json = app(SchemaService::class)->toJson([
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => 'Українська сторінка',
        'url' => 'https://example.com/page',
    ]);

    expect($json)->toBe('{"@context":"https://schema.org","@type":"WebPage","name":"Українська сторінка","url":"https://example.com/page"}');
});

it('falls back to webpage for unknown types by default', function (): void {
    $schema = app(SchemaService::class)->make('unknown-type', [
        'title' => 'Fallback page',
        'url' => 'https://example.com/fallback',
    ]);

    expect($schema['@type'])->toBe('WebPage')
        ->and($schema['name'])->toBe('Fallback page');
});

it('can throw an exception for unknown types', function (): void {
    config()->set('lazy-seo-structured-data.unknown_type_behavior', 'exception');

    app(SchemaService::class)->make('unknown-type');
})->throws(InvalidArgumentException::class, 'Unknown structured data type [unknown-type].');

it('builds item list schema', function (): void {
    $schema = app(SchemaService::class)->make('ItemList', [
        'items' => ['First', 'Second'],
    ]);

    expect($schema)->toMatchArray([
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'First'],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Second'],
        ],
    ]);
});

it('removes nested empty values recursively', function (): void {
    $json = app(SchemaService::class)->toJson([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => [
            [
                '@type' => 'Question',
                'name' => 'Question?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => null,
                    'empty' => '',
                ],
            ],
        ],
    ]);

    expect($json)->toContain('Question?')
        ->and($json)->not->toContain('null')
        ->and($json)->not->toContain('empty');
});

it('does not leak nested context into embedded schemas', function (): void {
    $schema = app(SchemaService::class)->make('product', [
        'name' => 'Laravel SEO Package',
        'brand' => 'Step2Dev',
        'price' => '49.00',
    ]);

    expect($schema['brand'])->not->toHaveKey('@context')
        ->and($schema['offers'])->not->toHaveKey('@context');
});

it('renders a schema through the main facade-style api', function (): void {
    $html = app(SchemaService::class)->render('article', [
        'title' => 'Clean API',
    ]);

    expect((string) $html)->toContain('application/ld+json')
        ->and((string) $html)->toContain('Article')
        ->and((string) $html)->toContain('Clean API');
});

it('renders a graph through the main facade-style api', function (): void {
    $schema = app(SchemaService::class);

    $html = $schema->renderGraph([
        $schema->make('organization', ['name' => 'Step2Dev']),
        $schema->make('website', ['name' => 'step2.dev']),
    ]);

    expect((string) $html)->toContain('@graph')
        ->and((string) $html)->toContain('Organization')
        ->and((string) $html)->toContain('WebSite');
});

it('registers a custom schema type at runtime', function (): void {
    $schema = app(SchemaService::class);

    $schema->register('course', fn (array $data): array => [
        '@context' => 'https://schema.org',
        '@type' => 'Course',
        'name' => $data['name'] ?? null,
        'description' => $data['description'] ?? null,
    ]);

    expect($schema->make('course', [
        'name' => 'Laravel Package Development',
        'description' => 'Build production-ready Laravel packages.',
    ]))->toMatchArray([
        '@context' => 'https://schema.org',
        '@type' => 'Course',
        'name' => 'Laravel Package Development',
    ]);
});

it('lists built-in and custom schema types', function (): void {
    $schema = app(SchemaService::class);

    $schema->register('course', fn (): array => ['@type' => 'Course']);

    expect($schema->types())->toContain('Article')
        ->and($schema->types())->toContain('WebSite')
        ->and($schema->types())->toContain('course');
});

it('has package lifecycle pieces registered', function (): void {
    expect(class_exists(\Step2dev\LazySeoStructuredData\Facades\Schema::class))->toBeTrue()
        ->and(function_exists('seo_schema'))->toBeTrue()
        ->and(function_exists('seo_schema_graph'))->toBeTrue()
        ->and(function_exists('seo_jsonld_render'))->toBeTrue()
        ->and(view()->exists('lazy-seo-structured-data::components.jsonld'))->toBeTrue()
        ->and(config('lazy-seo-structured-data.enabled'))->toBeTrue();
});

it('builds only schema.org supported public schema types', function (): void {
    $schema = app(SchemaService::class);

    $types = [
        'Article' => ['title' => 'Article title'],
        'BlogPosting' => ['title' => 'Blog post title'],
        'FAQPage' => ['items' => [['question' => 'Question?', 'answer' => 'Answer.']]],
        'Recipe' => ['name' => 'Recipe name'],
        'Product' => ['name' => 'Product name'],
        'Offer' => ['price' => '49.00', 'priceCurrency' => 'USD'],
        'Organization' => ['name' => 'Organization name'],
        'Person' => ['name' => 'Person name'],
        'LocalBusiness' => ['name' => 'Business name'],
        'BreadcrumbList' => ['items' => [['name' => 'Home', 'url' => 'https://example.com']]],
        'ItemList' => ['items' => ['First item']],
        'Event' => ['name' => 'Event name', 'start_date' => '2026-01-01'],
        'WebSite' => ['name' => 'Website name', 'url' => 'https://example.com'],
        'WebPage' => ['title' => 'Page title', 'url' => 'https://example.com/page'],
        'CollectionPage' => ['title' => 'Collection title', 'url' => 'https://example.com/items'],
    ];

    foreach ($types as $type => $data) {
        expect($schema->make($type, $data)['@type'])->toBe($type);
    }
});



it('exposes schema type metadata with required recommended and optional fields', function (): void {
    $schema = app(SchemaService::class);

    expect($schema->metadata('Product'))->toMatchArray([
        'type' => 'Product',
        'schema_org' => 'https://schema.org/Product',
        'required' => ['name'],
    ])
        ->and($schema->fields('Event')['required'])->toBe(['name', 'startDate', 'location'])
        ->and($schema->fields('Article')['recommended'])->toContain('headline')
        ->and($schema->metadata('Offer'))->toMatchArray([
            'type' => 'Offer',
            'required' => ['price', 'priceCurrency', 'availability', 'url'],
        ]);
});

it('does not keep removed shorthand schema type aliases', function (): void {
    config()->set('lazy-seo-structured-data.unknown_type_behavior', 'exception');

    app(SchemaService::class)->make('faq');
})->throws(InvalidArgumentException::class, 'Unknown structured data type [faq].');
