<?php

use Step2dev\LazySeoStructuredData\Services\JsonLdService;
use Step2dev\LazySeoStructuredData\Services\SchemaService;

if (! function_exists('seo_schema')) {
    function seo_schema(string $type = 'webPage', array $data = []): array
    {
        return app(SchemaService::class)->make($type, $data);
    }
}

if (! function_exists('seo_jsonld')) {
    function seo_jsonld(string $type = 'webPage', array $data = []): string
    {
        return app(JsonLdService::class)->script($type, $data);
    }
}

if (! function_exists('seo_jsonld_graph')) {
    /**
     * @param  array<int, array|\Illuminate\Contracts\Support\Arrayable>  $schemas
     */
    function seo_jsonld_graph(array $schemas): string
    {
        return app(JsonLdService::class)->scriptGraph($schemas);
    }
}
