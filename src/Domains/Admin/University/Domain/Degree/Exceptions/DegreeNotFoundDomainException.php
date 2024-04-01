<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Degree\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class DegreeNotFoundDomainException extends DomainException
{

    public function message(): string
    {
        return 'Degree not found';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
