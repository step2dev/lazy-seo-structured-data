<?php

use Illuminate\Support\Facades\Blade;
use Step2dev\LazySeoStructuredData\Services\SchemaService;

it('renders json ld blade component', function (): void {
    $html = Blade::render('<x-lazy-seo-jsonld type="article" :data="$data" />', [
        'data' => [
            'title' => 'Laravel SEO Tools',
            'description' => 'SEO toolkit for Laravel.',
        ],
    ]);

    expect($html)->toContain('application/ld+json')
        ->and($html)->toContain('Article')
        ->and($html)->toContain('Laravel SEO Tools');
});

it('renders namespaced json ld blade component', function (): void {
    $html = Blade::render('<x-lazy-seo-structured-data::json-ld type="article" :data="$data" />', [
        'data' => [
            'title' => 'Namespaced component',
        ],
    ]);

    expect($html)->toContain('application/ld+json')
        ->and($html)->toContain('Article')
        ->and($html)->toContain('Namespaced component');
});

it('renders json ld graph blade component', function (): void {
    $schema = app(SchemaService::class);

    $html = Blade::render('<x-lazy-seo-jsonld :graph="$graph" />', [
        'graph' => [
            $schema->make('organization', ['name' => 'Step2Dev']),
            $schema->make('website', ['name' => 'step2.dev']),
        ],
    ]);

    expect($html)->toContain('application/ld+json')
        ->and($html)->toContain('@graph')
        ->and($html)->toContain('Organization')
        ->and($html)->toContain('WebSite');
});
