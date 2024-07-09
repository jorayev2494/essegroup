<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Company\Subsribers\Student;

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
        $template = view('mails.company.student.created', [
            'dashboardLink' => $this->makeDashboardLink(),
            'firstName' => $event->firstName,
            'lastName' => $event->lastName,
            'email' => $event->email,
        ])->render();

        $message = (new Email())
            ->from(getenv('MAIL_FROM_ADDRESS'))
            ->to($event->email)
            ->subject('Time for Symfony Mailer!')
            ->html($template);

        $this->mailer->send($message);
    }

    private function makeDashboardLink(): string
    {
        return config('student_dashboard.url') . config('student_dashboard.page_routers.login');
    }
}
