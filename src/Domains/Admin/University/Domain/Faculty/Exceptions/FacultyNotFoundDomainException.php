<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Faculty\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class FacultyNotFoundDomainException extends DomainException
{
    public function message(): string
    {
        return 'Faculty not fund';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
