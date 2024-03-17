<?php

declare(strict_types=1);

namespace Project\Domains\Company\Manager\Domain\Manager;

use Project\Shared\Domain\Collection;

class ManagerCollection extends Collection
{

    protected function type(): string
    {
        return Manager::class;
    }

    protected function translatorClass(): string
    {
        return '';
    }
}
