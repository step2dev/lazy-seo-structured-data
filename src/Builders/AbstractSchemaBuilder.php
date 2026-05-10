<?php

namespace Step2dev\LazySeoStructuredData\Builders;

use Step2dev\LazySeoStructuredData\Support\SchemaCleaner;

abstract class AbstractSchemaBuilder
{
    public function __construct(protected readonly SchemaCleaner $cleaner) {}

    protected function base(string $type, array $schema, array $data = [], array $consumed = []): array
    {
        foreach (array_merge(['type', 'items', 'search_url', 'searchUrl'], $consumed) as $key) {
            unset($data[$key]);
        }

        return $this->cleaner->clean(array_replace([
            '@context' => 'https://schema.org',
            '@type' => $type,
        ], $schema, $data));
    }

    protected function embedded(array $schema): array
    {
        unset($schema['@context']);

        return $this->cleaner->clean($schema);
    }

    protected function searchAction(?string $searchUrl): ?array
    {
        if (! $searchUrl) {
            return null;
        }

        return [
            '@type' => 'SearchAction',
            'target' => $searchUrl,
            'query-input' => 'required name=search_term_string',
        ];
    }
}
