<?php

namespace Step2dev\LazySeoStructuredData\Support;

use InvalidArgumentException;
use Step2dev\LazySeoStructuredData\Builders\CommerceSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\ContentSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\EventSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\IdentitySchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\ListSchemaBuilder;
use Step2dev\LazySeoStructuredData\Builders\PageSchemaBuilder;

final class SchemaTypeResolver
{
    public function __construct(
        private readonly SchemaTypeNormalizer $normalizer,
    ) {}

    public function resolve(string $type): array
    {
        $types = $this->types();
        $normalizedType = $this->normalizer->normalize($type);

        if (array_key_exists($normalizedType, $types)) {
            return $types[$normalizedType]['handler'];
        }

        if (config('lazy-seo-structured-data.unknown_type_behavior', 'fallback') === 'exception') {
            throw new InvalidArgumentException("Unknown structured data type [{$type}].");
        }

        return [PageSchemaBuilder::class, 'webPage'];
    }

    public function availableTypes(): array
    {
        return array_column($this->types(), 'schemaType');
    }

    /**
     * @return array<string, array{schemaType: string, handler: array{class-string, string}}>
     */
    private function types(): array
    {
        return [
            'article' => [
                'schemaType' => 'Article',
                'handler' => [ContentSchemaBuilder::class, 'article'],
            ],
            'blogposting' => [
                'schemaType' => 'BlogPosting',
                'handler' => [ContentSchemaBuilder::class, 'blogPosting'],
            ],
            'faqpage' => [
                'schemaType' => 'FAQPage',
                'handler' => [ContentSchemaBuilder::class, 'faqPage'],
            ],
            'recipe' => [
                'schemaType' => 'Recipe',
                'handler' => [ContentSchemaBuilder::class, 'recipe'],
            ],
            'product' => [
                'schemaType' => 'Product',
                'handler' => [CommerceSchemaBuilder::class, 'product'],
            ],
            'organization' => [
                'schemaType' => 'Organization',
                'handler' => [IdentitySchemaBuilder::class, 'organization'],
            ],
            'person' => [
                'schemaType' => 'Person',
                'handler' => [IdentitySchemaBuilder::class, 'person'],
            ],
            'localbusiness' => [
                'schemaType' => 'LocalBusiness',
                'handler' => [IdentitySchemaBuilder::class, 'localBusiness'],
            ],
            'breadcrumblist' => [
                'schemaType' => 'BreadcrumbList',
                'handler' => [ListSchemaBuilder::class, 'breadcrumbList'],
            ],
            'itemlist' => [
                'schemaType' => 'ItemList',
                'handler' => [ListSchemaBuilder::class, 'itemList'],
            ],
            'event' => [
                'schemaType' => 'Event',
                'handler' => [EventSchemaBuilder::class, 'event'],
            ],
            'website' => [
                'schemaType' => 'WebSite',
                'handler' => [PageSchemaBuilder::class, 'webSite'],
            ],
            'webpage' => [
                'schemaType' => 'WebPage',
                'handler' => [PageSchemaBuilder::class, 'webPage'],
            ],
            'collectionpage' => [
                'schemaType' => 'CollectionPage',
                'handler' => [PageSchemaBuilder::class, 'collectionPage'],
            ],
        ];
    }
}
