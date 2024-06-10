<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Application\ApplicationStatusValue\Queries\WidgetList;

use Project\Domains\Admin\University\Domain\Application\ApplicationRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\StatusValue;
use Project\Domains\Admin\University\Domain\Application\StatusValueRepositoryInterface;
use Project\Domains\Admin\University\Domain\Application\StatusValueTranslate;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

readonly class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private StatusValueRepositoryInterface $repository,
        private ApplicationRepositoryInterface $applicationRepository
    ) { }

    public function __invoke(Query $query): array
    {
        $widgets = [];

        $this->repository->loadWidgetsList()->forEach($this->mapper($query, $widgets));

        return $widgets;
    }

    private function mapper(Query $query, array &$widgets): \Closure
    {
        return function (StatusValue $statusValue) use($query, &$widgets): void {
            array_push(
                $widgets,
                [
                    ...StatusValueTranslate::execute($statusValue)->toArray(),
                    ...[
                        'application_count' => $this->applicationRepository->getApplicationCountWhereCurrentStatusAre(
                            [$statusValue->getUuid()->value],
                            $query->filter->companyUuids
                        )->count(),
                    ],
                ]
            );
        };
    }
}
