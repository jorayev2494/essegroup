<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Company\Services\Logo\Contracts;

interface LogoableInterface
{
    public function getLogo(): ?LogoInterface;

    public function changeLogo(?LogoInterface $logo): static;

    public function deleteLogo(): static;
}
