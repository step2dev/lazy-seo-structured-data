<?php

namespace Step2dev\LazySeoStructuredData\Services;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\HtmlString;
use Step2dev\LazySeoStructuredData\Support\JsonLdRenderer;

class JsonLdService
{
    public function __construct(
        private readonly SchemaService $schema,
        private readonly JsonLdRenderer $renderer,
    ) {}

    public function generateForPage(array $data): HtmlString
    {
        return $this->renderType($data['schema'] ?? $data['type'] ?? 'webPage', $data);
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

    public function render(array|Arrayable $schema): HtmlString
    {
        return $this->renderer->render($schema);
    }

    public function renderType(string $type = 'webPage', array $data = []): HtmlString
    {
        return $this->render($this->make($type, $data));
    }

    public function renderGraph(array $schemas): HtmlString
    {
        return $this->render($this->graph($schemas));
    }

    /** @deprecated Use renderType(). */
    public function script(string $type = 'webPage', array $data = []): HtmlString
    {
        return $this->renderType($type, $data);
    }

    /** @deprecated Use renderGraph(). */
    public function scriptGraph(array $schemas): HtmlString
    {
        return $this->renderGraph($schemas);
    }
}
