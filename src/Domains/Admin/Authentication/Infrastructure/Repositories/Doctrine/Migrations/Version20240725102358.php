<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240725102358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auth_members ADD role_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\'');
        $this->addSql('ALTER TABLE auth_members ADD CONSTRAINT FK_B84F20C6FC02232 FOREIGN KEY (role_uuid) REFERENCES manager_roles (uuid) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_B84F20C6FC02232 ON auth_members (role_uuid)');
        $this->addSql('ALTER TABLE contest_won_students CHANGE note note text DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auth_members DROP FOREIGN KEY FK_B84F20C6FC02232');
        $this->addSql('DROP INDEX IDX_B84F20C6FC02232 ON auth_members');
        $this->addSql('ALTER TABLE auth_members DROP role_uuid');
        $this->addSql('ALTER TABLE contest_won_students CHANGE note note TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
