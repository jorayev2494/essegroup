<?php

declare(strict_types=1);

namespace Project\Domains\Company\University\Domain\University\Services;

use Project\Domains\Company\University\Domain\University\Services\Contracts\UniversityServiceInterface;
use Project\Infrastructure\Services\Auth\AuthManager;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Domains\Admin\University\Application\University\Queries\Index\Query;

readonly class UniversityService implements UniversityServiceInterface
{
    public function __construct(
        // private QueryBusInterface $queryBus
    )
    {

    }
    public function index(string $companyUuid): array
    {
//        return $this->queryBus->ask(
//            Query::makeFromArray([
//
//            ])
//        );
        return [];
    }
}
