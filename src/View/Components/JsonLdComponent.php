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
        $jsonLd = app(JsonLdService::class);

        return app(ViewFactory::class)->make('lazy-seo-structured-data::components.jsonld', [
            'jsonLd' => $this->graph !== []
                ? $jsonLd->renderGraph($this->graph)
                : $jsonLd->renderType($this->type, $this->data),
        ]);
    }
}
