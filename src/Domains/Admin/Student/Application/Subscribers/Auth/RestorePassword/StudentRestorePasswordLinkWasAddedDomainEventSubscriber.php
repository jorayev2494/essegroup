<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Application\Subscribers\Auth\RestorePassword;

use Project\Domains\Admin\Student\Domain\Student\Events\Auth\RestorePassword\StudentRestorePasswordLinkWasAddedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class StudentRestorePasswordLinkWasAddedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private MailerInterface $mailer
    ) { }

    public static function subscribedTo(): array
    {
        return [
            StudentRestorePasswordLinkWasAddedDomainEvent::class,
        ];
    }

    public function __invoke(StudentRestorePasswordLinkWasAddedDomainEvent $event): void
    {
        $template = view('mails.auth.restore.restorePasswordLink', [
            'firstName' => $event->firstName,
            'lastName' => $event->lastName,
            'restoreLink' => $this->makeRestoreLink($event),
        ])->render();

        $message = (new Email())
            ->from(getenv('MAIL_FROM_ADDRESS'))
            ->to($event->email)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html($template);

        $this->mailer->send($message);
    }

    private function makeRestoreLink(StudentRestorePasswordLinkWasAddedDomainEvent $event): string
    {
        $url = config('student_dashboard.url') . config('student_dashboard.page_routers.reset_password');

        // return $url . '?' . http_build_query(['token' => $event->codeValue]);
        return $url . '/' . $event->codeValue;
    }
}
