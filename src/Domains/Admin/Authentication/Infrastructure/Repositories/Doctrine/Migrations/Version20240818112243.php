<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240818112243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notification_notification_translations (id INT AUTO_INCREMENT NOT NULL, notification_uuid CHAR(36) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_C2F9C53F69431B9C (notification_uuid), UNIQUE INDEX notification_notification_translation_idx (locale, notification_uuid, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification_notifications (uuid CHAR(36) NOT NULL, type VARCHAR(255) DEFAULT NULL, payload JSON DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notification_notification_translations ADD CONSTRAINT FK_C2F9C53F69431B9C FOREIGN KEY (notification_uuid) REFERENCES notification_notifications (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contest_won_students CHANGE note note text DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification_notification_translations DROP FOREIGN KEY FK_C2F9C53F69431B9C');
        $this->addSql('DROP TABLE notification_notification_translations');
        $this->addSql('DROP TABLE notification_notifications');
        $this->addSql('ALTER TABLE contest_won_students CHANGE note note TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
