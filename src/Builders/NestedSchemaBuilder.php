<?php

namespace Step2dev\LazySeoStructuredData\Builders;

final class NestedSchemaBuilder extends AbstractSchemaBuilder
{
    public function searchAction(array|string $data = []): array
    {
        if (is_string($data)) {
            $data = ['target' => $data];
        }

        return $this->base('SearchAction', [
            'target' => $data['target'] ?? $data['url'] ?? $data['search_url'] ?? $data['searchUrl'] ?? null,
            'query-input' => $data['query-input'] ?? $data['query_input'] ?? 'required name=search_term_string',
        ], $data, ['search_url', 'searchUrl', 'query_input']);
    }

    public function brand(array|string $data = []): array
    {
        if (is_string($data)) {
            $data = ['name' => $data];
        }

        return $this->base('Brand', [
            'name' => $data['name'] ?? null,
            'url' => $data['url'] ?? null,
            'logo' => $data['logo'] ?? null,
            'sameAs' => $data['same_as'] ?? $data['sameAs'] ?? null,
        ], $data, ['same_as']);
    }

    public function imageObject(array|string $data = []): array
    {
        if (is_string($data)) {
            $data = ['url' => $data];
        }

        return $this->base('ImageObject', [
            'url' => $data['url'] ?? $data['contentUrl'] ?? $data['content_url'] ?? null,
            'contentUrl' => $data['content_url'] ?? $data['contentUrl'] ?? $data['url'] ?? null,
            'width' => $data['width'] ?? null,
            'height' => $data['height'] ?? null,
            'caption' => $data['caption'] ?? null,
            'representativeOfPage' => $data['representative_of_page'] ?? $data['representativeOfPage'] ?? null,
        ], $data, ['content_url', 'representative_of_page']);
    }

    public function postalAddress(array $data = []): array
    {
        return $this->base('PostalAddress', [
            'streetAddress' => $data['street_address'] ?? $data['streetAddress'] ?? null,
            'addressLocality' => $data['address_locality'] ?? $data['addressLocality'] ?? $data['city'] ?? null,
            'addressRegion' => $data['address_region'] ?? $data['addressRegion'] ?? $data['region'] ?? null,
            'postalCode' => $data['postal_code'] ?? $data['postalCode'] ?? null,
            'addressCountry' => $data['address_country'] ?? $data['addressCountry'] ?? $data['country'] ?? null,
        ], $data, ['street_address', 'address_locality', 'city', 'address_region', 'region', 'postal_code', 'address_country', 'country']);
    }

    public function contactPoint(array $data = []): array
    {
        return $this->base('ContactPoint', [
            'telephone' => $data['telephone'] ?? $data['phone'] ?? null,
            'contactType' => $data['contact_type'] ?? $data['contactType'] ?? null,
            'email' => $data['email'] ?? null,
            'areaServed' => $data['area_served'] ?? $data['areaServed'] ?? null,
            'availableLanguage' => $data['available_language'] ?? $data['availableLanguage'] ?? null,
        ], $data, ['phone', 'contact_type', 'area_served', 'available_language']);
    }

    public function aggregateRating(array $data = []): array
    {
        return $this->base('AggregateRating', [
            'ratingValue' => $data['rating_value'] ?? $data['ratingValue'] ?? null,
            'reviewCount' => $data['review_count'] ?? $data['reviewCount'] ?? null,
            'ratingCount' => $data['rating_count'] ?? $data['ratingCount'] ?? null,
            'bestRating' => $data['best_rating'] ?? $data['bestRating'] ?? null,
            'worstRating' => $data['worst_rating'] ?? $data['worstRating'] ?? null,
        ], $data, ['rating_value', 'review_count', 'rating_count', 'best_rating', 'worst_rating']);
    }

    public function rating(array $data = []): array
    {
        return $this->base('Rating', [
            'ratingValue' => $data['rating_value'] ?? $data['ratingValue'] ?? null,
            'bestRating' => $data['best_rating'] ?? $data['bestRating'] ?? null,
            'worstRating' => $data['worst_rating'] ?? $data['worstRating'] ?? null,
        ], $data, ['rating_value', 'best_rating', 'worst_rating']);
    }

    public function review(array $data = []): array
    {
        $rating = $data['reviewRating'] ?? $data['review_rating'] ?? null;

        return $this->base('Review', [
            'name' => $data['name'] ?? null,
            'author' => $this->personOrOrganization($data['author'] ?? null),
            'reviewBody' => $data['review_body'] ?? $data['reviewBody'] ?? $data['body'] ?? null,
            'datePublished' => $data['date_published'] ?? $data['datePublished'] ?? null,
            'reviewRating' => is_array($rating) ? $this->embedded($this->rating($rating)) : null,
        ], $data, ['review_rating', 'review_body', 'body', 'date_published']);
    }

    public function question(array $data = []): array
    {
        $answer = $data['acceptedAnswer'] ?? $data['accepted_answer'] ?? $data['answer'] ?? null;

        return $this->base('Question', [
            'name' => $data['name'] ?? $data['question'] ?? null,
            'acceptedAnswer' => is_array($answer) ? $this->embedded($this->answer($answer)) : $this->embedded($this->answer(['text' => $answer])),
        ], $data, ['question', 'accepted_answer', 'answer']);
    }

    public function answer(array|string|null $data = []): array
    {
        if (is_string($data) || $data === null) {
            $data = ['text' => $data];
        }

        return $this->base('Answer', [
            'text' => $data['text'] ?? $data['answer'] ?? null,
        ], $data, ['answer']);
    }

    public function listItem(array|string $data = []): array
    {
        if (is_string($data)) {
            $data = ['name' => $data];
        }

        return $this->base('ListItem', [
            'position' => $data['position'] ?? null,
            'name' => $data['name'] ?? $data['title'] ?? null,
            'item' => $data['item'] ?? $data['url'] ?? null,
            'url' => $data['url'] ?? null,
        ], $data, ['title']);
    }

    public function place(array|string $data = []): array
    {
        if (is_string($data)) {
            $data = ['name' => $data];
        }

        return $this->base('Place', [
            'name' => $data['name'] ?? null,
            'address' => isset($data['address']) && is_array($data['address']) ? $this->embedded($this->postalAddress($data['address'])) : ($data['address'] ?? null),
            'geo' => isset($data['geo']) && is_array($data['geo']) ? $this->embedded($this->geoCoordinates($data['geo'])) : ($data['geo'] ?? null),
            'url' => $data['url'] ?? null,
        ], $data);
    }

    public function virtualLocation(array|string $data = []): array
    {
        if (is_string($data)) {
            $data = ['url' => $data];
        }

        return $this->base('VirtualLocation', [
            'url' => $data['url'] ?? null,
        ], $data);
    }

    public function geoCoordinates(array $data = []): array
    {
        return $this->base('GeoCoordinates', [
            'latitude' => $data['latitude'] ?? $data['lat'] ?? null,
            'longitude' => $data['longitude'] ?? $data['lng'] ?? $data['lon'] ?? null,
        ], $data, ['lat', 'lng', 'lon']);
    }

    public function personOrOrganization(mixed $value): mixed
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_array($value)) {
            $type = $value['@type'] ?? $value['type'] ?? 'Person';

            if ($type === 'Organization') {
                return $this->embedded($this->organization($value));
            }

            return $this->embedded($this->person($value));
        }

        return ['@type' => 'Person', 'name' => (string) $value];
    }

    public function organization(array|string $data = []): array
    {
        if (is_string($data)) {
            $data = ['name' => $data];
        }

        return $this->base('Organization', [
            'name' => $data['name'] ?? null,
            'url' => $data['url'] ?? null,
            'logo' => $data['logo'] ?? null,
            'sameAs' => $data['same_as'] ?? $data['sameAs'] ?? null,
        ], $data, ['same_as']);
    }

    public function person(array|string $data = []): array
    {
        if (is_string($data)) {
            $data = ['name' => $data];
        }

        return $this->base('Person', [
            'name' => $data['name'] ?? null,
            'url' => $data['url'] ?? null,
            'image' => $data['image'] ?? null,
            'sameAs' => $data['same_as'] ?? $data['sameAs'] ?? null,
        ], $data, ['same_as']);
    }
}
