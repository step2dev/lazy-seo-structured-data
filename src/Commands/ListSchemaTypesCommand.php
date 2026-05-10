<?php

namespace Step2dev\LazySeoStructuredData\Commands;

use Illuminate\Console\Command;
use Step2dev\LazySeoStructuredData\Services\SchemaService;

class ListSchemaTypesCommand extends Command
{
    protected $signature = 'lazy-seo-structured-data:types';

    protected $description = 'List available Lazy SEO structured data schema types.';

    public function handle(SchemaService $schema): int
    {
        $this->components->info('Available structured data schema types');

        foreach ($schema->types() as $type) {
            $this->line("- {$type}");
        }

        return self::SUCCESS;
    }
}
