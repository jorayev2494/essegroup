<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Domain\Document;

use Project\Shared\Domain\Collection;

class DocumentCollection extends Collection
{

    protected function type(): string
    {
        return Document::class;
    }

    protected function translatorClass(): string
    {
        return DocumentTranslate::class;
    }
}
