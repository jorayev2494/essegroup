<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Mailer;

use Project\Infrastructure\Services\Mailer\Contracts\MailerServiceInterface;
use Project\Infrastructure\Services\Mailer\Contracts\MailMessageInterface;
use Symfony\Component\Mailer\MailerInterface;

class MailerService implements MailerServiceInterface
{
    public function __construct(
        private MailerInterface $mailer
    ) { }

    public function send(MailMessageInterface $mailMessage): void
    {
        $this->mailer->send($mailMessage->getMessage());
    }
}
