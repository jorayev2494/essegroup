<?php

namespace Project\Domains\Admin\University\Domain\Application\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class StatusValueNotFoundDomainException extends DomainException
{

    #[\Override]
    public function message(): string
    {
        return 'Status value not found';
    }

    #[\Override]
    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
