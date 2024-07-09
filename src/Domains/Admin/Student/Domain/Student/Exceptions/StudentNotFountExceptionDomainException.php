<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class StudentNotFountExceptionDomainException extends DomainException
{

    public function message(): string
    {
        return 'Student not found';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
