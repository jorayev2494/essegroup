<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Authentication\Events;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class CurrentPasswordIsInvalidDomainEvent extends DomainException
{
    public function message(): string
    {
        return 'Current password is invalid';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
