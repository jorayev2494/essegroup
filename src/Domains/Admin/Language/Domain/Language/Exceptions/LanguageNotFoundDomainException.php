<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Language\Domain\Language\Exceptions;

use Project\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;

class LanguageNotFoundDomainException extends DomainException
{
    public function message(): string
    {
        return 'Language not found';
    }

    public function getHttpResponseCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
