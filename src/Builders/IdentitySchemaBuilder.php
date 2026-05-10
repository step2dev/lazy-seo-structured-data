<?php

namespace Step2dev\LazySeoStructuredData\Builders;

final class IdentitySchemaBuilder extends AbstractSchemaBuilder
{
    public function organization(array $data = []): array
    {
        return $this->base($data['type'] ?? 'Organization', [
            'name' => $data['name'] ?? config('lazy-seo-structured-data.organization.name', config('app.name')),
            'url' => $data['url'] ?? config('lazy-seo-structured-data.organization.url', config('app.url')),
            'logo' => $data['logo'] ?? config('lazy-seo-structured-data.organization.logo'),
            'sameAs' => $data['same_as'] ?? $data['sameAs'] ?? config('lazy-seo-structured-data.organization.same_as', []),
        ], $data, ['same_as']);
    }

    public function person(array $data = []): array
    {
        return $this->base('Person', [
            'name' => $data['name'] ?? null,
            'url' => $data['url'] ?? null,
            'image' => $data['image'] ?? null,
            'sameAs' => $data['same_as'] ?? $data['sameAs'] ?? null,
        ], $data, ['same_as']);
    }

    public function localBusiness(array $data = []): array
    {
        return $this->base('LocalBusiness', [
            'name' => $data['name'] ?? config('lazy-seo-structured-data.organization.name', config('app.name')),
            'url' => $data['url'] ?? config('lazy-seo-structured-data.organization.url', config('app.url')),
            'telephone' => $data['telephone'] ?? $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'openingHours' => $data['opening_hours'] ?? $data['openingHours'] ?? null,
        ], $data, ['phone', 'opening_hours']);
    }

    public function personOrOrganization(mixed $value): mixed
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_array($value)) {
            $type = $value['type'] ?? 'Person';

            return $type === 'Organization'
                ? $this->embedded($this->organization($value))
                : $this->embedded($this->person($value));
        }

        return ['@type' => 'Person', 'name' => (string) $value];
    }
}
