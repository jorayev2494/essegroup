<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Domain\WonStudent\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class WonStudentNotFoundDomainException extends DomainException
{

    public function message(): string
    {
        return 'Won student not found';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
