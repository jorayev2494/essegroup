<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Services\Media\Cover\Contracts;

interface CoverableInterface
{
    public function getCover(): ?CoverInterface;

    public function changeCover(?CoverInterface $cover): static;

    public function deleteCover(): static;
}
