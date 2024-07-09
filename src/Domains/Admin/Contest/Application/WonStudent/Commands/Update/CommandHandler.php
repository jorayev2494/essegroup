<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Contest\Application\WonStudent\Commands\Update;

use Project\Domains\Admin\Contest\Domain\WonStudent\Exceptions\WonStudentNotFoundDomainException;
use Project\Domains\Admin\Contest\Domain\WonStudent\Services\Contracts\WonStudentServiceInterface;
use Project\Domains\Admin\Contest\Domain\WonStudent\ValueObjects\Code;
use Project\Domains\Admin\Contest\Domain\WonStudent\ValueObjects\Note;
use Project\Domains\Admin\Contest\Domain\WonStudent\WonStudentRepositoryInterface;

readonly class CommandHandler
{
    public function __construct(
        private WonStudentRepositoryInterface $repository,
        private WonStudentServiceInterface $service
    ) { }

    public function __invoke(Command $command): void
    {
        $wonStudent = $this->repository->findByCode(Code::fromValue($command->code));

        $wonStudent ?? throw new WonStudentNotFoundDomainException();

        $this->service->changeGiftGivenAt($wonStudent, $command->changeGiftGivenAt);
        $wonStudent->changeNote(Note::fromValue($command->note));

        $this->repository->save($wonStudent);
    }
}
