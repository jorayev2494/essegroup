<?php

namespace Project\Domains\Admin\University\Domain\Alias\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class AliasNotFoundExceptionDomainException extends DomainException
{

    public function message(): string
    {
        return 'Alias not found';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
