<?php

namespace Step2dev\LazySeoStructuredData\Support;

use Illuminate\Contracts\Support\Arrayable;

final class SchemaGraph
{
    public function __construct(private readonly SchemaCleaner $cleaner) {}

    public function make(array $schemas): array
    {
        if (array_key_exists('@graph', $schemas)) {
            return $this->cleaner->clean($schemas);
        }

        $graph = [];

        foreach ($schemas as $schema) {
            if ($schema instanceof Arrayable) {
                $schema = $schema->toArray();
            }

            if (! is_array($schema)) {
                continue;
            }

            unset($schema['@context']);
            $schema = $this->cleaner->clean($schema);

            if ($schema !== []) {
                $graph[] = $schema;
            }
        }

        return $this->cleaner->clean([
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ]);
    }
}
