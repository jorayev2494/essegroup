<?php

declare(strict_types=1);

namespace Project\Infrastructure\Archivator\Contracts;

use Symfony\Component\HttpFoundation\StreamedResponse;

interface ArchivatorInterface
{
    public function instance(string $name): self;

    public function add(string $path, string $name): self;

    public function response(): StreamedResponse;

}
