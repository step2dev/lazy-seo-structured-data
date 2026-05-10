<?php

namespace Step2dev\LazySeoStructuredData\Services;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\HtmlString;
use LogicException;
use Step2dev\LazySeoStructuredData\Builders\CommerceSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\ContentSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\EventSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\IdentitySchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\ListSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\OfferSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\PageSchemaBuilder;
use Step2dev\LazySeoStructuredData\Support\CustomSchemaRegistry;
use Step2dev\LazySeoStructuredData\Support\JsonLdRenderer;
use Step2dev\LazySeoStructuredData\Support\SchemaGraph;
use Step2dev\LazySeoStructuredData\Support\SchemaTypeMetadata;
use Step2dev\LazySeoStructuredData\Support\SchemaTypeResolver;

class SchemaService
{
    public function __construct(
        private readonly SchemaTypeResolver $types,
        private readonly CustomSchemaRegistry $customSchemas,
        private readonly SchemaGraph $graph,
        private readonly JsonLdRenderer $jsonLd,
        private readonly SchemaTypeMetadata $metadata,
        private readonly PageSchemaBuilder $pages,
        private readonly ContentSchemaBuilder $content,
        private readonly CommerceSchemaBuilder $commerce,
        private readonly IdentitySchemaBuilder $identity,
        private readonly ListSchemaBuilder $lists,
        private readonly EventSchemaBuilder $events,
        private readonly OfferSchemaBuilder $offers,
    ) {}

    public function make(string $type = 'webPage', array $data = []): array
    {
        if ($this->customSchemas->has($type)) {
            return $this->customSchemas->make($type, $data);
        }

        [$builderClass, $method] = $this->types->resolve($type);
        $builder = $this->builder($builderClass);

        return $builder->{$method}($data);
    }

    public function graph(array $schemas): array
    {
        return $this->graph->make($schemas);
    }

    public function render(string $type = 'webPage', array $data = []): HtmlString
    {
        return $this->renderSchema($this->make($type, $data));
    }

    public function renderGraph(array $schemas): HtmlString
    {
        return $this->renderSchema($this->graph($schemas));
    }

    public function renderSchema(array|Arrayable $schema): HtmlString
    {
        return $this->jsonLd->render($schema);
    }

    /**
     * @param callable|class-string $builder
     */
    public function register(string $type, callable|string $builder): self
    {
        $this->customSchemas->register($type, $builder);

        return $this;
    }

    /**
     * @return list<string>
     */
    public function types(): array
    {
        return array_values(array_unique([
            ...$this->types->availableTypes(),
            ...$this->customSchemas->types(),
        ]));
    }

    /**
     * @return array<string, array{
     *     type: string,
     *     schema_org: string,
     *     rich_result: bool,
     *     notes: string|null,
     *     required: list<string>,
     *     recommended: list<string>,
     *     optional: list<string>
     * }>|array{
     *     type: string,
     *     schema_org: string,
     *     rich_result: bool,
     *     notes: string|null,
     *     required: list<string>,
     *     recommended: list<string>,
     *     optional: list<string>
     * }|null
     */
    public function metadata(?string $type = null): ?array
    {
        if ($type !== null) {
            return $this->metadata->for($type);
        }

        return $this->metadata->all();
    }

    /**
     * @return array{required: list<string>, recommended: list<string>, optional: list<string>}
     */
    public function fields(string $type): array
    {
        $metadata = $this->metadata->for($type);

        return [
            'required' => $metadata['required'] ?? [],
            'recommended' => $metadata['recommended'] ?? [],
            'optional' => $metadata['optional'] ?? [],
        ];
    }

    public function toJson(array|Arrayable $schema): string
    {
        return $this->jsonLd->encode($schema);
    }

    public function webPage(array $data = []): array { return $this->make('webPage', $data); }
    public function collectionPage(array $data = []): array { return $this->make('collectionPage', $data); }
    public function article(array $data = []): array { return $this->make('article', $data); }
    public function blogPosting(array $data = []): array { return $this->make('blogPosting', $data); }
    public function product(array $data = []): array { return $this->make('product', $data); }
    public function organization(array $data = []): array { return $this->make('organization', $data); }
    public function person(array $data = []): array { return $this->make('person', $data); }
    public function localBusiness(array $data = []): array { return $this->make('localBusiness', $data); }
    public function webSite(array $data = []): array { return $this->make('webSite', $data); }
    public function breadcrumbList(array $items = []): array { return $this->make('BreadcrumbList', ['items' => $items]); }
    public function faqPage(array $items = []): array { return $this->make('FAQPage', ['items' => $items]); }
    public function itemList(array $items = []): array { return $this->make('ItemList', ['items' => $items]); }
    public function event(array $data = []): array { return $this->make('event', $data); }
    public function recipe(array $data = []): array { return $this->make('recipe', $data); }
    public function offer(array $data = []): array { return $this->make('offer', $data); }

    private function builder(string $builderClass): object
    {
        return match ($builderClass) {
            PageSchemaBuilder::class => $this->pages,
            ContentSchemaBuilder::class => $this->content,
            CommerceSchemaBuilder::class => $this->commerce,
            IdentitySchemaBuilder::class => $this->identity,
            ListSchemaBuilder::class => $this->lists,
            EventSchemaBuilder::class => $this->events,
            OfferSchemaBuilder::class => $this->offers,
            default => throw new LogicException("Unknown schema builder [{$builderClass}]."),
        };
    }
}
