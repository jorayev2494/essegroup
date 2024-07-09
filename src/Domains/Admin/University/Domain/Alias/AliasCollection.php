<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Alias;

use Project\Shared\Domain\Collection;

class AliasCollection extends Collection
{

    protected function type(): string
    {
        return Alias::class;
    }

    protected function translatorClass(): string
    {
        return AliasTranslate::class;
    }
}
