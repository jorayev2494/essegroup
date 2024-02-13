<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application;

enum StatusEnum : string
{
    case NEW = 'new';

    case VIEWED = 'viewed';

    case TEST = 'test';
}
