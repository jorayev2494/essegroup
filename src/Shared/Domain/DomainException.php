<?php

declare(strict_types=1);

namespace Project\Shared\Domain;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class DomainException extends \DomainException
{
    public function __construct()
    {
        parent::__construct($this->message(), 200);
    }

    abstract public function message(): string;

    abstract public function getHttpResponseCode(): int;

    public function response(): JsonResponse
    {
        return new JsonResponse([
            'message' => $this->getMessage(),
        ], $this->getHttpResponseCode());
    }
}
