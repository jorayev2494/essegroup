<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Document\Domain\Document\ValueObjects;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Document\Domain\Document\Document;
use Project\Domains\Admin\Document\Domain\Document\Services\File\Contracts\FileInterface;

#[ORM\Entity]
#[ORM\Table(name: 'document_document_covers')]
#[ORM\HasLifecycleCallbacks]
class File extends \Project\Shared\Domain\File\File implements FileInterface
{
    #[\Override]
    public static function path(): string
    {
        return '/admin/domain/document/document/files';
    }

    #[ORM\OneToOne(targetEntity: Document::class, mappedBy: 'file')]
    private Document $document;

    public function incrementDownloadedCount(): void
    {
        $this->downloadedCount++;
    }
}
