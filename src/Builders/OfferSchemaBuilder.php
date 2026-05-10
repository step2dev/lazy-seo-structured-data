<?php

namespace Step2dev\LazySeoStructuredData\Builders;

final class OfferSchemaBuilder extends AbstractSchemaBuilder
{
    public function offer(array $data): ?array
    {
        if (! isset($data['price']) && ! isset($data['priceCurrency']) && ! isset($data['price_currency'])) {
            return null;
        }

        return $this->cleaner->clean([
            '@type' => 'Offer',
            'price' => $data['price'] ?? null,
            'priceCurrency' => $data['price_currency'] ?? $data['priceCurrency'] ?? 'USD',
            'availability' => $data['availability'] ?? 'https://schema.org/InStock',
            'url' => $data['url'] ?? request()->fullUrl(),
        ]);
    }
}
