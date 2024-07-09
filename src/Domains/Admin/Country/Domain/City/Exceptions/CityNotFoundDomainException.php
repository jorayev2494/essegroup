<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain\City\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class CityNotFoundDomainException extends DomainException
{
    public function message(): string
    {
        return 'City not found';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
