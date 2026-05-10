<?php

namespace Step2dev\LazySeoStructuredData\Builders;

use Step2dev\LazySeoStructuredData\Support\SchemaCleaner;

final class CommerceSchemaBuilder extends AbstractSchemaBuilder
{
    public function __construct(
        SchemaCleaner $cleaner,
        private readonly NestedSchemaBuilder $nested,
        private readonly OfferSchemaBuilder $offers,
    ) {
        parent::__construct($cleaner);
    }

    public function product(array $data = []): array
    {
        return $this->base('Product', [
            'name' => $data['name'] ?? $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?? null,
            'sku' => $data['sku'] ?? null,
            'brand' => isset($data['brand']) ? $this->embedded($this->nested->brand($data['brand'])) : null,
            'offers' => $this->offers->offerOrNull($data['offers'] ?? $data),
            'aggregateRating' => isset($data['aggregateRating']) && is_array($data['aggregateRating'])
                ? $this->embedded($this->nested->aggregateRating($data['aggregateRating']))
                : null,
            'review' => $this->reviews($data['review'] ?? null),
        ], $data, ['brand', 'offers', 'aggregateRating', 'review', 'title', 'price', 'price_currency', 'priceCurrency', 'availability']);
    }

    private function reviews(mixed $reviews): ?array
    {
        if (! is_array($reviews)) {
            return null;
        }

        if (! array_is_list($reviews)) {
            return $this->embedded($this->nested->review($reviews));
        }

        return array_values(array_map(fn (array $review): array => $this->embedded($this->nested->review($review)), array_filter($reviews, 'is_array')));
    }
}
