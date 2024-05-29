<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Bus\Event;

use JsonSerializable;
use Project\Shared\Contracts\ArrayableInterface;

interface Event extends ArrayableInterface
{
}
