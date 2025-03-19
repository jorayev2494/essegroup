<?php

namespace Project\Domains\Admin\University\Domain\EmailApplication;

interface EmailApplicationRepositoryInterface
{
    public function save(EmailApplication $emailApplication): void;
}