<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240725004013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contest_won_students CHANGE note note text DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE manager_role_permission DROP FOREIGN KEY FK_2D73F1C0FED90CCA');
        $this->addSql('ALTER TABLE manager_role_permission DROP FOREIGN KEY FK_2D73F1C06FC02232');
        $this->addSql('ALTER TABLE manager_role_permission ADD CONSTRAINT FK_2D73F1C0FED90CCA FOREIGN KEY (permission_id) REFERENCES manager_role_permissions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE manager_role_permission ADD CONSTRAINT FK_2D73F1C06FC02232 FOREIGN KEY (role_uuid) REFERENCES manager_roles (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contest_won_students CHANGE note note TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE manager_role_permission DROP FOREIGN KEY FK_2D73F1C06FC02232');
        $this->addSql('ALTER TABLE manager_role_permission DROP FOREIGN KEY FK_2D73F1C0FED90CCA');
        $this->addSql('ALTER TABLE manager_role_permission ADD CONSTRAINT FK_2D73F1C06FC02232 FOREIGN KEY (role_uuid) REFERENCES manager_roles (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE manager_role_permission ADD CONSTRAINT FK_2D73F1C0FED90CCA FOREIGN KEY (permission_id) REFERENCES manager_role_permissions (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
