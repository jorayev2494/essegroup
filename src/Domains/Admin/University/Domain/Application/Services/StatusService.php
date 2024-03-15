<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application\Services;

use Project\Domains\Admin\University\Domain\Application\Application;
use Project\Domains\Admin\University\Domain\Application\Services\Contracts\StatusServiceInterface;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;
use Project\Shared\Domain\Translation\TranslationColumnServiceInterface;

class StatusService implements StatusServiceInterface
{
    public function __construct(
        private readonly TranslationColumnServiceInterface $translationColumnService
    )
    {

    }

    #[\Override]
    public function changeStatus(Application $application, Status $status, array $noteTranslations): void
    {
        if ($application->getStatus()->isNotEqualsValue($status->getValue())) {
            $this->translationColumnService->addTranslations($status, $noteTranslations);
            $application->addStatues($status);
        } else {
            $this->translationColumnService->addTranslations($application->getStatus(), $noteTranslations);
        }
    }
}
