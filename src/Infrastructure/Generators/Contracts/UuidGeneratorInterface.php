<?php

declare(strict_types=1);

namespace Project\Infrastructure\Generators\Contracts;

interface UuidGeneratorInterface
{
    public function generate(): string;
}
