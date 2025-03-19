<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\EmailApplication\Commands\EmailApplication;

use Project\Domains\Admin\University\Domain\EmailApplication\EmailApplication;
use Project\Domains\Admin\University\Domain\EmailApplication\EmailApplicationRepositoryInterface;
use Project\Domains\Admin\University\Domain\EmailApplication\ValueObjects\AdditionalPhone;
use Project\Domains\Admin\University\Domain\EmailApplication\ValueObjects\FatherFirstName;
use Project\Domains\Admin\University\Domain\EmailApplication\ValueObjects\FirstName;
use Project\Domains\Admin\University\Domain\EmailApplication\ValueObjects\LastName;
use Project\Domains\Admin\University\Domain\EmailApplication\ValueObjects\MotherFirstName;
use Project\Domains\Admin\University\Domain\EmailApplication\ValueObjects\Note;
use Project\Domains\Admin\University\Domain\EmailApplication\ValueObjects\Phone;
use Project\Domains\Admin\University\Domain\EmailApplication\ValueObjects\Uuid;
use Project\Domains\Admin\University\Infrastructure\EmailApplication\Mails\EmailApplicationMail;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EmailApplicationRepositoryInterface $repository,
        private EmailApplicationMail $emailApplicationMail
    ) { }

    public function __invoke(Command $command): void
    {
        $emailApplication = EmailApplication::create(
            Uuid::fromValue($command->uuid),
            FirstName::fromValue($command->firstName),
            LastName::fromValue($command->lastName),
            FatherFirstName::fromValue($command->fatherFirstName),
            MotherFirstName::fromValue($command->motherFirstName),
            Phone::fromValue($command->phone),
            AdditionalPhone::fromValue($command->additionalPhone),
            Note::fromValue($command->note),
        );

        $this->repository->save($emailApplication);
        $this->emailApplicationMail->send($emailApplication);
    }
}
