<?php

declare(strict_types=1);

namespace Project\Domains\Student\Contest\Domain\Contest\Services;

use Project\Domains\Student\Contest\Application\Contest\Queries\Index\Query;
use Project\Domains\Student\Contest\Domain\Contest\Services\Contracts\ContestServiceInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Domains\Admin\Contest\Application\Contest\Queries\Index\Query as IndexQuery;
use Project\Shared\Domain\ValueObject\UuidValueObject;
use Project\Domains\Admin\Contest\Application\Contest\Queries\Show\Query as ShowQuery;

class ContestService implements ContestServiceInterface
{
    public function index(UuidValueObject $studentUud, Query $query): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            IndexQuery::makeFromArray(
                array_merge(
                    $query->toArray(),
                    [
                        'filters' => [
                            'won_student_uuids' => [
                                $studentUud->value,
                            ]
                        ]
                    ]
                )
            )
        );
    }

    public function show(UuidValueObject $studentUud, UuidValueObject $uud): array
    {
        /** @var QueryBusInterface $queryBus */
        $queryBus = resolve(QueryBusInterface::class);

        return $queryBus->ask(
            new ShowQuery(
                $uud->value
            )
        );
    }
}
