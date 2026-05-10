<?php

use Illuminate\Contracts\Support\Arrayable;
use Step2dev\LazySeoStructuredData\Services\JsonLdService;
use Step2dev\LazySeoStructuredData\Services\SchemaService;

if (! function_exists('seo_schema')) {
    function seo_schema(string $type = 'webPage', array $data = []): array
    {
        return app(SchemaService::class)->make($type, $data);
    }
}

if (! function_exists('seo_schema_graph')) {
    function seo_schema_graph(array $schemas): array
    {
        return app(SchemaService::class)->graph($schemas);
    }
}

if (! function_exists('seo_jsonld')) {
    function seo_jsonld(string $type = 'webPage', array $data = []): string
    {
        return app(JsonLdService::class)->script($type, $data);
    }
}

if (! function_exists('seo_jsonld_render')) {
    function seo_jsonld_render(array|Arrayable $schema): string
    {
        return app(JsonLdService::class)->render($schema);
    }
}

if (! function_exists('seo_jsonld_graph')) {
    function seo_jsonld_graph(array $schemas): string
    {
        return app(JsonLdService::class)->scriptGraph($schemas);
    }
}
