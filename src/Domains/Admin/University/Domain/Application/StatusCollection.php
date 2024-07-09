<?php

namespace Project\Domains\Admin\University\Domain\Application;

use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;
use Project\Shared\Domain\Collection;

class StatusCollection extends Collection
{
    protected function type(): string
    {
        return Status::class;
    }

    protected function translatorClass(): string
    {
        return StatusTranslate::class;
    }
}
