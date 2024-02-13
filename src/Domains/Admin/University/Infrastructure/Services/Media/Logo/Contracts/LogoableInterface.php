<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Services\Media\Logo\Contracts;

interface LogoableInterface
{
    public function getLogoClassName(): string;

    public function getLogo(): ?LogoInterface;

    public function changeLogo(?LogoInterface $logo): static;

    public function deleteLogo(): static;
}
