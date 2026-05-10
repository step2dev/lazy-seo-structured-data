<?php

namespace Step2dev\LazySeoStructuredData\Builders;

use Step2dev\LazySeoStructuredData\Support\SchemaCleaner;

final class CommerceSchemaBuilder extends AbstractSchemaBuilder
{
    public function __construct(
        SchemaCleaner $cleaner,
        private readonly IdentitySchemaBuilder $identity,
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
            'brand' => isset($data['brand']) ? $this->embedded($this->identity->organization(['name' => $data['brand']])) : null,
            'offers' => $this->offers->offer($data['offers'] ?? $data),
        ], $data, ['brand', 'offers', 'title', 'price', 'price_currency', 'priceCurrency', 'availability']);
    }
}
