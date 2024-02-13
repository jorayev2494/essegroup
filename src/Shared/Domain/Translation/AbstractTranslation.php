<?php

namespace Project\Shared\Domain\Translation;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;
use Project\Shared\Contracts\ArrayableInterface;

abstract class AbstractTranslation extends AbstractPersonalTranslation implements ArrayableInterface
{
    private function __construct(string $locale, string $field, string $value)
    {
        $this->setLocale($locale);
        $this->setField($field);
        $this->setContent($value);
    }

    public static function make(string $locale, string $field, string $value): static
    {
        return new static($locale, $field, $value);
    }

    public function isEquals(self $other): bool
    {
        return $this->getLocale() === $other->getLocale() &&
            $this->getContent() === $other->getContent() &&
            $this->getField() === $other->getField();
    }

    public function isNotEquals(self $other): bool
    {
        return !$this->isEquals($other);
    }

    #[\Override]
    public function toArray(): array
    {
        return [
            'locale' => $this->locale,
            'field' => $this->field,
            'content' => $this->content,
        ];
    }
}
