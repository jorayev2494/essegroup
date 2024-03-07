<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Domain\Company\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class CompanyNameAlreadyExistsDomainException extends DomainException
{

    #[\Override]
    public function message(): string
    {
        return 'Company name already exists';
    }

    #[\Override]
    public function getHttpResponseCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

}
