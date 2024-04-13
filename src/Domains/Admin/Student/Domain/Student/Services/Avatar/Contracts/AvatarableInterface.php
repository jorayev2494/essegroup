<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Domain\Student\Services\Avatar\Contracts;

interface AvatarableInterface
{
    public function getAvatar(): ?AvatarInterface;

    public function changeAvatar(?AvatarInterface $avatar): static;

    public function deleteAvatar(): static;
}
