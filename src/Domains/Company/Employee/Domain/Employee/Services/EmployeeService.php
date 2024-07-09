<?php

namespace Project\Domains\Company\Employee\Domain\Employee\Services;

use Project\Domains\Admin\Company\Application\Employee\Queries\Index\Query;
use Project\Domains\Company\Employee\Application\Employee\Queries\Index\Query as IndexQuery;
use Project\Domains\Company\Employee\Application\Employee\Commands\Create\Command as CreateCommand;
use Project\Domains\Company\Employee\Application\Employee\Commands\Update\Command as UpdateCommand;
use Project\Domains\Company\Employee\Domain\Employee\Services\Contracts\EmployeeServiceInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Shared\Domain\ValueObject\UuidValueObject;

readonly class EmployeeService implements EmployeeServiceInterface
{
    public function index(UuidValueObject $companyUuid, IndexQuery $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            Query::makeFromArray(
                array_merge(
                    $query->toArray(),
                    [
                        'company_uuids' => [$companyUuid->value],
                    ]
                )
            )
        );
    }

    public function create(UuidValueObject $companyUuid, CreateCommand $command): void
    {
        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->dispatch(
            new \Project\Domains\Admin\Company\Application\Employee\Commands\Create\Command(
                $command->uuid,
                $command->firstName,
                $command->lastName,
                $command->email,
                $command->avatar,
                $companyUuid->value
            )
        );
    }

    public function show(UuidValueObject $companyUuid, UuidValueObject $uuid): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            new \Project\Domains\Admin\Company\Application\Employee\Queries\Show\Query($uuid->value)
        );
    }

    public function update(UpdateCommand $command): void
    {
        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->dispatch(
            new \Project\Domains\Admin\Company\Application\Employee\Commands\Update\Command(
                $command->uuid,
                AuthManager::companyUuid()->value,
                $command->firstName,
                $command->lastName,
                $command->email,
                $command->avatar
            )
        );
    }

    public function delete(UuidValueObject $companyUuid, UuidValueObject $uuid): void
    {
        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->dispatch(
            new \Project\Domains\Admin\Company\Application\Employee\Commands\Delete\Command(
                $uuid->value
            )
        );
    }
}
