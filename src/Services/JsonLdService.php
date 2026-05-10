<?php

namespace Step2dev\LazySeoStructuredData\Services;

use Illuminate\Contracts\Support\Arrayable;
use Step2dev\LazySeoStructuredData\Support\JsonLdRenderer;

class JsonLdService
{
    public function __construct(
        private readonly SchemaService $schema,
        private readonly JsonLdRenderer $renderer,
    ) {}

    public function generateForPage(array $data): string
    {
        return $this->script($data['schema'] ?? $data['type'] ?? 'webPage', $data);
    }

    public function make(string $type = 'webPage', array $data = []): array
    {
        return $this->schema->make($type, $data);
    }

    public function graph(array $schemas): array
    {
        return $this->schema->graph($schemas);
    }

    public function encode(array|Arrayable $schema): string
    {
        return $this->renderer->encode($schema);
    }

    public function render(array|Arrayable $schema): string
    {
        return $this->renderer->script($schema);
    }

    public function script(string $type = 'webPage', array $data = []): string
    {
        return $this->render($this->make($type, $data));
    }

    public function scriptGraph(array $schemas): string
    {
        return $this->render($this->graph($schemas));
    }
}
