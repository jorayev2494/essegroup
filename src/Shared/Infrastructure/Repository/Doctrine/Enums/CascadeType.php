<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository\Doctrine\Enums;

enum CascadeType : string
{
    case PERSIST = 'persist';

    case REMOVE = 'remove';
}
