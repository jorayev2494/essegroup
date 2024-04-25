<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Employee\Services\Avatar\Contracts;

interface AvatarableInterface
{
    public function getAvatar(): ?AvatarInterface;

    public function changeAvatar(?AvatarInterface $avatar): static;

    public function deleteAvatar(): static;
}
