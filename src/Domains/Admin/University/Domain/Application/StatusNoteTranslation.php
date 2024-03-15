<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Shared\Domain\Translation\AbstractTranslation;

#[ORM\Entity]
#[ORM\Table('university_application_status_note_translations')]
#[ORM\UniqueConstraint(name: 'university_application_status_note_translation_idx', columns: ['locale', 'field', 'status_uuid'])]
class StatusNoteTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: Status::class, fetch: 'LAZY', inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'status_uuid', referencedColumnName: 'id')]
    protected $object;
}
