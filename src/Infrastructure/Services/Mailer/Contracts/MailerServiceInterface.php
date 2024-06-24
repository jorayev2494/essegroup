<?php

namespace Project\Infrastructure\Services\Mailer\Contracts;

interface MailerServiceInterface
{
    public function send(MailMessageInterface $mailMessage): void;
}
