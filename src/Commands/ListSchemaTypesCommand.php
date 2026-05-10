<?php

namespace Step2dev\LazySeoStructuredData\Commands;

use Illuminate\Console\Command;
use Step2dev\LazySeoStructuredData\Services\SchemaService;

class ListSchemaTypesCommand extends Command
{
    protected $signature = 'lazy-seo-structured-data:types {type? : Show fields for one Schema.org type} {--json : Output metadata as JSON}';

    protected $description = 'List available Lazy SEO structured data schema types and their common fields.';

    public function handle(SchemaService $schema): int
    {
        $type = $this->argument('type');

        if (is_string($type) && $type !== '') {
            return $this->showType($schema, $type);
        }

        $metadata = $schema->metadata();

        if ($this->option('json')) {
            $this->line(json_encode($metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{}');

            return self::SUCCESS;
        }

        $this->components->info('Available structured data schema types');

        $rows = [];

        foreach ($metadata as $typeMetadata) {
            $rows[] = [
                $typeMetadata['type'],
                $typeMetadata['rich_result'] ? 'yes' : 'no',
                $this->displayFields($typeMetadata['required']),
                $this->displayFields(array_slice($typeMetadata['recommended'], 0, 5)),
            ];
        }

        $this->table(['Type', 'Rich result', 'Required', 'Recommended'], $rows);

        return self::SUCCESS;
    }

    private function showType(SchemaService $schema, string $type): int
    {
        $metadata = $schema->metadata($type);

        if ($metadata === null) {
            $this->components->error("Unknown built-in Schema.org type [{$type}].");

            return self::FAILURE;
        }

        if ($this->option('json')) {
            $this->line(json_encode($metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{}');

            return self::SUCCESS;
        }

        $this->components->info($metadata['type']);
        $this->line('Schema.org: '.$metadata['schema_org']);
        $this->line('Rich result: '.($metadata['rich_result'] ? 'yes' : 'no'));

        if ($metadata['notes'] !== null && $metadata['notes'] !== '') {
            $this->newLine();
            $this->line($metadata['notes']);
        }

        $this->newLine();
        $this->table(['Group', 'Fields'], [
            ['Required', $this->displayFields($metadata['required'])],
            ['Recommended', $this->displayFields($metadata['recommended'])],
            ['Optional', $this->displayFields($metadata['optional'])],
        ]);

        return self::SUCCESS;
    }

    /**
     * @param list<string> $fields
     */
    private function displayFields(array $fields): string
    {
        if ($fields === []) {
            return '-';
        }

        return implode(', ', $fields);
    }
}
