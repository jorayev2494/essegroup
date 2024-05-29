<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Employee\Subscribers;

use Project\Domains\Admin\Company\Domain\Employee\Events\EmployeeWasCreatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class EmployeeWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private MailerInterface $mailer
    ) { }

    public static function subscribedTo(): array
    {
        return [
            EmployeeWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(EmployeeWasCreatedDomainEvent $event): void
    {
        $template = view('mails.company.employee.created', [
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
        return config('company_dashboard.url') . config('company_dashboard.page_routers.login');
    }
}
