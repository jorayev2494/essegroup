<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager\Services\Avatar;

use Project\Domains\Admin\Manager\Domain\Manager\Services\Avatar\Contracts\AvatarableInterface;
use Project\Domains\Admin\Manager\Domain\Manager\Services\Avatar\Contracts\AvatarServiceInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\Avatar;
use Project\Shared\Domain\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class AvatarService implements AvatarServiceInterface
{
    function __construct(
        private FileSystemInterface $fileSystem
    ) { }

    public function upload(AvatarableInterface $avatarable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile === null) {
            return;
        }

        /** @var Avatar $avatar */
        $avatar = $this->fileSystem->upload(Avatar::class, $uploadedFile);
        $avatarable->changeAvatar($avatar);
    }

    public function update(AvatarableInterface $avatarable, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile instanceof UploadedFile) {
            $this->delete($avatarable);
            $this->upload($avatarable, $uploadedFile);
        }
    }

    public function delete(AvatarableInterface $avatarable): void
    {
        $this->fileSystem->delete($avatarable->getAvatar());
        $avatarable->deleteAvatar();
    }
}
