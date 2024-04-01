<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\Degree\Commands\Delete;

use Project\Domains\Admin\Company\Domain\Company\CompanyRepositoryInterface;
use Project\Domains\Admin\Company\Domain\Company\ValueObjects\Uuid as CompanyUuid;
use Project\Domains\Admin\University\Domain\Degree\Degree;
use Project\Domains\Admin\University\Domain\Degree\DegreeRepositoryInterface;
use Project\Domains\Admin\University\Domain\Degree\Exceptions\DegreeNotFoundDomainException;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Domains\Admin\University\Domain\Degree\ValueObjects\Uuid;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private DegreeRepositoryInterface $degreeRepository
    ) {

    }

    public function __invoke(Command $command): void
    {
        $degree = $this->degreeRepository->findByUuid(Uuid::fromValue($command->uuid));

        $degree ?? throw new DegreeNotFoundDomainException();

        $this->degreeRepository->delete($degree);
    }
}
