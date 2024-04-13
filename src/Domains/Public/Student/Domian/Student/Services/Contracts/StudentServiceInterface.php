<?php

namespace Project\Domains\Public\Student\Domian\Student\Services\Contracts;

use Project\Domains\Public\Student\Application\Commands\Create\Command;

interface StudentServiceInterface
{
    public function create(Command $command): void;
}
