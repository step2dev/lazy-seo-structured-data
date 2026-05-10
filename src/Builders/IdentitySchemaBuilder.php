<?php

namespace Step2dev\LazySeoStructuredData\Builders;

use Step2dev\LazySeoStructuredData\Support\SchemaCleaner;

final class IdentitySchemaBuilder extends AbstractSchemaBuilder
{
    public function __construct(SchemaCleaner $cleaner, private readonly NestedSchemaBuilder $nested)
    {
        parent::__construct($cleaner);
    }

    public function organization(array $data = []): array
    {
        return $this->base($data['type'] ?? 'Organization', [
            'name' => $data['name'] ?? config('lazy-seo-structured-data.organization.name', config('app.name')),
            'url' => $data['url'] ?? config('lazy-seo-structured-data.organization.url', config('app.url')),
            'logo' => $data['logo'] ?? config('lazy-seo-structured-data.organization.logo'),
            'sameAs' => $data['same_as'] ?? $data['sameAs'] ?? config('lazy-seo-structured-data.organization.same_as', []),
            'contactPoint' => $this->contactPoint($data['contactPoint'] ?? $data['contact_point'] ?? null),
            'address' => $this->address($data['address'] ?? null),
        ], $data, ['same_as', 'contact_point', 'contactPoint', 'address']);
    }

    public function person(array $data = []): array
    {
        return $this->base('Person', [
            'name' => $data['name'] ?? null,
            'url' => $data['url'] ?? null,
            'image' => $data['image'] ?? null,
            'sameAs' => $data['same_as'] ?? $data['sameAs'] ?? null,
            'jobTitle' => $data['job_title'] ?? $data['jobTitle'] ?? null,
            'worksFor' => isset($data['worksFor']) && is_array($data['worksFor']) ? $this->embedded($this->organization($data['worksFor'])) : ($data['worksFor'] ?? null),
        ], $data, ['same_as', 'job_title', 'worksFor']);
    }

    public function localBusiness(array $data = []): array
    {
        return $this->base('LocalBusiness', [
            'name' => $data['name'] ?? config('lazy-seo-structured-data.organization.name', config('app.name')),
            'url' => $data['url'] ?? config('lazy-seo-structured-data.organization.url', config('app.url')),
            'image' => $data['image'] ?? null,
            'telephone' => $data['telephone'] ?? $data['phone'] ?? null,
            'address' => $this->address($data['address'] ?? null),
            'geo' => isset($data['geo']) && is_array($data['geo']) ? $this->embedded($this->nested->geoCoordinates($data['geo'])) : ($data['geo'] ?? null),
            'openingHoursSpecification' => $data['opening_hours_specification'] ?? $data['openingHoursSpecification'] ?? null,
            'priceRange' => $data['price_range'] ?? $data['priceRange'] ?? null,
        ], $data, ['phone', 'address', 'opening_hours_specification', 'price_range']);
    }

    public function personOrOrganization(mixed $value): mixed
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_array($value)) {
            $type = $value['@type'] ?? $value['type'] ?? 'Person';

            return $type === 'Organization'
                ? $this->embedded($this->organization($value))
                : $this->embedded($this->person($value));
        }

        return ['@type' => 'Person', 'name' => (string) $value];
    }

    private function address(mixed $address): mixed
    {
        return is_array($address) ? $this->embedded($this->nested->postalAddress($address)) : $address;
    }

    private function contactPoint(mixed $contactPoint): mixed
    {
        if (! is_array($contactPoint)) {
            return null;
        }

        if (! array_is_list($contactPoint)) {
            return $this->embedded($this->nested->contactPoint($contactPoint));
        }

        return array_values(array_map(fn (array $item): array => $this->embedded($this->nested->contactPoint($item)), array_filter($contactPoint, 'is_array')));
    }
}
