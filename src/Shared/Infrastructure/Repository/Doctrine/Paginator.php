<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Repository\Doctrine;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as OrmPaginator;
use Illuminate\Contracts\Support\Arrayable;
use Project\Shared\Contracts\ArrayableInterface;
use ArrayIterator;

/**
 * @see https://gist.github.com/Naskalin/6306172b8081813ea213099a4d16019a
 * @see https://brennanwal.sh/article/how-to-paginate-doctrine-entities-with-symfony-5
 * @see https://api-platform.com/docs/core/pagination/
 */
class Paginator implements Arrayable
{
    private int $page;

    private int $perPage;

    private ?int $nextPage;

    private int $to;

    private int $total;

    private ?int $lastPage;

    private ArrayIterator $items;

    /**
     * @param QueryBuilder|Query $query
     * @param int $page
     * @param int $limit
     * @return Paginator
     */
    public function __construct($query, PaginatorHttpQueryParams $httpQueryParams, bool $fetchJoinCollection = true, bool $outputWalkers = true)
    {
        $this->items = new ArrayIterator();
        $paginator = new OrmPaginator($query, $fetchJoinCollection);

        $paginator
            ->getQuery()
            ->setFirstResult($httpQueryParams->perPage * ($httpQueryParams->page - 1))
            ->setMaxResults($httpQueryParams->perPage);

        $this->makeControl($paginator->setUseOutputWalkers($outputWalkers), $httpQueryParams);
    }

    private function makeControl(OrmPaginator $paginator, PaginatorHttpQueryParams $httpQueryParams): void
    {
        $this->page = $httpQueryParams->page;
        $this->perPage = $httpQueryParams->perPage;
        // $this->items = array_map(static fn (ArrayableInterface $item): array => $item->toArray(), iterator_to_array(($paginator->getIterator())));
        $this->items = new ArrayIterator(iterator_to_array($paginator->getIterator()));
        $this->lastPage = ($lastPage = (int) ceil($paginator->count() / $paginator->getQuery()->getMaxResults())) > 1 ? $lastPage : null;
        $this->nextPage = ($nexPage = $httpQueryParams->page + 1) <= $this->lastPage ? $nexPage : null;
        $this->to = $httpQueryParams->perPage * $httpQueryParams->page;
        $this->total = $paginator->count();
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function nextPage(): ?int
    {
        return $this->nextPage;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function getItems(): ArrayIterator
    {
        return $this->items;
    }

    public function map(\Closure $closure): self
    {
        $this->items = new ArrayIterator(array_map($closure, iterator_to_array($this->items)));

        return $this;
    }

    public function forEach(\Closure $closure): self
    {
        foreach ($this->items as $key => $item) {
            $closure($item, $key);
        }

        return $this;
    }

    public function translateItems(string $translateClassName): self
    {
        $this->map(static fn (object $item): object => $translateClassName::execute($item));

        return $this;
    }

    private function itemToArray(): \Closure
    {
        return static fn (array|ArrayableInterface $item): array => is_array($item) ? $item : $item->toArray();
    }

    public function toArray(): array
    {
        return [
            'current_page' => $this->page,
            'data' => array_map(
                $this->itemToArray(),
                iterator_to_array($this->items)
            ),
            'next_page' => $this->nextPage,
            'next_page_url' => $this->makePageUrl($this->nextPage),
            'last_page' => $this->lastPage,
            'last_page_url' => $this->makePageUrl($this->lastPage),
            'per_page' => $this->perPage,
            'to' => $this->to,
            'total' => $this->total,
        ];
    }

    private function makePageUrl(?int $page): ?string
    {
        if ($page === null) {
            return null;
        }

        unset($_REQUEST['page'], $_REQUEST['per_page']);

        return sprintf(
            '%s?%s',
            request()->url(),
            http_build_query([
                'page' => $page,
                'per_page' => $this->perPage,
                ...$_REQUEST,
            ])
        );
    }
}
