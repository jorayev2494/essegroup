<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Department\Name\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class DepartmentNameNotFoundDomainException extends DomainException
{

    public function message(): string
    {
        return 'Department name not found';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
