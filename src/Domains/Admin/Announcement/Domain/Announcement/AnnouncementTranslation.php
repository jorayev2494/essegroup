<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Announcement\Domain\Announcement;

use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Translation\AbstractTranslation;

/**
 * @property Announcement $objectClass
 */
#[ORM\Entity]
#[ORM\Table(name: 'announcement_announcement_translations')]
#[ORM\UniqueConstraint(name: 'announcement_announcement_translation_idx', columns: ['locale', 'announcement_uuid', 'field'])]
class AnnouncementTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: Announcement::class, fetch: 'LAZY', inversedBy: 'translations', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'announcement_uuid', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    protected $object;
}
