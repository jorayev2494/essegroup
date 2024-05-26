<?php

declare(strict_types=1);

namespace Project\Domains\Student\Authentication\Domain\Code;

interface CodeRepositoryInterface
{
    public function findByToken(string $token): ?Code;

    public function save(Code $code): void;

    public function delete(Code $code): void;
}
