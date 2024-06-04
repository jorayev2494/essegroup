<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Application\Subscribers\Application;

use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\Events\ApplicationStatusWasChangedDomainEvent;
use Project\Domains\Admin\University\Domain\Application\StatusTranslate;
use Project\Domains\Admin\University\Domain\Application\StatusValue;
use Project\Domains\Admin\University\Domain\Application\StatusValueRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\StatusValueUuid;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

readonly class ApplicationStatusWasChangedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private ApplicationRepositoryInterface $repository,
        private StatusValueRepositoryInterface $statusValueRepository,
        private MailerInterface $mailer
    ) { }

    public static function subscribedTo(): array
    {
        return [
            ApplicationStatusWasChangedDomainEvent::class,
        ];
    }

    public function __invoke(ApplicationStatusWasChangedDomainEvent $event): void
    {
        $application = $this->repository->findByUuid(Uuid::fromValue($event->uuid));
        $statusValue = $this->statusValueRepository->findByUuid(StatusValueUuid::fromValue($event->statusValueUuid));

        if ($application === null || $application->getStatus()->isNotEqualsValue($statusValue)) {
            return;
        }

        $this->sendMail($application, $statusValue);
    }

    private function sendMail(Application $application, StatusValue $statusValue): void
    {
        $template = view('mails.admin.application.statusChanged', [
            'application' => $application,
            'status' => StatusTranslate::execute(
                $application->getStatus(),
                $application->getStudent()->getCommunicationLanguage()?->getISO()->value
            ),
        ])->render();

        $message = (new Email())
            ->from(getenv('MAIL_FROM_ADDRESS'))
            ->to($application->getStudent()->getEmail()->value)
            ->subject('Application status was changed')
            ->text('Sending emails is fun again!')
            ->html($template);

        $this->mailer->send($message);
    }
}
