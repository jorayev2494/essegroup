<?php

namespace Project\Infrastructure\Services\Mailer\Contracts;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;

abstract readonly class MailMessageInterface
{

    protected abstract function build(Email $message): void;

    public function getMessage(): Message
    {
        $this->build(resolve(Email::class)->from(getenv('MAIL_FROM_ADDRESS')));

        return $this->message;
    }
}
