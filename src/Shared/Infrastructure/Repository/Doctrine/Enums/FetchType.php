<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository\Doctrine\Enums;

enum FetchType : string
{
    case LAZY = 'LAZY';

    case EAGER = 'EAGER';
}
