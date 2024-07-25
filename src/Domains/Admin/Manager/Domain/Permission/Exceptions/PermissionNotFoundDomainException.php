<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Permission\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class PermissionNotFoundDomainException extends DomainException
{

    public function message(): string
    {
        return 'Permission not found';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}