<?php

declare(strict_types=1);

namespace Project\Domains\Company\Announcement\Domain\Announcement\Services\Contracts;

use Project\Domains\Company\Announcement\Application\Announcement\Queries\Index\Query as IndexQuery;
use Project\Domains\Company\Announcement\Application\Announcement\Queries\List\Query as ListQuery;
use Project\Shared\Domain\ValueObject\UuidValueObject;

interface AnnouncementServiceInterface
{
    public function index(IndexQuery $httpQuery): array;

    public function list(ListQuery $httpQuery): array;

    public function view(UuidValueObject $uuid): array;
}
