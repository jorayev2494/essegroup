<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Domain\Announcement\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class AnnouncementNotFoundDomainException extends DomainException
{
    public function message(): string
    {
        return 'Announcement not found';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
