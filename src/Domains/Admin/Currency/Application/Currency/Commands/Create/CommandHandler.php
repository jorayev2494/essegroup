<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Application\Currency\Commands\Create;

use Project\Domains\Admin\Currency\Domain\Currency\Currency;
use Project\Domains\Admin\Currency\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Code;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Description;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Symbol;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Uuid;
use Project\Domains\Admin\Currency\Domain\Currency\ValueObjects\Value;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

readonly class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CurrencyRepositoryInterface $repository
    ) { }

    public function __invoke(Command $command): void
    {
        $currency = Currency::create(
            Uuid::fromValue($command->uuid),
            Value::fromValue($command->value),
            Code::fromValue($command->code),
            Symbol::fromValue($command->symbol),
            Description::fromValue($command->description),
            $command->isMain
        );

        $this->repository->save($currency);
    }
}
