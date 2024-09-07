<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240819191250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notification_managers (uuid CHAR(36) NOT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification_notifications_managers (notification_uuid CHAR(36) NOT NULL, manager_uuid CHAR(36) NOT NULL, INDEX IDX_E63E5AE869431B9C (notification_uuid), INDEX IDX_E63E5AE8D776F2DF (manager_uuid), PRIMARY KEY(notification_uuid, manager_uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notification_notifications_managers ADD CONSTRAINT FK_E63E5AE869431B9C FOREIGN KEY (notification_uuid) REFERENCES notification_notifications (uuid)');
        $this->addSql('ALTER TABLE notification_notifications_managers ADD CONSTRAINT FK_E63E5AE8D776F2DF FOREIGN KEY (manager_uuid) REFERENCES notification_managers (uuid)');
        $this->addSql('ALTER TABLE contest_won_students CHANGE note note text DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification_notifications_managers DROP FOREIGN KEY FK_E63E5AE869431B9C');
        $this->addSql('ALTER TABLE notification_notifications_managers DROP FOREIGN KEY FK_E63E5AE8D776F2DF');
        $this->addSql('DROP TABLE notification_managers');
        $this->addSql('DROP TABLE notification_notifications_managers');
        $this->addSql('ALTER TABLE contest_won_students CHANGE note note TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
