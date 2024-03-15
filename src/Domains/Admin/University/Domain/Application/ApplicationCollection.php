<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application;

use Project\Shared\Domain\Collection;

class ApplicationCollection extends Collection
{
    protected function type(): string
    {
        return Application::class;
    }

    protected function translatorClass(): string
    {
        return '';
    }
}
