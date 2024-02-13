<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Application\Services\Files\Passport\Contracts;

interface PassportableInterface
{
    public function getPassportClassName(): string;

    public function getPassport(): PassportInterface;

    public function changePassport(PassportInterface $passport): void;

    public function deletePassport(): void;
}
