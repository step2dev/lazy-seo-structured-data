<?php

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\HtmlString;
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

if (! function_exists('seo_jsonld_render')) {
    function seo_jsonld_render(array|Arrayable $schema): HtmlString
    {
        return app(JsonLdService::class)->render($schema);
    }
}

if (! function_exists('seo_jsonld')) {
    function seo_jsonld(string $type = 'webPage', array $data = []): HtmlString
    {
        return app(SchemaService::class)->render($type, $data);
    }
}

if (! function_exists('seo_jsonld_graph')) {
    function seo_jsonld_graph(array $schemas): HtmlString
    {
        return app(SchemaService::class)->renderGraph($schemas);
    }
}
