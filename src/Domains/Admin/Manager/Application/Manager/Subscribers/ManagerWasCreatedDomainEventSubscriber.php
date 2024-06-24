<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Manager\Subscribers;

use Project\Domains\Admin\Manager\Domain\Manager\Events\ManagerWasCreatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class ManagerWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private MailerInterface $mailer
    ) { }

    public static function subscribedTo(): array
    {
        return [
            ManagerWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(ManagerWasCreatedDomainEvent $event): void
    {
        $template = view('mails.manager.created', [
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
    }

    private function makeDashboardLink(): string
    {
        return config('admin_dashboard.url') . config('admin_dashboard.page_routers.login');
    }
}
