<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240724215647 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE manager_role_permission (role_uuid CHAR(36) NOT NULL, permission_id INT NOT NULL, INDEX IDX_2D73F1C06FC02232 (role_uuid), INDEX IDX_2D73F1C0FED90CCA (permission_id), PRIMARY KEY(role_uuid, permission_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE manager_role_permission ADD CONSTRAINT FK_2D73F1C06FC02232 FOREIGN KEY (role_uuid) REFERENCES manager_roles (uuid)');
        $this->addSql('ALTER TABLE manager_role_permission ADD CONSTRAINT FK_2D73F1C0FED90CCA FOREIGN KEY (permission_id) REFERENCES manager_role_permissions (id)');
        $this->addSql('ALTER TABLE contest_won_students CHANGE note note text DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manager_role_permission DROP FOREIGN KEY FK_2D73F1C06FC02232');
        $this->addSql('ALTER TABLE manager_role_permission DROP FOREIGN KEY FK_2D73F1C0FED90CCA');
        $this->addSql('DROP TABLE manager_role_permission');
        $this->addSql('ALTER TABLE contest_won_students CHANGE note note TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
