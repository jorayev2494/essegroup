<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240405143855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE university_departments_degrees DROP FOREIGN KEY FK_E6C78F71736537F3');
        $this->addSql('ALTER TABLE university_departments_degrees DROP FOREIGN KEY FK_E6C78F71A1FCCBE9');
        $this->addSql('DROP TABLE university_departments_degrees');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments ADD degree_uuid VARCHAR(255) DEFAULT NULL, CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments ADD CONSTRAINT FK_6F54A23A1FCCBE9 FOREIGN KEY (degree_uuid) REFERENCES university_degrees (uuid) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_6F54A23A1FCCBE9 ON university_departments (degree_uuid)');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE university_departments_degrees (department_uuid VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, degree_uuid VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, INDEX IDX_E6C78F71736537F3 (department_uuid), INDEX IDX_E6C78F71A1FCCBE9 (degree_uuid), PRIMARY KEY(department_uuid, degree_uuid)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE university_departments_degrees ADD CONSTRAINT FK_E6C78F71736537F3 FOREIGN KEY (department_uuid) REFERENCES university_departments (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE university_departments_degrees ADD CONSTRAINT FK_E6C78F71A1FCCBE9 FOREIGN KEY (degree_uuid) REFERENCES university_degrees (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments DROP FOREIGN KEY FK_6F54A23A1FCCBE9');
        $this->addSql('DROP INDEX IDX_6F54A23A1FCCBE9 ON university_departments');
        $this->addSql('ALTER TABLE university_departments DROP degree_uuid, CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
