<?php

namespace Project\Infrastructure\Services\Authentication\DTOs;

readonly class CredentialsDTO
{
    public function __construct(
        public string $email,
        public string $password,
    ) {

    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
