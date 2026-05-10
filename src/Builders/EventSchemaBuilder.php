<?php

namespace Step2dev\LazySeoStructuredData\Builders;

use Step2dev\LazySeoStructuredData\Support\SchemaCleaner;

final class EventSchemaBuilder extends AbstractSchemaBuilder
{
    public function __construct(
        SchemaCleaner $cleaner,
        private readonly IdentitySchemaBuilder $identity,
        private readonly OfferSchemaBuilder $offers,
        private readonly NestedSchemaBuilder $nested,
    ) {
        parent::__construct($cleaner);
    }

    public function event(array $data = []): array
    {
        return $this->base('Event', [
            'name' => $data['name'] ?? $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'startDate' => $data['start_date'] ?? $data['startDate'] ?? null,
            'endDate' => $data['end_date'] ?? $data['endDate'] ?? null,
            'eventStatus' => $data['event_status'] ?? $data['eventStatus'] ?? null,
            'eventAttendanceMode' => $data['event_attendance_mode'] ?? $data['eventAttendanceMode'] ?? null,
            'location' => $this->location($data['location'] ?? null),
            'image' => $data['image'] ?? null,
            'url' => $data['url'] ?? null,
            'organizer' => $this->identity->personOrOrganization($data['organizer'] ?? null),
            'performer' => $this->identity->personOrOrganization($data['performer'] ?? null),
            'offers' => $this->offers->offerOrNull($data['offers'] ?? $data),
        ], $data, ['title', 'start_date', 'end_date', 'event_status', 'event_attendance_mode', 'location', 'organizer', 'performer', 'offers', 'price', 'price_currency', 'priceCurrency', 'availability']);
    }

    private function location(mixed $location): mixed
    {
        if (! is_array($location)) {
            return $location;
        }

        $type = $location['@type'] ?? $location['type'] ?? 'Place';

        return match ($type) {
            'VirtualLocation' => $this->embedded($this->nested->virtualLocation($location)),
            default => $this->embedded($this->nested->place($location)),
        };
    }
}
