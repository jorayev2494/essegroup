<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application;

use Project\Shared\Domain\Collection;

class StatusValueCollection extends Collection
{

    protected function type(): string
    {
        return StatusValue::class;
    }

    protected function translatorClass(): string
    {
        return StatusValueTranslate::class;
    }
}
