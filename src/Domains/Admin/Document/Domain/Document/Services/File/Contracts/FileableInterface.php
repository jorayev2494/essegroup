<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Domain\Document\Services\File\Contracts;

interface FileableInterface
{
    public function getFile(): ?FileInterface;

    public function changeFile(FileInterface $file): static;

    public function deleteFile(): static;
}
