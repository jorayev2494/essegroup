<?php

declare(strict_types=1);

namespace Project\Domains\Company\Company\Domain\Company\Services;

use Project\Domains\Admin\Company\Application\Company\Commands\Update\Command as CompanyUpdateCommand;
use Project\Domains\Admin\Company\Application\Company\Queries\Show\Query;
use Project\Domains\Company\Company\Application\Company\Commands\Update\Command;
use Project\Domains\Company\Company\Domain\Company\Services\Contracts\CompanyServiceInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class CompanyService implements Contracts\CompanyServiceInterface
{
    public function __construct(

    )
    {

    }

    public function show(string $uuid): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(new Query($uuid));
    }

    public function update(Command $command): void
    {
        /** @var CommandBusInterface $commandBus */
        $commandBus = resolve(CommandBusInterface::class);

        $commandBus->dispatch(
            new CompanyUpdateCommand(
                $command->uuid,
                $command->logo,
                $command->name,
                $command->email,
                $command->domain
            )
        );
    }
}
