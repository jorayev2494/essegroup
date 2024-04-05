<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Faculty\Name\Exception;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class FacultyNameNotFoundDomainException extends DomainException
{
    public function message(): string
    {
        return 'Faculty name not found';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
