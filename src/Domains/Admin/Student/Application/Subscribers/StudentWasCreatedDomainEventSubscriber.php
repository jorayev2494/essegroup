<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Application\Subscribers;

use Project\Domains\Admin\Student\Domain\Student\Events\StudentWasCreatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class StudentWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private MailerInterface $mailer
    ) { }

    public static function subscribedTo(): array
    {
        return [
            StudentWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(StudentWasCreatedDomainEvent $event): void
    {
        $template = view('mails.student.created', [
            'dashboardLink' => $this->makeDashboardLink(),
            'firstName' => $event->firstName,
            'lastName' => $event->lastName,
            'email' => $event->email,
            'password' => $event->password,
        ])->render();

        $message = (new Email())
            ->from(getenv('MAIL_FROM_ADDRESS'))
            ->to($event->email)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html($template);

        $this->mailer->send($message);
    }

    private function makeDashboardLink(): string
    {
        return config('student_dashboard.url') . config('student_dashboard.page_routers.login');
    }
}
