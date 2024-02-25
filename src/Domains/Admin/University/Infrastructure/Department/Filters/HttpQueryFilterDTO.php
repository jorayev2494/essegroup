<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Department\Filters;

use Project\Shared\Contracts\ArrayableInterface;
use Symfony\Component\HttpFoundation\Request;

readonly class HttpQueryFilterDTO implements ArrayableInterface
{
    private function __construct(
        public ?string $facultyUuid
    ) {

    }

    public static function makeFromRequest(Request $request): self
    {
        return new self(
            $request->query->get('filter_by_faculty_uuid')
        );
    }

    public static function makeFromArray(array $data): self
    {
        return new self(
            $data['filter_by_faculty_uuid'] ?? null,
        );
    }


    #[\Override]
    public function toArray(): array
    {
        return [
            'filter_by_faculty_uuid' => $this->facultyUuid,
        ];
    }
}
