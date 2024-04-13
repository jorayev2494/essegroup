<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Authentication\Subsribers\Restore;

use Project\Domains\Admin\Authentication\Domain\Member\Events\Restore\MemberRestorePasswordLinkWasAddedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class MemberRestorePasswordLinkWasAddedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private MailerInterface $mailer,
    ) { }
    public static function subscribedTo(): array
    {
        return [
            MemberRestorePasswordLinkWasAddedDomainEvent::class,
        ];
    }

    public function __invoke(MemberRestorePasswordLinkWasAddedDomainEvent $event): void
    {
        $template = view('mails.admin.auth.restore.restorePasswordLink', [
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

    private function makeRestoreLink(MemberRestorePasswordLinkWasAddedDomainEvent $event): string
    {
        $url = config('admin_dashboard.admin_url') . config('admin_dashboard.page_routers.reset_password');

        return $url . '?' . http_build_query(['token' => $event->codeValue]);
    }
}
