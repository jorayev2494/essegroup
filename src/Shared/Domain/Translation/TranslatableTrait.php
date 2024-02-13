<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Translation;

use Project\Shared\Domain\Translation\DomainEvents\TranslationDomainEventTypeEnum;

trait TranslatableTrait
{
    public function addTranslation(AbstractTranslation $t): void
    {
        $trans = $this->translations->findFirst(
            static fn (int $idx, AbstractTranslation $item): bool => $item->getLocale() === $t->getLocale() && $item->getField() === $t->getField()
        );

        if ($trans) {
            if ($trans->getContent() !== $t->getContent()) {
                $trans->setContent($t->getContent());
                $this->translationDomainEvent($t, TranslationDomainEventTypeEnum::CHANGED);
            }
        } else {
           $this->translations[] = $t;
           $t->setObject($this);
           $this->translationDomainEvent($t, TranslationDomainEventTypeEnum::ADDED);
        }
    }

    public function translationsToArray(): array
    {
        $result = [];

        foreach ($this->translations as $translation) {
            $result[$translation->getLocale()][$translation->getField()] = $translation->getContent();
        }

        return $result;
    }

    public function toArrayWithTranslations(): array
    {
        return array_merge(
            $this->toArray(),
            ['translations' => $this->translationsToArray()],
        );
    }
}
