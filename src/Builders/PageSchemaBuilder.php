<?php

namespace Step2dev\LazySeoStructuredData\Builders;

use Step2dev\LazySeoStructuredData\Support\SchemaCleaner;

final class PageSchemaBuilder extends AbstractSchemaBuilder
{
    public function __construct(SchemaCleaner $cleaner, private readonly ListSchemaBuilder $lists)
    {
        parent::__construct($cleaner);
    }

    public function webPage(array $data = []): array
    {
        return $this->base('WebPage', [
            'name' => $data['name'] ?? $data['title'] ?? config('lazy-seo-structured-data.defaults.title', config('lazy-seo-structured-data.organization.name', config('app.name'))),
            'description' => $data['description'] ?? config('lazy-seo-structured-data.defaults.description', ''),
            'url' => $data['url'] ?? request()->fullUrl(),
        ], $data, ['title']);
    }

    public function collectionPage(array $data = []): array
    {
        return $this->base('CollectionPage', [
            'name' => $data['name'] ?? $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'url' => $data['url'] ?? request()->fullUrl(),
            'mainEntity' => isset($data['items']) ? $this->embedded($this->lists->itemList($data['items'])) : null,
        ], $data, ['title']);
    }

    public function webSite(array $data = []): array
    {
        return $this->base('WebSite', [
            'name' => $data['name'] ?? config('lazy-seo-structured-data.organization.name', config('app.name')),
            'url' => $data['url'] ?? config('lazy-seo-structured-data.organization.url', config('app.url')),
            'potentialAction' => $this->searchAction($data['search_url'] ?? $data['searchUrl'] ?? null),
        ], $data);
    }
}
