<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Infrastructure\Announcement\Filters;

use Project\Shared\Contracts\ArrayableInterface;
use Symfony\Component\HttpFoundation\Request;

readonly class QueryFilter implements ArrayableInterface
{
    private function __construct(
        public array $forItems,
        public ?bool $activity,
    ) { }

    public static function makeFromRequest(Request $request): self
    {
        return self::makeFromArray($request->query->all('filters'));
    }

    public static function makeFromArray(array $data): self
    {
        return new self(
            $data['for_items'] ?? [],
            is_bool($data['activity'] ?? null) ? $data['activity'] : null,
        );
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'for_items' => $this->forItems,
            'activity' => $this->activity,
        ];
    }
}
