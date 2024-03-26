<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Infrastructure\Repositories\Doctrine\University\Search\Pipelines;

use Project\Shared\Infrastructure\Repository\Doctrine\Search\Contracts\BaseSearchPipe;
use Project\Shared\Infrastructure\Repository\Doctrine\Search\SearchPipelineSendDTO;

class SearchByName extends BaseSearchPipe
{
    public function execute(SearchPipelineSendDTO $data): void
    {
        $data->queryBuilder->innerJoin('u.translations', 'ut', 'u.uuid = ut.university_uuid')
            ->where('ut.field = :field')
            ->setParameter('field', $data->search->searchBy)

            ->andWhere('ut.locale = :locale')
            ->setParameter('locale', app()->getLocale())

            ->andWhere('ut.content LIKE :content')
            ->setParameter('content', '%' . $data->search->search . '%');
    }

    public function canExecute(SearchPipelineSendDTO $data): bool
    {
        return $data->search->search !== null &&  $data->search->searchBy === 'name';
    }
}
