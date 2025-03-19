<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\EmailApplication\Mails;

use Project\Domains\Admin\University\Domain\EmailApplication\EmailApplication;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class EmailApplicationMail
{
    private const SUBJECT = 'Site Email Application';

    public function __construct(
        private MailerInterface $mailer
    ) { }

    public function send(EmailApplication $emailApplication): void
    {
        $template = view('mails.university.email_application.form_mail', [
            'firstName' => $emailApplication->getFistName()->value,
            'lastName' => $emailApplication->getLastName()->value,
            'fatherFirstName' => $emailApplication->getFatherFirstName()->value,
            'motherFirstName' => $emailApplication->getMotherFirstName()->value,
            'phone' => $emailApplication->getPhone()->value,
            'additionalPhone' => $emailApplication->getAdditionalPhone()->value,
            'note' => $emailApplication->getNote()->value,
        ])->render();

        $message = (new Email())
            ->from(config('mail.from.address'))
            ->to(config('mail.admin_address'))
            ->subject(self::SUBJECT)
            ->html($template);

        $this->mailer->send($message);
    }
}