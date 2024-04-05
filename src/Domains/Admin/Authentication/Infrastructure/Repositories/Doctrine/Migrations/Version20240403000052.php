<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240403000052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE university_department_name_translations (id INT AUTO_INCREMENT NOT NULL, department_name_uuid VARCHAR(255) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_2C04518C4D4BFD1D (department_name_uuid), UNIQUE INDEX university_department_name_translation_idx (locale, field, department_name_uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_department_names (uuid VARCHAR(255) NOT NULL, value VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE university_department_name_translations ADD CONSTRAINT FK_2C04518C4D4BFD1D FOREIGN KEY (department_name_uuid) REFERENCES university_department_names (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL, CHANGE name name_uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments ADD CONSTRAINT FK_6F54A2396C98AD1 FOREIGN KEY (name_uuid) REFERENCES university_department_names (uuid) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_6F54A2396C98AD1 ON university_departments (name_uuid)');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE university_departments DROP FOREIGN KEY FK_6F54A2396C98AD1');
        $this->addSql('ALTER TABLE university_department_name_translations DROP FOREIGN KEY FK_2C04518C4D4BFD1D');
        $this->addSql('DROP TABLE university_department_name_translations');
        $this->addSql('DROP TABLE university_department_names');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_6F54A2396C98AD1 ON university_departments');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL, CHANGE name_uuid name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
