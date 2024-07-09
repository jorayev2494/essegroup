<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Student\Presentation\Http\Web\REST\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\Response;
use Project\Domains\Admin\Student\Application\Queries\PDFPreview\Query as PDFPreviewQuery;

readonly class PDFController
{
    public function __construct(
        private ResponseFactory $response,
        private QueryBusInterface $queryBus
    ) { }

    public function preview(string $uuid): Response
    {
        return $this->response->view(
            ...$this->queryBus->ask(
                new PDFPreviewQuery(
                    $uuid
                )
            )
        );
    }
}
