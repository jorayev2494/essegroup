<?php

declare(strict_types=1);

namespace Project\Domains\Company\University\Domain\Aplication\Services;

use Project\Domains\Company\University\Application\Application\Commands\Create\Command;
use Project\Domains\Company\University\Application\Application\Commands\Update\Command as UpdateCommand;
use Project\Domains\Company\University\Application\Application\Queries\ByStudentUuid\Query as ByStudentUuidQuery;
use Project\Domains\Company\University\Application\Application\Queries\Index\Query as IndexQuery;
use Project\Domains\Company\University\Application\Application\Queries\Show\Query as ShowQuery;
use Project\Domains\Company\University\Domain\Aplication\Services\Contracts\ApplicationServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Shared\Domain\ValueObject\UuidValueObject;

class ApplicationService implements ApplicationServiceInterface
{

    public function index(UuidValueObject $companyUuid, IndexQuery $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            \Project\Domains\Admin\University\Application\Application\Queries\Index\Query::makeFromArray(
                array_merge(
                    $query->toArray(),
                    [
                        'company_uuids' => [$companyUuid->value],
                    ]
                )
            )
        );
    }

    public function paginateByStudentUuid(ByStudentUuidQuery $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            new \Project\Domains\Admin\University\Application\Application\Queries\ByStudentUuid\Query(
                $query->studentUuid,
                $query->paginator
            )
        );
    }

    public function create(Command $command): void
    {
        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->dispatch(
            new \Project\Domains\Admin\University\Application\Application\Commands\Create\Command(
                $command->uuid,
                $command->studentUuid,
                $command->aliasUuid,
                $command->languageUuid,
                $command->degreeUuid,
                $command->countryUuid,
                $command->universityUuid,
                $command->departmentUuids,
                true,
                'company'
            )
        );
    }

    public function show(ShowQuery $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            new \Project\Domains\Admin\University\Application\Application\Queries\Show\Query(
                $query->uuid
            )
        );
    }

    public function update(UpdateCommand $command): void
    {
        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->dispatch(
            new \Project\Domains\Admin\University\Application\Application\Commands\Update\Command(
                $command->uuid,
                $command->aliasUuid,
                $command->languageUuid,
                $command->degreeUuid,
                $command->countryUuid,
                $command->universityUuid,
                $command->departmentUuids,
                $command->statusValueUuid,
                $command->statusNotes
            )
        );
    }
}
