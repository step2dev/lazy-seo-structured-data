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
    public function resolve(string $type): array
    {
        $types = $this->types();
        $normalizedType = str($type)->replace(['-', '_'], '')->lower()->toString();

        if (array_key_exists($normalizedType, $types)) {
            return $types[$normalizedType];
        }

        if (config('lazy-seo-structured-data.unknown_type_behavior', 'fallback') === 'exception') {
            throw new InvalidArgumentException("Unknown structured data type [{$type}].");
        }

        return [PageSchemaBuilder::class, 'webPage'];
    }

    private function types(): array
    {
        return [
            'article' => [ContentSchemaBuilder::class, 'article'],
            'blogposting' => [ContentSchemaBuilder::class, 'blogPosting'],
            'blogpost' => [ContentSchemaBuilder::class, 'blogPosting'],
            'faqpage' => [ContentSchemaBuilder::class, 'faqPage'],
            'faq' => [ContentSchemaBuilder::class, 'faqPage'],
            'recipe' => [ContentSchemaBuilder::class, 'recipe'],
            'product' => [CommerceSchemaBuilder::class, 'product'],
            'organization' => [IdentitySchemaBuilder::class, 'organization'],
            'person' => [IdentitySchemaBuilder::class, 'person'],
            'localbusiness' => [IdentitySchemaBuilder::class, 'localBusiness'],
            'breadcrumblist' => [ListSchemaBuilder::class, 'breadcrumbList'],
            'breadcrumbs' => [ListSchemaBuilder::class, 'breadcrumbList'],
            'itemlist' => [ListSchemaBuilder::class, 'itemList'],
            'list' => [ListSchemaBuilder::class, 'itemList'],
            'event' => [EventSchemaBuilder::class, 'event'],
            'website' => [PageSchemaBuilder::class, 'webSite'],
            'webpage' => [PageSchemaBuilder::class, 'webPage'],
            'collectionpage' => [PageSchemaBuilder::class, 'collectionPage'],
        ];
    }
}
