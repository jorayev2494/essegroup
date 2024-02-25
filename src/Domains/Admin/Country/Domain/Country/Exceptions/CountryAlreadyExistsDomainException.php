<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain\Country\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class CountryAlreadyExistsDomainException extends DomainException
{

    #[\Override]
    public function message(): string
    {
        return 'Country already exists';
    }

    #[\Override]
    public function getHttpResponseCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
