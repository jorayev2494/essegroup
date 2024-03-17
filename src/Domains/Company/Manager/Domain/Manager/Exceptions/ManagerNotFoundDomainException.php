<?php

namespace Project\Domains\Company\Manager\Domain\Manager\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class ManagerNotFoundDomainException extends DomainException
{
    public function message(): string
    {
        return 'Manager not found';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
