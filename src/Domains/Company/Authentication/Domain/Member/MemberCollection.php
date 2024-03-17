<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Domain\Member;

use Project\Shared\Domain\Collection;

class MemberCollection extends Collection
{
    protected function type(): string
    {
        return Member::class;
    }

    protected function translatorClass(): string
    {
        return '';
    }
}
