<?php

declare(strict_types=1);

namespace Project\Domains\Admin\StaticPage\Domain\StaticPage;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\Services\Cover\Contracts\CoverableInterface;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\Services\Cover\Contracts\CoverInterface;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Content;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Cover;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Slug;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Title;
use Project\Domains\Admin\StaticPage\Domain\StaticPage\ValueObjects\Uuid;
use Project\Domains\Admin\StaticPage\Infrastructure\StaticPage\Repositories\Doctrine\Types\ContentType;
use Project\Domains\Admin\StaticPage\Infrastructure\StaticPage\Repositories\Doctrine\Types\SlugType;
use Project\Domains\Admin\StaticPage\Infrastructure\StaticPage\Repositories\Doctrine\Types\TitleType;
use Project\Domains\Admin\StaticPage\Infrastructure\StaticPage\Repositories\Doctrine\Types\UuidType;
use Project\Shared\Contracts\ArrayableInterface;
use Project\Shared\Domain\Contracts\EntityUuid;
use Project\Shared\Domain\Traits\CreatedAtAndUpdatedAtTrait;
use Project\Shared\Domain\Translation\TranslatableInterface;
use Project\Shared\Domain\Translation\TranslatableTrait;
use Project\Shared\Domain\ValueObject\UuidValueObject;

#[ORM\Entity]
#[ORM\Table('static_page_static_pages')]
#[ORM\HasLifecycleCallbacks]
class StaticPage implements EntityUuid, TranslatableInterface, ArrayableInterface, CoverableInterface
{
    use TranslatableTrait,
        CreatedAtAndUpdatedAtTrait;

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME)]
    private Uuid $uuid;

    #[ORM\Column(type: SlugType::NAME, length: 20, unique: true)]
    private Slug $slug;

    #[ORM\Column(type: TitleType::NAME, nullable: true)]
    private Title $title;

    #[ORM\Column(type: ContentType::NAME, nullable: true)]
    private Content $content;

    #[ORM\Column(name: 'cover_uuid', type: Types::GUID, nullable: true)]
    private ?string $coverUuid;

    /** @var Cover|null $cover */
    #[ORM\OneToOne(targetEntity: Cover::class, inversedBy: 'staticPage', cascade: ['persist', 'remove'], fetch: 'EAGER', orphanRemoval: true)]
    #[ORM\JoinColumn(name: 'cover_uuid', referencedColumnName: 'uuid', onDelete: 'SET NULL')]
    private mixed $cover;

    /**
     * @var StaticPageTranslation[] $translations
     */
    #[ORM\OneToMany(targetEntity: StaticPageTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'], fetch: 'EAGER')]
    private Collection $translations;

    private function __construct(
        Uuid $uuid,
        Slug $slug
    ) {
        $this->uuid = $uuid;
        $this->slug = $slug;
        $this->title = Title::fromValue(null);
        $this->content = Content::fromValue(null);
        $this->cover = null;
        $this->translations = new ArrayCollection();
    }

    public static function create(Uuid $uuid, Slug $slug): self
    {
        return new self($uuid, $slug);
    }

    public function getUuid(): UuidValueObject
    {
        return $this->uuid;
    }

    public function setTitle(Title $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setContent(Content $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getTranslationClass(): string
    {
        return StaticPageTranslation::class;
    }

    public function getCover(): ?CoverInterface
    {
        return $this->cover;
    }

    public function changeCover(?CoverInterface $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    public function deleteCover(): static
    {
        return $this;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'slug' => $this->slug->value,
            'title' => $this->title->value,
            'content' => $this->content->value,
            'cover' => $this->cover?->toArray(),
        ];
    }
}
