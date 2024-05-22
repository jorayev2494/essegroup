<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Domain\Document\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class DocumentNotFoundDomainException extends DomainException
{
    public function message(): string
    {
        return 'Document not found';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
