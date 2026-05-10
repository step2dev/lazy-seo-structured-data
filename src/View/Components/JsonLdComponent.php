<?php

namespace Step2dev\LazySeoStructuredData\View\Components;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Step2dev\LazySeoStructuredData\Services\JsonLdService;

class JsonLdComponent extends Component
{
    public function __construct(
        public string $type = 'webPage',
        public array $data = [],
        public array $graph = [],
    ) {}

    public function render(): View
    {
        return app(ViewFactory::class)->make('lazy-seo-structured-data::components.jsonld', [
            'schema' => $this->graph !== []
                ? app(JsonLdService::class)->graph($this->graph)
                : app(JsonLdService::class)->make($this->type, $this->data),
        ]);
    }
}
