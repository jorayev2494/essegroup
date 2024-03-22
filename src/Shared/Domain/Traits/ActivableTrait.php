<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait ActivableTrait
{
    #[ORM\Column(name: 'is_active', type: Types::BOOLEAN)]
    private bool $isActive;

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
