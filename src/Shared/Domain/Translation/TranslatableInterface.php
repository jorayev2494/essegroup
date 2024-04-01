<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Translation;

use Doctrine\Common\Collections\Collection;
use Project\Shared\Contracts\NullableInterface;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Translation\DomainEvents\TranslationDomainEventTypeEnum;

interface TranslatableInterface // extends EntityUuid // NullableInterface
{
    public function addTranslation(AbstractTranslation $t): void;

    public function translationsToArray(): array;

    public function getTranslations(): Collection;

    public function getTranslationClass(): string;

    // public function translationDomainEvent(AbstractTranslation $translation, TranslationDomainEventTypeEnum $type): void;
}
