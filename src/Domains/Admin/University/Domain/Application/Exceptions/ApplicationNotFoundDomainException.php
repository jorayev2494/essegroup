<?php

namespace Project\Domains\Admin\University\Domain\Application\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class ApplicationNotFoundDomainException extends DomainException
{

    #[\Override]
    public function message(): string
    {
        return 'Application not found';
    }

    #[\Override]
    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
