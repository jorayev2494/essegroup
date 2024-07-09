<?php

declare(strict_types=1);

namespace Project\Infrastructure\Archivator;

use Illuminate\Support\Facades\Storage;
use Project\Infrastructure\Archivator\Contracts\ArchivatorInterface;
use STS\ZipStream\ZipStream;
use Symfony\Component\HttpFoundation\StreamedResponse;

readonly class ZipArchivator implements ArchivatorInterface
{
    private \STS\ZipStream\ZipStream $zipStream;

    function __construct(
        private ZipStream $zip
    ) { }

    public function instance(string $name): self
    {
        $this->zipStream = $this->zip->setName("{$name}.zip");

        return $this;
    }

    public function add(string $path, string $name): self
    {
        $this->zipStream->add(Storage::get($path), $name);

        return $this;
    }

    public function response(): StreamedResponse
    {
        return $this->zipStream->response();
    }
}
