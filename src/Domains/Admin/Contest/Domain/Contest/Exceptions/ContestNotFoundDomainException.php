<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Domain\Contest\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class ContestNotFoundDomainException extends DomainException
{

    public function message(): string
    {
        return 'Contest not found';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
