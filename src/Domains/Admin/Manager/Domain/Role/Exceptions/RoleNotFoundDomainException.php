<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Role\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class RoleNotFoundDomainException extends DomainException
{

    public function message(): string
    {
        return 'Role not found';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}