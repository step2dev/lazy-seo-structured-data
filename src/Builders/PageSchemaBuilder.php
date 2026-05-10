<?php

namespace Step2dev\LazySeoStructuredData\Builders;

use Step2dev\LazySeoStructuredData\Support\SchemaCleaner;

final class PageSchemaBuilder extends AbstractSchemaBuilder
{
    public function __construct(
        SchemaCleaner $cleaner,
        private readonly ListSchemaBuilder $lists,
        private readonly NestedSchemaBuilder $nested,
    ) {
        parent::__construct($cleaner);
    }

    public function webPage(array $data = []): array
    {
        return $this->base('WebPage', [
            'name' => $data['name'] ?? $data['title'] ?? config('lazy-seo-structured-data.defaults.title', config('lazy-seo-structured-data.organization.name', config('app.name'))),
            'description' => $data['description'] ?? config('lazy-seo-structured-data.defaults.description', ''),
            'url' => $data['url'] ?? request()->fullUrl(),
            'breadcrumb' => isset($data['breadcrumb']) && is_array($data['breadcrumb']) ? $this->embedded($this->lists->breadcrumbList($data['breadcrumb'])) : ($data['breadcrumb'] ?? null),
            'primaryImageOfPage' => isset($data['primaryImageOfPage']) && is_array($data['primaryImageOfPage']) ? $this->embedded($this->nested->imageObject($data['primaryImageOfPage'])) : ($data['primaryImageOfPage'] ?? null),
        ], $data, ['title', 'breadcrumb', 'primaryImageOfPage']);
    }

    public function collectionPage(array $data = []): array
    {
        return $this->base('CollectionPage', [
            'name' => $data['name'] ?? $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'url' => $data['url'] ?? request()->fullUrl(),
            'mainEntity' => isset($data['items']) ? $this->embedded($this->lists->itemList($data['items'])) : null,
            'breadcrumb' => isset($data['breadcrumb']) && is_array($data['breadcrumb']) ? $this->embedded($this->lists->breadcrumbList($data['breadcrumb'])) : ($data['breadcrumb'] ?? null),
        ], $data, ['title', 'items', 'breadcrumb']);
    }

    public function webSite(array $data = []): array
    {
        return $this->base('WebSite', [
            'name' => $data['name'] ?? config('lazy-seo-structured-data.organization.name', config('app.name')),
            'url' => $data['url'] ?? config('lazy-seo-structured-data.organization.url', config('app.url')),
            'potentialAction' => $this->potentialAction($data),
        ], $data, ['search_url', 'searchUrl', 'searchAction', 'potentialAction']);
    }

    private function potentialAction(array $data): ?array
    {
        $action = $data['potentialAction'] ?? $data['searchAction'] ?? null;

        if (is_array($action)) {
            return $this->embedded($this->nested->searchAction($action));
        }

        $target = $data['search_url'] ?? $data['searchUrl'] ?? null;

        return $target ? $this->embedded($this->nested->searchAction($target)) : null;
    }
}
