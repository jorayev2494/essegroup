<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Role\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class RoleAdminCantBeRemovedDomainException extends DomainException
{
    public function message(): string
    {
        return 'Role Admin can\'t be removed';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}