<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\File\Laravel;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Project\Shared\Domain\File\File;
use Project\Shared\Domain\File\FileSystemInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class FileSystem implements FileSystemInterface
{
    private int $lengthRandomName = 32;

    public function upload(string $className, UploadedFile $uploadedFile): File
    {
        $path = $className::path();
        try {
            $bucketPath = '/' . env('AWS_BUCKET');
            list($width, $height) = @getimagesize($uploadedFile->getPathname());
            $mimeType = $uploadedFile->getClientMimeType();
            $extension = $uploadedFile->getClientOriginalExtension();
            $size = $uploadedFile->getSize();
            $fileOriginalName = $uploadedFile->getClientOriginalName();
            $fullPath = $uploadedFile->storeAs($path, $fileName = $this->generateFileName($extension));
            $url = Storage::url($fullPath);

            return $className::make(
                Uuid::uuid4()->toString(),
                $mimeType,
                $width,
                $height,
                $extension,
                $size,
                $bucketPath . $path,
                $fullPath,
                $fileName,
                $fileOriginalName,
                $url,
            );
        } catch (\Throwable $th) {
            throw new BadRequestException($th->getMessage());
        }
    }

    private function generateFileName(string $extension): string
    {
        return Str::random($this->lengthRandomName) . '.' . $extension;
    }

    public function download(File $file, ?string $name = null, array $headers = []): StreamedResponse
    {
        $name = ! is_null($name) ? sprintf('%s.%s', $name, $file->getExtension()) : $file->getFileName();

        return Storage::download($file->getFullPath(), $name, $headers);
    }

    public function delete(?File $file): bool
    {
        if ($file === null) {
            return true;
        }

        if (Storage::exists($fileFullPath = $file->getFullPath())) {
            return Storage::delete($fileFullPath);
        }

        return true;
    }
}
