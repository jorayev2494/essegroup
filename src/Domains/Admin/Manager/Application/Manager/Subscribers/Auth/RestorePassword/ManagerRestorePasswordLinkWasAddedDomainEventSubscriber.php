<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Manager\Subscribers\Auth\RestorePassword;

use Project\Domains\Admin\Manager\Domain\Manager\Events\Auth\RestorePassword\ManagerRestorePasswordLinkWasAddedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class ManagerRestorePasswordLinkWasAddedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private MailerInterface $mailer
    ) { }

    public static function subscribedTo(): array
    {
        return [
            ManagerRestorePasswordLinkWasAddedDomainEvent::class,
        ];
    }

    public function __invoke(ManagerRestorePasswordLinkWasAddedDomainEvent $event): void
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
            ->html($template);

        $this->mailer->send($message);
    }

    private function makeRestoreLink(ManagerRestorePasswordLinkWasAddedDomainEvent $event): string
    {
        $url = config('admin_dashboard.url') . config('admin_dashboard.page_routers.reset_password');

        return $url . '?' . http_build_query(['token' => $event->codeValue]);
    }
}
