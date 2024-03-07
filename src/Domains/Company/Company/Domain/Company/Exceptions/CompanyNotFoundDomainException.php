<?php

declare(strict_types=1);

namespace Project\Domains\Company\Company\Domain\Company\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class CompanyNotFoundDomainException extends DomainException
{

    #[\Override]
    public function message(): string
    {
        return 'Company not found';
    }

    #[\Override]
    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }

}
