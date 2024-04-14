<?php

declare(strict_types=1);

namespace Project\Domains\Admin\University\Domain\Application;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\University\Domain\Application\ValueObjects\Status;
use Project\Domains\Admin\University\Domain\Department\Department;
use Project\Shared\Domain\Translation\AbstractTranslation;

#[ORM\Entity]
#[ORM\Table(name: 'university_application_status_value_translations')]
#[ORM\UniqueConstraint(name: 'university_application_status_value_translation_idx', columns: ['locale', 'field', 'status_value_uuid'])]
class StatusValueTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: StatusValue::class, fetch: 'LAZY', inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'status_value_uuid', referencedColumnName: 'uuid')]
    protected $object;
}
