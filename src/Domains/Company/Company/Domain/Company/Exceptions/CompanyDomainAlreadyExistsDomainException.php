<?php

declare(strict_types=1);

namespace Project\Domains\Company\Company\Domain\Company\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class CompanyDomainAlreadyExistsDomainException extends DomainException
{

    #[\Override]
    public function message(): string
    {
        return 'Company domain already exists';
    }

    #[\Override]
    public function getHttpResponseCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

}
