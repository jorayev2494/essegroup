<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Domain\StaticPage\Services\Cover\Contracts;

interface CoverableInterface
{
    public function getCover(): ?CoverInterface;

    public function changeCover(?CoverInterface $cover): static;

    public function deleteCover(): static;
}
