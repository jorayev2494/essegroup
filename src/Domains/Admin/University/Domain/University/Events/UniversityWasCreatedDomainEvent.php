<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\University\Events;

use Project\Shared\Domain\Bus\Event\DomainEvent;

readonly class UniversityWasCreatedDomainEvent extends DomainEvent
{

    public function __construct(
        public string $uuid,
        public string $countryUuid,
        public string $cityUuid,
        public string $youTubeVideoId,
        string $eventId = null,
        string $occurredOn = null
    )
    {
        parent::__construct($this->uuid, $eventId, $occurredOn);
    }

    #[\Override]
    public static function fromPrimitives(string $id, array $body, string $eventId, string $occurredOn): self
    {
        [
            'uuid' => $uuid,
            'country_uuid' => $countryUuid,
            'city_uuid' => $cityUuid,
            'youtube_video_id' => $youTubeVideoId,
        ] = $body;

        return new self($uuid, $countryUuid, $cityUuid, $youTubeVideoId, $eventId, $occurredOn);
    }

    #[\Override]
    public static function eventName(): string
    {
        return 'university_university.was.created';
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'aggregate_id' => $this->aggregateId(),
            'body' => [
                'uuid' => $this->uuid,
                'country_uuid' => $this->uuid,
                'city_uuid' => $this->uuid,
                'youtube_video_id' => $this->youTubeVideoId,
            ],
            'event_id' => $this->eventId(),
            'occurred_on' => $this->occurredOn(),
        ];
    }
}
