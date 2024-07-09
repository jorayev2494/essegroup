<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Employee\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class EmployeeNotFoundDomainException extends DomainException
{
    public function message(): string
    {
        return 'Employee not found';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
