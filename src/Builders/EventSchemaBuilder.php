<?php

namespace Step2dev\LazySeoStructuredData\Builders;

use Step2dev\LazySeoStructuredData\Support\SchemaCleaner;

final class EventSchemaBuilder extends AbstractSchemaBuilder
{
    public function __construct(
        SchemaCleaner $cleaner,
        private readonly IdentitySchemaBuilder $identity,
        private readonly OfferSchemaBuilder $offers,
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
            'location' => $data['location'] ?? null,
            'image' => $data['image'] ?? null,
            'url' => $data['url'] ?? null,
            'organizer' => $this->identity->personOrOrganization($data['organizer'] ?? null),
            'offers' => $this->offers->offer($data['offers'] ?? $data),
        ], $data, ['title', 'start_date', 'end_date', 'event_status', 'event_attendance_mode', 'organizer', 'offers', 'price', 'price_currency', 'priceCurrency', 'availability']);
    }
}
