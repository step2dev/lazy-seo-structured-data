<?php

use Step2dev\LazySeoStructuredData\Services\JsonLdService;
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
    $schema = app(SchemaService::class)->make('breadcrumbs', [
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
    $schema = app(SchemaService::class)->make('itemList', [
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

it('renders json ld script', function (): void {
    $html = app(JsonLdService::class)->script('faq', [
        'items' => [
            ['question' => 'What is Lazy SEO?', 'answer' => 'A Laravel SEO toolkit.'],
        ],
    ]);

    expect($html)->toContain('application/ld+json')
        ->and($html)->toContain('FAQPage')
        ->and($html)->toContain('What is Lazy SEO?');
});

it('renders json ld graph script', function (): void {
    $schema = app(SchemaService::class);

    $html = app(JsonLdService::class)->scriptGraph([
        $schema->make('organization', ['name' => 'Step2Dev']),
        $schema->make('website', ['name' => 'step2.dev']),
    ]);

    expect($html)->toContain('application/ld+json')
        ->and($html)->toContain('@graph')
        ->and($html)->toContain('Organization')
        ->and($html)->toContain('WebSite');
});
