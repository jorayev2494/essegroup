<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Application\Contest\Queries\Participants;

use Project\Shared\Domain\Bus\Query\BaseHttpQueryParams;
use Project\Shared\Infrastructure\Repository\Doctrine\PaginatorHttpQueryParams;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

readonly class Query extends BaseHttpQueryParams
{
    public PaginatorHttpQueryParams $paginator;

    public array $applicationStatusUuids;

    public array $studentNationalityUuids;

    protected function fromRequest(SymfonyRequest $request): static
    {
        $this->paginator = PaginatorHttpQueryParams::makeFromRequest($request);

        $this->applicationStatusUuids = $request->get('application_status_uuids', []);
        $this->studentNationalityUuids = $request->get('student_nationality_uuids', []);

        return $this;
    }

    protected function fromArray(array $data): static
    {
        $this->paginator = PaginatorHttpQueryParams::makeFromArray($data);

        $this->applicationStatusUuids = $data['application_status_uuids'] ?? [];
        $this->studentNationalityUuids = $data['student_nationality_uuids'] ?? [];

        return $this;
    }

    public function toArray(): array
    {
        return [

        ];
    }
}
