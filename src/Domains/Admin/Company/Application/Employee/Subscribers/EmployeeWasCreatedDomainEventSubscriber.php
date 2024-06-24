<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Company\Application\Employee\Subscribers;

use Project\Domains\Admin\Company\Domain\Employee\Events\EmployeeWasCreatedDomainEvent;
use Project\Domains\Admin\Company\Infrastructure\Mails\Employee\EmployeeCreatedMailMessage;
use Project\Infrastructure\Services\Mailer\Contracts\MailerServiceInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class EmployeeWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private MailerInterface $mailer,
        private MailerServiceInterface $mailerService
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
            ->html($template);

        $this->mailer->send($message);

//        $this->mailerService->send(
//            new EmployeeCreatedMailMessage(
//                $event->firstName,
//                $event->lastName,
//                $event->email,
//                $event->password
//            )
//        );
    }

    private function makeDashboardLink(): string
    {
        return config('company_dashboard.url') . config('company_dashboard.page_routers.login');
    }
}
