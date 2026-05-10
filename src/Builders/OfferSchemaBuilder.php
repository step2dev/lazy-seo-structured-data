<?php

namespace Step2dev\LazySeoStructuredData\Builders;

use Step2dev\LazySeoStructuredData\Support\SchemaCleaner;

final class OfferSchemaBuilder extends AbstractSchemaBuilder
{
    public function __construct(SchemaCleaner $cleaner, private readonly NestedSchemaBuilder $nested)
    {
        parent::__construct($cleaner);
    }

    public function offer(array $data): array
    {
        return $this->cleaner->clean([
            '@type' => 'Offer',
            'price' => $data['price'] ?? null,
            'priceCurrency' => $data['price_currency'] ?? $data['priceCurrency'] ?? 'USD',
            'availability' => $data['availability'] ?? 'https://schema.org/InStock',
            'url' => $data['url'] ?? request()->fullUrl(),
            'itemCondition' => $data['item_condition'] ?? $data['itemCondition'] ?? null,
            'priceValidUntil' => $data['price_valid_until'] ?? $data['priceValidUntil'] ?? null,
            'seller' => isset($data['seller']) && is_array($data['seller']) ? $this->embedded($this->nested->organization($data['seller'])) : ($data['seller'] ?? null),
        ]);
    }

    public function offerOrNull(array $data): ?array
    {
        if (! isset($data['price']) && ! isset($data['priceCurrency']) && ! isset($data['price_currency'])) {
            return null;
        }

        return $this->offer($data);
    }
}
