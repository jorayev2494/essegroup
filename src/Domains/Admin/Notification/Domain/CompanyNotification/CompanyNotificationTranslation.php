<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Notification\Domain\CompanyNotification;

use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Translation\AbstractTranslation;
use Project\Shared\Infrastructure\Repository\Doctrine\Enums\CascadeType;
use Project\Shared\Infrastructure\Repository\Doctrine\Enums\FetchType;

/**
 * @property CompanyNotification $objectClass
 */
#[ORM\Entity]
#[ORM\Table(name: 'notification_company_notification_translations')]
#[ORM\UniqueConstraint(name: 'notification_company_notification_translation_idx', columns: ['locale', 'notification_uuid', 'field'])]
class CompanyNotificationTranslation extends AbstractTranslation
{
    #[ORM\ManyToOne(targetEntity: CompanyNotification::class, cascade: [CascadeType::PERSIST->value, CascadeType::REMOVE->value], fetch: FetchType::LAZY->value, inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'notification_uuid', referencedColumnName: 'uuid', onDelete: 'CASCADE')]
    protected $object;
}