<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Domain\Company;

use Project\Shared\Domain\Collection;

class CompanyCollection extends Collection
{

    #[\Override]
    protected function type(): string
    {
        return Company::class;
    }

    #[\Override]
    protected function translatorClass(): string
    {
        return '';
    }
}
