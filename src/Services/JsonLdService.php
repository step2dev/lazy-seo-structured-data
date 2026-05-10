<?php

namespace Step2dev\LazySeoStructuredData\Services;

class JsonLdService
{
    public function __construct(protected SchemaService $schema) {}

    public function generateForPage(array $data): string
    {
        return $this->script($data['schema'] ?? $data['type'] ?? 'webPage', $data);
    }

    public function make(string $type = 'webPage', array $data = []): array
    {
        return $this->schema->make($type, $data);
    }

    /**
     * @param  array<int, array|\Illuminate\Contracts\Support\Arrayable>  $schemas
     */
    public function graph(array $schemas): array
    {
        return $this->schema->graph($schemas);
    }

    public function script(string $type = 'webPage', array $data = []): string
    {
        return '<script type="application/ld+json">'.$this->schema->toJson($this->make($type, $data)).'</script>';
    }

    /**
     * @param  array<int, array|\Illuminate\Contracts\Support\Arrayable>  $schemas
     */
    public function scriptGraph(array $schemas): string
    {
        return '<script type="application/ld+json">'.$this->schema->toJson($this->graph($schemas)).'</script>';
    }
}
